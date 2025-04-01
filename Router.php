<?php
namespace MVC;

class Router {
    public $getRoutes = [];
    public $postRoutes = [];

    public function get($url, $fn) {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn) {
        $this->postRoutes[$url] = $fn;
    }

    public function checkRoute() {
        $currentUrl = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        $routes = ($method === 'POST') ? $this->postRoutes : $this->getRoutes;
        $fn = $routes[$currentUrl] ?? null;

        $this->executeFunction($fn);
    }

    public function executeFunction($fn) {
        if ($fn) {
            call_user_func($fn, $this);
        } else {
            header("HTTP/1.0 404 Not Found");
            $this->render('pages/default');
        }
    }

    public function render($view, $data = []) {
        foreach($data as $key=>$value) {
            $$key = $value;
        }
        
        ob_start();
        include_once __DIR__ . '/views/' . $view . '.php';
        $content = ob_get_clean();
        include __DIR__ . '/views/layout.php';
    }
}