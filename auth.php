<?php

if (!isset($_SESSION['name'])) {
   header("Location: /sis/05_GENERAL/login_module.php");
    exit();
}

?>