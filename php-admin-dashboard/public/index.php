<?php
require_once '../config/config.php';
require_once '../src/controllers/DashboardController.php';

session_start();

$controller = new DashboardController();

$view = 'dashboard'; // Default view

if (isset($_GET['view'])) {
    $view = $_GET['view'];
}

switch ($view) {
    case 'orders':
        $controller->renderOrders();
        break;
    case 'customers':
        $controller->renderCustomers();
        break;
    case 'inventory':
        $controller->renderInventory();
        break;
    case 'reports':
        $controller->renderReports();
        break;
    case 'settings':
        $controller->renderSettings();
        break;
    default:
        $controller->renderDashboard();
        break;
}
?>