<header>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-6 d-flex align-items-center header-left">
                <img src="assets/images/logo.jpg" alt="Logo" class="header-logo">
            </div>
            <div class="col-6 d-flex justify-content-end">
                <button id="theme-toggle" class="theme-toggle-btn">
                    <i class="fa-regular fa-moon fa-xl"></i>              
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