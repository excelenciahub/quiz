<?php
    include('include/config.php');
    session_destroy();
    
    header("location:".SITE_URL."login.php");exit;
?>