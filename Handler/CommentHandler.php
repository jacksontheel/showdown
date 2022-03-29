<?php
// A handler for creating a comment
require_once "../Database/Dao.php";

function validateComment($comment)
{
    $retVal = true;

    // Comment must be at least 1 character
    $retVal = $retVal && (strlen($comment) > 0);
    // Comment must be no greater than 280 characters
    $retVal = $retVal && (strlen($comment) <= 280);
    // Grossly oversimplified profanity filter
    $retVal = $retVal && !preg_match("shit|damn|fuck", $input);

    return $retVal;
}

if (isset($_POST["commentButton"]))
{
    session_start();

    if(!isset($_SESSION["username"]))
    {
        header("Location:../login.php");
        exit;
    }

    $comment = $_POST["comment"];
    $author = $_SESSION["username"];
    $fightid = $_POST["fightid"];

    try
    {
        $dao = new Dao();
        if (validateComment($comment))
        {
            $dao->saveComment($comment, $author, $fightid);
        }
    } catch (Exception $e)
    {
        var_dump($e);
        exit;
    }
}

header("Location:../index.php");
exit;