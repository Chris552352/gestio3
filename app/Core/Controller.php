<?php
namespace App\Core;

abstract class Controller {
    protected function render($view, $data = []) {
        extract($data);
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';
        
        if (!file_exists($viewPath)) {
            throw new \Exception('View not found: ' . $view);
        }
        
        ob_start();
        require $viewPath;
        $content = ob_get_clean();
        
        require __DIR__ . '/../Views/layout.php';
    }

    protected function redirect($url) {
        header('Location: ' . APP_URL . $url);
        exit();
    }

    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}
