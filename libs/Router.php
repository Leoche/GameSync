<?php
class Router {

    private $url;
    private $routes = [];

	public function __construct($url){
		$this->url = $url;
	}
    public function get($path, $callable){
		$route = new Route($path, $callable);
		$this->routes["GET"][] = $route;
		return $route;
	}
    public function post($path, $callable){
		$route = new Route($path, $callable);
		$this->routes["POST"][] = $route;
		return $route;
	}
    public function delete($path, $callable){
		$route = new Route($path, $callable);
		$this->routes["DELETE"][] = $route;
		return $route;
	}
	public function run(){
	    if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
	    	header("HTTP/1.0 404 Not Found");
	    }
	    foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
	        if($route->match($this->url)){
	            return $route->call();
	        }
	    }
	    header("HTTP/1.0 404 Not Found");
	}
}