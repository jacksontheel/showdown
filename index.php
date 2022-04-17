<?php
    require_once "Database/Dao.php";
    require_once "Database/Fight.php";
    require_once "Database/AppUser.php";
    $dao = new Dao();

    session_start();

    // Setting up today's fight
    date_default_timezone_set('America/Los_Angeles');
    $startDate = date_create("2022-03-26");
    $today = date_create();
    $diff = date_diff($startDate, $today);
    $todayId = 1 + $diff->format("%a");

    $readOnly = false;
    if (!isset($_GET["day"]) || $_GET["day"] >= $todayId)
    {
        $fight = new Fight($todayId);
    }
    else
    {
        $fight = new Fight($_GET["day"]);
        $readOnly = true;
    }

    // Set up user if logged in
    $loggedIn = isset($_SESSION["username"]);
    $user;
    if ($loggedIn)
    {
        $user = new AppUser($_SESSION["username"]);
    }
?>
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
<html>
    <head>
        <link rel="stylesheet" href="style.css?v=1.03">
    </head>
    <body>
        <div class="container">
            <?php
                $_GET["current"] = "home";
                require_once "Nav.php";
            ?>
            <header class="readOnly">
                <p>Everybody Fights is going read-only on May 1st. Thanks for playing!</p>
                <a class="readOnlyClose">X</a>
            </header>
            <main>
                <div class="content">
                    <h1>Fight to the death:<br />Who would win?</h1>
                    <div id="userProfileCharacters">
                    <?php
                        $contestants = $fight->getContestants();
                        $contestantNumber = 1;
                        foreach ($contestants as $c)
                        {
                            if ($readOnly || ( $loggedIn && $fight->hasVoted($user->getUsername()) ))
                            {
                                if ($contestantNumber == 1)
                                {
                                    $spanClass = "character-left-span";
                                }
                                else
                                {
                                    $spanClass = "character-right-span";
                                }
                                echo "<p>" . $c["username"] . "<span class='" . $spanClass . "'>&#9679;</span></p>";
                            }
                            else
                            {
                                echo "<form action='Handler/CastVote.php' method='POST'>";
                                    echo "<input type='submit'";
                                    if ($contestantNumber == 1)
                                    {
                                        echo " class='left-character-button'";
                                    }
                                    else
                                    {
                                        echo " class='right-character-button'";
                                    }
                                    echo " value='" . $c["username"] . "'";
                                    echo "/>";
                                    echo "<input type='hidden' name='id' value='" . $c["id"] . "' />";
                                echo "</form>";
                            }
                            $contestantNumber++;
                        }
                    ?>
                    </div>
                    <div id="progress">
                        <div id="fill" style="width:<?php
                            echo $fight->getFillPercent();
                        ?>%"></div>
                    </div>
                    <p id="matchTime"></p>
                </div>
            </main>
            <aside class="comments">
                <form name="commentForm" action="Handler/CommentHandler.php" method="POST">
                    <textarea <?php if ($readOnly) echo "readonly"; ?> name="comment" placeholder="You may make one comment per day."></textarea>
                    <input type="hidden" name="fightid" value="<?php echo $fight->id ?>" />
                    <?php
                        if(!$readOnly)
                        {
                            echo "<input type='submit' name='commentButton' />";
                        }
                    ?>
                </form>
                <?php
                    $comments = $dao->getComments($fight->id);
                    foreach ($comments as $comment)
                    {
                        echo "<div class='comment'>";
                        echo "<a class='commentUsername' href='user.php?username=" . htmlspecialchars($comment["author"]) . "'>";
                            echo htmlspecialchars($comment["author"]);
                        echo "</a>";
                        echo "</a>";
                        if ($loggedIn && ($user->isAdmin() || $comment["author"] == $user->getUsername()) )
                        {
                            echo "<a class='commentDelete' href='Handler/DeleteCommentHandler.php?username=" . $comment["author"] . "&fightid=" . $fight->id . "'>X</a>";
                        }
                        echo "<p>" . htmlspecialchars($comment["content"]) . "</p>";
                        echo "<ul>";
                        echo "<li><a href='https://twitter.com/intent/tweet?text=" . urlencode($fight->contestantsString() . "\n" . $comment["content"] . "\n\neverybodyfights.herokuapp.com") . "'>tweet</a></li>";
                        echo "</ul>";
                        echo "</div>";
                    }
                ?>
            </aside>
            <footer>
                <ul>
                    <?php
                    if ($fight->id > 1)
                    {
                        echo "<li><a href='index.php?day=1'>First</a></li>";
                        echo "<li><a href='index.php?day=" . $fight->id - 1 . "'>Previous</a></li>";
                    }
                    if ($fight->id < $todayId)
                    {
                        echo "<li><a href='index.php?day=" . $fight->id + 1 . "'>Next</a></li>";
                        echo "<li><a href='index.php'>Latest</a></li>";
                    }
                    ?>
                </ul>
            </footer>  
            <footer>&#169;Jackson Theel 2022</footer>  
        </div>
    <script src="jquery.js"></script>
    <script src="jquery-ui.js"></script>
    <script src="countdown.js"></script>
    <script src="animatebar.js"></script>
    <script src="readOnlyBanner.js"></script>
    </body>
</html>
