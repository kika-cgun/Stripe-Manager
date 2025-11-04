<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once __DIR__ . '/dao.php';
$dao = new dao();

if($dao->apiKeyExists()){
    $page = $_GET['page'] ?? 'home';
}
else {
    $page = 'settings';
}

$allowedPages = ['home', 'add_customer', 'delete_customer', 'retrieve_customer', 'list_customers', 'update_customer', 'settings'];

$pageTitle = "Stripe Management - " . ucfirst($page);
if ($page === 'home') {
    $pageTitle = "Stripe Management - Home";
}

include __DIR__ . '/includes/header.php';

if (in_array($page, $allowedPages) && file_exists(__DIR__ . '/pages/' . $page . '.php')) {
    include __DIR__ . '/pages/' . $page . '.php';
} else {
    echo "<h3>404 - Strona nie znaleziona</h3>";
}

include __DIR__ . '/includes/footer.php';

?>