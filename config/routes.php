<?php

  $routes->get('/', function() {
    TopicController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
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

  $routes->get('/topic/:id/edit', function($id){
    TopicController::edit($id);
  });

  $routes->post('/topic/:id/edit', function($id){
    TopicController::update($id);
  });

  $routes->post('/topic/:id/destroy', function($id){
    TopicController::destroy($id);
  });

  //reply
  $routes->post('/reply', function(){
    ReplyController::store();
  });

  //user
  $routes->get('/login', function(){
    UserController::login();
  });

  $routes->post('/login', function(){
    UserController::handle_login();
  });
