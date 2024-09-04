<?php
// Determine the current page
$current_page = basename($_SERVER['PHP_SELF']);
?>
<header>
    <nav>
        <ul>
            <li><a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a></li>
            <li><a href="login.php" class="<?php echo ($current_page == 'login.php') ? 'active' : ''; ?>">Login</a></li>
            <li><a href="howitworks.php" class="<?php echo ($current_page == 'register.php') ? 'active' : ''; ?>">How It Works</a></li>
            <li><a href="aboutus.php" class="<?php echo ($current_page == 'register.php') ? 'active' : ''; ?>">About Us</a></li>
        </ul>
    </nav>
</header>
