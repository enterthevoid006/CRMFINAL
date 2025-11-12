<?php
class DashboardController {
    public function index() {
        require_once __DIR__ . '/../Models/DashboardModel.php';
        global $conn;

        $model = new DashboardModel($conn);

        $stats = $model->getStats();
        $dernieresFiches = $model->getLastFiches(); // ✅ bien orthographié

        require __DIR__ . '/../Views/dashboard.view.php';
    }
}



