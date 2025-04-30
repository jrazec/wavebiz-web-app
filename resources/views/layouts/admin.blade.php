<!-- File: resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        body {
            display: flex;
            font-family: "Poppins", sans-serif;
            font-weight: 300;
            font-style: normal;
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
            font-weight: 500;
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
            background-color: #E8C330;
            height: 100vh;
        }
        .active-menu {
            background-color: #ffe15db7;
            color: black;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            #sidebar-logo {
                display: none;
            }
            .sidebar {
                width: 100%;
                height: 100%;
                position: absolute;
                top: 7vh;
                display: none;
                transition: transform 0.3s ease-in-out;
                transform: translateX(-100%);
                z-index: 1000;
                /* oppacity 50% */
                background-color: rgba(16, 12, 4, 0.95);
                
            }

            .sidebar.active {
                display: block;
                transform: translateX(0);
            }

            .mobile-navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                background-color: rgb(16, 12, 4);
                color: white;
                padding: 10px 20px;
            }

            .mobile-navbar img {
                width: 10rem;
            }

            .toggle-sidebar-btn {
                background-color: transparent;
                color: white;
                border: none;
                font-size: 1.5rem;
                cursor: pointer;
            }

            .content {
                height: auto;
            }
        }

        @media (max-width: 576px) {
            .sidebar a {
                padding: 8px 15px;
                font-size: 0.9rem;
            }
            .submenu {
                padding-left: 20px;
                font-size: 0.85rem;
            }
        }

    #viewMoreCategoryContent {
        padding: 20px;
    }


    /* Title: "Category: ..." */
    #viewMoreCategoryContent h5 {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .modal-header {
        background: #E8C330;
    }
    /* Description: italic paragraph */
    #viewMoreCategoryContent p {
        font-style: italic;
        color: #555;
        margin-bottom: 20px;
    }

    /* "Subcategories:" heading */
    #viewMoreCategoryContent h6 {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    /* List of subcategories */
    #viewMoreCategoryContent ul {
        list-style: none;
        padding: 0;
        display: grid;
        gap: 10px;
    }

    /* Each subcategory item */
    #viewMoreCategoryContent ul li {
        background: #f5f5f5;
        padding: 12px 16px;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        font-weight: bold;
    }


    #viewMoreCategoryContent ul li:empty,
    #viewMoreCategoryContent ul li:contains('---') {
        color: #999;
        font-style: italic;
    }
</style>
    @yield('styles')
</head>
<body>
    
    <!-- Mobile Navbar -->
    <div class="mobile-navbar d-md-none">
        <img src="{{ asset('assets/wavebiz_logo.png') }}" alt="Wavebiz Logo">
        <button class="toggle-sidebar-btn" onclick="toggleSidebar()">☰</button>
    </div>

    <!-- Sidebar -->

    <div class="sidebar d-flex flex-column justify-content-between p-3">
        <img src="{{ asset('assets/wavebiz_logo.png') }}" alt="Wavebiz Logo" class="mt-4 mb-4" style="width: 12rem;" id="sidebar-logo">
        <div class="flex-grow-1">
            <a href="{{ url('/admin/dashboard') }}" class="menu {{ Request::is('dashboard') ? 'active-menu' : '' }}">Home</a>
        
            <a href="{{ url('/admin/products') }}" class="menu {{ Request::is('products') ? 'active-menu' : '' }}">Products</a>
            
            <a href="{{ url('/admin/categories') }}" class="menu">Categories</a>
            <div class="submenu">
                <a href="{{ url('/admin/subcategories') }}">Sub-Categories</a>
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

        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('active');
        }
        

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
