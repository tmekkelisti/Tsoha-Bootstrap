<?php

  $routes->get('/', function() {
    TopicController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/login', function(){
  	HelloWorldController::login();
  });

  //topics
  $routes->get('/topic', function(){
    TopicController::index();
  });

  $routes->get('/topic/new_topic', function(){
    TopicController::new_topic();
  });

  $routes->post('/topic', function(){
    TopicController::store();
  });

  $routes->get('/topic/:id', function($id){
  	TopicController::show($id);
  });

  //reply
  $routes->post('/reply', function(){
    ReplyController::store();
  });
