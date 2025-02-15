@extends('layouts/contentNavbarLayout')

@section('title', 'Template Customizer')

@section('content')

<!-- Customizer Panel -->
<div class="customizer-panel hidden" id="customizer-panel">
    <h2 style="font-size: 18px; text-align: center; font-weight: 600; margin-bottom: 10px;">TEMPLATE CUSTOMIZER</h2>
    <p style="font-size: 14px; color: #777; text-align: center; margin-bottom: 20px;">Set preferences that will be saved for your live preview demonstration.</p>

    <!-- Color Scheme -->
    <div class="section">
        <h3 style="font-size: 14px; font-weight: 500; margin-bottom: 8px;">Color Scheme</h3>
        <div class="options" style="display: flex; gap: 10px;">
            <button class="option-btn theme-toggle active" data-type="color-scheme" data-value="light">
                <i class="fas fa-sun" style="color: #ffcc00;"></i> Light
            </button>
            <button class="option-btn theme-toggle" data-type="color-scheme" data-value="dark">
                <i class="fas fa-moon" style="color: #4a90e2;"></i> Dark
            </button>
        </div>
    </div>

    <!-- Direction -->
    <div class="section" style="margin-top: 18px;">
        <h3 style="font-size: 14px; font-weight: 500; margin-bottom: 8px;">Direction</h3>
        <div class="options" style="display: flex; gap: 10px;">
            <button class="option-btn dir-toggle active" data-value="ltr">
                <i class="fas fa-align-left"></i> LTR
            </button>
            <button class="option-btn dir-toggle" data-value="rtl">
                <i class="fas fa-align-right"></i> RTL
            </button>
        </div>
    </div>

    <!-- Reset Button -->
    <button id="reset-btn">🔄 Reset Settings</button>
</div>

<!-- FontAwesome Icons -->
<script src="https://kit.fontawesome.com/YOUR-KIT-ID.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        const htmlTag = $("html");
        const darkThemeCSS = $("#dark-theme-css");
        const customizerPanel = $("#customizer-panel");
        const customizerBtn = $("#open-customizer");

        function applyTheme(theme) {
            $(".theme-toggle").removeClass("active");
            $(`.theme-toggle[data-value="${theme}"]`).addClass("active");

            if (theme === "dark") {
                htmlTag.removeClass("light-style").addClass("dark-style");
                darkThemeCSS.attr("href", "/assets/css/dark.css").removeAttr("disabled");
            } else {
                htmlTag.removeClass("dark-style").addClass("light-style");
                darkThemeCSS.attr("href", "#").attr("disabled", "true");
            }
        }

        function applyDirection(direction) {
            $(".dir-toggle").removeClass("active");
            $(`.dir-toggle[data-value="${direction}"]`).addClass("active");
            htmlTag.attr("dir", direction);
        }

        let savedTheme = localStorage.getItem("color-scheme") || "light";
        let savedDirection = localStorage.getItem("direction") || "ltr";

        applyTheme(savedTheme);
        applyDirection(savedDirection);

        $(document).on("click", ".theme-toggle", function() {
            let theme = $(this).data("value");
            localStorage.setItem("color-scheme", theme);
            applyTheme(theme);
        });

        $(document).on("click", ".dir-toggle", function() {
            let direction = $(this).data("value");
            localStorage.setItem("direction", direction);
            applyDirection(direction);
        });

        $("#reset-btn").on("click", function() {
            localStorage.clear();
            location.reload();
        });

        // Toggle Customizer Panel
        customizerBtn.on("click", function() {
            customizerPanel.toggleClass("hidden");
        });
    });
</script>

<style>
    .customizer-panel {
        position: fixed;
        right: -300px;
        top: 50px;
        width: 300px;
        height: 100vh;
        background: #fff;
        transition: right 0.3s ease;
        padding: 20px;
        box-shadow: -5px 0 10px rgba(0, 0, 0, 0.1);
    }

    .customizer-panel.hidden {
        right: -300px;
    }

    .customizer-panel.visible {
        right: 0;
    }
</style>

@endsection
