<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Sidebar Toggle */
        .menu-hidden {
            transform: translateX(-250px);
            transition: transform 0.3s ease-in-out;
        }

        #layout-menu {
            transition: transform 0.3s ease-in-out;
        }

        /* Sidebar Toggle Button */
        #sidebar-toggle {
            position: absolute;
            top: 15px;
            right: -20px;
            width: 40px;
            height: 40px;
            background-color: #696cff;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }

        #sidebar-toggle i {
            font-size: 18px;
        }

        #sidebar-toggle:hover {
            background-color: #5a5ed6;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
            <a href="{{ url('/') }}" class="app-brand-link">
                <span class="app-brand-logo demo">
                    @include('_partials.macros', ['width' => 25, 'withbg' => 'var(--bs-primary)'])
                </span>
                <span class="app-brand-text demo menu-text fw-bold ms-2">
                    {{ config('variables.templateName') }}
                </span>
            </a>

            <!-- Sidebar Toggle Button (Inside Sidebar) -->
            <a href="javascript:void(0);" id="sidebar-toggle" class="menu-link">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">
            @foreach ($menuData[0]->menu as $menu)
                @if (isset($menu->menuHeader))
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
                    </li>
                @else
                    @php
                        $activeClass = Route::currentRouteName() === $menu->slug ? 'active' : '';
                    @endphp

                    <li class="menu-item {{ $activeClass }}">
                        <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                            class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}">
                            @isset($menu->icon)
                                <i class="{{ $menu->icon }}"></i>
                            @endisset
                            <div class="menu-text">{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                        </a>

                        @isset($menu->submenu)
                            @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                        @endisset
                    </li>
                @endif
            @endforeach
        </ul>
    </aside>

    <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let sidebarToggle = document.getElementById("sidebar-toggle");
            let sidebar = document.getElementById("layout-menu");

            if (!sidebar || !sidebarToggle) {
                console.error("Sidebar elements not found!");
                return;
            }

            function toggleSidebar() {
                sidebar.classList.toggle("menu-hidden");
                localStorage.setItem("sidebarState", sidebar.classList.contains("menu-hidden") ? "hidden" : "expanded");
            }

            sidebarToggle.addEventListener("click", toggleSidebar);

            // Load Sidebar State from Local Storage
            if (localStorage.getItem("sidebarState") === "hidden") {
                sidebar.classList.add("menu-hidden");
            }

            // Show success message if exists
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>

</body>

</html>
