<?php
session_start();
unset($_SESSION['Username']);
unset($_SESSION['GroupID']);
unset($_SESSION['id']);
//session_destroy($_SESSION['Username1']);
header('Location: login.php');
exit();

?>