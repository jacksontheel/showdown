<?php
// A handler for logging in.

require_once "../Database/Dao.php";
session_start();

$dao = new Dao();
$user = $dao->checkUser($_POST["username"], $_POST["password"]);
if ($user)
{
    $_SESSION["access_granted"] = true;
    $_SESSION["username"] = $_POST["username"];
    header("Location:../index.php");
} else
{
    $status = "Invalid username or password";
    $_SESSION["post"]["loginUsername"] = $_POST["username"];
    $_SESSION["statusLogin"] = $status;
    $_SESSION["access_granted"] = false;

    header("Location:../login.php");
}