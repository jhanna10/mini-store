<?php

session_start();
setcookie('auth', '', time() - 3600, '/');
session_destroy();
header('Location: index.php');
exit;