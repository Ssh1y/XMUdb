<?php
session_start();
if (isset($_SESSION['USER']))
    session_destroy();
    die("<script>window.location.href='".$_SERVER['HTTP_REFERER']."'</script>");
