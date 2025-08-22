<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Secure Access</title>
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

        .login-container {
            animation: slideUp 0.8s ease-out;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .login-card:hover {
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

        .btn-login {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover:before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
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
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card w-full max-w-md p-8">
            <!-- Logo -->
            <div class="text-center mb-8 logo-container">
                <div class="w-20 h-20 bg-gray-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lock text-white text-3xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Secure Access</h1>
                <p class="text-gray-600">Sign in to your account</p>
            </div>

            <!-- Login Form -->
            <form action="{{ route('auth.login') }}" method="POST" class="space-y-6">
                <!-- CSRF Token (for Laravel) -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

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
                            placeholder="Enter your password"
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button
                                type="button"
                                class="password-toggle text-gray-400 hover:text-gray-600 focus:outline-none"
                                onclick="togglePassword()"
                            >
                                <i class="fas fa-eye" id="eye-icon"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800 transition-colors">Forgot password?</a>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="btn-login w-full py-3 px-4 rounded-xl text-white font-semibold text-sm uppercase tracking-wide focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Sign In
                </button>
            </form>


            <!-- Sign Up Link -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('auth.register') }}" class="text-blue-600 font-semibold hover:text-blue-800 transition-colors">Sign up</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

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

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (!email || !password) {
                e.preventDefault();
                showError('Please fill in all fields');
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

            document.querySelector('form').prepend(errorDiv);

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
    </script>
</body>
</html>

