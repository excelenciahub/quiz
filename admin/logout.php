<?php
    include('../include/config.php');
    session_destroy();
    
    header("location:".SITE_URL);exit;
?>