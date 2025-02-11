<?php

class Core{
    
    protected $currentController = 'LandingController';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
        $url = $this->getURL();

        // Check if controller file exists
        if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        } else {
            $this->show404();
        }

        // Require and instantiate the controller
        require_once '../app/controllers/' . $this->currentController . '.php';
        $this->currentController = new $this->currentController;

        // Check if method exists in controller
        if(isset($url[1]) && method_exists($this->currentController, $url[1])){
            $this->currentMethod = $url[1];
            unset($url[1]);
        } elseif (isset($url[1])) {
            $this->show404();
        }

        // Get parameters
        $this->params = $url ? array_values($url) : [];

        // Call method and pass parameters
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function show404() {
        http_response_code(404);
        require "../app/views/inc/404.php"; // Load your custom 404 page
        exit();
    }

    public function getURL(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return ["LandingController"]; // Default controller
    }
}

?>
