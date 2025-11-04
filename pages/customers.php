<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$config = include __DIR__ . '/.config.php';

$stripe = $config['stripe'];

$customers = $stripe->customers->all(['limit' => 3]);

header('Content-Type: application/json');
echo json_encode($customers, JSON_PRETTY_PRINT);