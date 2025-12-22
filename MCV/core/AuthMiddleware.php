<?php
if (!isset($_SESSION['user'])) {
    header("Location: " . _BASE_URL . "/auth/signin");
    exit;
}