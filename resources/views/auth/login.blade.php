<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Management System - Login</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('public/logokid.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('https://images.unsplash.com/photo-1591123120675-6f7f1aae0e5b?q=80&w=869&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-wrapper {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            overflow: hidden;
            max-height: 550px; /* Reduced height */
        }

        .image-section {
            flex: 1;
            background: 
                linear-gradient(rgba(44, 62, 80, 0.9), rgba(52, 152, 219, 0.85)),
                url('https://plus.unsplash.com/premium_photo-1680807869780-e0876a6f3cd5?q=80&w=871&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 30px 25px; /* Reduced padding */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow-y: auto; /* Enable scrolling if content overflows */
        }

        .login-section {
            flex: 1;
            padding: 30px 25px; /* Reduced padding */
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto; /* Enable scrolling if content overflows */
        }

        .school-logo {
            text-align: center;
            margin-bottom: 20px; /* Reduced margin */
        }

        .school-logo h1 {
            color: #2c3e50;
            font-size: 24px; /* Slightly smaller */
            margin: 0;
            font-weight: 700;
        }

        .school-logo p {
            color: #7f8c8d;
            font-size: 14px; /* Slightly smaller */
            margin: 6px 0 0 0;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px; /* Reduced margin */
            color: #2c3e50;
            font-weight: 500;
            font-size: 20px; /* Slightly smaller */
        }

        .form-group {
            margin-bottom: 15px; /* Reduced margin */
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px 15px; /* Reduced padding */
            border-radius: 10px;
            border: 1px solid #ddd;
            outline: none;
            font-size: 14px; /* Slightly smaller */
            transition: all 0.3s;
            box-sizing: border-box;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .error-message {
            color: #e74c3c;
            font-size: 12px; /* Slightly smaller */
            margin-top: 4px;
            display: none;
        }

        button {
            width: 100%;
            padding: 12px; /* Reduced padding */
            background: #3498db;
            color: #fff;
            font-size: 15px; /* Slightly smaller */
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 8px;
        }

        button:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3);
        }

        button:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        p {
            text-align: center;
            margin-top: 15px; /* Reduced margin */
            color: #7f8c8d;
            font-size: 13px; /* Slightly smaller */
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
            margin-bottom: 15px; /* Reduced margin */
            padding: 10px; /* Reduced padding */
            background: #d5f4e6;
            border-radius: 8px;
            border-left: 4px solid #27ae60;
            font-size: 13px; /* Slightly smaller */
        }

        .alert-error {
            color: #e74c3c;
            text-align: center;
            margin-bottom: 15px; /* Reduced margin */
            padding: 10px; /* Reduced padding */
            background: #fadbd8;
            border-radius: 8px;
            border-left: 4px solid #e74c3c;
            font-size: 13px; /* Slightly smaller */
        }

        .forgot-password {
            text-align: right;
            margin: -3px 0 12px 0; /* Reduced margin */
        }

        .forgot-password a {
            font-size: 12px; /* Slightly smaller */
            color: #7f8c8d;
        }

        .role-selector {
            margin-bottom: 15px; /* Reduced margin */
        }

        .role-selector select {
            width: 100%;
            padding: 12px 15px; /* Reduced padding */
            border-radius: 10px;
            border: 1px solid #ddd;
            outline: none;
            font-size: 14px; /* Slightly smaller */
            background: white;
            color: #333;
            cursor: pointer;
        }

        .features {
            text-align: center;
            margin-top: 15px; /* Reduced margin */
            padding-top: 15px; /* Reduced padding */
            border-top: 1px solid #ecf0f1;
        }

        .features small {
            color: #95a5a6;
            font-size: 11px; /* Slightly smaller */
            line-height: 1.4;
        }

        .image-content h3 {
            font-size: 22px; /* Slightly smaller */
            font-weight: 700;
            margin-bottom: 12px; /* Reduced margin */
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .image-content p {
            font-size: 14px; /* Slightly smaller */
            line-height: 1.4;
            margin-bottom: 15px; /* Reduced margin */
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
            text-align: left;
            color: rgba(255,255,255,0.95);
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin: 15px 0; /* Reduced margin */
        }

        .features-list li {
            margin-bottom: 8px; /* Reduced margin */
            display: flex;
            align-items: center;
            font-weight: 500;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
            font-size: 13px; /* Slightly smaller */
            line-height: 1.3;
        }

        .features-list li i {
            margin-right: 10px; /* Reduced margin */
            color: #f39c12;
            font-size: 14px; /* Slightly smaller */
            width: 16px;
            text-align: center;
            flex-shrink: 0;
        }

        .contact-info {
            margin-top: 20px; /* Reduced margin */
            padding: 15px; /* Reduced padding */
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .contact-info h5 {
            color: #fff;
            margin-bottom: 12px; /* Reduced margin */
            font-weight: 700;
            font-size: 14px; /* Slightly smaller */
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px; /* Reduced margin */
            color: #fff;
            font-size: 13px; /* Slightly smaller */
            font-weight: 500;
        }

        .contact-item i {
            margin-right: 8px; /* Reduced margin */
            color: #f39c12;
            width: 14px;
            text-align: center;
            font-size: 13px; /* Slightly smaller */
            flex-shrink: 0;
        }

        .contact-item a {
            color: white;
            text-decoration: none;
        }

        .contact-item a:hover {
            text-decoration: underline;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            body {
                padding: 15px;
                background-attachment: scroll;
            }

            .login-wrapper {
                flex-direction: column;
                max-width: 100%;
                max-height: none; /* Remove height restriction on mobile */
                border-radius: 15px;
            }

            .image-section {
                padding: 25px 20px;
                order: 2;
            }

            .login-section {
                padding: 25px 20px;
                order: 1;
            }

            .image-content h3 {
                font-size: 20px;
                text-align: center;
            }

            .image-content p {
                text-align: center;
                font-size: 13px;
            }

            .features-list {
                margin: 12px 0;
            }

            .features-list li {
                font-size: 12px;
                margin-bottom: 6px;
            }

            .contact-info {
                margin-top: 15px;
                padding: 12px;
            }

            .school-logo h1 {
                font-size: 20px;
            }

            h2 {
                font-size: 18px;
            }

            input[type="email"], input[type="password"] {
                padding: 10px 12px;
                font-size: 13px;
            }

            button {
                padding: 11px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .image-section, .login-section {
                padding: 20px 15px;
            }

            .image-content h3 {
                font-size: 18px;
            }

            .school-logo h1 {
                font-size: 18px;
            }

            h2 {
                font-size: 16px;
            }

            .contact-info {
                padding: 10px;
            }

            .contact-item {
                font-size: 12px;
            }
        }

        /* For very small screens */
        @media (max-height: 600px) {
            .login-wrapper {
                max-height: 500px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="login-wrapper">
    <!-- Left Side - Image and School Info -->
    <div class="image-section">
        <div class="image-content">
            <h3>School Management System</h3>
            <p>Transform your educational institution with our comprehensive School Management System. Streamline administration, enhance learning, and connect everyone in your school community.</p>
            
            <ul class="features-list">
                <li><i class="fas fa-user-graduate"></i> Student Management & Progress Tracking</li>
                <li><i class="fas fa-chalkboard-teacher"></i> Teacher & Staff Administration</li>
                <li><i class="fas fa-calendar-alt"></i> Attendance & Timetable Management</li>
                <li><i class="fas fa-file-invoice-dollar"></i> Fee Collection & Financial Reports</li>
                <li><i class="fas fa-book"></i> Digital Library & Resource Center</li>
                <li><i class="fas fa-bullhorn"></i> Parent Communication Portal</li>
            </ul>
        </div>
        
        <div class="contact-info">
            <h5>Contact Information</h5>
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
    
    <!-- Right Side - Login Form -->
    <div class="login-section">
        <div class="school-logo">
            <h1>School Management System</h1>
            <p>Comprehensive School Administration</p>
        </div>

        <h2>Welcome Back</h2>

        <!-- Display Messages -->
        <div id="message-container">
            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif
            
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="alert-error">{{ $error }}</div>
                @endforeach
            @endif
            
            @if(session('error'))
                <div class="alert-error">{{ session('error') }}</div>
            @endif
        </div>

        <form method="POST" action="{{ route('login.post') }}" id="loginForm">
            @csrf
            
            <div class="role-selector">
                <select name="role" id="role">
                    <option value="student">Student</option>
                    <option value="staff">Staff Member</option>
                    <option value="teacher">Teacher</option>
                    <option value="admin" selected>Administrator</option>
                    <option value="parent">Parent</option>
                </select>
            </div>
            
            <div class="form-group">
                <input type="email" name="email" id="email" placeholder="Email Address" value="{{ old('email') }}" >
                <div class="error-message" id="email-error">Please enter a valid email address</div>
            </div>
            
            <div class="form-group">
                <input type="password" name="password" id="password" placeholder="Password" >
                <div class="error-message" id="password-error">Please enter your password</div>
            </div>
            
            <button type="submit" id="login-btn">Login to Dashboard</button>
        </form>

        <p>New to our system? <a href="{{ route('register') }}">Create Account</a></p>
        
        <div class="features">
            <small>Student Portal • Grade Management • Attendance Tracking • Parent Communication</small>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loginForm = document.getElementById('loginForm');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const emailError = document.getElementById('email-error');
        const passwordError = document.getElementById('password-error');
        const loginBtn = document.getElementById('login-btn');

        // Form validation
        loginForm.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Reset error messages
            emailError.style.display = 'none';
            passwordError.style.display = 'none';
            
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
            
            // Password validation
            if (!passwordInput.value.trim()) {
                passwordError.textContent = 'Please enter your password';
                passwordError.style.display = 'block';
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                showMessage('Please fill in all required fields correctly', 'error');
            }
        });

        // Real-time validation
        emailInput.addEventListener('blur', function() {
            if (!this.value.trim()) {
                emailError.textContent = 'Please enter your email address';
                emailError.style.display = 'block';
            } else if (!isValidEmail(this.value)) {
                emailError.textContent = 'Please enter a valid email address';
                emailError.style.display = 'block';
            } else {
                emailError.style.display = 'none';
            }
        });

        passwordInput.addEventListener('blur', function() {
            if (!this.value.trim()) {
                passwordError.textContent = 'Please enter your password';
                passwordError.style.display = 'block';
            } else {
                passwordError.style.display = 'none';
            }
        });

        // Clear errors on input
        emailInput.addEventListener('input', function() {
            if (this.value.trim() && isValidEmail(this.value)) {
                emailError.style.display = 'none';
            }
        });

        passwordInput.addEventListener('input', function() {
            if (this.value.trim()) {
                passwordError.style.display = 'none';
            }
        });

        // Email validation function
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
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

        // Auto-remove success messages after 5 seconds
        setTimeout(() => {
            const successMessages = document.querySelectorAll('.alert-success');
            successMessages.forEach(message => {
                message.remove();
            });
        }, 5000);
    });
</script>

</body>
</html>