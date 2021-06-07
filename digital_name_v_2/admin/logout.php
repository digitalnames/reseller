<?php
session_start();
unset($_SESSION['login_token']);

header("Location: index.php");
exit();