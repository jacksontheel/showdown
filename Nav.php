<header>
    <ul>
        <li><a href="index.php">Home</a></li>
        <?php
            if(!isset($_SESSION["username"]))
            {
                echo "<li><a href='login.php'>Log in</a></li>";
            }
            else
            {
                echo "<li><a href='user.php'>Profile</a></li>";
                echo "<li><a href='../Handler/logout.php'>Log out</a></li>";
            }
        ?>
    </ul>
</header>