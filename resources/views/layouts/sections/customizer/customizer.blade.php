@extends('layouts/contentNavbarLayout')

@section('title', 'Template Customizer')

@section('content')

    
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
                customizerPanel.toggleClass("visible");
            });
        });
    </script>

    <style>
        .customizer-panel {
            position: fixed;
            right: -450px; /* Adjust this based on new width */
            top: 50px;
            width: 450px; /* Increased width to 1000px */
            max-width: 100vw; /* Prevent overflow issues */
            height: 100vh;
            background: #fff;
            transition: right 0.3s ease;
            padding: 20px;
            box-shadow: -5px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto; /* Ensure content is scrollable if necessary */
        }

        /* Adjust hidden and visible states */
        .customizer-panel.hidden {
            right: -450px; /* Match with increased width */
        }

        .customizer-panel.visible {
            right: 0;
        }
    </style>

@endsection
