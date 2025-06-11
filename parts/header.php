<header>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-6 d-flex align-items-center header-left">
                <img src="assets/images/logo.jpg" alt="Logo" class="header-logo">
            </div>
            <div class="col-6 d-flex justify-content-end">
                <button id="theme-toggle" class="theme-toggle-btn">
                    <!-- Sun/Moon SVG icon -->
                    <svg id="theme-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="5" />
                        <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>

<script>
document.getElementById('theme-toggle').onclick = function() {
    document.body.classList.toggle('dark-theme');
};
</script>