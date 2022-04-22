<?php 

  /* Base controller
   * Loads models and views
   */

class Controller {

  // Load Controller
  private function requireModel($model) {
    $modelFile = '../app/models/' . $model . '.php';
    if (file_exists($modelFile)) {
      require_once($modelFile);
    }
    else {
      die("Error: Model file missing: " . $modelFile);
    }
  }

  protected function model($model) {
    // Require model file
    $this->requireModel($model);
    return new $model;
  }

  // Load View
  private function requireView($view, $data) {
    $viewFile = '../app/views/' . $view . '.php';
    if (file_exists($viewFile)) {
      require_once($viewFile);
    }
    else {
      die("Error: View file missing: " . $viewFile);
    }
  }

  protected function view($view, $data = []) {
    $this->requireView($view,$data);
  }
}