<!-- File: resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            min-width: 250px;
            height: 100vh;
            background: rgb(16, 12, 4);
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .sidebar a:hover {
            background-color: #ffe15db7;
            color: black;
        }

        .menu {
            border-radius: 0.25rem;
        }
        .submenu {
            padding-left: 30px;
            font-size: 0.95rem;
            border-radius: 0.25rem;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
            height: 100vh;
        }
        .active-menu {
            background-color: #ffe15db7;
            color: black;
        }

     
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->

    <div class="sidebar d-flex flex-column justify-content-between p-3">
        <img src="{{ asset('assets/wavebiz_logo.png') }}" alt="Wavebiz Logo" class="mt-4 mb-4" style="width: 12rem;">
        <div class="flex-grow-1">
            <a href="{{ url('/admin/dashboard') }}" class="menu {{ Request::is('dashboard') ? 'active-menu' : '' }}">Home</a>
        
            <a href="{{ url('/admin/products') }}" class="menu {{ Request::is('products') ? 'active-menu' : '' }}">Products</a>
            <div class="submenu">
                <a href="{{ url('/admin/categories') }}">Categories</a>
                <div class="submenu">
                    <a href="{{ url('/admin/subcategories') }}">Sub-Categories</a>
                </div>
            </div>
        
            <a href="{{ url('/admin/delivery') }}" class="menu {{ Request::is('deliveries') ? 'active-menu' : '' }}">Deliveries</a>
        
            <a href="{{ url('/admin/user') }}" class="menu {{ Request::is('members') ? 'active-menu' : '' }}">Members</a>

            <a href="{{ url('/admin/roles') }}" class="menu {{ Request::is('roles') ? 'active-menu' : '' }}">Roles</a>
        
            <a href="{{ url('/admin/logs') }}" class="menu {{ Request::is('auditlog') ? 'active-menu' : '' }}">Audit Log</a>
        
            <a href="{{ url('/admin/settings') }}"class="menu {{ Request::is('profile') ? 'active-menu' : '' }}">Profile</a>

        </div>
        <div class="d-flex justify-content-center">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light mt-auto">Logout</button>
            </form>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        @yield('content')
    </div>

    @yield('scripts')
    <script>
        // Check current route
        const currentPath = window.location.pathname;

        // Check  if the current path matches any of the menu links
        const menuLinks = document.querySelectorAll('.menu');
        const submenuLinks = document.querySelectorAll('.submenu a');
        menuLinks.forEach(link => {

            // removing the other part of the path, will only use /admin/*, not inclyuding -not included-/admin
            currentLink = link.getAttribute('href').split('/').slice(3,5).join('/');
            console.log(currentLink,currentPath);
            if (link.getAttribute('href').includes(currentPath) ) {
                link.classList.add('active-menu');
            }
        });
        submenuLinks.forEach(link => {
            if (link.getAttribute('href').includes(currentPath)) {
                link.classList.add('active-menu');
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
