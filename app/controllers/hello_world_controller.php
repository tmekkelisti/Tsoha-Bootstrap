<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
      //echo 'tämä on etusivu';
      View::make('home.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      echo 'Hello World!';
    }

    public static function login(){
      View::make('suunnitelmat/login.html');
    }

    public static function thread(){
      View::make('suunnitelmat/show_thread.html');
    }
  }
