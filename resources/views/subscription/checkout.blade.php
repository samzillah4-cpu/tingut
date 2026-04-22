@extends('layouts.public')

@section('title', 'Checkout - ' . $plan->name . ' - ' . config('app.name'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--primary-color) 0%, #146060 100%);">
                                <i class="fas fa-credit-card text-white" style="font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <h4 class="mb-0" style="color: var(--primary-color);">Checkout</h4>
                                <small class="text-muted">Complete your subscription payment</small>
                            </div>
                        </div>
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Home
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Plan Summary -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-crown me-2"></i>{{ $plan->name }} Plan
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <div class="h3 mb-0 fw-bold" style="color: var(--primary-color);">NOK {{ $plan->price }}</div>
                                            <small class="text-muted">per {{ $plan->duration }}</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="h3 mb-0 fw-bold">{{ $plan->max_products == 0 ? 'Unlimited' : $plan->max_products }}</div>
                                            <small class="text-muted">Max Products</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="h3 mb-0 fw-bold">{{ ucfirst($plan->duration) }}</div>
                                            <small class="text-muted">Duration</small>
                                        </div>
                                    </div>

                                    @if($plan->description)
                                        <div class="mt-3">
                                            <p class="text-muted mb-0">{{ $plan->description }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Order Summary</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>{{ $plan->name }} Plan</span>
                                        <span>NOK {{ $plan->price }}</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>Total</span>
                                        <span style="color: var(--primary-color);">NOK {{ $plan->price }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Selection -->
                    <form id="paymentForm" method="POST" action="{{ route('payment.process', $plan) }}">
                        @csrf
                        <div class="mb-4">
                            <h5 class="mb-3">Select Payment Method</h5>

                            <div class="row">
                                <!-- Cash Payment -->
                                <div class="col-md-6 mb-3">
                                    <div class="card payment-method-card" data-method="cash" style="cursor: pointer; border: 2px solid #e9ecef;">
                                        <div class="card-body text-center p-4">
                                            <input type="radio" name="payment_method" value="cash" id="cash" class="d-none">
                                            <i class="fas fa-money-bill-wave fa-2x mb-3" style="color: var(--primary-color);"></i>
                                            <h6 class="mb-2">Cash Payment</h6>
                                            <p class="text-muted small mb-0">Pay in person or via bank transfer. Admin approval required.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Vipps Payment -->
                                <div class="col-md-6 mb-3">
                                    <div class="card payment-method-card" data-method="vipps" style="cursor: pointer; border: 2px solid #e9ecef;">
                                        <div class="card-body text-center p-4">
                                            <input type="radio" name="payment_method" value="vipps" id="vipps" class="d-none">
                                            <i class="fas fa-mobile-alt fa-2x mb-3" style="color: #ff5b2c;"></i>
                                            <h6 class="mb-2">Vipps</h6>
                                            <p class="text-muted small mb-0">Pay securely with Vipps. Instant activation.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Vipps Payment Form (Hidden initially) -->
                        <div id="vippsForm" class="d-none">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Vipps Payment</h6>
                                </div>
                                <div class="card-body text-center">
                                    <p class="mb-3">You will be redirected to Vipps to complete your payment securely.</p>
                                    <div id="vipps-errors" class="text-danger small mt-2" role="alert"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Cash Payment Notice -->
                        <div id="cashNotice" class="d-none">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Cash Payment Selected:</strong> After submitting, please contact an administrator to complete your payment.
                                Your subscription will be activated once payment is confirmed.
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" id="submitBtn" class="btn btn-primary" disabled>
                                <span id="btnText">
                                    <i class="fas fa-credit-card me-2"></i>Select Payment Method First
                                </span>
                                <span id="btnSpinner" class="d-none">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    Processing Payment...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .payment-method-card {
        transition: all 0.3s ease;
    }

    .payment-method-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .payment-method-card.selected {
        border-color: var(--primary-color) !important;
        background-color: rgba(26, 105, 105, 0.05);
    }

    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .alert {
        border-radius: 10px;
        border: none;
    }
</style>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedMethod = null;

    // Payment method selection
    document.querySelectorAll('.payment-method-card').forEach(card => {
        card.addEventListener('click', function() {
            const method = this.dataset.method;

            // Remove selected class from all cards
            document.querySelectorAll('.payment-method-card').forEach(c => {
                c.classList.remove('selected');
            });

            // Add selected class to clicked card
            this.classList.add('selected');

            // Check the radio button
            document.getElementById(method).checked = true;

            // Show/hide relevant forms
            handlePaymentMethodChange(method);
        });
    });

    function handlePaymentMethodChange(method) {
        selectedMethod = method;
        const submitBtn = document.getElementById('submitBtn');
        const vippsForm = document.getElementById('vippsForm');
        const cashNotice = document.getElementById('cashNotice');

        if (method === 'vipps') {
            vippsForm.classList.remove('d-none');
            cashNotice.classList.add('d-none');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span id="btnText"><i class="fas fa-mobile-alt me-2"></i>Pay with Vipps</span><span id="btnSpinner" class="d-none"><span class="spinner-border spinner-border-sm me-2" role="status"></span>Processing...</span>';
        } else if (method === 'cash') {
            vippsForm.classList.add('d-none');
            cashNotice.classList.remove('d-none');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span id="btnText"><i class="fas fa-money-bill-wave me-2"></i>Request Cash Payment</span><span id="btnSpinner" class="d-none"><span class="spinner-border spinner-border-sm me-2" role="status"></span>Processing...</span>';
        }
    }


    // Form submission
    document.getElementById('paymentForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!selectedMethod) {
            alert('Please select a payment method.');
            return;
        }

        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');

        submitBtn.disabled = true;
        btnText.classList.add('d-none');
        btnSpinner.classList.remove('d-none');

        try {
            if (selectedMethod === 'vipps') {
                const result = await handleVippsPayment();
                if (result && result.success) {
                    // Redirect to Vipps payment URL
                    window.location.href = result.payment_url;
                }
            } else if (selectedMethod === 'cash') {
                const result = await handleCashPayment();
                if (result && result.success) {
                    alert('Cash payment request submitted successfully! Your subscription will be activated once payment is confirmed by an administrator.');
                    window.location.href = '{{ route("subscriptions") }}';
                }
            }
        } catch (error) {
            console.error('Payment error:', error);
            alert('An error occurred. Please try again.');
            resetSubmitButton();
        }
    });

    // Handle payment method selection and redirect to payment details
    function handlePaymentMethodChange(method) {
        selectedMethod = method;
        const submitBtn = document.getElementById('submitBtn');
        const stripeForm = document.getElementById('stripeForm');
        const cashNotice = document.getElementById('cashNotice');

        if (method === 'stripe') {
            stripeForm.classList.remove('d-none');
            cashNotice.classList.add('d-none');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span id="btnText"><i class="fas fa-credit-card me-2"></i>Pay with Card</span><span id="btnSpinner" class="d-none"><span class="spinner-border spinner-border-sm me-2" role="status"></span>Processing...</span>';
        } else if (method === 'cash') {
            stripeForm.classList.add('d-none');
            cashNotice.classList.remove('d-none');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span id="btnText"><i class="fas fa-money-bill-wave me-2"></i>Request Cash Payment</span><span id="btnSpinner" class="d-none"><span class="spinner-border spinner-border-sm me-2" role="status"></span>Processing...</span>';
        }
    }

    async function handleVippsPayment() {
        try {
            // Create Vipps payment
            const response = await fetch('{{ route("payment.vipps.create") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    plan_id: {{ $plan->id }}
                })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || 'Failed to create Vipps payment');
            }

            if (data.success && data.payment_url) {
                return { success: true, payment_url: data.payment_url };
            } else {
                throw new Error(data.message || 'Failed to initiate Vipps payment');
            }

        } catch (error) {
            console.error('Vipps payment error:', error);
            document.getElementById('vipps-errors').textContent = error.message || 'An error occurred during payment processing.';
            resetSubmitButton();
            throw error;
        }
    }

    async function handleCashPayment() {
        try {
            // Submit the form normally for cash payment
            const formData = new FormData(document.getElementById('paymentForm'));

            const response = await fetch('{{ route("payment.process", $plan) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                return { success: true };
            } else {
                throw new Error(data.error || 'Cash payment request failed');
            }
        } catch (error) {
            console.error('Cash payment error:', error);
            throw error;
        }
    }

    // Show success message for cash payment
    function showCashPaymentSuccess() {
        alert('Cash payment request submitted successfully! Your subscription will be activated once payment is confirmed by an administrator.');
        window.location.href = '{{ route("subscriptions") }}';
    }

    function resetSubmitButton() {
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');

        submitBtn.disabled = false;
        btnText.classList.remove('d-none');
        btnSpinner.classList.add('d-none');
    }
});
</script>
@endpush
