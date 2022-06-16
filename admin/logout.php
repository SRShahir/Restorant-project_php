<?php
include('../config/constants.php');
//destroy the session
session_destroy();
header('location:'.SITEURL.'admin/login.php');
?>