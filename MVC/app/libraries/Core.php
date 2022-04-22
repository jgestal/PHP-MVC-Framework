<?php 

/*
 * App Core Class
 * Creates URL & loads core controller
 * URL FORMAT - /controller/method/params
 */

class Core {

  protected $defaultController = 'Pages';
  protected $defaultMethod = 'index';
  protected $defaultParams = [];

  protected $currentController;
  protected $currentMethod;
  protected $currentParams;

  private function getURLArray() {
    if (isset($_GET['url'])) {
      $url = rtrim($_GET['url'], '/');
      $urlFiltered = filter_var($url, FILTER_SANITIZE_URL);
      $urlArray = explode('/', $urlFiltered);
      return $urlArray;
    }
  }

  private function controllerPathFor($controller) {
    return '../app/controllers/' . $controller . '.php';
  }

  private function getControllerNameFromURLArrayOrDefault($urlArray) {

    $controllerName = isset($urlArray[0]) ? ucwords($urlArray[0]) : NULL;

    if ($controllerName != NULL && file_exists($this->controllerPathFor($controllerName))) {
      return $controllerName;
    }

    return $this->defaultController;
  }

  private function getMethodFromURLArrayOrDefault($urlArray) {

    if (isset($urlArray[1]) && method_exists($this->currentController,$urlArray[1])) {
      return $urlArray[1];
    }
    return $this->defaultMethod;
  }

  private function getParamsFromURLArray($urlArray) {

    if (isset($urlArray[2])) {
      unset($urlArray[0]);
      unset($urlArray[1]);

      return array_values($urlArray);
    }
    return $this->defaultParams;
  }

  public function __construct() {

    $urlArray = $this->getURLArray();
    // Set the current controller
    $controllerName = $this->getControllerNameFromURLArrayOrDefault($urlArray);
    // Require the controller
    require_once $this->controllerPathFor($controllerName);
    // Instantiate controller class
    $this->currentController = new $controllerName;
    // Set the current method
    $this->currentMethod = $this->getMethodFromURLArrayOrDefault($urlArray);
    // Params
    $this->currentParams = $this->getParamsFromURLArray($urlArray); 
    // Call the controller with method and params
    call_user_func_array([$this->currentController, $this->currentMethod], $this->currentParams);
  }
}

