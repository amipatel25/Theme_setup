<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Your CSS & Other Scripts -->
</head>

<body>

    <!-- Sidebar Code -->
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

            <!-- Sidebar Toggle Button -->
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
                        $activeClass = null;
                        $currentRouteName = Route::currentRouteName();
                        if ($currentRouteName === $menu->slug) {
                            $activeClass = 'active';
                        } elseif (isset($menu->submenu)) {
                            if (is_array($menu->slug)) {
                                foreach ($menu->slug as $slug) {
                                    if (
                                        str_contains($currentRouteName, $slug) &&
                                        strpos($currentRouteName, $slug) === 0
                                    ) {
                                        $activeClass = 'active open';
                                    }
                                }
                            } else {
                                if (
                                    str_contains($currentRouteName, $menu->slug) &&
                                    strpos($currentRouteName, $menu->slug) === 0
                                ) {
                                    $activeClass = 'active open';
                                }
                            }
                        }
                    @endphp

                    <li class="menu-item {{ $activeClass }}">
                        <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                            class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                            @if (isset($menu->target) && !empty($menu->target)) target="_blank" @endif>
                            @isset($menu->icon)
                                <i class="{{ $menu->icon }}"></i>
                            @endisset
                            <div class="menu-text">{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                            @isset($menu->badge)
                                <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
                            @endisset
                        </a>

                        @isset($menu->submenu)
                            @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                        @endisset
                    </li>
                @endif
            @endforeach
        </ul>
    </aside>

    <!-- Sidebar Toggle Icon -->
    <div class="toggle-container" id="sidebar-toggle-wrapper">
        <i class="bx bx-menu"></i>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let sidebarToggle = document.getElementById("sidebar-toggle");
            let sidebar = document.getElementById("layout-menu");
            let toggleWrapper = document.getElementById("sidebar-toggle-wrapper");
            let body = document.body;

            function toggleSidebar() {
                if (sidebar.classList.contains("menu-hidden")) {
                    sidebar.classList.remove("menu-hidden");
                    toggleWrapper.style.display = "none";
                    localStorage.setItem("sidebarState", "expanded");
                } else {
                    sidebar.classList.add("menu-hidden");
                    toggleWrapper.style.display = "flex";
                    localStorage.setItem("sidebarState", "hidden");
                }
            }

            sidebarToggle.addEventListener("click", toggleSidebar);
            toggleWrapper.addEventListener("click", toggleSidebar);

            if (localStorage.getItem("sidebarState") === "hidden") {
                sidebar.classList.add("menu-hidden");
                toggleWrapper.style.display = "flex";
            }

            @if (session('success'))
                body.classList.add("disable-interaction");
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                }).then(() => {
                    body.classList.remove("disable-interaction");
                });
            @endif
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-open .layout-container,
        .swal2-open .layout-menu {
            pointer-events: none !important;
            opacity: 0.5;
            filter: blur(2px);
        }

        .swal2-container {
            z-index: 1050 !important;
        }
    </style>

</body>

</html>
