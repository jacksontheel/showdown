<?php
// A handler for casting a single vote
require_once "../Database/Fight.php";

session_start();

if (!isset($_SESSION["username"]))
{
    header("Location:../login.php");
    exit;
}

Fight::addVote($_SESSION["username"], $_POST["id"]);

header("Location:../index.php");
exit;