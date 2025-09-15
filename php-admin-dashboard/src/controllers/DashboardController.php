<?php

class DashboardController {
    public function renderDashboard() {
        include '../views/dashboard.php';
    }

    public function renderOrders() {
        include '../views/orders.php';
    }

    public function renderCustomers() {
        include '../views/customers.php';
    }

    public function renderInventory() {
        include '../views/inventory.php';
    }

    public function renderReports() {
        include '../views/reports.php';
    }

    public function renderSettings() {
        include '../views/settings.php';
    }
}