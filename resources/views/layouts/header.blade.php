 <header class="school-header">
        <div class="header-container">
            <!-- Left: School Name and Logo -->
            <div class="logo-section">
                <div class="school-logo">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="school-info">
                    <h1>SchoolSphere</h1>
                    <p>Comprehensive Education Platform</p>
                </div>
            </div>

            <!-- Right: Profile and Notifications -->
            <div class="profile-section">
                <!-- Notification Bell -->
                <div class="notification-icon">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </div>

                <!-- Profile Dropdown -->
                <div class="profile-dropdown">
                   <button class="profile-btn" id="profileBtn">
    <div class="profile-avatar">
        {{ substr(Auth::user()->name, 0, 1) }}
    </div>
    <span class="profile-name">{{ Auth::user()->name }}</span>
    <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
</button>
                    
                    <div class="dropdown-menu" id="profileDropdown">
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            <span>My Profile</span>
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users"></i>
                            <span>Manage Users</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
        <button type="submit" class="logout-btn">Logout</button>
    </form>
                    </div>
                </div>
            </div>
        </div>
    </header>