<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'School Management System')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('public/logokid.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://rsms.me/inter/inter.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header Styles */
        .school-header {
            background: linear-gradient(135deg, #2563EB 0%, #4F46E5 100%);
            color: white;
            padding: 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: 70px;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 30px;
            height: 100%;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .school-logo {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .school-info h1 {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
            line-height: 1.2;
        }

        .school-info p {
            font-size: 12px;
            margin: 0;
            opacity: 0.9;
            font-weight: 400;
        }

        .profile-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-icon {
            position: relative;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .notification-icon:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #EF4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .profile-dropdown {
            position: relative;
        }

        .profile-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }

        .profile-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10B981, #059669);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }

        .profile-name {
            font-size: 14px;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            min-width: 200px;
            padding: 8px;
            margin-top: 10px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1001;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: #374151;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 14px;
            font-weight: 500;
        }

        .dropdown-item:hover {
            background: #f3f4f6;
            color: #2563EB;
        }

        .dropdown-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 6px 0;
        }

        /* Sidebar Styles */
        .main-container {
            display: flex;
            flex: 1;
            margin-top: 70px;
        }

        .sidebar {
            width: 240px;
            background: linear-gradient(180deg, #1e40af 0%, #3730a3 100%);
            color: white;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            height: calc(100vh - 70px);
            position: fixed;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.3) transparent;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar .brand {
            font-size: 1.3rem;
            font-weight: bold;
            text-align: center;
            padding: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .sidebar a,
        .sidebar .toggle-btn {
            color: white;
            text-decoration: none;
            padding: 0.8rem 1rem;
            display: flex;
            align-items: center;
            transition: background 0.3s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .sidebar a:hover,
        .sidebar .toggle-btn:hover {
            background-color: rgba(255,255,255,0.15);
        }

        .sidebar i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Active menu item */
        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.2);
            border-right: 3px solid white;
        }

        /* Hide text when collapsed */
        .sidebar.collapsed a span,
        .sidebar.collapsed .brand span,
        .sidebar.collapsed .toggle-btn span {
            display: none;
        }

        .sidebar.collapsed i {
            margin: 0 auto;
        }

        /* Main content */
        .content {
            flex-grow: 1;
            padding: 2rem;
            margin-left: 240px;
            transition: margin-left 0.3s ease;
            min-height: calc(100vh - 70px);
            background-color: #f8f9fa;
        }

        /* Hide empty content */
        .content:empty {
            display: none;
        }

        .sidebar.collapsed + .content {
            margin-left: 70px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .header-container {
                padding: 10px 20px;
            }

            .school-info h1 {
                font-size: 18px;
            }

            .school-info p {
                font-size: 11px;
            }

            .profile-name {
                display: none;
            }

            .profile-btn {
                padding: 8px;
            }

            .sidebar {
                left: -240px;
                width: 240px;
                position: fixed;
                z-index: 999;
            }

            .sidebar.open {
                left: 0;
                box-shadow: 2px 0 8px rgba(0,0,0,0.2);
            }

            .content {
                margin-left: 0 !important;
                padding: 1rem;
            }

            .mobile-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background-color: #2563EB;
                color: white;
                border: none;
                padding: 0.6rem 0.9rem;
                font-size: 1.2rem;
                position: fixed;
                top: 80px;
                left: 15px;
                border-radius: 8px;
                z-index: 1100;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
                transition: all 0.3s ease;
            }

            .sidebar.open ~ .mobile-toggle {
                left: 255px;
            }

            .sidebar-overlay.active {
                display: block;
            }

            .sidebar.collapsed {
                width: 240px;
            }

            .sidebar.collapsed a span,
            .sidebar.collapsed .brand span,
            .sidebar.collapsed .toggle-btn span {
                display: inline;
            }
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 70px;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 998;
        }
        .logout-btn {
            display: inline-block;
            padding: 12px 25px;
            background: #dc3545;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background 0.3s;
            border: none;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: #a71d2a;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Header -->
@include('layouts.header')
@include('layouts.sidebar')

    <!-- Main Container -->
 

    <!-- Bootstrap JS + Icons -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mobileToggle = document.getElementById('mobileToggle');
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');

        // Desktop collapse toggle
        function toggleSidebar() {
            if (window.innerWidth > 991) {
                sidebar.classList.toggle('collapsed');
            }
        }

        // Mobile open/close toggle
        mobileToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            sidebarOverlay.classList.toggle('active');
        });

        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('active');
        });

        // Profile dropdown functionality
        profileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!profileBtn.contains(event.target) && !profileDropdown.contains(event.target)) {
                profileDropdown.classList.remove('show');
            }
        });

        // Auto reset button if resized
        window.addEventListener('resize', () => {
            if (window.innerWidth > 991) {
                sidebar.classList.remove('open');
                sidebarOverlay.classList.remove('active');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>