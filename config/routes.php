<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/login', function(){
  	HelloWorldController::login();
  });

  $routes->get('/new_thread', function(){
    HelloWorldController::new_thread();
  });

  $routes->get('/thread/1', function(){
  	HelloWorldController::thread();
  });
