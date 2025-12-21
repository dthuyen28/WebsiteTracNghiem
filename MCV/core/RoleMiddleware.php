<?php
function requireRole($role)
{
    if ($_SESSION['user']['role'] !== $role) {
        header("Location: " . _BASE_URL . "/403");
        exit;
    }
}
