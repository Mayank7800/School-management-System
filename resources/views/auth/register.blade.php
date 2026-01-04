<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Management System - Register</title>
    <link rel="icon" type="image/x-icon" sizes="180x180" href="{{ asset('public/logokid.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/logokid.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/logokid.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/logokid.png') }}">
    <link rel="manifest" href="{{ asset('public/logokid.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: 
                linear-gradient(rgba(255, 255, 255, 0.92), rgba(255, 255, 255, 0.92)),
                url('https://images.unsplash.com/photo-1591123120675-6f7f1aae0e5b?q=80&w=869&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 15px;
        }

        .register-wrapper {
            display: flex;
            max-width: 1100px;
            width: 100%;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            overflow: hidden;
            min-height: 650px;
        }

        .image-section {
            flex: 1;
            background: 
                linear-gradient(rgba(44, 62, 80, 0.9), rgba(52, 152, 219, 0.85)),
                url('https://plus.unsplash.com/premium_photo-1680807869780-e0876a6f3cd5?q=80&w=871&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 40px 35px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .register-section {
            flex: 1;
            padding: 40px 35px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
        }

        .school-logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .school-logo h1 {
            color: #2c3e50;
            font-size: 26px;
            margin: 0;
            font-weight: 700;
        }

        .school-logo p {
            color: #7f8c8d;
            font-size: 15px;
            margin: 8px 0 0 0;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #2c3e50;
            font-weight: 500;
            font-size: 22px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        input[type="text"], input[type="email"], input[type="password"], input[type="tel"] {
            width: 100%;
            padding: 14px 18px;
            border-radius: 10px;
            border: 1px solid #ddd;
            outline: none;
            font-size: 15px;
            transition: all 0.3s;
            box-sizing: border-box;
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus, input[type="tel"]:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
        }

        .error-message {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
            display: none;
        }

        button {
            width: 100%;
            padding: 15px;
            background: #28a745;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        button:hover {
            background: #1e7e34;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
        }

        button:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        p {
            text-align: center;
            margin-top: 20px;
            color: #7f8c8d;
            font-size: 14px;
        }

        a {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
        }

        a:hover {
            text-decoration: underline;
        }

        .alert-success {
            color: #27ae60;
            text-align: center;
            margin-bottom: 20px;
            padding: 12px;
            background: #d5f4e6;
            border-radius: 8px;
            border-left: 4px solid #27ae60;
            font-size: 14px;
        }

        .alert-error {
            color: #e74c3c;
            text-align: center;
            margin-bottom: 20px;
            padding: 12px;
            background: #fadbd8;
            border-radius: 8px;
            border-left: 4px solid #e74c3c;
            font-size: 14px;
        }

        .role-selector {
            margin-bottom: 20px;
        }

        .role-selector select {
            width: 100%;
            padding: 14px 18px;
            border-radius: 10px;
            border: 1px solid #ddd;
            outline: none;
            font-size: 15px;
            background: white;
            color: #333;
            cursor: pointer;
        }

        .image-content h3 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .image-content p {
            font-size: 15px;
            line-height: 1.5;
            margin-bottom: 20px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
            text-align: left;
            color: rgba(255,255,255,0.95);
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .features-list li {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            font-weight: 500;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
            font-size: 14px;
            line-height: 1.4;
        }

        .features-list li i {
            margin-right: 12px;
            color: #f39c12;
            font-size: 16px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .contact-info {
            margin-top: 25px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .contact-info h5 {
            color: #fff;
            margin-bottom: 15px;
            font-weight: 700;
            font-size: 16px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            color: #fff;
            font-size: 14px;
            font-weight: 500;
        }

        .contact-item i {
            margin-right: 10px;
            color: #f39c12;
            width: 16px;
            text-align: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .contact-item a {
            color: white;
            text-decoration: none;
        }

        .contact-item a:hover {
            text-decoration: underline;
        }

        .password-strength {
            margin-top: 5px;
            font-size: 12px;
            display: none;
        }

        .strength-weak { color: #e74c3c; }
        .strength-medium { color: #f39c12; }
        .strength-strong { color: #27ae60; }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            body {
                padding: 10px;
                background-attachment: scroll;
            }

            .register-wrapper {
                flex-direction: column;
                max-width: 100%;
                min-height: auto;
                border-radius: 15px;
            }

            .image-section {
                padding: 30px 25px;
                order: 2;
            }

            .register-section {
                padding: 30px 25px;
                order: 1;
            }

            .image-content h3 {
                font-size: 22px;
                text-align: center;
            }

            .image-content p {
                text-align: center;
                font-size: 14px;
            }

            .features-list {
                margin: 15px 0;
            }

            .features-list li {
                font-size: 13px;
                margin-bottom: 10px;
            }

            .contact-info {
                margin-top: 20px;
                padding: 15px;
            }

            .school-logo h1 {
                font-size: 22px;
            }

            h2 {
                font-size: 20px;
            }

            input[type="text"], input[type="email"], input[type="password"], input[type="tel"] {
                padding: 12px 15px;
                font-size: 14px;
            }

            button {
                padding: 14px;
                font-size: 15px;
            }
        }

        @media (max-width: 480px) {
            .image-section, .register-section {
                padding: 25px 20px;
            }

            .image-content h3 {
                font-size: 20px;
            }

            .school-logo h1 {
                font-size: 20px;
            }

            h2 {
                font-size: 18px;
            }

            .contact-info {
                padding: 12px;
            }

            .contact-item {
                font-size: 13px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="register-wrapper">
    <!-- Left Side - Image and School Info -->
    <div class="image-section">
        <div class="image-content">
            <h3>Join Our School Community</h3>
            <p>Become part of our educational ecosystem. Register now to access all the features of our comprehensive School Management System.</p>
            
            <ul class="features-list">
                <li><i class="fas fa-user-graduate"></i> Student Progress Tracking</li>
                <li><i class="fas fa-chalkboard-teacher"></i> Teacher Collaboration Tools</li>
                <li><i class="fas fa-calendar-alt"></i> Real-time Attendance System</li>
                <li><i class="fas fa-file-invoice-dollar"></i> Easy Fee Management</li>
                <li><i class="fas fa-book"></i> Digital Learning Resources</li>
                <li><i class="fas fa-bullhorn"></i> Direct Parent Communication</li>
            </ul>
        </div>
        
        <div class="contact-info">
            <h5>Need Help?</h5>
            <div class="contact-item">
                <i class="fas fa-envelope"></i>
                <span>info@apkwebtech.com</span>
            </div>
            <div class="contact-item">
                <i class="fas fa-phone"></i>
                <span>+91 9555019146</span>
            </div>
            <div class="contact-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>310, ABC Complex Nirmaan Vihar, Delhi</span>
            </div>
            <div class="contact-item">
                <i class="fas fa-globe"></i>
                <span><a href="https://www.apkwebtech.com/" target="_blank">www.apkwebtech.com</a></span>
            </div>
        </div>
    </div>
    
    <!-- Right Side - Registration Form -->
    <div class="register-section">
        <div class="school-logo">
            <h1>School Management System</h1>
            <p>Create Your Account</p>
        </div>

        <h2>Join Our Community</h2>

        <!-- Display Messages -->
        <div id="message-container">
            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif
        </div>

        <form method="POST" action="{{ route('register.post') }}" id="registerForm">
            @csrf
            
            <div class="role-selector">
                <select name="role" id="role" required>
                    <option value="">Select Your Role</option>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="parent">Parent</option>
                    <option value="staff">Staff Member</option>
                    <option value="admin" selected>Administrator</option>

                </select>
            </div>
            
            <div class="form-group">
                <input type="text" name="name" id="name" placeholder="Full Name" value="{{ old('name') }}" required>
                <div class="error-message" id="name-error">Please enter your full name</div>
            </div>

            <div class="form-group">
                <input type="email" name="email" id="email" placeholder="Email Address" value="{{ old('email') }}" required>
                <div class="error-message" id="email-error">Please enter a valid email address</div>
            </div>

            <div class="form-group">
                <input type="tel" name="phone" id="phone" placeholder="Phone Number" value="{{ old('phone') }}" required>
                <div class="error-message" id="phone-error">Please enter a valid phone number</div>
            </div>
            
            <div class="form-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <div class="error-message" id="password-error">Password must be at least 8 characters</div>
                <div class="password-strength" id="password-strength"></div>
            </div>

            <div class="form-group">
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
                <div class="error-message" id="confirm-password-error">Passwords do not match</div>
            </div>
            
            <button type="submit" id="register-btn">Create Account</button>
        </form>

        <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const registerForm = document.getElementById('registerForm');
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const roleSelect = document.getElementById('role');
        const passwordStrength = document.getElementById('password-strength');

        const nameError = document.getElementById('name-error');
        const emailError = document.getElementById('email-error');
        const phoneError = document.getElementById('phone-error');
        const passwordError = document.getElementById('password-error');
        const confirmPasswordError = document.getElementById('confirm-password-error');

        const registerBtn = document.getElementById('register-btn');

        // Password strength checker
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = '';
            let strengthText = '';
            let strengthClass = '';

            if (password.length === 0) {
                passwordStrength.style.display = 'none';
                return;
            }

            if (password.length < 6) {
                strength = 'weak';
                strengthText = 'Weak password';
                strengthClass = 'strength-weak';
            } else if (password.length < 8) {
                strength = 'medium';
                strengthText = 'Medium password';
                strengthClass = 'strength-medium';
            } else {
                // Check for complexity
                const hasUpperCase = /[A-Z]/.test(password);
                const hasLowerCase = /[a-z]/.test(password);
                const hasNumbers = /\d/.test(password);
                const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

                const complexityScore = [hasUpperCase, hasLowerCase, hasNumbers, hasSpecialChar].filter(Boolean).length;

                if (complexityScore >= 3) {
                    strength = 'strong';
                    strengthText = 'Strong password';
                    strengthClass = 'strength-strong';
                } else {
                    strength = 'medium';
                    strengthText = 'Medium password - add uppercase, numbers, or symbols';
                    strengthClass = 'strength-medium';
                }
            }

            passwordStrength.textContent = strengthText;
            passwordStrength.className = 'password-strength ' + strengthClass;
            passwordStrength.style.display = 'block';
        });

        // Form validation
        registerForm.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Reset error messages
            resetErrors();
            
            // Role validation
            if (!roleSelect.value) {
                showMessage('Please select your role', 'error');
                isValid = false;
            }
            
            // Name validation
            if (!nameInput.value.trim()) {
                nameError.textContent = 'Please enter your full name';
                nameError.style.display = 'block';
                isValid = false;
            }
            
            // Email validation
            if (!emailInput.value.trim()) {
                emailError.textContent = 'Please enter your email address';
                emailError.style.display = 'block';
                isValid = false;
            } else if (!isValidEmail(emailInput.value)) {
                emailError.textContent = 'Please enter a valid email address';
                emailError.style.display = 'block';
                isValid = false;
            }
            
            // Phone validation
            if (!phoneInput.value.trim()) {
                phoneError.textContent = 'Please enter your phone number';
                phoneError.style.display = 'block';
                isValid = false;
            } else if (!isValidPhone(phoneInput.value)) {
                phoneError.textContent = 'Please enter a valid phone number';
                phoneError.style.display = 'block';
                isValid = false;
            }
            
            // Password validation
            if (!passwordInput.value.trim()) {
                passwordError.textContent = 'Please enter a password';
                passwordError.style.display = 'block';
                isValid = false;
            } else if (passwordInput.value.length < 8) {
                passwordError.textContent = 'Password must be at least 8 characters';
                passwordError.style.display = 'block';
                isValid = false;
            }
            
            // Confirm password validation
            if (!confirmPasswordInput.value.trim()) {
                confirmPasswordError.textContent = 'Please confirm your password';
                confirmPasswordError.style.display = 'block';
                isValid = false;
            } else if (passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordError.textContent = 'Passwords do not match';
                confirmPasswordError.style.display = 'block';
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                showMessage('Please fill in all required fields correctly', 'error');
            }
        });

        // Real-time validation
        nameInput.addEventListener('blur', validateName);
        emailInput.addEventListener('blur', validateEmail);
        phoneInput.addEventListener('blur', validatePhone);
        passwordInput.addEventListener('blur', validatePassword);
        confirmPasswordInput.addEventListener('blur', validateConfirmPassword);

        // Clear errors on input
        nameInput.addEventListener('input', clearError(nameError));
        emailInput.addEventListener('input', clearError(emailError));
        phoneInput.addEventListener('input', clearError(phoneError));
        passwordInput.addEventListener('input', clearError(passwordError));
        confirmPasswordInput.addEventListener('input', clearError(confirmPasswordError));

        function validateName() {
            if (!nameInput.value.trim()) {
                nameError.textContent = 'Please enter your full name';
                nameError.style.display = 'block';
            } else {
                nameError.style.display = 'none';
            }
        }

        function validateEmail() {
            if (!emailInput.value.trim()) {
                emailError.textContent = 'Please enter your email address';
                emailError.style.display = 'block';
            } else if (!isValidEmail(emailInput.value)) {
                emailError.textContent = 'Please enter a valid email address';
                emailError.style.display = 'block';
            } else {
                emailError.style.display = 'none';
            }
        }

        function validatePhone() {
            if (!phoneInput.value.trim()) {
                phoneError.textContent = 'Please enter your phone number';
                phoneError.style.display = 'block';
            } else if (!isValidPhone(phoneInput.value)) {
                phoneError.textContent = 'Please enter a valid phone number';
                phoneError.style.display = 'block';
            } else {
                phoneError.style.display = 'none';
            }
        }

        function validatePassword() {
            if (!passwordInput.value.trim()) {
                passwordError.textContent = 'Please enter a password';
                passwordError.style.display = 'block';
            } else if (passwordInput.value.length < 8) {
                passwordError.textContent = 'Password must be at least 8 characters';
                passwordError.style.display = 'block';
            } else {
                passwordError.style.display = 'none';
            }
        }

        function validateConfirmPassword() {
            if (!confirmPasswordInput.value.trim()) {
                confirmPasswordError.textContent = 'Please confirm your password';
                confirmPasswordError.style.display = 'block';
            } else if (passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordError.textContent = 'Passwords do not match';
                confirmPasswordError.style.display = 'block';
            } else {
                confirmPasswordError.style.display = 'none';
            }
        }

        function clearError(errorElement) {
            return function() {
                if (this.value.trim()) {
                    errorElement.style.display = 'none';
                }
            };
        }

        function resetErrors() {
            nameError.style.display = 'none';
            emailError.style.display = 'none';
            phoneError.style.display = 'none';
            passwordError.style.display = 'none';
            confirmPasswordError.style.display = 'none';
        }

        // Email validation function
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Phone validation function
        function isValidPhone(phone) {
            const phoneRegex = /^[\+]?[0-9\s\-\(\)]{10,}$/;
            return phoneRegex.test(phone.replace(/\s/g, ''));
        }

        // Show message function
        function showMessage(message, type) {
            const messageContainer = document.getElementById('message-container');
            const messageDiv = document.createElement('div');
            messageDiv.className = type === 'error' ? 'alert-error' : 'alert-success';
            messageDiv.textContent = message;
            
            // Clear existing messages
            while (messageContainer.firstChild) {
                messageContainer.removeChild(messageContainer.firstChild);
            }
            
            messageContainer.appendChild(messageDiv);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (messageContainer.contains(messageDiv)) {
                    messageContainer.removeChild(messageDiv);
                }
            }, 5000);
        }
    });
</script>

</body>
</html>