@extends('adminlte::page')

@section('title', 'Subscribe to Plan')

@section('content_header')
    <!-- Header matching website colors -->
    <div class="text-white py-4 mb-4" style="border-radius: 12px; background: linear-gradient(135deg, #165c60 0%, #1c6c6c 100%);">
        <div class="container-fluid px-3">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-2 me-3" style="background: rgba(255,255,255,0.15);">
                            <i class="fas fa-credit-card fs-4"></i>
                        </div>
                        <div>
                            <h2 class="mb-0 fw-bold fs-3">Complete Subscription</h2>
                            <small class="opacity-90" style="color: #f9f2d6;">Choose your payment method</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-end">
                    <a href="{{ route('subscriptions') }}" class="btn btn-light btn-sm px-4" style="border-radius: 20px; color: #165c60; font-weight: 600;">
                        <i class="fas fa-arrow-left me-2"></i>Back to Plans
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid px-3">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <!-- Plan Summary Card -->
                <div class="card mb-4" style="border-radius: 12px; border: 1px solid #e0e0e0; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 56px; height: 56px; background: rgba(15, 83, 87, 0.1);">
                                        <i class="fas fa-crown fs-4" style="color: #165c60;"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-1 fw-bold" style="color: #165c60;">{{ $plan->name }}</h4>
                                        <p class="text-muted mb-0 small">{{ $plan->description }}</p>
                                    </div>
                                </div>
                                <div class="row text-center g-2">
                                    <div class="col-4">
                                        <div class="p-2 rounded-3" style="background: rgba(15, 83, 87, 0.05);">
                                            <div class="fw-bold fs-5" style="color: #165c60;">NOK {{ number_format($plan->price, 0) }}</div>
                                            <small class="text-muted">per {{ $plan->duration }}</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-2 rounded-3" style="background: rgba(40, 167, 69, 0.08);">
                                            <div class="fw-bold fs-5" style="color: #28a745;">{{ $plan->max_products == 0 ? '∞' : $plan->max_products }}</div>
                                            <small class="text-muted">Max Products</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-2 rounded-3" style="background: rgba(23, 162, 184, 0.08);">
                                            <div class="fw-bold fs-5" style="color: #17a2b8;">{{ $plan->duration }}</div>
                                            <small class="text-muted">Duration</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center mt-3 mt-md-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px; background: rgba(22, 92, 96, 0.1);">
                                    <i class="fas fa-check fs-3" style="color: #165c60;"></i>
                                </div>
                                <h3 class="fw-bold mb-1" style="color: #165c60;">NOK {{ number_format($plan->price, 0) }}</h3>
                                <small class="text-muted">Total Amount</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods Card -->
                <div class="card" style="border-radius: 12px; border: 1px solid #e0e0e0; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <div class="card-body p-4">
                        @if(session('error'))
                            <div class="alert mb-4" role="alert" style="border-radius: 8px; background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); color: #dc3545;">
                                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                            </div>
                        @endif

                        <h5 class="mb-4 fw-bold" style="color: #165c60;">
                            <i class="fas fa-wallet me-2"></i>Choose Payment Method
                        </h5>

                        <form method="POST" action="{{ route('subscribe.process', $plan) }}">
                            @csrf

                            <!-- Cash Payment Option -->
                            <div class="payment-option mb-3">
                                <div class="form-check p-0">
                                    <input class="form-check-input d-none" type="radio" name="payment_method" id="cash" value="cash" checked>
                                    <label class="form-check-label w-100 cursor-pointer" for="cash">
                                        <div class="payment-card selected p-3" data-payment="cash" style="border-radius: 10px; border: 2px solid #165c60; background: rgba(15, 83, 87, 0.03); transition: all 0.3s ease;">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; background: rgba(22, 92, 96, 0.1);">
                                                    <i class="fas fa-money-bill-wave fs-5" style="color: #165c60;"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 fw-bold" style="color: #165c60;">Cash Payment</h6>
                                                    <p class="mb-0 small text-muted">Pay directly to administrator. Subscription activated after approval.</p>
                                                </div>
                                                <div class="d-none d-md-block">
                                                    <span class="badge px-3 py-2 fw-bold" style="border-radius: 20px; background: #165c60; color: white;">Recommended</span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Vipps Payment Option -->
                            <div class="payment-option mb-4">
                                <div class="form-check p-0">
                                    <input class="form-check-input d-none" type="radio" name="payment_method" id="vipps" value="vipps">
                                    <label class="form-check-label w-100 cursor-pointer" for="vipps">
                                        <div class="payment-card p-3" data-payment="vipps" style="border-radius: 10px; border: 1px solid #e0e0e0; background: white; transition: all 0.3s ease;">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; background: rgba(40, 167, 69, 0.1);">
                                                    <i class="fas fa-mobile-alt fs-5" style="color: #28a745;"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 fw-bold" style="color: #165c60;">Vipps Payment</h6>
                                                    <p class="mb-0 small text-muted">Instant payment via Vipps mobile app. Subscription activated immediately.</p>
                                                </div>
                                                <div class="d-none d-md-block">
                                                    <span class="badge px-3 py-2 fw-bold" style="border-radius: 20px; background: rgba(40, 167, 69, 0.15); color: #28a745;">Instant</span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Terms Checkbox -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" required style="border-color: #165c60;">
                                    <label class="form-check-label small text-muted" for="terms">
                                        I agree to the <a href="#" style="color: #165c60; text-decoration: none;">Terms of Service</a> and <a href="#" style="color: #165c60; text-decoration: none;">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex flex-column flex-sm-row gap-3">
                                <a href="{{ route('subscriptions') }}" class="btn flex-fill py-3 fw-bold" style="border-radius: 8px; border: 1px solid #e0e0e0; color: #6c757d; background: white;">
                                    <i class="fas fa-arrow-left me-2"></i>Back
                                </a>
                                <button type="submit" class="btn flex-fill py-3 fw-bold" style="border-radius: 8px; background: #165c60; border: 1px solid #165c60; color: white;">
                                    <i class="fas fa-credit-card me-2"></i>Complete Subscription
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="card mt-4" style="border-radius: 12px; border: 1px solid #e0e0e0; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <div class="card-body p-4 text-center">
                        <i class="fas fa-question-circle mb-3" style="font-size: 2rem; color: #17a2b8;"></i>
                        <h6 class="mb-2 fw-bold" style="color: #165c60;">Need Help?</h6>
                        <p class="text-muted mb-3 small">Contact our support team if you have any questions about subscriptions.</p>
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <a href="mailto:support@tingut.no" class="btn btn-sm px-3 py-2" style="border-radius: 20px; border: 1px solid #17a2b8; color: #17a2b8;">
                                <i class="fas fa-envelope me-1"></i>Email
                            </a>
                            <a href="tel:+4712345678" class="btn btn-sm px-3 py-2" style="border-radius: 20px; border: 1px solid #28a745; color: #28a745;">
                                <i class="fas fa-phone me-1"></i>Call
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
    <style>
        :root {
            --primary-color: #165c60;
            --secondary-color: #f9f2d6;
            --success-color: #28a745;
        }

        /* Hide sidebar for full-width layout */
        .main-sidebar { display: none !important; }
        .content-wrapper { margin-left: 0 !important; }
        .main-header { margin-left: 0 !important; }

        /* Card styling matching website */
        .card {
            border-radius: 12px !important;
            border: 1px solid #e0e0e0 !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;
        }

        .card:hover {
            transform: none !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
        }

        /* Button styling */
        .btn {
            border-radius: 8px !important;
            font-weight: 600 !important;
            transition: all 0.2s ease !important;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
        }

        /* Badge styling */
        .badge {
            border-radius: 20px !important;
            font-weight: 600 !important;
        }

        /* Form checkbox */
        .form-check-input:checked {
            background-color: #165c60 !important;
            border-color: #165c60 !important;
        }

        /* Content background */
        .content {
            padding: 0 20px !important;
            background: #f8f9fa !important;
        }

        /* Payment card styling */
        .payment-card {
            cursor: pointer;
            transition: all 0.3s ease !important;
        }

        .payment-card:hover {
            border-color: #165c60 !important;
            background: rgba(22, 92, 96, 0.05) !important;
        }

        .payment-card.selected {
            border-color: #165c60 !important;
            background: rgba(22, 92, 96, 0.08) !important;
            box-shadow: 0 0 0 1px rgba(22, 92, 96, 0.2);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .content { padding: 0 15px !important; }
            .card-body { padding: 1.25rem !important; }
            .fs-3 { font-size: 1.35rem !important; }
            .fs-4 { font-size: 1.15rem !important; }
        }

        @media (max-width: 480px) {
            .btn {
                padding: 0.6rem 1rem !important;
                font-size: 0.875rem !important;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #165c60 0%, #1c6c6c 100%);
            border-radius: 10px;
        }

        /* Focus styles for accessibility */
        .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(22, 92, 96, 0.25);
        }

        a:focus, button:focus {
            outline: 2px solid #165c60;
            outline-offset: 2px;
        }
    </style>
@stop

@section('js')
<script>
    // Payment method selection
    document.querySelectorAll('.payment-card').forEach(card => {
        card.addEventListener('click', function() {
            const paymentMethod = this.dataset.payment;

            // Update radio
            document.getElementById(paymentMethod).checked = true;

            // Update visual selection
            document.querySelectorAll('.payment-card').forEach(c => {
                c.classList.remove('selected');
                c.style.borderColor = '#e0e0e0';
                c.style.background = 'white';
            });

            this.classList.add('selected');
            this.style.borderColor = '#165c60';
            this.style.background = 'rgba(22, 92, 96, 0.08)';
        });
    });

    // Add loading animation to form submission
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.7';
                }
            });
        }
    });
</script>
@stop
