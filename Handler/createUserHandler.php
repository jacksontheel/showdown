<?php
// A handler for creating a new user
require_once "../Database/Dao.php";
session_start();

$dao = new Dao();

// Check passwords match
if ($_POST["password"] != $_POST["reenterPassword"])
{
    $_SESSION['statusCreate'][] = "Passwords don't match.";
    $_SESSION["post"]["createUsername"] = $_POST["username"];
}

// Check password length > 5
if(strlen($_POST["password"]) < 5)
{
    $_SESSION['statusCreate'][] = "Password must be at least 5 characters.";
    $_SESSION["post"]["createUsername"] = $_POST["username"];
}

// Check password length < 64
if(strlen($_POST["password"]) > 64)
{
    $_SESSION['statusCreate'][] = "Password may be 64 characters maximum.";
    $_SESSION["post"]["createUsername"] = $_POST["username"];
}

// Check user doesn't already exist
if($dao->checkUserExists($_POST["username"]))
{
    $_SESSION['statusCreate'][] = "Username already in use.";
}

// Check username length > 5
if(strlen($_POST["username"]) < 5)
{
    $_SESSION['statusCreate'][] = "Username must be at least 5 characters.";
}

// Check username length < 20
if(strlen($_POST["username"]) > 20)
{
    $_SESSION['statusCreate'][] = "Username may be 20 characters maximum.";
}

if (isset($_SESSION['statusCreate'])) {
    header("Location:../login.php");
    exit;
  }

$dao->createUser($_POST["username"], password_hash($_POST["password"], PASSWORD_DEFAULT));    
$_SESSION["username"] = $_POST["username"];
header("Location:../index.php");
exit;