<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Verify your identity with BankID') }}
    </div>

    <form id="bankid-form" method="POST" action="{{ route('bankid.initiate') }}">
        @csrf

        <input type="hidden" name="redirect" value="{{ $redirect ?? 'home' }}">

        <!-- National ID Number -->
        <div>
            <x-input-label for="national_id" :value="__('National ID Number (11 digits)')" />
            <x-text-input id="national_id" class="block mt-1 w-full" type="text" name="national_id"
                          required autofocus autocomplete="off" placeholder="DDMMYYNNNN" maxlength="11" />
            <x-input-error :messages="$errors->get('national_id')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" href="{{ route('login') }}">
                {{ __('Back to Login') }}
            </a>

            <x-primary-button class="ms-4" id="verify-btn">
                {{ __('Verify with BankID') }}
            </x-primary-button>
        </div>
    </form>

    <!-- BankID Status Container -->
    <div id="bankid-status" class="mt-4" style="display: none;">
        <div class="alert alert-info">
            <div class="spinner-border spinner-border-sm mr-2" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <span id="status-message">{{ __('Initiating BankID...') }}</span>
        </div>
    </div>

    @section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('bankid-form');
            const statusDiv = document.getElementById('bankid-status');
            const statusMessage = document.getElementById('status-message');
            const verifyBtn = document.getElementById('verify-btn');
            const nationalIdInput = document.getElementById('national_id');
            const initiateUrl = '{{ route("bankid.initiate") }}';
            const statusUrl = '{{ route("bankid.status") }}';
            const completeUrl = '{{ route("bankid.complete") }}';
            const redirectUrl = '{{ $redirect ?? route("dashboard") }}';
            const csrfToken = '{{ csrf_token() }}';

            // Format national ID input
            nationalIdInput.addEventListener('input', function(e) {
                // Remove non-digits
                this.value = this.value.replace(/\D/g, '');
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validate national ID
                if (nationalIdInput.value.length !== 11) {
                    alert('National ID must be 11 digits');
                    return;
                }

                // Show status
                statusDiv.style.display = 'block';
                verifyBtn.disabled = true;
                statusMessage.textContent = 'Opening BankID...';

                // Submit form via AJAX
                fetch(initiateUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        national_id: nationalIdInput.value,
                        redirect: redirectUrl
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        statusMessage.textContent = 'Please complete BankID verification on your device...';

                        // Start polling for status
                        pollStatus();
                    } else {
                        statusDiv.style.display = 'none';
                        verifyBtn.disabled = false;
                        alert(data.error || 'Failed to initiate BankID');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    statusDiv.style.display = 'none';
                    verifyBtn.disabled = false;
                    alert('An error occurred. Please try again.');
                });
            });

            // Poll for BankID status
            function pollStatus() {
                let attempts = 0;
                const maxAttempts = 60; // 60 seconds timeout

                const pollInterval = setInterval(function() {
                    attempts++;

                    fetch(statusUrl, {
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (data.status === 'complete') {
                                clearInterval(pollInterval);
                                statusMessage.textContent = 'Verification complete! Redirecting...';

                                // Complete the authentication
                                fetch(completeUrl, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    body: JSON.stringify({
                                        redirect: redirectUrl
                                    })
                                })
                                .then(response => response.json())
                                .then(result => {
                                    if (result.success) {
                                        window.location.href = result.redirect || redirectUrl;
                                    } else {
                                        alert(result.error || 'Verification failed');
                                        statusDiv.style.display = 'none';
                                        verifyBtn.disabled = false;
                                    }
                                });
                            } else if (data.status === 'failed') {
                                clearInterval(pollInterval);
                                statusMessage.textContent = 'Verification failed';
                                statusDiv.style.display = 'none';
                                verifyBtn.disabled = false;
                                alert('BankID verification failed');
                            }
                            // Otherwise still pending, continue polling
                        }

                        if (attempts >= maxAttempts) {
                            clearInterval(pollInterval);
                            statusMessage.textContent = 'Verification timed out';
                            statusDiv.style.display = 'none';
                            verifyBtn.disabled = false;
                            alert('Verification timed out. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Poll error:', error);
                    });
                }, 1000); // Poll every second
            }
        });
    </script>
    @stop
</x-guest-layout>
