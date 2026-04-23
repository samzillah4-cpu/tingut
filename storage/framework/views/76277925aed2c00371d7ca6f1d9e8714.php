<!-- Worldclass Preloader -->
<div id="worldclass-preloader" class="worldclass-preloader">
    <div class="preloader-overlay">
        <!-- Main Loader Container -->
        <div class="loader-container">
            <!-- Logo Section -->
            <div class="loader-logo-section">
                <?php if(config('settings.site_logo')): ?>
                    <img src="<?php echo e(asset('storage/' . config('settings.site_logo'))); ?>"
                         alt="<?php echo e(config('settings.site_name', 'Bytte.no')); ?>"
                         class="loader-logo">
                <?php endif; ?>
                <div class="loader-brand">
                    <h1 class="loader-title"><?php echo e(config('settings.site_name', 'Bytte.no')); ?></h1>
                    <p class="loader-subtitle">Loading amazing experiences...</p>
                </div>
            </div>

            <!-- Animated Loader -->
            <div class="loader-animation">
                <!-- Spinning Rings -->
                <div class="loader-rings">
                    <div class="ring ring-1"></div>
                    <div class="ring ring-2"></div>
                    <div class="ring ring-3"></div>
                </div>

                <!-- Pulsing Dots -->
                <div class="loader-dots">
                    <div class="dot dot-1"></div>
                    <div class="dot dot-2"></div>
                    <div class="dot dot-3"></div>
                </div>

                <!-- Wave Animation -->
                <div class="loader-wave">
                    <div class="wave-bar"></div>
                    <div class="wave-bar"></div>
                    <div class="wave-bar"></div>
                    <div class="wave-bar"></div>
                    <div class="wave-bar"></div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="loader-progress">
                <div class="progress-bar">
                    <div class="progress-fill" id="progressFill"></div>
                </div>
                <div class="progress-text">
                    <span id="progressText">0%</span>
                </div>
            </div>

            <!-- Loading Messages -->
            <div class="loader-messages">
                <div class="message" data-message="Preparing your experience...">Preparing your experience...</div>
                <div class="message" data-message="Loading amazing content...">Loading amazing content...</div>
                <div class="message" data-message="Almost ready...">Almost ready...</div>
                <div class="message" data-message="Welcome to TingUt.no!">Welcome to TingUt.no!</div>
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
    background: linear-gradient(135deg, #0f5057 0%, #1a6b73 50%, #0f5057 100%);
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
}

.loader-container {
    text-align: center;
    z-index: 10;
    max-width: 400px;
    padding: 2rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 24px;
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
    animation: containerFloat 3s ease-in-out infinite;
}

@keyframes containerFloat {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
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
    0% { box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); }
    100% { box-shadow: 0 10px 40px rgba(250, 244, 215, 0.4); }
}

.loader-brand {
    animation: brandFadeIn 1s ease-out 0.5s both;
}

.loader-title {
    font-size: 2rem;
    font-weight: 700;
    color: #faf4d7;
    margin: 0 0 0.5rem 0;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.loader-subtitle {
    font-size: 1rem;
    color: rgba(250, 244, 215, 0.8);
    margin: 0;
    font-weight: 400;
}

/* Loader Animation */
.loader-animation {
    margin: 2rem 0;
    position: relative;
}

/* Spinning Rings */
.loader-rings {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 1.5rem auto;
}

.ring {
    position: absolute;
    border: 3px solid rgba(250, 244, 215, 0.3);
    border-radius: 50%;
    animation: spin 2s linear infinite;
}

.ring-1 {
    width: 120px;
    height: 120px;
    top: 0;
    left: 0;
    border-top-color: #faf4d7;
    animation-duration: 2s;
}

.ring-2 {
    width: 90px;
    height: 90px;
    top: 15px;
    left: 15px;
    border-right-color: #faf4d7;
    animation-duration: 1.5s;
    animation-direction: reverse;
}

.ring-3 {
    width: 60px;
    height: 60px;
    top: 30px;
    left: 30px;
    border-bottom-color: #faf4d7;
    animation-duration: 1s;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Pulsing Dots */
.loader-dots {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-bottom: 1.5rem;
}

.dot {
    width: 12px;
    height: 12px;
    background: #faf4d7;
    border-radius: 50%;
    animation: pulse 1.5s ease-in-out infinite;
}

.dot-1 { animation-delay: 0s; }
.dot-2 { animation-delay: 0.2s; }
.dot-3 { animation-delay: 0.4s; }

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        opacity: 0.7;
    }
    50% {
        transform: scale(1.2);
        opacity: 1;
    }
}



/* Progress Bar */
.loader-progress {
    margin-top: 1.5rem;
}

.progress-bar {
    width: 100%;
    height: 4px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #faf4d7 0%, #0f5057 100%);
    border-radius: 2px;
    width: 0%;
    transition: width 0.3s ease;
    animation: progressShimmer 2s ease-in-out infinite;
}

@keyframes progressShimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

.progress-text {
    font-size: 0.875rem;
    color: rgba(250, 244, 215, 0.8);
    font-weight: 500;
}

/* Loading Messages */
.loader-messages {
    margin-top: 1rem;
    height: 1.5rem;
    overflow: hidden;
}

.message {
    animation: messageSlide 8s ease-in-out infinite;
    opacity: 0;
    transform: translateY(20px);
    font-size: 0.875rem;
    color: rgba(250, 244, 215, 0.9);
    font-weight: 400;
}

.message:nth-child(1) { animation-delay: 0s; }
.message:nth-child(2) { animation-delay: 2s; }
.message:nth-child(3) { animation-delay: 4s; }
.message:nth-child(4) { animation-delay: 6s; }

@keyframes messageSlide {
    0%, 20% {
        opacity: 1;
        transform: translateY(0);
    }
    25%, 100% {
        opacity: 0;
        transform: translateY(-20px);
    }
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
    background: radial-gradient(circle, rgba(250, 244, 215, 0.1) 0%, transparent 70%);
    animation: shapeFloat 6s ease-in-out infinite;
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
        transform: translateY(0px) rotate(0deg);
        opacity: 0.3;
    }
    50% {
        transform: translateY(-20px) rotate(180deg);
        opacity: 0.6;
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .loader-container {
        max-width: 90%;
        padding: 1.5rem;
        margin: 1rem;
    }

    .loader-title {
        font-size: 1.5rem;
    }

    .loader-subtitle {
        font-size: 0.875rem;
    }

    .loader-rings {
        width: 100px;
        height: 100px;
    }

    .ring-1 { width: 100px; height: 100px; }
    .ring-2 { width: 75px; height: 75px; top: 12.5px; left: 12.5px; }
    .ring-3 { width: 50px; height: 50px; top: 25px; left: 25px; }

    .loader-logo {
        width: 60px;
        height: 60px;
    }
}

@media (max-width: 480px) {
    .loader-container {
        padding: 1rem;
    }

    .loader-title {
        font-size: 1.25rem;
    }

    .loader-rings {
        width: 80px;
        height: 80px;
    }

    .ring-1 { width: 80px; height: 80px; }
    .ring-2 { width: 60px; height: 60px; top: 10px; left: 10px; }
    .ring-3 { width: 40px; height: 40px; top: 20px; left: 20px; }
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
// Worldclass Preloader JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const preloader = document.getElementById('worldclass-preloader');
    const progressFill = document.getElementById('progressFill');
    const progressText = document.getElementById('progressText');

    if (!preloader) return;

    let progress = 0;
    const targetProgress = 100;
    const duration = 3000; // 3 seconds
    const increment = targetProgress / (duration / 50);

    // Progress animation
    const progressInterval = setInterval(() => {
        progress += increment;
        if (progress >= targetProgress) {
            progress = targetProgress;
            clearInterval(progressInterval);

            // Hide preloader after a short delay
            setTimeout(() => {
                preloader.classList.add('fade-out');
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 800);
            }, 500);
        }

        // Update progress bar and text
        progressFill.style.width = progress + '%';
        progressText.textContent = Math.round(progress) + '%';
    }, 50);

    // Handle page load completion
    window.addEventListener('load', function() {
        // Ensure minimum loading time
        setTimeout(() => {
            if (progress < targetProgress) {
                progress = targetProgress;
                progressFill.style.width = '100%';
                progressText.textContent = '100%';

                setTimeout(() => {
                    preloader.classList.add('fade-out');
                    setTimeout(() => {
                        preloader.style.display = 'none';
                    }, 800);
                }, 300);
            }
        }, 1000);
    });

    // Fallback: hide preloader after 5 seconds max
    setTimeout(() => {
        if (preloader.style.display !== 'none') {
            preloader.classList.add('fade-out');
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 800);
        }
    }, 5000);
});
</script><?php /**PATH /var/www/html/resources/views/components/preloader.blade.php ENDPATH**/ ?>