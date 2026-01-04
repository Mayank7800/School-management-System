<div class="main-container">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <button class="toggle-btn d-none d-lg-flex" onclick="toggleSidebar()">
            <i class="bi bi-list"></i> <span>Menu</span>
        </button>

        <a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
        </a>
        
        <a href="{{ route('staff.index') }}" class="{{ Request::routeIs('staff.create') ? 'active' : '' }}">
            <i class="bi bi-people"></i> <span>Staff Registration</span>
        </a>
        
        <a href="{{ route('admissions.index') }}" class="{{ Request::routeIs('admissions.*') ? 'active' : '' }}">
            <i class="bi bi-person-plus"></i> <span>Student Admission</span>
        </a>
        
        <a href="{{ route('fee-structures.index') }}" class="{{ Request::routeIs('fee-structures.*') ? 'active' : '' }}">
            <i class="bi bi-cash-stack"></i> <span>Fees Management</span>
        </a>
        
        <a href="{{ route('student-fees.index') }}" class="{{ Request::routeIs('student-fees.*') ? 'active' : '' }}">
            <i class="bi bi-cash"></i> <span>Student Fees</span>
        </a>
        
        <a href="{{ route('fee-payments.index') }}" class="{{ Request::routeIs('fee-payments.*') ? 'active' : '' }}">
            <i class="bi bi-wallet2"></i> <span>Fee Payments</span>
        </a>
        
        <a href="{{ route('courses.index') }}" class="{{ Request::routeIs('courses.*') ? 'active' : '' }}">
            <i class="bi bi-book"></i> <span>Courses</span>
        </a>
        
        <a href="{{ route('attendance.index') }}" class="{{ Request::routeIs('attendance.index') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> <span>View Attendance</span>
        </a>
        
        <a href="{{ route('attendance.create') }}" class="{{ Request::routeIs('attendance.create') ? 'active' : '' }}">
            <i class="bi bi-pencil-square"></i> <span>Mark Attendance</span>
        </a>
        
        <a href="{{ route('reports.index') }}" class="{{ Request::routeIs('reports.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i> <span>Reports</span>
        </a>
         <a href="{{ route('syllabus.index') }}" class="{{ Request::routeIs('syllabus.*') ? 'active' : '' }}">
            <i class="fas fa-book"></i> <span>Syllabus</span>
        </a>
        <!-- WhatsApp Menu Item -->
        <a href="{{ route('whatsapp.form') }}" class="{{ Request::routeIs('whatsapp.*') ? 'active' : '' }}">
    <i class="fab fa-whatsapp"></i> <span>WhatsApp</span>
        </a>

<!-- SMS Menu Item -->
        <a href="{{ route('sms.form') }}" class="{{ Request::routeIs('sms.*') ? 'active' : '' }}">
    <i class="fas fa-sms"></i> <span>SMS</span>
    </a>

<!-- Email Menu Item -->
    <a href="{{ route('email.form') }}" class="{{ Request::routeIs('email.*') ? 'active' : '' }}">
    <i class="fas fa-envelope"></i> <span>Email</span>
    </a>
       
    </div>

    <!-- Overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Floating mobile button -->
    <button class="mobile-toggle d-lg-none" id="mobileToggle">
        <i class="bi bi-list"></i>
    </button>

    <!-- Content area - will be hidden when empty -->
    <div class="content">
        @yield('content')
    </div>
</div>