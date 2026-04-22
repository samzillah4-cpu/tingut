@extends('layouts.public')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="freecycle-card p-4">
                <div class="text-center mb-5">
                    <h1 class="mb-3" style="color: var(--primary-color);">{{ __('gdpr.privacy_policy_title') }}</h1>
                    <p class="text-muted">{{ __('gdpr.last_updated') }}: {{ date('F j, Y') }}</p>
                </div>

                <div class="privacy-content">
                    <section class="mb-5">
                        <h2 class="h4 mb-3" style="color: var(--primary-color);">{{ __('gdpr.introduction_title') }}</h2>
                        <p>{{ __('gdpr.introduction_text') }}</p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 mb-3" style="color: var(--primary-color);">{{ __('gdpr.data_collection_title') }}</h2>
                        <h3 class="h5 mb-2">{{ __('gdpr.personal_data_title') }}</h3>
                        <p>{{ __('gdpr.personal_data_text') }}</p>
                        <ul class="list-unstyled ms-3">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('gdpr.data_name') }}</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('gdpr.data_email') }}</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('gdpr.data_phone') }}</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('gdpr.data_address') }}</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('gdpr.data_payment') }}</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 mb-3" style="color: var(--primary-color);">{{ __('gdpr.cookies_title') }}</h2>
                        <p>{{ __('gdpr.cookies_text') }}</p>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3">
                                    <h4 class="h6 mb-2" style="color: var(--primary-color);">{{ __('gdpr.essential_cookies') }}</h4>
                                    <p class="small mb-0">{{ __('gdpr.essential_description') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3">
                                    <h4 class="h6 mb-2" style="color: var(--primary-color);">{{ __('gdpr.analytics_cookies') }}</h4>
                                    <p class="small mb-0">{{ __('gdpr.analytics_description') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3">
                                    <h4 class="h6 mb-2" style="color: var(--primary-color);">{{ __('gdpr.functional_cookies') }}</h4>
                                    <p class="small mb-0">{{ __('gdpr.functional_description') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3">
                                    <h4 class="h6 mb-2" style="color: var(--primary-color);">{{ __('gdpr.marketing_cookies') }}</h4>
                                    <p class="small mb-0">{{ __('gdpr.marketing_description') }}</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 mb-3" style="color: var(--primary-color);">{{ __('gdpr.data_usage_title') }}</h2>
                        <p>{{ __('gdpr.data_usage_text') }}</p>
                        <ul class="list-unstyled ms-3">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('gdpr.usage_account') }}</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('gdpr.usage_communication') }}</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('gdpr.usage_improvement') }}</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('gdpr.usage_legal') }}</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 mb-3" style="color: var(--primary-color);">{{ __('gdpr.data_sharing_title') }}</h2>
                        <p>{{ __('gdpr.data_sharing_text') }}</p>
                        <ul class="list-unstyled ms-3">
                            <li class="mb-2"><i class="fas fa-times-circle text-danger me-2"></i>{{ __('gdpr.sharing_no_sale') }}</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('gdpr.sharing_service_providers') }}</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ __('gdpr.sharing_legal_requirements') }}</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 mb-3" style="color: var(--primary-color);">{{ __('gdpr.data_security_title') }}</h2>
                        <p>{{ __('gdpr.data_security_text') }}</p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 mb-3" style="color: var(--primary-color);">{{ __('gdpr.user_rights_title') }}</h2>
                        <p>{{ __('gdpr.user_rights_text') }}</p>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3">
                                    <h4 class="h6 mb-2" style="color: var(--primary-color);">{{ __('gdpr.right_access') }}</h4>
                                    <p class="small mb-0">{{ __('gdpr.right_access_desc') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3">
                                    <h4 class="h6 mb-2" style="color: var(--primary-color);">{{ __('gdpr.right_rectification') }}</h4>
                                    <p class="small mb-0">{{ __('gdpr.right_rectification_desc') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3">
                                    <h4 class="h6 mb-2" style="color: var(--primary-color);">{{ __('gdpr.right_erasure') }}</h4>
                                    <p class="small mb-0">{{ __('gdpr.right_erasure_desc') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3">
                                    <h4 class="h6 mb-2" style="color: var(--primary-color);">{{ __('gdpr.right_portability') }}</h4>
                                    <p class="small mb-0">{{ __('gdpr.right_portability_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 mb-3" style="color: var(--primary-color);">{{ __('gdpr.contact_title') }}</h2>
                        <p>{{ __('gdpr.contact_text') }}</p>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-1"><strong>{{ __('gdpr.contact_email') }}:</strong> {{ config('settings.contact_email', 'privacy@tingut.no') }}</p>
                            <p class="mb-0"><strong>{{ __('gdpr.contact_address') }}:</strong> {{ config('settings.contact_address', config('app.name', 'TingUt.no')) }}</p>
                        </div>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 mb-3" style="color: var(--primary-color);">{{ __('gdpr.changes_title') }}</h2>
                        <p>{{ __('gdpr.changes_text') }}</p>
                    </section>
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('home') }}" class="btn btn-freecycle">{{ __('gdpr.back_to_home') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
.privacy-content h2, .privacy-content h3, .privacy-content h4 {
    color: var(--primary-color) !important;
}

.privacy-content ul li {
    margin-bottom: 0.5rem;
}

.privacy-content .border {
    transition: all 0.3s ease;
}

.privacy-content .border:hover {
    box-shadow: 0 2px 8px rgba(15, 83, 87, 0.1);
    border-color: var(--primary-color) !important;
}
</style>
