<?php
// A handler for logging out

session_start();
session_destroy();
header("Location:../index.php");
exit;