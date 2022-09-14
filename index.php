<?php
  if (isset($_SERVER['HTTP_ORIGIN'])) {
      header('Access-Control-Allow-Origin: *');
      header('Access-Control-Allow-Credentials: true');
      header('Access-Control-Max-Age: 1000');
  }
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
      if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
          header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
      }

      if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
          header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");
      }
      exit(0);
  }
  require_once __DIR__.'/vendor/autoload.php';
  use App\Controllers\ProductController as ProductController;

  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $uri = explode('/', trim($uri, '/'));

  $uriFound=false;
  if (!empty($uri)&&$uri[0]==='products') {
      switch($_SERVER['REQUEST_METHOD']) {
          case 'GET':
              if (count($uri)===1) {
                  (new ProductController())->readAll();
                  $uriFound=true;
                  break;
              }
              break;
          case 'POST':
              if (count($uri)===2 && $uri[1]==='create') {
                  (new ProductController())->create();
                  $uriFound=true;
                  break;
              }
              break;
          case 'DELETE':
              if (count($uri)===2 && $uri[1]==='massDelete') {
                  (new ProductController())->massDelete();
                  $uriFound=true;
                  break;
              }
      }
  }
  if (!$uriFound) {
      header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
  }
