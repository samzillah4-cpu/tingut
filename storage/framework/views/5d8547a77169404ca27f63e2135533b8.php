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

        <!-- Simple Progress Loader -->
        <div class="simple-loader">
            <!-- Progress Steps -->
            <div class="progress-steps">
                <div class="step step-1 active">
                    <div class="step-indicator">
                        <div class="step-dot"></div>
                    </div>
                    <span class="step-label">Loading</span>
                </div>
                <div class="step step-2">
                    <div class="step-indicator">
                        <div class="step-dot"></div>
                    </div>
                    <span class="step-label">Processing</span>
                </div>
                <div class="step step-3">
                    <div class="step-indicator">
                        <div class="step-dot"></div>
                    </div>
                    <span class="step-label">Ready</span>
                </div>
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

@keyframes dotPulse {
    0%, 100% {
        transform: scale(1.2);
        box-shadow:
            0 0 20px rgba(255, 255, 255, 0.8),
            0 0 40px rgba(255, 255, 255, 0.4),
            0 4px 12px rgba(0, 0, 0, 0.3);
    }
    50% {
        transform: scale(1.4);
        box-shadow:
            0 0 35px rgba(255, 255, 255, 1),
            0 0 70px rgba(255, 255, 255, 0.6),
            0 6px 18px rgba(0, 0, 0, 0.4);
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

/* Simple Progress Loader */
.simple-loader {
    margin: 2rem 0;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Progress Steps */
.progress-steps {
    display: flex;
    align-items: center;
    gap: 2.5rem;
    position: relative;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.8rem;
    opacity: 0.3;
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    transform: scale(0.9);
}

.step.active {
    opacity: 1;
    transform: scale(1.1);
}

.step.completed {
    opacity: 0.8;
    transform: scale(1);
}

.step-indicator {
    position: relative;
}

.step-dot {
    width: 16px;
    height: 16px;
    background: rgba(255, 255, 255, 0.4);
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.step.active .step-dot {
    background: #ffffff;
    border-color: #ffffff;
    box-shadow:
        0 0 20px rgba(255, 255, 255, 0.8),
        0 0 40px rgba(255, 255, 255, 0.4);
    animation: dotPulse 1.8s ease-in-out infinite;
    transform: scale(1.2);
}

.step.completed .step-dot {
    background: rgba(255, 255, 255, 0.9);
    border-color: rgba(255, 255, 255, 0.8);
    box-shadow: 0 0 15px rgba(255, 255, 255, 0.6);
}

.step-label {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.7);
    font-weight: 600;
    text-align: center;
    min-width: 80px;
    transition: all 0.4s ease;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    letter-spacing: 0.5px;
}

.step.active .step-label {
    color: #ffffff;
    font-weight: 700;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
}

.step.completed .step-label {
    color: rgba(255, 255, 255, 0.9);
}

/* Connection Lines */
.progress-steps {
    --progress-width: 0%;
}

.progress-steps::before {
    content: '';
    position: absolute;
    top: 8px;
    left: 32px;
    right: 32px;
    height: 2px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 1px;
    z-index: 0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

.progress-steps::after {
    content: '';
    position: absolute;
    top: 8px;
    left: 32px;
    height: 2px;
    background: linear-gradient(90deg, #ffffff 0%, rgba(15, 80, 87, 0.9) 100%);
    border-radius: 1px;
    z-index: 1;
    width: var(--progress-width);
    transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow:
        0 0 15px rgba(255, 255, 255, 0.8),
        0 2px 8px rgba(15, 80, 87, 0.4);
}

/* Loading Status */
.loading-status {
    margin-top: 2.5rem;
    text-align: center;
}

.status-text {
    font-size: 1.1rem;
    color: #ffffff;
    font-weight: 600;
    text-shadow:
        0 2px 8px rgba(0, 0, 0, 0.5),
        0 0 20px rgba(255, 255, 255, 0.3);
    animation: textGlow 2.5s ease-in-out infinite;
    letter-spacing: 0.8px;
    background: rgba(255, 255, 255, 0.1);
    padding: 0.8rem 1.5rem;
    border-radius: 25px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    display: inline-block;
    min-width: 200px;
}

@keyframes textGlow {
    0%, 100% {
        opacity: 0.9;
        transform: scale(1);
    }
    50% {
        opacity: 1;
        transform: scale(1.02);
    }
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
    .loader-container {
        max-width: 90%;
        padding: 2.5rem 2rem;
    }

    .loader-title {
        font-size: 2.4rem;
    }

    .loader-subtitle {
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .progress-steps {
        gap: 2rem;
    }

    .step-label {
        font-size: 0.8rem;
        min-width: 60px;
    }

    .status-text {
        font-size: 1rem;
        padding: 0.6rem 1.2rem;
        min-width: 180px;
    }
}

@media (max-width: 480px) {
    .loader-container {
        padding: 2rem 1.5rem;
    }

    .loader-title {
        font-size: 2rem;
        margin-bottom: 0.6rem;
    }

    .loader-subtitle {
        font-size: 1rem;
        margin-bottom: 1.2rem;
    }

    .progress-steps {
        gap: 1.5rem;
    }

    .step {
        gap: 0.6rem;
    }

    .step-dot {
        width: 14px;
        height: 14px;
    }

    .step-label {
        font-size: 0.75rem;
        min-width: 50px;
    }

    .status-text {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        min-width: 160px;
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
// Simple Progress Preloader JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const preloader = document.getElementById('worldclass-preloader');
    const statusText = document.getElementById('statusText');
    const steps = document.querySelectorAll('.step');
    const progressLine = document.querySelector('.progress-steps::after');

    if (!preloader) return;

    const loadingMessages = [
        'Initializing...',
        'Loading resources...',
        'Connecting to server...',
        'Almost ready...',
        'Welcome aboard!'
    ];

    let messageIndex = 0;
    let currentStep = 0;
    const messageDuration = 900; // Duration per message in ms

    // Function to activate next step
    function activateStep(stepIndex) {
        steps.forEach((step, index) => {
            if (index < stepIndex) {
                step.classList.remove('active');
                step.classList.add('completed');
            } else if (index === stepIndex) {
                step.classList.add('active');
                step.classList.remove('completed');
            } else {
                step.classList.remove('active', 'completed');
            }
        });

        // Update progress line width
        const progressWidth = ((stepIndex + 1) / steps.length) * 100;
        const progressContainer = document.querySelector('.progress-steps');
        if (progressContainer) {
            progressContainer.style.setProperty('--progress-width', progressWidth + '%');
        }
    }

    // Status message and step animation
    const messageInterval = setInterval(() => {
        messageIndex++;
        currentStep = Math.min(messageIndex, steps.length - 1);

        if (messageIndex >= loadingMessages.length) {
            messageIndex = loadingMessages.length - 1;
            clearInterval(messageInterval);

            // Activate final step
            activateStep(steps.length - 1);

            // Hide preloader after a short delay
            setTimeout(() => {
                preloader.classList.add('fade-out');
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 800);
            }, 1200);
        } else {
            // Activate current step
            activateStep(currentStep);
        }

        // Update status text
        if (statusText) {
            statusText.textContent = loadingMessages[messageIndex];
        }
    }, messageDuration);

    // Handle page load completion
    window.addEventListener('load', function() {
        // Ensure minimum loading time and complete all steps
        setTimeout(() => {
            if (statusText && statusText.textContent !== 'Welcome aboard!') {
                statusText.textContent = 'Welcome aboard!';
                activateStep(steps.length - 1); // Complete all steps

                setTimeout(() => {
                    preloader.classList.add('fade-out');
                    setTimeout(() => {
                        preloader.style.display = 'none';
                    }, 800);
                }, 1000);
            }
        }, 300);
    });

    // Fallback: hide preloader after 6 seconds max
    setTimeout(() => {
        if (preloader.style.display !== 'none') {
            if (statusText) {
                statusText.textContent = 'Welcome aboard!';
            }
            activateStep(steps.length - 1);
            setTimeout(() => {
                preloader.classList.add('fade-out');
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 800);
            }, 500);
        }
    }, 6000);
});
</script><?php /**PATH C:\xampp\htdocs\bytte.no\resources\views/components/preloader.blade.php ENDPATH**/ ?>