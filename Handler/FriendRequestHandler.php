<?php
// A handler for creating a new friend request (not currently used)

require_once "Database/AppUser.php";

$followee = new AppUser($_POST["followee"]);

$followee->sendRequestFrom($_POST["follower"]);

header("Location:user.php?username=" . $_POST["followee"]);