<?php
    require_once "Database/AppUser.php";
    require_once "Database/Dao.php";
    session_start();

    $dao = new Dao();
    
    $user;
    $loggedIn = isset($_SESSION["username"]);
    if (isset($_GET["username"]) && $dao->checkUserExists($_GET["username"]))
    {
        $user = new AppUser($_GET["username"]);
    }
    else if ($loggedIn)
    {
        $user = new AppUser($_SESSION["username"]);
    }
    else
    {
        header("Location:index.php");
        exit;
    }
?>
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
<html>
    <head>
        <link rel="stylesheet" href="../style.css?v=1.02">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;400&display=swap" rel="stylesheet">
    <body>
        <div class="container">
            <?php
                require_once "Nav.php";
            ?>
            <main id="userContent" class="user-sidebar">
                <h1>
                    <?php
                        echo htmlspecialchars($user->getUsername());
                    ?>
                </h1>
                <div>
                    <?php
                        echo "<p> User since " . $user->getCreateDate() . "</p>";
                        echo "<p>" . $user->numberOfVotes() . "-time voter";
                    ?>
                </div>
            </main>
            <main>
                <div class="comments">
                    <?php
                        foreach($user->getDiary() as $key=>$value)
                        {
                            echo "<div class='comment'>";
                            echo "<a href='../index.php?day=" . $key . "'>" . date('F d, Y', strtotime("3/26/2022" . " + " . $key . " days")) . "</a>";
                            echo "<p>Voted for " . $value->contestant . "</p>";
                            if ($value->comment != "")
                            {
                                echo "<p>&ldquo;" . htmlspecialchars($value->comment) . "&rdquo;</p>";
                            }
                            echo "</div>";
                        }
                    ?>
                </div>
            </main>
            <footer>&#169;Jackson Theel 2022</footer>  
        </div>
    </body>
</html>