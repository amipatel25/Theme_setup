<!DOCTYPE html>
<html class="light-style layout-menu-fixed" data-theme="theme-default" data-assets-path="{{ asset('/assets') . '/' }}"
    data-base-url="{{ url('/') }}" data-framework="laravel" data-template="vertical-menu-laravel-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title') | Sneat - Laravel Admin Template</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
    <link id="dark-theme-css" rel="stylesheet" href="#" disabled>

    @include('layouts/sections/styles')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let savedTheme = localStorage.getItem("color-scheme") || "light";
            let savedDirection = localStorage.getItem("direction") || "ltr";
            const htmlTag = document.documentElement;
            const darkThemeCSS = document.getElementById("dark-theme-css");

            htmlTag.classList.remove("light-style", "dark-style");
            htmlTag.setAttribute("dir", savedDirection);

            // Apply the theme (dark or light)
            if (savedTheme === "dark") {
                htmlTag.classList.add("dark-style");
                darkThemeCSS.setAttribute("href", "/assets/css/dark.css");
                darkThemeCSS.removeAttribute("disabled");
            } else {
                htmlTag.classList.add("light-style");
                darkThemeCSS.setAttribute("href", "#");
                darkThemeCSS.setAttribute("disabled", "true");
            }

            // Apply direction (LTR or RTL)
            if (savedDirection === "rtl") {
                htmlTag.setAttribute("dir", "rtl");
            } else {
                htmlTag.setAttribute("dir", "ltr");
            }
        });
    </script>

    <style>
        /* Floating Customizer Button */
        .customizer-btn {
            position: fixed;
            bottom: 50px;
            right: 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
            cursor: pointer;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
            z-index: 1001;
        }

        .customizer-btn:hover {
            background: #0056b3;
            transform: rotate(90deg);
        }

        /* Sidebar Customizer */
        .customizer-sidebar {
            position: fixed;
            top: 0;
            right: -350px;
            width: 350px;
            height: 100%;
            background: white;
            box-shadow: -4px 0px 10px rgba(0, 0, 0, 0.2);
            transition: right 0.3s ease-in-out;
            padding: 20px;
            z-index: 1002;
            overflow-y: auto;
            border-left: 3px solid #007bff;
            font-family: 'Arial', sans-serif;
        }

        .customizer-sidebar.active {
            right: 0;
        }

        .customizer-sidebar.dark-mode {
            background-color: #2c2c2c;
            /* Dark background */
            color: white;
            /* Light text */
        }

        .customizer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .customizer-header h3 {
            font-size: 16px;
            font-weight: 600;
        }

        #customizer-close {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }

        /* Sections */
        .section {
            margin-top: 20px;
        }

        .section h4 {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        /* Button Group Styling */
        .options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .option-btn {
            flex: 1;
            padding: 10px 15px;
            border: 2px solid #007bff;
            background-color: white;
            color: #007bff;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            font-size: 14px;
            text-align: center;
        }

        .option-btn.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .option-btn:hover {
            background-color: #0056b3;
            color: white;
            border-color: #0056b3;
        }

        /* Reset Button */
        #reset-btn {
            width: 100%;
            margin-top: 20px;
            padding: 10px;
            border: none;
            background: #007bff;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        #reset-btn:hover {
            background: #0056b3;
        }

        .customizer-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            /* Lower than the navbar */
            display: none;
        }

        .customizer-sidebar {
            position: fixed;
            top: 0;
            right: -350px;
            width: 350px;
            height: 100%;
            background: white;
            box-shadow: -4px 0px 10px rgba(0, 0, 0, 0.2);
            transition: right 0.3s ease-in-out;
            padding: 20px;
            z-index: 1050;
            /* Higher than the navbar */
            overflow-y: auto;
            border-left: 3px solid #007bff;
            font-family: 'Arial', sans-serif;
        }

        .customizer-sidebar.active {
            right: 0;
        }

        /* Add dark mode for sidebar */
        .customizer-sidebar.dark-mode {
            background-color: #2c2c2c;
            color: white;
        }

        /* Prevent navbar and content interaction when the customizer is open */
        .swal2-open .layout-menu,
        .swal2-open .layout-overlay {
            pointer-events: none !important;
        }

        /* Prevent overlay issues, making sure the customizer overlay takes precedence */
        .layout-page {
            z-index: 1;
        }
    </style>
    @include('layouts/sections/scriptsIncludes')
</head>

<body>
    @yield('layoutContent')

    <!-- Floating Gear Icon for Customizer -->
    <button id="customizer-toggle" class="customizer-btn">
        <i class="fas fa-cog"></i>
    </button>

    <!-- Sidebar Customizer -->
    <div id="customizer-sidebar" class="customizer-sidebar">
        <div class="customizer-header">
            <h3>TEMPLATE CUSTOMIZER</h3>
            <button id="customizer-close"><i class="fas fa-times"></i></button>
        </div>

        <p>Set preferences that will be saved for your live preview demonstration.</p>

        <!-- Color Scheme -->
        <div class="section">
            <h4>Color Scheme</h4>
            <div class="options">
                <button class="option-btn theme-toggle active" data-type="color-scheme" data-value="light">
                    <i class="fas fa-sun"></i> Light
                </button>
                <button class="option-btn theme-toggle" data-type="color-scheme" data-value="dark">
                    <i class="fas fa-moon"></i> Dark
                </button>
                <button class="option-btn theme-toggle" data-type="color-scheme" data-value="system">
                    <i class="fas fa-desktop"></i> System
                </button>
            </div>
        </div>

        <!-- Direction -->
        <div class="section">
            <h4>Direction</h4>
            <div class="options">
                <button class="option-btn dir-toggle active" data-value="ltr">LTR</button>
                <button class="option-btn dir-toggle" data-value="rtl">RTL</button>
            </div>
        </div>

        <!-- Reset Button -->
        <button id="reset-btn">🔄 Reset Settings</button>
    </div>

    <!-- Overlay -->
    <div id="customizer-overlay" class="customizer-overlay"></div>

    <!-- JavaScript for Sidebar Customizer -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const customizerToggle = document.getElementById("customizer-toggle");
            const customizerSidebar = document.getElementById("customizer-sidebar");
            const customizerClose = document.getElementById("customizer-close");
            const overlay = document.getElementById("customizer-overlay");
            const themeButtons = document.querySelectorAll(".theme-toggle");
            const dirButtons = document.querySelectorAll(".dir-toggle");
            const resetBtn = document.getElementById("reset-btn");

            function setActive(buttons, value) {
                buttons.forEach(btn => {
                    if (btn.dataset.value === value) {
                        btn.classList.add("active");
                    } else {
                        btn.classList.remove("active");
                    }
                });
            }

            function saveSetting(key, value) {
                localStorage.setItem(key, value);
                location.reload();
            }

            themeButtons.forEach(button => {
                button.addEventListener("click", function() {
                    saveSetting("color-scheme", this.dataset.value);
                });
            });

            dirButtons.forEach(button => {
                button.addEventListener("click", function() {
                    saveSetting("direction", this.dataset.value);
                });
            });

            // Open Sidebar
            customizerToggle.addEventListener("click", () => {
                customizerSidebar.classList.add("active");
                overlay.classList.add("active");
            });

            // Close Sidebar
            customizerClose.addEventListener("click", () => {
                customizerSidebar.classList.remove("active");
                overlay.classList.remove("active");
            });

            overlay.addEventListener("click", () => {
                customizerSidebar.classList.remove("active");
                overlay.classList.remove("active");
            });

            // Reset Button
            resetBtn.addEventListener("click", () => {
                localStorage.clear();
                location.reload();
            });

            // Load Saved Settings
            setActive(themeButtons, localStorage.getItem("color-scheme") || "light");
            setActive(dirButtons, localStorage.getItem("direction") || "ltr");

            // Apply theme (light or dark) and direction (LTR or RTL) when the page loads
            let savedTheme = localStorage.getItem("color-scheme") || "light";
            let savedDirection = localStorage.getItem("direction") || "ltr";
            const htmlTag = document.documentElement;
            const darkThemeCSS = document.getElementById("dark-theme-css");

            htmlTag.classList.remove("light-style", "dark-style");
            htmlTag.setAttribute("dir", savedDirection);

            if (savedTheme === "dark") {
                htmlTag.classList.add("dark-style");
                darkThemeCSS.setAttribute("href", "/assets/css/dark.css");
                darkThemeCSS.removeAttribute("disabled");
                customizerSidebar.classList.add("dark-mode");
            } else {
                htmlTag.classList.add("light-style");
                darkThemeCSS.setAttribute("href", "#");
                darkThemeCSS.setAttribute("disabled", "true");
                customizerSidebar.classList.remove("dark-mode");
            }

            if (savedDirection === "rtl") {
                htmlTag.setAttribute("dir", "rtl");
            } else {
                htmlTag.setAttribute("dir", "ltr");
            }
        });
    </script>

    @include('layouts/sections/scripts')
</body>

</html>
