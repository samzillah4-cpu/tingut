@extends('layouts.public')

@section('title', 'My Subscriptions - ' . config('app.name'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--primary-color) 0%, #146060 100%);">
                                <i class="fas fa-crown text-white" style="font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <h4 class="mb-0" style="color: var(--primary-color);">My Subscriptions</h4>
                                <small class="text-muted">Manage your subscription plans and billing</small>
                            </div>
                        </div>
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Home
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($subscriptions->count() > 0)
                        <div class="row">
                            @foreach($subscriptions as $subscription)
                                <div class="col-md-6 mb-4">
                                    <div class="card border h-100 {{ $subscription->isActive() ? 'border-success' : 'border-secondary' }}">
                                        <div class="card-header {{ $subscription->isActive() ? 'bg-success text-white' : 'bg-light' }}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">
                                                    <i class="fas fa-crown me-2"></i>{{ $subscription->plan->name }}
                                                </h5>
                                                @if($subscription->isActive())
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($subscription->status) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row text-center mb-3">
                                                <div class="col-6">
                                                    <div class="h4 mb-0 fw-bold" style="color: var(--primary-color);">NOK {{ $subscription->plan->price }}</div>
                                                    <small class="text-muted">per {{ $subscription->plan->duration }}</small>
                                                </div>
                                                <div class="col-6">
                                                    <div class="h4 mb-0 fw-bold">{{ $subscription->plan->max_products == 0 ? 'Unlimited' : $subscription->plan->max_products }}</div>
                                                    <small class="text-muted">Max Products</small>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-calendar-plus me-1"></i>
                                                    <strong>Started:</strong> {{ $subscription->start_date->format('M d, Y') }}
                                                </small>
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-calendar-times me-1"></i>
                                                    <strong>Expires:</strong> {{ $subscription->end_date->format('M d, Y') }}
                                                </small>
                                            </div>

                                            @if($subscription->plan->description)
                                                <p class="text-muted small mb-3">{{ $subscription->plan->description }}</p>
                                            @endif

                                            @if($subscription->isActive())
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-success">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        {{ $subscription->end_date->diffInDays() }} days remaining
                                                    </small>
                                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancelModal" data-subscription-id="{{ $subscription->id }}">
                                                        <i class="fas fa-times me-1"></i>Cancel
                                                    </button>
                                                </div>
                                            @else
                                                <div class="text-center">
                                                    <small class="text-muted">Subscription ended on {{ $subscription->end_date->format('M d, Y') }}</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-crown fa-4x text-muted opacity-50"></i>
                            </div>
                            <h4 class="text-muted mb-3">No Subscriptions Yet</h4>
                            <p class="text-muted mb-4">You haven't subscribed to any plans yet. Choose a plan to unlock premium features.</p>
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-crown me-2"></i>View Available Plans
                            </a>
                        </div>
                    @endif

                    <!-- Available Plans Section (shown when no active subscription or after cancellation) -->
                    @php
                        $activeSubscriptions = $subscriptions->filter(function($subscription) {
                            return $subscription->status === 'active' && $subscription->end_date->isFuture();
                        });
                        $showPlans = $activeSubscriptions->isEmpty() || request('cancelled');
                        $availablePlans = \App\Models\SubscriptionPlan::active()->ordered()->get();
                    @endphp
                    @if($showPlans && $availablePlans->count() > 0)
                        <div class="mt-5">
                            <div class="text-center mb-4">
                                <h3 class="fw-bold" style="color: var(--primary-color);">
                                    <i class="fas fa-star me-2"></i>Choose Your Plan
                                </h3>
                                <p class="text-muted">Select a subscription plan that fits your needs</p>
                            </div>

                            <div class="row g-4">
                                @php
                                    $colors = ['#ffc107', '#dc3545', '#28a745']; // yellow, red, green
                                    $colorIndex = 0;
                                @endphp
                                @foreach($availablePlans as $plan)
                                    @php
                                        $currentColor = $colors[$colorIndex % count($colors)];
                                        $colorIndex++;
                                    @endphp
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <div class="card h-100 plan-card position-relative" style="border-radius: 12px; border: 2px solid #e9ecef; transition: all 0.3s ease; cursor: pointer;" data-plan-id="{{ $plan->id }}">
                                            <div class="card-body p-3 text-center">
                                                <!-- Plan Icon -->
                                                <div class="plan-icon mb-2">
                                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: {{ $currentColor }}20; border: 2px solid {{ $currentColor }};">
                                                        <i class="fas fa-crown fs-4" style="color: {{ $currentColor }};"></i>
                                                    </div>
                                                </div>

                                                <!-- Plan Name -->
                                                <h5 class="fw-bold mb-1">{{ $plan->name }}</h5>

                                                <!-- Price -->
                                                <div class="mb-2">
                                                    <span class="h4 fw-bold" style="color: var(--primary-color);">NOK {{ number_format($plan->price, 0) }}</span>
                                                    <small class="text-muted d-block">/ {{ $plan->duration }}</small>
                                                </div>

                                                <!-- Features -->
                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <i class="fas fa-box me-1" style="color: {{ $currentColor }};"></i>
                                                        <span class="fw-bold small">{{ $plan->max_products == 0 ? 'Unlimited' : $plan->max_products }}</span>
                                                        <small class="text-muted ms-1">products</small>
                                                    </div>
                                                </div>

                                                <!-- Subscribe Button -->
                                                <a href="{{ route('subscribe', $plan) }}" class="btn w-100 py-1 fw-bold" style="border-radius: 20px; font-size: 0.85rem; background: {{ $currentColor }}; border: 1px solid {{ $currentColor }}; color: white;">
                                                    <i class="fas fa-shopping-cart me-1"></i>Subscribe
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Cancellation Modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
                <div class="modal-header border-0" style="background: linear-gradient(135deg, var(--primary-color), #146060); color: white; border-radius: 16px 16px 0 0;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                        <div>
                            <h5 class="modal-title fw-bold mb-0" id="cancelModalLabel">Cancel Subscription</h5>
                            <small>Are you sure you want to cancel?</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <p class="mb-3">Cancelling your subscription will:</p>
                        <ul class="text-start list-unstyled">
                            <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>End your current plan immediately</li>
                            <li class="mb-2"><i class="fas fa-lock text-warning me-2"></i>Limit your product listings</li>
                            <li class="mb-2"><i class="fas fa-star text-primary me-2"></i>Allow you to choose a new plan below</li>
                        </ul>
                    </div>
                    <div class="alert alert-info" style="border-radius: 12px;">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Note:</strong> You can resubscribe to any plan immediately after cancellation.
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 25px;">Keep Subscription</button>
                    <form method="POST" action="" id="cancelForm" class="d-inline">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-danger" style="border-radius: 25px;">
                            <i class="fas fa-times me-2"></i>Yes, Cancel Subscription
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
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

    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
    }

    /* Plan Cards Styling */
    .plan-card {
        transition: all 0.3s ease;
        border: 2px solid #e9ecef !important;
    }

    .plan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(15, 83, 87, 0.15);
        border-color: var(--primary-color) !important;
    }

    .plan-icon {
        transition: transform 0.3s ease;
    }

    .plan-card:hover .plan-icon {
        transform: scale(1.1);
    }

    .plan-card .btn {
        transition: all 0.3s ease;
    }

    .plan-card:hover .btn {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(15, 83, 87, 0.3);
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }

    .modal-header {
        border-radius: 16px 16px 0 0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .plan-card {
            margin-bottom: 20px;
        }

        .plan-card .card-body {
            padding: 20px !important;
        }

        .display-5 {
            font-size: 2rem !important;
        }
    }

    @media (max-width: 576px) {
        .col-lg-4 {
            margin-bottom: 20px;
        }

        .plan-card .card-body {
            padding: 15px !important;
        }

        .plan-icon div {
            width: 50px !important;
            height: 50px !important;
        }

        .plan-icon i {
            font-size: 1.5rem !important;
        }
    }
</style>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle cancel modal
    const cancelModal = document.getElementById('cancelModal');
    const cancelForm = document.getElementById('cancelForm');

    cancelModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const subscriptionId = button.getAttribute('data-subscription-id');
        cancelForm.action = `/subscriptions/${subscriptionId}/cancel`;
    });

    // Add loading state to plan cards
    const planCards = document.querySelectorAll('.plan-card .btn');
    planCards.forEach(card => {
        card.addEventListener('click', function() {
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            this.disabled = true;

            // Re-enable after 3 seconds (fallback)
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
            }, 3000);
        });
    });

    // Add hover effects to plan cards
    const cards = document.querySelectorAll('.plan-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endpush
