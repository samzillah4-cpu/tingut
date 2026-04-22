@extends('layouts.public')

@section('title', $homeSale->title . ' - Home Sale')

@section('content')
    <!-- Breadcrumb -->
    <section class="breadcrumb-section py-3" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none" style="color: var(--primary-color);">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $homeSale->title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Home Sale Details -->
    <section class="home-sale-details py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Image Gallery -->
                    <div class="card mb-4 shadow-sm" style="border-radius: 15px; overflow: hidden; border: none;">
                        <div id="homeSaleCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @if($homeSale->images && count($homeSale->images) > 0)
                                    @foreach($homeSale->images as $index => $image)
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                            @if(str_starts_with($image, 'http'))
                                                <img src="{{ $image }}" class="d-block w-100" alt="{{ $homeSale->title }}" style="height: 450px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('storage/' . $image) }}" class="d-block w-100" alt="{{ $homeSale->title }}" style="height: 450px; object-fit: cover;">
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="carousel-item active">
                                        <div class="d-flex align-items-center justify-content-center" style="height: 450px; background: linear-gradient(135deg, var(--primary-color), #1c6c6c);">
                                            <i class="fas fa-home fa-5x text-white"></i>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if($homeSale->images && count($homeSale->images) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#homeSaleCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: var(--primary-color); border-radius: 50%; width: 50px; height: 50px; padding: 10px;"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#homeSaleCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: var(--primary-color); border-radius: 50%; width: 50px; height: 50px; padding: 10px;"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="card mb-4 shadow-sm" style="border-radius: 15px; border: none;">
                        <div class="card-body p-4">
                            <h2 class="fw-bold mb-3" style="color: var(--primary-color);">{{ $homeSale->title }}</h2>
                            <p class="text-muted">{{ $homeSale->description }}</p>
                        </div>
                    </div>

                    <!-- Listed Items -->
                    @if($homeSale->items->count() > 0)
                    <div class="card mb-4 shadow-sm" style="border-radius: 15px; border: none;">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4" style="color: var(--primary-color);">
                                <i class="fas fa-box-open mr-2"></i>Available Items ({{ $homeSale->items->count() }})
                            </h4>
                            <div class="row">
                                @foreach($homeSale->items as $item)
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100 home-sale-item-card" style="border-radius: 10px;">
                                            <div class="row no-gutters">
                                                <div class="col-4">
                                                    @if($item->image)
                                                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img" alt="{{ $item->name }}" style="height: 120px; object-fit: cover; border-radius: 10px 0 0 10px;">
                                                    @else
                                                        <div class="d-flex align-items-center justify-content-center h-100" style="background: #f5f5f5; border-radius: 10px 0 0 10px; min-height: 120px;">
                                                            <i class="fas fa-image fa-2x text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-8">
                                                    <div class="card-body py-2 px-3">
                                                        <h6 class="card-title mb-1">{{ $item->name }}</h6>
                                                        @if($item->category)
                                                            <span class="badge badge-light mb-1" style="font-size: 0.7rem;">{{ $item->category }}</span>
                                                        @endif
                                                        @if($item->condition)
                                                            <span class="badge badge-outline-secondary mb-1" style="font-size: 0.7rem;">{{ $item->condition }}</span>
                                                        @endif
                                                        @if($item->description)
                                                            <p class="card-text mb-1"><small class="text-muted">{{ Str::limit($item->description, 40) }}</small></p>
                                                        @endif
                                                        @if($item->price)
                                                            <p class="card-text fw-bold mb-0" style="color: var(--primary-color);">{{ number_format($item->price, 2, ',', '.') }} NOK</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <!-- Sale Info Card -->
                    <div class="card mb-4 shadow-sm" style="border-radius: 15px; border: none;">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-3" style="color: var(--primary-color);">Sale Information</h4>

                            <div class="mb-3">
                                <label class="text-muted small">Sale Dates</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar-alt mr-2" style="color: var(--primary-color);"></i>
                                    <span class="fw-bold">{{ $homeSale->sale_date_from->format('M d, Y') }} - {{ $homeSale->sale_date_to->format('M d, Y') }}</span>
                                </div>
                            </div>

                            @if($homeSale->is_featured)
                                <div class="mb-3">
                                    <span class="badge badge-warning p-2" style="font-size: 0.9rem;">
                                        <i class="fas fa-star mr-1"></i>Featured Sale
                                    </span>
                                </div>
                            @endif

                            <hr class="my-3">

                            <!-- Location -->
                            <div class="mb-3">
                                <label class="text-muted small">Location</label>
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-map-marker-alt mr-2 mt-1" style="color: var(--primary-color);"></i>
                                    <div>
                                        <span class="fw-bold d-block">{{ $homeSale->location }}</span>
                                        @if($homeSale->address)
                                            <small class="text-muted">{{ $homeSale->address }}</small><br>
                                        @endif
                                        @if($homeSale->city)
                                            <small class="text-muted">{{ $homeSale->city }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr class="my-3">

                            <!-- Seller Info -->
                            <div class="mb-3">
                                <label class="text-muted small">Seller</label>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px; background-color: var(--primary-color); color: white;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold d-block">{{ $homeSale->user->name }}</span>
                                        <small class="text-muted">Member since {{ $homeSale->user->created_at->format('Y') }}</small>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-3">

                            <!-- Contact Button -->
                            @auth
                                <button class="btn btn-lg w-100 fw-bold" style="border-radius: 25px; background: linear-gradient(135deg, var(--primary-color) 0%, #1c6c6c 100%); color: white; border: none;" data-bs-toggle="modal" data-bs-target="#contactModal">
                                    <i class="fas fa-envelope mr-2"></i>Contact Seller
                                </button>
                            @else
                                <a href="#" class="btn btn-lg w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#loginModal" style="border-radius: 25px; background: linear-gradient(135deg, var(--primary-color) 0%, #1c6c6c 100%); color: white; border: none;">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Login to Contact
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Share -->
                    <div class="card shadow-sm" style="border-radius: 15px; border: none;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3" style="color: var(--primary-color);">Share This Sale</h5>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-outline-primary" style="border-radius: 50%; padding: 10px 15px;">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="btn btn-outline-info" style="border-radius: 50%; padding: 10px 12px;">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="btn btn-outline-success" style="border-radius: 50%; padding: 10px 12px;">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="#" class="btn btn-outline-secondary" style="border-radius: 50%; padding: 10px 12px;">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Seller Modal -->
    @auth
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1); max-width: 500px;">
                <!-- Header -->
                <div class="modal-header" style="background: linear-gradient(135deg, #0f5057 0%, #1a6b6d 100%); color: white; border-radius: 15px 15px 0 0; padding: 20px 25px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="background: rgba(255,255,255,0.2); border-radius: 10px; padding: 8px; backdrop-filter: blur(10px);">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0" id="contactModalLabel" style="font-weight: 600; font-size: 1.1rem;">Contact Organizer</h5>
                            <small style="opacity: 0.9; font-size: 0.8rem;">Get in touch about this home sale</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body" style="padding: 25px; background: #ffffff;">
                    <form id="contactForm">
                        @csrf
                        <input type="hidden" name="home_sale_id" value="{{ $homeSale->id }}">
                        <input type="hidden" name="seller_id" value="{{ $homeSale->user->id }}">

                        <!-- Organizer Info (Compact) -->
                        <div style="background: #f8f9fa; border-radius: 10px; padding: 15px; margin-bottom: 20px; border: 1px solid #e9ecef;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 35px; height: 35px; border-radius: 8px; background: linear-gradient(135deg, #0f5057, #1a6b6d); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.9rem;">
                                    {{ substr($homeSale->user->name, 0, 1) }}
                                </div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: #0f5057; font-size: 0.9rem;">{{ $homeSale->user->name }}</div>
                                    <div style="color: #6c757d; font-size: 0.8rem;">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $homeSale->location }}{{ $homeSale->city ? ', ' . $homeSale->city : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Subject Field -->
                        <div class="mb-3">
                            <label for="subject" class="form-label" style="color: #0f5057; font-weight: 600; font-size: 0.9rem; margin-bottom: 6px;">Subject</label>
                            <div style="position: relative;">
                                <input type="text"
                                       class="form-control"
                                       id="subject"
                                       name="subject"
                                       value="Inquiry about {{ Str::limit($homeSale->title, 25) }}"
                                       style="border-radius: 8px; border: 1px solid #e9ecef; padding: 10px 15px; font-size: 0.9rem; padding-left: 40px;"
                                       required>
                                <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #0f5057; font-size: 0.9rem;">
                                    <i class="fas fa-tag"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Message Field -->
                        <div class="mb-3">
                            <label for="message" class="form-label" style="color: #0f5057; font-weight: 600; font-size: 0.9rem; margin-bottom: 6px;">Your Message</label>
                            <div style="position: relative;">
                                <textarea class="form-control"
                                          id="message"
                                          name="message"
                                          rows="4"
                                          style="border-radius: 8px; border: 1px solid #e9ecef; padding: 10px 15px; font-size: 0.9rem; resize: vertical; padding-left: 40px; line-height: 1.5;"
                                          placeholder="Hi {{ $homeSale->user->name }}, I'm interested in your home sale..."
                                          required>Hi {{ $homeSale->user->name }},

I'm interested in your home sale "{{ $homeSale->title }}" in {{ $homeSale->location }}. Could you please provide more details about the available items?

Thank you!</textarea>
                                <div style="position: absolute; left: 12px; top: 12px; color: #0f5057; font-size: 0.9rem;">
                                    <i class="fas fa-comment-alt"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Templates (Compact) -->
                        <div class="mb-3">
                            <label class="form-label" style="color: #0f5057; font-weight: 600; font-size: 0.9rem; margin-bottom: 8px;">Quick Templates</label>
                            <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                                <button type="button" class="btn btn-sm" onclick="useTemplate('general')" style="background: rgba(15, 80, 87, 0.1); color: #0f5057; border: 1px solid rgba(15, 80, 87, 0.2); border-radius: 15px; padding: 4px 10px; font-size: 0.75rem;">
                                    <i class="fas fa-question-circle me-1"></i>General
                                </button>
                                <button type="button" class="btn btn-sm" onclick="useTemplate('pricing')" style="background: rgba(15, 80, 87, 0.1); color: #0f5057; border: 1px solid rgba(15, 80, 87, 0.2); border-radius: 15px; padding: 4px 10px; font-size: 0.75rem;">
                                    <i class="fas fa-dollar-sign me-1"></i>Pricing
                                </button>
                                <button type="button" class="btn btn-sm" onclick="useTemplate('availability')" style="background: rgba(15, 80, 87, 0.1); color: #0f5057; border: 1px solid rgba(15, 80, 87, 0.2); border-radius: 15px; padding: 4px 10px; font-size: 0.75rem;">
                                    <i class="fas fa-calendar-check me-1"></i>Availability
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="modal-footer" style="border: none; padding: 20px 25px; background: #f8f9fa; border-radius: 0 0 15px 15px;">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal" style="border-radius: 20px; padding: 8px 20px; font-size: 0.9rem;">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" form="contactForm" class="btn btn-sm" id="sendMessageBtn" style="border-radius: 20px; padding: 8px 20px; font-size: 0.9rem; background: linear-gradient(135deg, #0f5057 0%, #1a6b6d 100%); color: white; border: none;">
                        <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                        <i class="fas fa-paper-plane me-1"></i>
                        <span class="btn-text">Send Message</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endauth

    <style>
        .breadcrumb-item a:hover {
            text-decoration: underline !important;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-size: 60% 60%;
        }

        .badge-outline-secondary {
            border: 1px solid #6c757d;
            color: #6c757d;
            background-color: transparent;
        }

        /* Home Sale Item Card Hover Effects */
        .home-sale-item-card {
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
        }

        .home-sale-item-card:hover {
            border: 2px solid var(--primary-color);
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .home-sale-item-card .card-img,
        .home-sale-item-card .d-flex.align-items-center.justify-content-center {
            transition: transform 0.3s ease;
        }

        .home-sale-item-card:hover .card-img,
        .home-sale-item-card:hover .d-flex.align-items-center.justify-content-center {
            transform: scale(1.1);
        }
    </style>

    <script>
        // Focus enhancements for form inputs
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('#contactModal .form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.borderColor = '#0f5057';
                    this.style.boxShadow = '0 0 0 3px rgba(15, 80, 87, 0.1)';
                });

                input.addEventListener('blur', function() {
                    this.style.borderColor = '#e9ecef';
                    this.style.boxShadow = 'none';
                });
            });
        });

        // Template message functions
        function useTemplate(type) {
            const messageTextarea = document.getElementById('message');
            const organizerName = '{{ $homeSale->user->name }}';
            const saleTitle = '{{ Str::limit($homeSale->title, 20) }}';
            const location = '{{ $homeSale->location }}';

            let template = '';

            switch(type) {
                case 'general':
                    template = `Hi ${organizerName},

I'm interested in your home sale "${saleTitle}" in ${location}. Could you provide more details about available items?

Thank you!`;
                    break;

                case 'pricing':
                    template = `Hi ${organizerName},

I'm interested in your home sale "${saleTitle}". Could you please provide pricing information?

Thanks!`;
                    break;

                case 'availability':
                    template = `Hi ${organizerName},

Are there still items available at your home sale "${saleTitle}"? What are the pickup times?

Best regards.`;
                    break;
            }

            messageTextarea.value = template;

            // Highlight the template button briefly
            event.target.style.background = 'rgba(15, 80, 87, 0.2)';
            event.target.style.borderColor = 'rgba(15, 80, 87, 0.4)';
            setTimeout(() => {
                event.target.style.background = 'rgba(15, 80, 87, 0.1)';
                event.target.style.borderColor = 'rgba(15, 80, 87, 0.2)';
            }, 200);
        }

        // Form submission handling
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('sendMessageBtn');
            const spinner = submitBtn.querySelector('.spinner-border');
            const btnText = submitBtn.querySelector('.btn-text');

            // Show loading state
            submitBtn.disabled = true;
            spinner.classList.remove('d-none');
            btnText.textContent = 'Sending...';

            const formData = new FormData(this);

            fetch('{{ route("home-sales.contact") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Success animation
                    submitBtn.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
                    btnText.textContent = 'Message Sent!';
                    spinner.classList.add('d-none');

                    // Close modal after success
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('contactModal'));
                        modal.hide();

                        // Show success toast
                        showToast('Message sent successfully!', 'success');
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Failed to send message');
                }
            })
            .catch(error => {
                console.error('Error:', error);

                // Reset button state
                submitBtn.disabled = false;
                spinner.classList.add('d-none');
                btnText.textContent = 'Send Message';

                // Show error
                showToast(error.message || 'Failed to send message. Please try again.', 'error');
            });
        });

        // Toast notification function
        function showToast(message, type = 'info') {
            const toastColors = {
                success: '#28a745',
                error: '#dc3545',
                info: '#0f5057'
            };

            // Create toast element
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${toastColors[type]};
                color: white;
                padding: 15px 20px;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                z-index: 9999;
                font-weight: 500;
                max-width: 300px;
                transform: translateX(100%);
                transition: transform 0.3s ease;
            `;
            toast.textContent = message;

            document.body.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.style.transform = 'translateX(0)';
            }, 100);

            // Remove after 3 seconds
            setTimeout(() => {
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }

        // Modal enhancements
        document.getElementById('contactModal').addEventListener('show.bs.modal', function() {
            // Reset form when modal opens
            document.getElementById('contactForm').reset();

            // Focus on message field for quicker interaction
            setTimeout(() => {
                document.getElementById('message').focus();
            }, 300);
        });

        // Responsive adjustments - smaller modal works better on mobile
        window.addEventListener('resize', function() {
            const modal = document.querySelector('#contactModal .modal-dialog');
            if (window.innerWidth < 576) {
                modal.style.maxWidth = '95vw';
            } else {
                modal.style.maxWidth = '500px';
            }
        });

        // Initialize responsive modal size
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.querySelector('#contactModal .modal-dialog');
            if (window.innerWidth < 576) {
                modal.style.maxWidth = '95vw';
            }
        });
    </script>
@endsection
