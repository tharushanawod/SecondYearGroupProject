<?php

class Core{
    
    protected $currentController = 'LandingController';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
      

        $url = $this->getURL();
        //if controller exists in controllers folder then set as current controller 
        if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
            $this->currentController = ucwords($url[0]);
            unset($url[0]);

            //call the controller
            require_once '../app/controllers/' . $this->currentController . '.php';

            //instantiate controller class
            $this->currentController = new $this->currentController;
        
            //check whether the method exists in the controller
            if(isset($url[1])){
                if(method_exists($this->currentController, $url[1])){
                    $this->currentMethod = $url[1];
                    unset($url[1]);
                }
                
                //get parameters
                $this->params = $url ? array_values($url) : [];
            
                //call method and pass parameters
                call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
            }
        }
    }

    public function getURL(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            return $url;
        }
    }
}

?>