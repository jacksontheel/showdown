<?php
    session_start();

    $createUserStatus = array();
    if (isset($_SESSION['statusCreate']))
    {
        $createUserStatus = $_SESSION['statusCreate'];
        unset($_SESSION['statusCreate']);
    }

    function getUserInput($lookup)
    {
        $retVal = "";
        if (isset($_SESSION['post'][$lookup]))
        {
            $retVal = $_SESSION['post'][$lookup];
            unset($_SESSION['post'][$lookup]);
        }
        return $retVal;
    }
?>
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
<html>
    <head>
        <link rel="stylesheet" href="../style.css?v=1.03">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;400&display=swap" rel="stylesheet">
    <body>
        <div class="container">
            <?php
                require_once "Nav.php";
            ?>
            <main>
                <div class="content">
                    <form name="loginForm" action="Handler/login_handler.php" method="POST">
                        <?php
                            if(isset($_SESSION["statusLogin"]))
                            {
                                echo "<div class='status'>";
                                echo $_SESSION["statusLogin"];
                                echo "</div>";
                                unset($_SESSION["statusLogin"]);
                            }
                        ?>
                        <h1>Sign in</h1>
                        <label for="username">username:</label>
                        <input type="text" id="username" name="username" value="<?php echo getUserInput("loginUsername"); ?>"><br><br>
                        <label for="password">password:</label>
                        <input type="password" id="password" name="password"><br><br>
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </main>
            <main>
                <div class="content">
                    <h1>Create an account</h1>
                    <form name="createUserForm" action="Handler/createUserHandler.php" method="POST">
                        <?php
                            if(count($createUserStatus) > 0)
                            {
                                echo "<div class='status'>";
                                foreach($createUserStatus as $s)
                                {
                                    echo "<p>" . $s . "</p>";
                                }
                                echo "</div>";
                            }
                        ?>
                        <label for="username">username:</label>
                        <input type="text" id="username" name="username" value="<?php echo getUserInput("createUsername"); ?>"><br><br>
                        <label for="password">password:</label>
                        <input type="password" id="password" name="password"><br><br>
                        <label for="reenterPassword">reenter password:</label>
                        <input type="password" id="reenterPassword" name="reenterPassword"><br><br>
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </main>
            <footer>&#169;Jackson Theel 2022</footer>  
        </div>
    </body>
</html>