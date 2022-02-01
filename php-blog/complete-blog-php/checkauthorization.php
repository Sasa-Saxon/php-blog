<?php

if (!isset($_SESSION["user"]) AND ! isset($_SESSION["admin"])) {
    header("Location: " . "http://localhost/complete-blog-php/index.php", TRUE);

    exit();
}
?>
