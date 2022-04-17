<?php

function currentPageClass($page)
{
    return ($_GET["current"] === $page)? "current" : "";
}

?>


<header>
    <ul>
        <li><a class="<?php echo currentPageClass("home") ?>" href="index.php">Home</a></li>
        <?php
            if(!isset($_SESSION["username"]))
            {
                echo "<li><a class='" . currentPageClass("login")  . "' href='login.php'>Log in</a></li>";
            }
            else
            {
                echo "<li><a class='" . currentPageClass("profile")  . "' href='user.php'>Profile</a></li>";
                echo "<li><a href='../Handler/logout.php'>Log out</a></li>";
            }
        ?>
    </ul>
</header>