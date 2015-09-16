<?php
  //require 'app/models/topic.php';
  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
      //echo 'tämä on etusivu';
      View::make('home.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      $ekatopic = Topic::find(1);
      $topics = Topic::all();
      $replies = Reply::repliesForTopic(1);

      Kint::dump($replies);
      
    }

    public static function login(){
      View::make('suunnitelmat/login.html');
    }

    public static function thread(){
      View::make('suunnitelmat/show_thread.html');
    }

    public static function new_topic(){
      View::make('topic/new_topic.html');
    }
  }
