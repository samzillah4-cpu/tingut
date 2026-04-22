@extends('adminlte::page')

@section('title', 'Seller Subscriptions')

@section('plugins.Datatables', true)

@section('content_header')
    <!-- Header matching website colors -->
    <div class="text-white py-4 mb-4" style="border-radius: 12px; background: linear-gradient(135deg, #165c60 0%, #1c6c6c 100%);">
        <div class="container-fluid px-3">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-2 me-3" style="background: rgba(255,255,255,0.15);">
                            <i class="fas fa-crown fs-4"></i>
                        </div>
                        <div>
                            <h2 class="mb-0 fw-bold fs-3">Subscription Plans</h2>
                            <small class="opacity-90" style="color: #f9f2d6;">Choose the perfect plan for your business</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-end">
                    <a href="{{ route('seller.dashboard') }}" class="btn btn-light btn-sm px-4" style="border-radius: 20px; color: #165c60; font-weight: 600;">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid px-3">
        <!-- Current Subscription Status -->
        @if($activeSubscription)
            <div class="alert mb-4" role="alert" style="border-radius: 10px; background: rgba(40, 167, 69, 0.1); border: 1px solid rgba(40, 167, 69, 0.3);">
                <div class="d-flex align-items-center p-2">
                    <i class="fas fa-check-circle me-2 fs-4" style="color: #28a745;"></i>
                    <div class="flex-grow-1">
                        <small class="fw-bold" style="color: #28a745;">Active Plan: {{ $activeSubscription->plan->name }}</small>
                        <div class="small text-muted">Expires {{ $activeSubscription->end_date->format('M d, Y') }} • {{ $activeSubscription->end_date->diffInDays() }} days remaining</div>
                    </div>
                    <form method="POST" action="{{ route('subscriptions.cancel', $activeSubscription) }}" class="ms-3">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-outline-danger btn-sm fw-bold px-3" style="border-radius: 20px;"
                                onclick="return confirm('Are you sure you want to cancel this subscription?')">
                            <i class="fas fa-times me-1"></i>Cancel
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="alert mb-4" role="alert" style="border-radius: 10px; background: rgba(255, 193, 7, 0.1); border: 1px solid rgba(255, 193, 7, 0.3);">
                <div class="d-flex align-items-center p-2">
                    <i class="fas fa-exclamation-triangle me-2 fs-4" style="color: #ffc107;"></i>
                    <div class="flex-grow-1">
                        <small class="fw-bold" style="color: #856404;">No Active Subscription</small>
                        <div class="small text-muted">Choose a plan below to start selling products</div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Active Plan Widgets & Subscription History Row -->
        <div class="row g-3 mb-4">
            <!-- Available Plans -->
            <div class="col-xl-8 col-lg-7">
                <div class="card h-100" style="border-radius: 12px; border: 1px solid #e0e0e0; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <div class="card-header border-bottom py-3 px-3" style="background: white; border-radius: 12px 12px 0 0;">
                        <h5 class="mb-0 fw-bold" style="color: #165c60;">
                            <i class="fas fa-star me-2" style="color: #ffc107;"></i>Available Plans
                        </h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-3">
                            @php
                                $colors = ['#165c60', '#28a745', '#17a2b8'];
                                $colorIndex = 0;
                            @endphp
                            @foreach($availablePlans as $plan)
                                @php
                                    $currentColor = $colors[$colorIndex % count($colors)];
                                    $colorIndex++;
                                @endphp
                                <div class="col-md-6">
                                    <div class="card h-100 position-relative" style="border-radius: 10px; border: 1px solid #e0e0e0; transition: all 0.3s ease;">
                                        @if($activeSubscription && $activeSubscription->plan_id == $plan->id)
                                            <div class="position-absolute top-0 end-0 px-2 py-1 rounded-pill small fw-bold" style="margin-top: -8px; margin-right: -8px; font-size: 0.7rem; background: #28a745; color: white;">
                                                <i class="fas fa-check me-1"></i>Current
                                            </div>
                                        @endif

                                        <div class="card-body p-3 text-center">
                                            <div class="mb-3">
                                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background: {{ $currentColor }}20; border: 2px solid {{ $currentColor }};">
                                                    <i class="fas fa-crown fs-4" style="color: {{ $currentColor }};"></i>
                                                </div>
                                            </div>

                                            <h5 class="fw-bold mb-2" style="color: #165c60;">{{ $plan->name }}</h5>
                                            <div class="mb-3">
                                                <span class="fw-bold" style="font-size: 1.5rem; color: #165c60;">NOK {{ number_format($plan->price, 0) }}</span>
                                                <small class="text-muted">/ {{ $plan->duration }}</small>
                                            </div>

                                            @if($plan->description)
                                                <p class="text-muted small mb-3">{{ $plan->description }}</p>
                                            @endif

                                            <div class="mb-3">
                                                <div class="d-flex justify-content-center align-items-center mb-1">
                                                    <i class="fas fa-box me-2" style="color: {{ $currentColor }};"></i>
                                                    <span class="fw-bold">{{ $plan->max_products == 0 ? 'Unlimited' : $plan->max_products }}</span>
                                                    <small class="text-muted ms-1">products</small>
                                                </div>
                                                <small class="text-muted">Max products you can list</small>
                                            </div>

                                            @if($activeSubscription && $activeSubscription->plan_id == $plan->id)
                                                <button class="btn w-100 fw-bold py-2" style="border-radius: 8px; background: #28a745; border: 1px solid #28a745; color: white;" disabled>
                                                    <i class="fas fa-check me-1"></i>Current Plan
                                                </button>
                                            @else
                                                <a href="{{ route('subscribe', $plan) }}" class="btn w-100 fw-bold py-2" style="border-radius: 8px; background: {{ $currentColor }}; border: 1px solid {{ $currentColor }}; color: white;">
                                                    <i class="fas fa-shopping-cart me-1"></i>
                                                    {{ $activeSubscription ? 'Upgrade Plan' : 'Choose Plan' }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subscription History -->
            <div class="col-xl-4 col-lg-5">
                @if($subscriptionHistory->count() > 0)
                    <div class="card h-100" style="border-radius: 12px; border: 1px solid #e0e0e0; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <div class="card-header border-bottom py-3 px-3" style="background: white; border-radius: 12px 12px 0 0;">
                            <h5 class="mb-0 fw-bold" style="color: #165c60;">
                                <i class="fas fa-history me-2" style="color: #17a2b8;"></i>History
                            </h5>
                        </div>
                        <div class="card-body p-3" style="max-height: 350px; overflow-y: auto;">
                            <div class="list-group list-group-flush">
                                @foreach($subscriptionHistory as $subscription)
                                    <div class="list-group-item border-0 px-0 py-2">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <div>
                                                <h6 class="mb-0 fw-bold" style="color: #165c60;">{{ $subscription->plan->name }}</h6>
                                                <small class="text-muted">{{ $subscription->start_date->format('M d, Y') }} - {{ $subscription->end_date->format('M d, Y') }}</small>
                                            </div>
                                            <span class="badge rounded-pill px-2 py-1 fw-bold" style="background: {{ $subscription->status === 'active' ? 'rgba(40, 167, 69, 0.15); color: #28a745;' : 'rgba(108, 117, 125, 0.15); color: #6c757d;' }}">
                                                {{ ucfirst($subscription->status) }}
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <small class="text-muted">NOK {{ number_format($subscription->plan->price, 0) }}</small>
                                            <small class="text-muted">{{ $subscription->plan->max_products == 0 ? 'Unlimited' : $subscription->plan->max_products }} products</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card h-100" style="border-radius: 12px; border: 1px solid #e0e0e0; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <div class="card-header border-bottom py-3 px-3" style="background: white; border-radius: 12px 12px 0 0;">
                            <h5 class="mb-0 fw-bold" style="color: #165c60;">
                                <i class="fas fa-history me-2" style="color: #17a2b8;"></i>History
                            </h5>
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <div class="text-center text-muted">
                                <i class="fas fa-history fa-2x mb-2" style="opacity: 0.4;"></i>
                                <p class="mb-0 small">No subscription history</p>
                            </div>
                        </div>
                    </div>
                @endif
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
        }

        /* Hide sidebar */
        .main-sidebar { display: none !important; }
        .content-wrapper { margin-left: 0 !important; }
        .main-header { margin-left: 0 !important; }

        /* Card styling matching website */
        .card {
            border-radius: 12px !important;
            border: 1px solid #e0e0e0 !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;
        }

        .card-header {
            background: white !important;
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

        /* Alert styling */
        .alert {
            border-radius: 10px !important;
            border: none !important;
        }

        /* Content background */
        .content {
            padding: 0 20px !important;
            background: #f8f9fa !important;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .content { padding: 0 15px !important; }
            .card-body { padding: 1rem !important; }
            .fs-3 { font-size: 1.35rem !important; }
            .fs-4 { font-size: 1.15rem !important; }
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
    </style>
@stop

@section('js')
<script>
    // Add loading animation to subscription buttons
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.btn[href*="subscribe"]');
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                this.disabled = true;

                // Re-enable after 3 seconds (for demo purposes)
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 3000);
            });
        });
    });
</script>
@stop
