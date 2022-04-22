<?php

class Pages extends Controller {
  
  public function __construct()
  {
    $this->postModel = $this->model('Post');

  }

  // Index: Default view 
  public function index() {

    $posts = $this->postModel->getPosts();

    $data = [
      'title' => 'WELCOME',
      'posts' => $posts
    ];


    $this->view('pages/index', $data);
  }
  
  public function about() {

    $data = [
      'title' => 'ABOUT'
    ];

    $this->view('pages/about', $data);
  }
}