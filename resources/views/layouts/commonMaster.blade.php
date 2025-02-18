<!DOCTYPE html>
<html class="light-style layout-menu-fixed" data-theme="theme-default" data-assets-path="{{ asset('/assets') . '/' }}"
    data-base-url="{{ url('/') }}" data-framework="laravel" data-template="vertical-menu-laravel-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <!-- Set favicon using the logo image -->
    <link rel="icon" href="{{ asset('assets/img/logo_main.png') }}" type="image/png">
    <title>@yield('title')</title>

    <link id="dark-theme-css" rel="stylesheet" href="#" disabled>
    @include('layouts/sections/styles')

    <script>
        // Immediately apply the theme before the page loads
        (function() {
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
        })();
    </script>

<style>
  /* Floating Customizer Button */
  .customizer-btn {
      position: fixed;
      bottom: 50px;
      right: 20px;
      background: #696cff;
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
      transform: rotate(90deg);
  }

  /* Sidebar Customizer */
  .customizer-sidebar {
      position: fixed;
      top: 0;
      right: -450px;
      width: 450px;
      height: 100%;
      background: white;
      box-shadow: -4px 0px 10px rgba(0, 0, 0, 0.2);
      transition: right 0.3s ease-in-out;
      padding: 20px;
      z-index: 1002;
      overflow-y: auto;
      border-left: 3px solid #696cff;
      font-family: 'Arial', sans-serif;
  }

  .customizer-sidebar.active {
      right: 0;
  }

  /* Dark Mode for the Customizer */
  html.dark-style .customizer-sidebar {
      background-color: #2c2c2c;
      color: white;
      border-left: 3px solid #696cff;
  }

  html.dark-style .customizer-header h3,
  html.dark-style .customizer-header .description,
  html.dark-style .section h4 {
      color: white;
  }

  html.dark-style .option-btn {
      background-color: black;
      color: #696cff;
      border: 2px solid #696cff;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.2s ease-in-out;
      font-size: 14px;
      text-align: center;
      padding: 10px 15px;
      flex: 1;
  }

  html.dark-style .option-btn.active {
      background-color: #696cff;
      color: white;
  }

  html.dark-style .option-btn:hover {
      background-color: #4e52c1;
      color: white;
  }

  html.dark-style #reset-btn {
      background-color: #696cff;
      color: white;
  }

  html.dark-style #reset-btn:hover {
      background-color: #4e52c1;
  }

  /* Customizer Header */
  .customizer-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #ddd;
      padding-bottom: 10px;
      text-align: left;
  }

  .customizer-header h3 {
      font-size: 16px;
      font-weight: 600;
      margin: 0;
      text-align: center;
      width: 100%;
  }

  .customizer-header .description {
      font-size: 14px;
      color: #666;
      text-align: center;
  }

  html.dark-style .customizer-header .description {
      color: white;
  }

  #customizer-close {
      background: none;
      border: none;
      font-size: 18px;
      cursor: pointer;
      color: #696cff;
  }

  /* Customizer Sections */
  .section {
      margin-top: 20px;
  }

  .section h4 {
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 8px;
      color: #333;
  }

  html.dark-style .section h4 {
      color: white;
  }

  /* Options Styling */
  .options {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
  }

  .option-btn {
      flex: 1;
      padding: 10px 15px;
      border: 2px solid #696cff;
      background-color: white;
      color: #696cff;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.2s ease-in-out;
      font-size: 14px;
      text-align: center;
  }

  .option-btn.active {
      background-color: #696cff;
      color: white;
  }

  .option-btn:hover {
      background-color: #696cff;
      color: white;
      border-color: #696cff;
  }

  /* Reset Button */
  #reset-btn {
      width: 100%;
      margin-top: 20px;
      padding: 10px;
      border: none;
      background: #696cff;
      color: white;
      border-radius: 8px;
      cursor: pointer;
      font-size: 14px;
      font-weight: bold;
  }

  #reset-btn:hover {
      background: #4e52c1;
  }

  /* Customizer Overlay */
  .customizer-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 1040;
      display: none;
  }

  /* Ensure layout stays behind the customizer */
  .layout-page {
      z-index: 1;
  }
</style>


    @include('layouts/sections/scriptsIncludes')
</head>

<body>
    @yield('layoutContent')

    <button id="customizer-toggle" class="customizer-btn">
        <i class="fas fa-cog"></i>
    </button>

    <div id="customizer-sidebar" class="customizer-sidebar">
        <div class="customizer-header">
            <h3>TEMPLATE CUSTOMIZER</h3>
            <button id="customizer-close"><i class="fas fa-times"></i></button>
        </div>
        <div class="description">
            <p>Set preferences that will be saved for your live preview demonstration.</p>
        </div>

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

        <div class="section">
            <h4>Direction</h4>
            <div class="options">
                <button class="option-btn dir-toggle active" data-value="ltr">LTR</button>
                <button class="option-btn dir-toggle" data-value="rtl">RTL</button>
            </div>
        </div>

        <button id="reset-btn">🔄 Reset Settings</button>
    </div>

    <div id="customizer-overlay" class="customizer-overlay"></div>

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

            customizerToggle.addEventListener("click", () => {
                customizerSidebar.classList.add("active");
                overlay.classList.add("active");
            });

            customizerClose.addEventListener("click", () => {
                customizerSidebar.classList.remove("active");
                overlay.classList.remove("active");
            });

            overlay.addEventListener("cl696cffick", () => {
                customizerSidebar.classList.remove("active");
                overlay.classList.remove("active");
            });

            resetBtn.addEventListener("click", () => {
                localStorage.clear();
                location.reload();
            });

            setActive(themeButtons, localStorage.getItem("color-scheme") || "light");
            setActive(dirButtons, localStorage.getItem("direction") || "ltr");
        });
    </script>

    @include('layouts/sections/scripts')
</body>

</html>
