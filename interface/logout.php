<?php
session_start();
unset($_SESSION['Username1']);
unset($_SESSION['GroupID1']);
unset($_SESSION['UserID1']);
unset($_SESSION['check']);
//session_destroy($_SESSION['Username1']);
header('Location: login.php');
exit();

?>