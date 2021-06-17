<?php
require_once ('auth/auth.database.php');
require_once ('auth/session.php');
session_unset();
session_destroy();
header("location: index.php");
?>