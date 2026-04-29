<!-- Worldclass Preloader -->
<div id="worldclass-preloader" class="worldclass-preloader">
    <div class="preloader-overlay">
        <!-- Main Loader Container -->
        <div class="loader-container">
            <!-- Logo Section -->
            <div class="loader-logo-section">
                @if(config('settings.site_logo'))
                    <img src="{{ asset('storage/' . config('settings.site_logo')) }}"
                         alt="{{ config('settings.site_name', 'Bytte.no') }}"
                         class="loader-logo">
                @endif
                <div class="loader-brand">
                    <h1 class="loader-title">{{ config('settings.site_name', 'Bytte.no') }}</h1>
                    <p class="loader-subtitle">Loading amazing experiences...</p>
                </div>
            </div>

        <!-- Microsoft-Style Loader -->
        <div class="microsoft-loader">
            <!-- Windows Logo Animation -->
            <div class="windows-logo">
                <div class="logo-squares">
                    <div class="square square-1"></div>
                    <div class="square square-2"></div>
                    <div class="square square-3"></div>
                    <div class="square square-4"></div>
                </div>
            </div>

            <!-- Brand Section -->
            <div class="microsoft-brand">
                <h1 class="microsoft-title">{{ config('settings.site_name', 'Bytte.no') }}</h1>
                <p class="microsoft-subtitle">Loading your experience</p>
            </div>

            <!-- Progress Section -->
            <div class="microsoft-progress">
                <div class="progress-track">
                    <div class="progress-fill" id="microsoftProgressFill"></div>
                </div>
                <div class="progress-dots">
                    <div class="progress-dot dot-1 active"></div>
                    <div class="progress-dot dot-2"></div>
                    <div class="progress-dot dot-3"></div>
                </div>
                <div class="progress-text">
                    <span id="microsoftStatus">Getting things ready...</span>
                </div>
            </div>

            <!-- Footer Text -->
            <div class="microsoft-footer">
                <span>© {{ date('Y') }} {{ config('settings.site_name', 'Bytte.no') }}. All rights reserved.</span>
            </div>
        </div>

            <!-- Loading Status -->
            <div class="loading-status">
                <div class="status-text">
                    <span id="statusText">Initializing...</span>
                </div>
            </div>


        </div>

        <!-- Background Elements -->
        <div class="preloader-bg-elements">
            <div class="bg-shape shape-1"></div>
            <div class="bg-shape shape-2"></div>
            <div class="bg-shape shape-3"></div>
            <div class="bg-shape shape-4"></div>
        </div>
    </div>
</div>

<style>
/* Worldclass Preloader Styles */
        .worldclass-preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: linear-gradient(135deg, rgba(15, 80, 87, 0.95) 0%, rgba(26, 107, 109, 0.95) 100%);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            visibility: visible;
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

.worldclass-preloader.fade-out {
    opacity: 0;
    visibility: hidden;
}

        .preloader-overlay {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background:
                radial-gradient(circle at 20% 80%, rgba(250, 244, 215, 0.15) 0%, transparent 60%),
                radial-gradient(circle at 80% 20%, rgba(250, 244, 215, 0.12) 0%, transparent 60%),
                radial-gradient(circle at 40% 40%, rgba(15, 80, 87, 0.1) 0%, transparent 60%),
                linear-gradient(45deg, rgba(255, 255, 255, 0.03) 0%, transparent 50%, rgba(255, 255, 255, 0.03) 100%);
            animation: subtleFloat 8s ease-in-out infinite;
        }

        .loader-container {
            text-align: center;
            z-index: 10;
            max-width: 480px;
            padding: 3rem;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 32px;
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 2px solid rgba(255, 255, 255, 0.25);
            box-shadow:
                0 32px 64px rgba(0, 0, 0, 0.25),
                inset 0 2px 0 rgba(255, 255, 255, 0.15);
            animation: containerFloat 4s ease-in-out infinite;
            position: relative;
            overflow: hidden;
        }

        .loader-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), rgba(255,255,255,0.25), rgba(255,255,255,0.15), transparent);
            animation: shimmer 4s ease-in-out infinite;
            border-radius: 32px;
        }

@keyframes containerFloat {
    0%, 100% { transform: translateY(0px) scale(1); }
    50% { transform: translateY(-8px) scale(1.02); }
}

@keyframes subtleFloat {
    0%, 100% { transform: translate(0, 0) rotate(0deg); opacity: 0.3; }
    25% { transform: translate(10px, -10px) rotate(1deg); opacity: 0.4; }
    50% { transform: translate(-5px, 5px) rotate(-1deg); opacity: 0.35; }
    75% { transform: translate(-10px, -5px) rotate(0.5deg); opacity: 0.45; }
}

@keyframes patternShift {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(10px, -10px) scale(1.05); }
    66% { transform: translate(-10px, 10px) scale(0.95); }
}

@keyframes iconPulse {
    0%, 100% { transform: scale(1); opacity: 0.2; }
    50% { transform: scale(1.1); opacity: 0.3; }
}

@keyframes squareFill {
    0%, 100% {
        opacity: 0.7;
        transform: scale(1);
    }
    50% {
        opacity: 1;
        transform: scale(1.1);
    }
}

@keyframes microsoftShimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

@keyframes dotPulse {
    0%, 100% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.3);
        opacity: 0.8;
    }
}

@keyframes subtleFloat {
    0%, 100% { transform: translate(0, 0) rotate(0deg); opacity: 0.3; }
    25% { transform: translate(10px, -10px) rotate(1deg); opacity: 0.4; }
    50% { transform: translate(-5px, 5px) rotate(-1deg); opacity: 0.35; }
    75% { transform: translate(-10px, -5px) rotate(0.5deg); opacity: 0.45; }
}

@keyframes shimmer {
    0% { left: -100%; }
    50% { left: 100%; }
    100% { left: -100%; }
}

/* Logo Section */
.loader-logo-section {
    margin-bottom: 2rem;
}

.loader-logo {
    width: 80px;
    height: 80px;
    border-radius: 16px;
    margin-bottom: 1rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    animation: logoGlow 2s ease-in-out infinite alternate;
}

@keyframes logoGlow {
    0% { box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2), 0 0 20px rgba(255, 255, 255, 0.1); }
    100% { box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3), 0 0 30px rgba(255, 255, 255, 0.2); }
}

.loader-brand {
    animation: brandFadeIn 1s ease-out 0.5s both;
}

        .loader-title {
            font-size: 2.8rem;
            font-weight: 800;
            color: #ffffff;
            margin: 0 0 0.8rem 0;
            text-shadow:
                0 2px 20px rgba(0, 0, 0, 0.6),
                0 0 40px rgba(255, 255, 255, 0.3);
            background: linear-gradient(135deg, #ffffff 0%, rgba(250, 244, 215, 0.9) 50%, #ffffff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 1px;
        }

        .loader-subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.95);
            margin: 0 0 2rem 0;
            font-weight: 500;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
            opacity: 0.9;
        }

/* Microsoft-Style Loader */
.microsoft-loader {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2rem;
    max-width: 600px;
    width: 100%;
    padding: 0 2rem;
}

/* Windows Logo */
.windows-logo {
    margin-bottom: 1rem;
}

.logo-squares {
    position: relative;
    width: 60px;
    height: 60px;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-template-rows: repeat(2, 1fr);
    gap: 4px;
}

.square {
    background: linear-gradient(135deg, #0078d4 0%, #005a9e 100%);
    border-radius: 2px;
    animation: squareFill 2.5s ease-in-out infinite;
    box-shadow: 0 2px 8px rgba(0, 120, 212, 0.3);
}

.square-1 {
    animation-delay: 0s;
    background: linear-gradient(135deg, #0078d4 0%, #005a9e 100%);
}

.square-2 {
    animation-delay: 0.2s;
    background: linear-gradient(135deg, #0078d4 0%, #005a9e 100%);
}

.square-3 {
    animation-delay: 0.4s;
    background: linear-gradient(135deg, #0078d4 0%, #005a9e 100%);
}

.square-4 {
    animation-delay: 0.6s;
    background: linear-gradient(135deg, #0078d4 0%, #005a9e 100%);
}

/* Brand Section */
.microsoft-brand {
    text-align: center;
    margin-bottom: 2rem;
}

.microsoft-title {
    font-size: 2.2rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0 0 0.5rem 0;
    letter-spacing: 0.5px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.microsoft-subtitle {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
    font-weight: 400;
}

/* Progress Section */
.microsoft-progress {
    width: 100%;
    margin-bottom: 2rem;
}

.progress-track {
    width: 100%;
    height: 3px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 2px;
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #0078d4 0%, #106ebe 50%, #0078d4 100%);
    border-radius: 2px;
    width: 0%;
    transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.progress-fill::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    animation: microsoftShimmer 2s ease-in-out infinite;
}

.progress-dots {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.progress-dot {
    width: 8px;
    height: 8px;
    background: rgba(255, 255, 255, 0.4);
    border-radius: 50%;
    transition: all 0.3s ease;
}

.progress-dot.active {
    background: #0078d4;
    box-shadow: 0 0 12px rgba(0, 120, 212, 0.6);
    animation: dotPulse 1.2s ease-in-out infinite;
}

.progress-text {
    text-align: center;
}

.progress-text span {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
}

/* Footer */
.microsoft-footer {
    margin-top: 1rem;
    text-align: center;
}

.microsoft-footer span {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.6);
    font-weight: 400;
}



        .progress-text {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }



/* Background Elements */
.preloader-bg-elements {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    pointer-events: none;
}

        .bg-shape {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(250, 244, 215, 0.08) 0%, transparent 80%);
            backdrop-filter: blur(10px);
            animation: shapeFloat 8s ease-in-out infinite;
        }

.shape-1 {
    width: 200px;
    height: 200px;
    top: 10%;
    left: 10%;
    animation-delay: 0s;
}

.shape-2 {
    width: 150px;
    height: 150px;
    top: 60%;
    right: 10%;
    animation-delay: 2s;
}

.shape-3 {
    width: 100px;
    height: 100px;
    bottom: 20%;
    left: 20%;
    animation-delay: 4s;
}

.shape-4 {
    width: 80px;
    height: 80px;
    top: 30%;
    right: 30%;
    animation-delay: 1s;
}

@keyframes shapeFloat {
    0%, 100% {
        transform: translateY(0px) rotate(0deg) scale(1);
        opacity: 0.15;
    }
    33% {
        transform: translateY(-15px) rotate(120deg) scale(1.1);
        opacity: 0.25;
    }
    66% {
        transform: translateY(10px) rotate(240deg) scale(0.9);
        opacity: 0.2;
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .microsoft-loader {
        padding: 0 1.5rem;
    }

    .logo-squares {
        width: 50px;
        height: 50px;
    }

    .microsoft-title {
        font-size: 1.8rem;
    }

    .microsoft-subtitle {
        font-size: 0.9rem;
    }

    .progress-text span {
        font-size: 0.85rem;
    }

    .microsoft-footer span {
        font-size: 0.75rem;
    }
}

@media (max-width: 480px) {
    .microsoft-loader {
        padding: 0 1rem;
        gap: 1.5rem;
    }

    .logo-squares {
        width: 40px;
        height: 40px;
        gap: 3px;
    }

    .microsoft-title {
        font-size: 1.6rem;
        margin-bottom: 0.3rem;
    }

    .microsoft-subtitle {
        font-size: 0.85rem;
    }

    .microsoft-progress {
        margin-bottom: 1.5rem;
    }

    .progress-dots {
        gap: 0.4rem;
    }

    .progress-dot {
        width: 6px;
        height: 6px;
    }

    .progress-text span {
        font-size: 0.8rem;
    }

    .microsoft-footer {
        margin-top: 0.8rem;
    }

    .microsoft-footer span {
        font-size: 0.7rem;
    }
}

    .icon-container {
        width: 70px;
        height: 70px;
    }

    .loader-compass {
        font-size: 2rem;
    }

    .brand-title {
        font-size: 2.2rem;
    }

    .brand-tagline {
        font-size: 0.9rem;
    }

    .card-content {
        padding: 2rem 1.5rem;
    }

    .progress-percentage {
        font-size: 1.1rem;
    }

    .progress-status span {
        font-size: 0.9rem;
    }

    .tip-item span {
        font-size: 0.85rem;
    }
}

@media (max-width: 480px) {
    .loader-container {
        padding: 1.5rem;
    }

    .icon-container {
        width: 60px;
        height: 60px;
    }

    .loader-compass {
        font-size: 1.8rem;
    }

    .brand-title {
        font-size: 1.8rem;
        margin-bottom: 0.3rem;
    }

    .brand-tagline {
        font-size: 0.85rem;
    }

    .card-content {
        padding: 1.5rem 1rem;
    }

    .progress-percentage {
        font-size: 1rem;
    }

    .progress-status {
        margin-top: 0.8rem;
    }

    .progress-status span {
        font-size: 0.85rem;
    }

    .loading-tips {
        margin-top: 1.5rem;
        max-height: 50px;
    }

    .tip-item span {
        font-size: 0.8rem;
    }
}

/* Animation Delays */
@keyframes brandFadeIn {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
// Microsoft-Style Preloader JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const preloader = document.getElementById('worldclass-preloader');
    const progressFill = document.getElementById('microsoftProgressFill');
    const currentStatus = document.getElementById('microsoftStatus');
    const progressDots = document.querySelectorAll('.progress-dot');

    if (!preloader) return;

    const loadingPhases = [
        { percent: 0, status: 'Getting things ready...', dots: 1 },
        { percent: 30, status: 'Loading your content...', dots: 2 },
        { percent: 70, status: 'Almost there...', dots: 2 },
        { percent: 100, status: 'Welcome to ' + (document.querySelector('.microsoft-title')?.textContent || 'Bytte.no'), dots: 3 }
    ];

    let currentPhase = 0;
    let currentPercent = 0;
    const duration = 3500; // Total loading time
    const increment = 100 / (duration / 50); // Progress increment per frame

    // Function to update progress dots
    function updateDots(dotCount) {
        progressDots.forEach((dot, index) => {
            if (index < dotCount) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    // Progress animation
    const progressInterval = setInterval(() => {
        currentPercent += increment;

        if (currentPercent >= 100) {
            currentPercent = 100;
            clearInterval(progressInterval);

            // Activate all dots and show completion
            updateDots(3);

            // Hide preloader after completion
            setTimeout(() => {
                preloader.classList.add('fade-out');
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 1000);
            }, 1000);
        }

        // Update progress bar
        if (progressFill) {
            progressFill.style.width = currentPercent + '%';
        }

        // Update status and dots based on progress
        const nextPhaseIndex = loadingPhases.findIndex(phase => phase.percent > currentPercent);
        const currentPhaseIndex = nextPhaseIndex > 0 ? nextPhaseIndex - 1 : 0;
        const phase = loadingPhases[currentPhaseIndex];

        if (currentStatus && phase) {
            currentStatus.textContent = phase.status;
        }

        if (phase) {
            updateDots(phase.dots);
        }
    }, 50);

    // Handle page load completion
    window.addEventListener('load', function() {
        // Ensure minimum loading time and complete progress
        setTimeout(() => {
            if (currentPercent < 100) {
                currentPercent = 100;
                if (progressFill) progressFill.style.width = '100%';
                if (currentStatus) currentStatus.textContent = 'Welcome to ' + (document.querySelector('.microsoft-title')?.textContent || 'Bytte.no');
                updateDots(3);

                setTimeout(() => {
                    preloader.classList.add('fade-out');
                    setTimeout(() => {
                        preloader.style.display = 'none';
                    }, 1000);
                }, 1200);
            }
        }, 300);
    });

    // Fallback: hide preloader after 6 seconds max
    setTimeout(() => {
        if (preloader.style.display !== 'none') {
            currentPercent = 100;
            if (progressFill) progressFill.style.width = '100%';
            if (currentStatus) currentStatus.textContent = 'Welcome to ' + (document.querySelector('.microsoft-title')?.textContent || 'Bytte.no');
            updateDots(3);

            setTimeout(() => {
                preloader.classList.add('fade-out');
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 1000);
            }, 500);
        }
    }, 6000);
});
</script>