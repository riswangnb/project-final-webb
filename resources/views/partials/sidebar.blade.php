<nav id="sidebar" class="col-md-3 col-lg-2 sidebar" style="background: linear-gradient(180deg, #3b82f6, #1e3a8a); position: fixed; top: 0; left: 0; height: 100vh; z-index: 1050;">
    <div class="d-flex flex-column h-100">
        <div class="text-center mb-4 pt-4">
            <h4 class="text-white fw-bold" style="font-family: 'Poppins', sans-serif; letter-spacing: 1px;">Laundry-In</h4>
        </div>

        <ul class="nav flex-column px-2 flex-grow-1">
            @if(auth()->user()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link text-white {{ \Illuminate\Support\Facades\Request::is('dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ \Illuminate\Support\Facades\Request::is('customers*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                        <i class="fas fa-users me-2"></i> Customers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ \Illuminate\Support\Facades\Request::is('services*') ? 'active' : '' }}" href="{{ route('services.index') }}">
                        <i class="fas fa-concierge-bell me-2"></i> Services
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ \Illuminate\Support\Facades\Request::is('orders*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                        <i class="fas fa-clipboard-list me-2"></i> Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ \Illuminate\Support\Facades\Request::is('reports*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                        <i class="fas fa-chart-bar me-2"></i> Reports
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link text-white {{ \Illuminate\Support\Facades\Request::is('dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ \Illuminate\Support\Facades\Request::is('user/orders*') ? 'active' : '' }}" href="{{ route('user.orders') }}">
                        <i class="fas fa-clipboard-list me-2"></i> My Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ \Illuminate\Support\Facades\Request::is('user/profile*') ? 'active' : '' }}" href="{{ route('user.profile') }}">
                        <i class="fas fa-user me-2"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ \Illuminate\Support\Facades\Request::is('user/settings*') ? 'active' : '' }}" href="{{ route('user.settings') }}">
                        <i class="fas fa-cog me-2"></i> Settings
                    </a>
                </li>
            @endif
        </ul>

        <!-- Account Identity Section with Logout -->
        <div class="account-identity text-center mt-4 p-3 mx-2 mb-3 rounded-3 shadow-sm" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(5px);">
            <div class="d-flex align-items-center justify-content-center mb-2">
                <div class="account-avatar me-3">
                    <div class="avatar-circle" style="width: 50px; height: 50px; border: 3px solid #ffffff; border-radius: 50%; overflow: hidden;">
                        <i class="fas fa-user-circle fa-3x text-white" style="line-height: 50px;"></i>
                    </div>
                </div>
                <div class="text-start">
                    <span class="text-white fw-bold d-block" style="font-family: 'Poppins', sans-serif;">{{ auth()->user()->name }}</span>
                    <small class="text-warning fw-semibold">{{ auth()->user()->isAdmin() ? 'Admin' : 'User' }}</small>
                </div>
            </div>
            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 py-1 mt-2" style="font-family: 'Poppins', sans-serif; font-size: 0.9rem;">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- Sidebar Toggle Button for Mobile -->
<button id="sidebarToggle" class="btn btn-primary d-md-none" style="position: fixed; top: 15px; left: 15px; z-index: 1060; border-radius: 50%; width: 45px; height: 45px; padding: 0; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<style>
    .sidebar {
        transition: transform 0.3s ease-in-out;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
        z-index: 1050;
        width: 250px;
    }

    .nav-link {
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
        padding: 10px 15px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .nav-link.active {
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.1));
        font-weight: 600;
    }

    .nav-link:hover {
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.25), rgba(255, 255, 255, 0.15));
        transform: translateX(5px);
        color: #fff;
    }

    .account-identity {
        transition: all 0.3s ease;
    }

    .account-identity:hover {
        transform: scale(1.02);
        background: rgba(255, 255, 255, 0.15);
    }

    .account-avatar {
        display: flex;
        align-items: center;
    }

    .btn-outline-danger {
        border-color: #f87171;
        color: #f87171;
        transition: all 0.3s ease;
    }

    .btn-outline-danger:hover {
        background-color: #f87171;
        color: #fff;
        transform: translateY(-1px);
    }

    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1040;
        transition: opacity 0.3s ease-in-out;
        opacity: 0;
    }

    .sidebar-overlay.show {
        display: block;
        opacity: 1;
    }

    /* Responsive Styles */
    @media (min-width: 992px) {
        .sidebar {
            width: calc(100% / 12 * 2); /* Match col-lg-2 */
            transform: translateX(0);
        }

        .main-content {
            margin-left: calc(100% / 12 * 2);
        }

        #sidebarToggle, .sidebar-overlay {
            display: none;
        }
    }

    @media (min-width: 768px) and (max-width: 991.98px) {
        .sidebar {
            width: calc(100% / 12 * 3); /* Match col-md-3 */
            transform: translateX(0);
        }

        .main-content {
            margin-left: calc(100% / 12 * 3);
        }

        #sidebarToggle, .sidebar-overlay {
            display: none;
        }
    }

    @media (max-width: 767.98px) {
        .sidebar {
            width: 250px;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0 !important;
            transition: margin-left 0.3s ease-in-out;
        }

        #sidebarToggle {
            display: flex;
        }

        body.sidebar-open .sidebar {
            transform: translateX(0);
        }

        body.sidebar-open .sidebar-overlay {
            display: block;
            opacity: 1;
        }
    }

    @media (max-width: 576px) {
        .sidebar {
            width: 80%;
            max-width: 250px;
        }

        .account-identity {
            padding: 10px;
        }

        .account-avatar .avatar-circle {
            width: 40px;
            height: 40px;
        }

        .account-avatar .fa-user-circle {
            font-size: 2.5rem;
            line-height: 40px;
        }

        .text-white.fw-bold.d-block {
            font-size: 1rem;
        }

        .btn-outline-danger {
            font-size: 0.8rem;
            padding: 5px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        // Function to toggle sidebar
        function toggleSidebar() {
            sidebar.classList.toggle('show');
            document.body.classList.toggle('sidebar-open');
            sidebarOverlay.classList.toggle('show');
        }

        // Function to close sidebar
        function closeSidebar() {
            sidebar.classList.remove('show');
            document.body.classList.remove('sidebar-open');
            sidebarOverlay.classList.remove('show');
        }

        // Toggle sidebar on hamburger menu click
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation(); // Prevent click from bubbling to body
                toggleSidebar();
            });
        }

        // Close sidebar when overlay is clicked
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeSidebar);
        }

        // Close sidebar when clicking a nav link on mobile
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 767.98) {
                    closeSidebar();
                }
            });
        });

        // Close sidebar when clicking logout button on mobile
        const logoutButton = document.querySelector('.btn-outline-danger');
        if (logoutButton) {
            logoutButton.addEventListener('click', function () {
                if (window.innerWidth <= 767.98) {
                    closeSidebar();
                }
            });
        }

        // Close sidebar on outside click
        document.addEventListener('click', function (e) {
            if (window.innerWidth <= 767.98 && sidebar.classList.contains('show') && !sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                closeSidebar();
            }
        });

        // Handle window resize to ensure sidebar state is correct
        window.addEventListener('resize', function () {
            if (window.innerWidth > 767.98) {
                closeSidebar();
            }
        });
    });
</script>