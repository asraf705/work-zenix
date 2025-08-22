<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Create Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 50%, #2d2d2d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
        }

        .register-container {
            animation: slideUp 0.8s ease-out;
        }

        i {
            color: gray;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .register-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 35px 60px rgba(0, 0, 0, 0.4);
        }

        .form-input {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
        }

        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            transform: scale(1.02);
        }

        .password-toggle {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .password-toggle:hover {
            color: #3b82f6;
            transform: scale(1.1);
        }

        .btn-register {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-register:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-register:hover:before {
            left: 100%;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .password-strength {
            height: 4px;
            margin-top: 8px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-message {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .logo-container {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        .progress-step {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #e5e7eb;
            margin: 0 4px;
            transition: all 0.3s ease;
        }

        .progress-step.active {
            background: #3b82f6;
            transform: scale(1.2);
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card w-full max-w-md p-8">
            <!-- Logo -->
            <div class="text-center mb-8 logo-container">
                <div class="w-20 h-20 bg-gray-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-plus text-white text-3xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Create Account</h1>
                <p class="text-gray-600">Join our community today</p>
            </div>

            <!-- Registration Form -->
            <form action="{{ route('auth.register') }}" method="POST" class="space-y-6" id="registerForm">
                <!-- CSRF Token (for Laravel) -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <!-- Name Input -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            required
                            class="form-input w-full pl-10 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter your full name"
                        >
                    </div>
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            required
                            class="form-input w-full pl-10 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter your email"
                        >
                    </div>
                </div>

                <!-- Phone Input -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            required
                            class="form-input w-full pl-10 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter your phone number"
                        >
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="form-input w-full pl-10 pr-12 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Create a password"
                            oninput="checkPasswordStrength()"
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button
                                type="button"
                                class="password-toggle text-gray-400 hover:text-gray-600 focus:outline-none"
                                onclick="togglePassword('password')"
                            >
                                <i class="fas fa-eye" id="password-eye-icon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex space-x-1 mt-2">
                        <div class="progress-step" id="strength-1"></div>
                        <div class="progress-step" id="strength-2"></div>
                        <div class="progress-step" id="strength-3"></div>
                        <div class="progress-step" id="strength-4"></div>
                    </div>
                </div>

                <!-- Confirm Password Input -->
                <div>
                    <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input
                            type="password"
                            id="confirmPassword"
                            name="password_confirmation"
                            required
                            class="form-input w-full pl-10 pr-12 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Confirm your password"
                            oninput="validatePasswordMatch()"
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button
                                type="button"
                                class="password-toggle text-gray-400 hover:text-gray-600 focus:outline-none"
                                onclick="togglePassword('confirmPassword')"
                            >
                                <i class="fas fa-eye" id="confirmPassword-eye-icon"></i>
                            </button>
                        </div>
                    </div>
                    <p id="passwordMatchMessage" class="text-sm mt-2 hidden"></p>
                </div>

                <!-- Terms Agreement -->
                <label class="flex items-start">
                    <input type="checkbox" name="terms" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1" required>
                    <span class="ml-2 text-sm text-gray-600">
                        I agree to the <a href="#" class="text-blue-600 hover:text-blue-800">Terms of Service</a> and <a href="#" class="text-blue-600 hover:text-blue-800">Privacy Policy</a>
                    </span>
                </label>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="btn-register w-full py-3 px-4 rounded-xl text-white font-semibold text-sm uppercase tracking-wide focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700"
                >
                    <i class="fas fa-user-plus mr-2"></i>
                    Create Account
                </button>
            </form>

            <!-- Login Link -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('auth.login') }}" class="text-blue-600 font-semibold hover:text-blue-800 transition-colors">Sign in</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(fieldId + '-eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthSteps = document.querySelectorAll('.progress-step');

            // Reset all steps
            strengthSteps.forEach(step => step.classList.remove('active'));

            if (password.length === 0) return;

            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            // Activate steps based on strength
            for (let i = 0; i < strength; i++) {
                if (strengthSteps[i]) {
                    strengthSteps[i].classList.add('active');
                }
            }
        }

        function validatePasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const messageElement = document.getElementById('passwordMatchMessage');

            if (confirmPassword.length === 0) {
                messageElement.classList.add('hidden');
                return;
            }

            if (password === confirmPassword) {
                messageElement.textContent = 'Passwords match!';
                messageElement.className = 'text-sm mt-2 text-green-600';
            } else {
                messageElement.textContent = 'Passwords do not match';
                messageElement.className = 'text-sm mt-2 text-red-600';
            }
            messageElement.classList.remove('hidden');
        }

        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const terms = document.querySelector('input[name="terms"]').checked;

            let errors = [];

            if (!name) errors.push('Name is required');
            if (!email) errors.push('Email is required');
            if (!phone) errors.push('Phone number is required');
            if (!password) errors.push('Password is required');
            if (password !== confirmPassword) errors.push('Passwords do not match');
            if (!terms) errors.push('You must agree to the terms and conditions');

            if (errors.length > 0) {
                e.preventDefault();
                showError(errors.join('<br>'));
            }
        });

        function showError(message) {
            // Remove any existing error messages
            const existingError = document.querySelector('.error-message');
            if (existingError) {
                existingError.remove();
            }

            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm';
            errorDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>${message}</span>
                </div>
            `;

            document.getElementById('registerForm').prepend(errorDiv);

            // Auto-remove error message after 5 seconds
            setTimeout(() => {
                if (errorDiv.parentNode) {
                    errorDiv.remove();
                }
            }, 5000);
        }

        // Add subtle hover effects to all interactive elements
        document.querySelectorAll('input, button, a').forEach(element => {
            element.addEventListener('mouseenter', () => {
                element.style.transform = 'scale(1.02)';
                element.style.transition = 'transform 0.2s ease';
            });

            element.addEventListener('mouseleave', () => {
                element.style.transform = 'scale(1)';
            });
        });

        // Phone number formatting
        document.getElementById('phone').addEventListener('input', function(e) {
            const input = e.target.value.replace(/\D/g, '').substring(0, 15);
            let formattedInput = input;

            if (input.length > 3 && input.length <= 6) {
                formattedInput = input.replace(/(\d{3})(\d{0,3})/, '$1-$2');
            } else if (input.length > 6) {
                formattedInput = input.replace(/(\d{3})(\d{3})(\d{0,9})/, '$1-$2-$3');
            }

            e.target.value = formattedInput;
        });
    </script>
</body>
</html>

