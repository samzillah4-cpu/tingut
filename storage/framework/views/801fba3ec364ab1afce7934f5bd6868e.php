
<div id="gdpr-banner" class="gdpr-banner" style="display: none; position: fixed; bottom: 20px; left: 20px; max-width: 400px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); backdrop-filter: blur(20px); border: 2px solid var(--primary-color); border-radius: 16px; box-shadow: 0 8px 32px rgba(15, 83, 87, 0.15); z-index: 9999; padding: 20px;">
    <div class="d-flex align-items-start">
        <div class="cookie-icon-wrapper me-3" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-radius: 50%; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 15px rgba(15, 83, 87, 0.3);">
            <i class="fas fa-cookie-bite" style="color: white;"></i>
        </div>
        <div class="flex-grow-1">
            <h6 class="mb-2 fw-bold" style="color: var(--primary-color); font-size: 1rem;">We use cookies</h6>
            <p class="mb-3 small text-muted" style="line-height: 1.4;">We use cookies to enhance your browsing experience and analyze our traffic.</p>
            <div class="d-flex gap-2 mb-2">
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="acceptEssentialCookies()" style="border-radius: 20px; padding: 6px 12px; font-size: 0.75rem; font-weight: 600; border: 2px solid var(--primary-color); color: var(--primary-color);">
                    Essential Only
                </button>
                <button type="button" class="btn btn-primary btn-sm" onclick="acceptAllCookies()" style="border-radius: 20px; padding: 6px 12px; font-size: 0.75rem; font-weight: 600; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border: none;">
                    Accept All
                </button>
            </div>
            <div class="d-flex gap-3">
                <a href="#" class="text-decoration-none small fw-medium" data-bs-toggle="modal" data-bs-target="#gdpr-settings-modal" style="color: var(--primary-color); transition: all 0.3s ease;">
                    <i class="fas fa-cog me-1"></i>Customize
                </a>
                <a href="<?php echo e(route('privacy-policy')); ?>" class="text-decoration-none small fw-medium" style="color: var(--primary-color); transition: all 0.3s ease;">
                    <i class="fas fa-shield-alt me-1"></i>Privacy Policy
                </a>
            </div>
        </div>
        <button type="button" class="btn-close btn-close-custom ms-2" onclick="hideBanner()" style="font-size: 0.75rem; opacity: 0.6;" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>


<div class="modal fade" id="gdpr-settings-modal" tabindex="-1" aria-labelledby="gdprSettingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.15); overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; border: none; padding: 24px;">
                <div class="d-flex align-items-center">
                    <div class="me-3" style="background: rgba(255,255,255,0.2); border-radius: 50%; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-cookie-bite fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="gdprSettingsModalLabel"><?php echo e(__('gdpr.settings_title')); ?></h5>
                        <small class="text-white-50">Manage your privacy preferences</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="p-4">
                    <p class="text-muted mb-4"><?php echo e(__('gdpr.settings_description')); ?></p>
                </div>

                
                <div class="cookie-category mb-0 p-4 border-bottom" style="background: linear-gradient(135deg, rgba(15, 83, 87, 0.02), rgba(247, 240, 211, 0.02));">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="flex-grow-1 me-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3" style="background: var(--primary-color); border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-shield-alt fa-sm" style="color: white;"></i>
                                </div>
                                <h6 class="mb-0 fw-bold" style="color: var(--primary-color);"><?php echo e(__('gdpr.essential_cookies')); ?></h6>
                            </div>
                            <p class="mb-0 small text-muted"><?php echo e(__('gdpr.essential_description')); ?></p>
                        </div>
                        <span class="badge" style="background: var(--primary-color); color: white; padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;"><?php echo e(__('gdpr.always_active')); ?></span>
                    </div>
                </div>

                
                <div class="cookie-category mb-0 p-4 border-bottom">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="flex-grow-1 me-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3" style="background: #28a745; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-chart-line fa-sm" style="color: white;"></i>
                                </div>
                                <h6 class="mb-0 fw-bold"><?php echo e(__('gdpr.analytics_cookies')); ?></h6>
                            </div>
                            <p class="mb-0 small text-muted"><?php echo e(__('gdpr.analytics_description')); ?></p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="analytics-cookies" style="width: 48px; height: 24px;">
                            <label class="form-check-label visually-hidden" for="analytics-cookies"><?php echo e(__('gdpr.analytics_cookies')); ?></label>
                        </div>
                    </div>
                </div>

                
                <div class="cookie-category mb-0 p-4 border-bottom">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="flex-grow-1 me-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3" style="background: #17a2b8; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-cogs fa-sm" style="color: white;"></i>
                                </div>
                                <h6 class="mb-0 fw-bold"><?php echo e(__('gdpr.functional_cookies')); ?></h6>
                            </div>
                            <p class="mb-0 small text-muted"><?php echo e(__('gdpr.functional_description')); ?></p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="functional-cookies" style="width: 48px; height: 24px;" checked>
                            <label class="form-check-label visually-hidden" for="functional-cookies"><?php echo e(__('gdpr.functional_cookies')); ?></label>
                        </div>
                    </div>
                </div>

                
                <div class="cookie-category mb-0 p-4">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="flex-grow-1 me-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3" style="background: #ffc107; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-bullhorn fa-sm" style="color: white;"></i>
                                </div>
                                <h6 class="mb-0 fw-bold"><?php echo e(__('gdpr.marketing_cookies')); ?></h6>
                            </div>
                            <p class="mb-0 small text-muted"><?php echo e(__('gdpr.marketing_description')); ?></p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="marketing-cookies" style="width: 48px; height: 24px;">
                            <label class="form-check-label visually-hidden" for="marketing-cookies"><?php echo e(__('gdpr.marketing_cookies')); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4" style="background: #f8f9fa;">
                <div class="d-flex justify-content-between w-100">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 25px; padding: 10px 24px;">
                        <?php echo e(__('gdpr.cancel')); ?>

                    </button>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-primary" onclick="saveCookiePreferences()" style="border-radius: 25px; padding: 10px 24px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border: none;">
                            <?php echo e(__('gdpr.save_preferences')); ?>

                        </button>
                        <button type="button" class="btn" onclick="acceptAllCookies()" data-bs-dismiss="modal" style="border-radius: 25px; padding: 10px 24px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border: none; color: white;">
                            <?php echo e(__('gdpr.accept_all')); ?>

                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.gdpr-banner {
    animation: slideInLeft 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
}

@keyframes slideInLeft {
    from {
        transform: translateX(-100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.cookie-category {
    transition: all 0.3s ease;
    border-left: 4px solid transparent !important;
}

.cookie-category:hover {
    background: linear-gradient(135deg, rgba(15, 83, 87, 0.03), rgba(247, 240, 211, 0.03)) !important;
    border-left-color: var(--primary-color) !important;
    transform: translateX(2px);
}

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.form-check-input {
    border: 2px solid #dee2e6;
    transition: all 0.3s ease;
}

.form-check-input:focus {
    box-shadow: 0 0 0 0.2rem rgba(15, 83, 87, 0.25);
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(15, 83, 87, 0.3);
}

.cookie-icon-wrapper {
    animation: bounceIn 0.8s ease-out;
}

@keyframes bounceIn {
    0% {
        transform: scale(0.3);
        opacity: 0;
    }
    50% {
        transform: scale(1.05);
    }
    70% {
        transform: scale(0.9);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.btn-close-custom {
    background: none;
    border: none;
    font-size: 0.75rem;
    color: #6c757d;
    cursor: pointer;
    padding: 0;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.btn-close-custom:hover {
    background: rgba(108, 117, 125, 0.1);
    color: #495057;
}

@media (max-width: 768px) {
    .gdpr-banner {
        display: none !important;
    }
}

    .modal-dialog {
        margin: 0.5rem;
        max-width: calc(100vw - 1rem);
    }

    .modal-content {
        border-radius: 12px !important;
    }

    .cookie-category {
        padding: 16px !important;
    }

    .modal-footer .d-flex {
        flex-direction: column !important;
        gap: 12px !important;
    }

    .modal-footer .d-flex > div {
        width: 100% !important;
    }

    .modal-footer .d-flex .d-flex {
        justify-content: center !important;
    }
}

@media (max-width: 576px) {
    .gdpr-banner {
        padding: 16px;
        max-width: calc(100vw - 20px);
    }

    .cookie-icon-wrapper {
        width: 40px !important;
        height: 40px !important;
    }

    .cookie-icon-wrapper i {
        font-size: 0.9rem !important;
    }

    .modal-header {
        padding: 20px !important;
    }

    .modal-body {
        padding: 0 !important;
    }

    .cookie-category {
        padding: 16px 20px !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if user has already made a choice
    const consent = getCookie('cookie_consent');
    if (consent) {
        applyCookieSettings(JSON.parse(consent));
    } else {
        showBanner();
    }
});

function showBanner() {
    const banner = document.getElementById('gdpr-banner');
    if (banner) {
        banner.style.display = 'block';
        // Adjust body padding to account for fixed banner
        document.body.style.paddingBottom = '80px';
    }
}

function hideBanner() {
    const banner = document.getElementById('gdpr-banner');
    if (banner) {
        banner.style.display = 'none';
    }
}

function acceptAllCookies() {
    const preferences = {
        essential: true,
        analytics: true,
        marketing: true,
        functional: true
    };
    saveCookiePreferences(preferences);
    hideBanner();
}

function acceptEssentialCookies() {
    const preferences = {
        essential: true,
        analytics: false,
        marketing: false,
        functional: false
    };
    saveCookiePreferences(preferences);
    hideBanner();
}

function saveCookiePreferences(preferences = null) {
    if (!preferences) {
        preferences = {
            essential: true, // Always true
            analytics: document.getElementById('analytics-cookies').checked,
            marketing: document.getElementById('marketing-cookies').checked,
            functional: document.getElementById('functional-cookies').checked
        };
    }

    // Save preferences
    setCookie('cookie_consent', JSON.stringify(preferences), 365);
    applyCookieSettings(preferences);

    // Close modal if open
    const modal = bootstrap.Modal.getInstance(document.getElementById('gdpr-settings-modal'));
    if (modal) {
        modal.hide();
    }

    hideBanner();
}

function applyCookieSettings(preferences) {
    // Essential cookies are always enabled

    // Analytics cookies
    if (preferences.analytics) {
        enableAnalyticsCookies();
    } else {
        disableAnalyticsCookies();
    }

    // Marketing cookies
    if (preferences.marketing) {
        enableMarketingCookies();
    } else {
        disableMarketingCookies();
    }

    // Functional cookies
    if (preferences.functional) {
        enableFunctionalCookies();
    } else {
        disableFunctionalCookies();
    }
}

function enableAnalyticsCookies() {
    // Enable Google Analytics, etc.
    console.log('Analytics cookies enabled');
    // Add your analytics code here
}

function disableAnalyticsCookies() {
    // Disable Google Analytics, etc.
    console.log('Analytics cookies disabled');
    // Remove analytics tracking here
}

function enableMarketingCookies() {
    // Enable marketing cookies
    console.log('Marketing cookies enabled');
    // Add marketing scripts here
}

function disableMarketingCookies() {
    // Disable marketing cookies
    console.log('Marketing cookies disabled');
    // Remove marketing scripts here
}

function enableFunctionalCookies() {
    // Enable functional cookies
    console.log('Functional cookies enabled');
    // Add functional scripts here
}

function disableFunctionalCookies() {
    // Disable functional cookies
    console.log('Functional cookies disabled');
    // Remove functional scripts here
}

// Utility functions
function setCookie(name, value, days) {
    const expires = new Date();
    expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = name + '=' + encodeURIComponent(value) + ';expires=' + expires.toUTCString() + ';path=/;SameSite=Lax';
}

function getCookie(name) {
    const nameEQ = name + '=';
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}

// Update modal checkboxes based on current preferences
document.getElementById('gdpr-settings-modal').addEventListener('show.bs.modal', function() {
    const consent = getCookie('cookie_consent');
    if (consent) {
        const preferences = JSON.parse(consent);
        document.getElementById('analytics-cookies').checked = preferences.analytics;
        document.getElementById('marketing-cookies').checked = preferences.marketing;
        document.getElementById('functional-cookies').checked = preferences.functional;
    }
});
</script>
<?php /**PATH C:\xampp\htdocs\bytte.no\resources\views/components/gdpr-banner.blade.php ENDPATH**/ ?>