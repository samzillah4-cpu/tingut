@extends('layouts.public')

@section('title', 'Contact Us - ' . config('settings.site_name', 'TingUt.no'))

@section('content')
<section class="contact-section py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); min-height: 70vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact-card" style="border-radius: 15px; background: white; box-shadow: 0 8px 25px rgba(0,0,0,0.1); padding: 3rem; border: 1px solid rgba(26, 105, 105, 0.1);">
                    <div class="text-center mb-5">
                        <h1 class="display-5 fw-bold mb-3" style="color: var(--primary-color);">{{ __('Contact Us') }}</h1>
                        <p class="lead text-muted">{{ __('Get in touch with us. We\'d love to hear from you!') }}</p>
                    </div>

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

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}" novalidate>
                        @csrf

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="{{ __('Your Name') }}" value="{{ old('name') }}" required>
                                    <label for="name">{{ __('Your Name') }} *</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="{{ __('Your Email') }}" value="{{ old('email') }}" required>
                                    <label for="email">{{ __('Your Email') }} *</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mt-4">
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="{{ __('Subject') }}" value="{{ old('subject') }}" required>
                            <label for="subject">{{ __('Subject') }} *</label>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mt-4">
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" placeholder="{{ __('Your Message') }}" style="height: 150px; resize: vertical;" required>{{ old('message') }}</textarea>
                            <label for="message">{{ __('Your Message') }} *</label>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-lg px-5 py-3 fw-bold" style="border-radius: 50px; background: linear-gradient(135deg, var(--primary-color) 0%, #1c6c6c 100%); color: white; border: none; font-size: 1.1rem; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(26, 105, 105, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <i class="fas fa-paper-plane me-2"></i>{{ __('Send Message') }}
                            </button>
                        </div>
                    </form>

                    <div class="contact-info mt-5 pt-4 border-top">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="info-item">
                                    <i class="fas fa-envelope fa-2x mb-3" style="color: var(--primary-color);"></i>
                                    <h6 class="fw-bold">{{ __('Email Us') }}</h6>
                                    <p class="text-muted small">{{ config('settings.contact_email', 'admin@tingut.no') }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <i class="fas fa-clock fa-2x mb-3" style="color: var(--primary-color);"></i>
                                    <h6 class="fw-bold">{{ __('Response Time') }}</h6>
                                    <p class="text-muted small">{{ __('Within 24 hours') }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <i class="fas fa-shield-alt fa-2x mb-3" style="color: var(--primary-color);"></i>
                                    <h6 class="fw-bold">{{ __('Secure') }}</h6>
                                    <p class="text-muted small">{{ __('Your information is safe with us') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .contact-card {
        animation: fadeInUp 0.8s ease-out;
    }

    .form-floating > .form-control:focus,
    .form-floating > .form-control:not(:placeholder-shown) {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(26, 105, 105, 0.25);
    }

    .form-floating > label {
        color: #6c757d;
        transition: all 0.2s ease;
    }

    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        color: var(--primary-color);
        transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
    }

    .info-item {
        padding: 1rem;
        transition: transform 0.3s ease;
    }

    .info-item:hover {
        transform: translateY(-5px);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .contact-card {
            padding: 2rem 1.5rem;
        }

        .display-5 {
            font-size: 2.5rem;
        }
    }
</style>
@endsection
