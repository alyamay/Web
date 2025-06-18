<?php
session_start();
if (!isset($_SESSION['author_id'])) {
    header("Location: login.php");
    exit;
}
?>