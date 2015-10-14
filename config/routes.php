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

  $routes->post('/logout', function(){
    UserController::logout();
  });

  $routes->get('/user/:id', function($id){
    UserController::show($id);
  });

  $routes->post('/user/:id', function($id){
    UserController::update($id);
  });

  $routes->get('/user/:id/edit', function($id){
    UserController::edit($id);
  });

  $routes->post('/user/:id/edit', function($id){
    UserController::updateUser($id);
  });

  $routes->post('/user/:id/destroy', function($id){
    UserController::destroy($id);
  });

  $routes->get('/signup', function(){
    UserController::new_user();
  });

  $routes->post('/signup', function(){
    UserController::store();
  });

  $routes->get('/user', function(){
    UserController::all();
  });
