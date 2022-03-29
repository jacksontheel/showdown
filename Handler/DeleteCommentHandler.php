<?php
// A handler for deleting a comment
require_once "../Database/Dao.php";
require_once "../Database/AppUser.php";

session_start();

// Set up user if logged in
$loggedIn = isset($_SESSION["username"]);
$user;
if ($loggedIn)
{
    $user = new AppUser($_SESSION["username"]);
}

if(!$loggedIn)
{
    header("Location:../index.php");
    exit;
}

if(!$user->isAdmin() && $_GET["username"] != $user->getUsername())
{
    header("Location:../index.php");
    exit;
}

$author = $_GET["username"];
$fightid = $_GET["fightid"];

try
{
    $dao = new Dao();
    $dao->removeComment($author, $fightid);
} catch (Exception $e)
{
    var_dump($e);
    exit;
}

header("Location:../index.php");
exit;