<nav class="navbar">
    <div class="nav-container">
        <a href="#" class="brand">
            <img src="./images/Whiteridge.jpg" alt="Whiteridge Logo">
        </a>
        <button class="hamburger" onclick="toggleNav()">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <ul class="nav-menu">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#">Solutions <i class="fas fa-caret-down fa-thin" onclick="toggleDropdown(event)"></i></a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="Legarly.php">Legarly</a></li>
                    <!-- ...other items... -->
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#">Services <i class="fas fa-caret-down" onclick="toggleDropdown(event)"></i></a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="software.php">Software Development</a></li>
                    <li><a class="dropdown-item" href="cybersecurity.php">Cybersecurity</a></li>
                    <li><a class="dropdown-item" href="consulting.php">IT Consulting</a></li>
                    <li><a class="dropdown-item" href="managed.php">Managed Testing Services</a></li>
                </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
        </ul>
    </div>
</nav>

<div id="sidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="#">Solutions <i class="fas fa-caret-down" onclick="toggleSidenavDropdown(event)"></i></a>
    <div class="dropdown-content">
        <a href="Legarly.php">Legarly</a>
        <!-- ...other items... -->
    </div>
    <a href="#">Services <i class="fas fa-caret-down" onclick="toggleSidenavDropdown(event)"></i></a>
    <div class="dropdown-content">
        <a href="software.php">Software Development</a>
        <a href="cybersecurity.php">Cybersecurity</a>
        <a href="consulting.php">IT Consulting</a>
        <a href="managed.php">Managed Testing Services</a>
    </div>
    <a href="contact.php">Contact Us</a>
</div>

<script>
    function toggleNav() {
        document.getElementById("sidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("sidenav").style.width = "0";
    }

    function toggleDropdown(event) {
        event.preventDefault();
        const dropdown = event.target.parentElement.nextElementSibling;
        dropdown.classList.toggle('active');
    }

    function toggleSidenavDropdown(event) {
        event.preventDefault();
        const dropdown = event.target.parentElement.nextElementSibling;
        dropdown.classList.toggle('active');
    }

    // Smooth scroll with header offset
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const offset = 80; // Height of fixed header
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                // Close mobile menu if open
                document.querySelector('.hamburger').classList.remove('active');
                document.querySelector('.sidenav').classList.remove('active');
            }
        });
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.nav-container') && !e.target.closest('.sidenav')) {
            closeNav();
            document.querySelectorAll('.dropdown-content').forEach(menu => menu.classList.remove('active'));
        }
    });
</script>

