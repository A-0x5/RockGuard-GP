<?php

namespace RockGuard\app\controller;

require_once 'app\model\Session.php';
require_once 'app\model\User.php';
require_once 'app\model\Auth.php';
require_once 'app\controller\UserController.php';

use Exception;
use RockGuard\app\model\Session;
use RockGuard\app\model\User;
use RockGuard\app\controller\UserController;
use RockGuard\app\model\Auth;

class AuthController
{


      /**
       * sign_up
       *
       * @return mixed
       */
      public static function sign_up()
      {
            try {
                  // check validation
                  if (!self::register_validation())
                        return;

                  // oky the data is valid (:
                  // check if the email is already registered
                  if (User::find($_POST['email'], 'email'))
                        return Session::flash(['email' => 'This email is already registered']);

                  // oky the data is valid and the email is not registered
                  UserController::store($_POST['name'], $_POST['email'], $_POST['password']);

                  // start session for this user
                  Auth::register(User::find($_POST['email'], 'email'));
                  header('location: index.php');
            } catch (Exception $e) {
                  echo $e->getMessage();
            }
      } //-- end sign_up

      
      /**
       * sign_in
       *
       */
      public static function sign_in()
      {
            try {
                  // check validation
                  if (!self::sign_in_validation())
                        return;

                   // oky the data is valid (:
                  // check if the email and password on our database or not
                  if(User::check($_POST['email'], $_POST['password'])){
                        Auth::register(User::find($_POST['email'], 'email'));
                        header('location: index.php');
                  }

                  // oky there is error in email or password
                  return Session::flash(['email' => 'The email or password is wrong, try again!']);

            } catch (Exception $e) {
                  echo $e->getMessage();
            }
      } //-- end sign_in


      /**
       * register_validation
       *
       * @return mixed
       */
      public static function register_validation()
      {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $errors = [];

            // check the name length
            if (isset($name) && strlen($name) < 3) {
                  $errors['name'] =  'The name must be at least 3 characters';
            }
            // check the email length
            if (isset($email) && strlen($email) < 4) {
                  $errors['email'] =  'The email must be at least 4 characters';
            }
            // check the password length
            if (isset($password) && strlen($password) < 8) {
                  $errors['password'] = 'The password must be at least 8 characters';
            }
            // Check if there is error before connect the database
            return !empty($errors) ?  Session::flash($errors) : true;
      } //-- end register_validation


      /**
       * sign_in_validation
       *
       * @return mixed
       */
      public static function sign_in_validation()
      {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $errors = [];

            // check the email length
            if (isset($email) && strlen($email) < 4) {
                  $errors['email'] =  'The email must be at least 4 characters';
            }
            // check the password length
            if (isset($password) && strlen($password) < 8) {
                  $errors['password'] = 'The password must be at least 8 characters';
            }
            // Check if there is error before connect the database
            return !empty($errors) ?  Session::flash($errors) : true;
      } //-- end sign_in_validation


      /**
       * sign_out
       *
       */
      public static function sign_out()
      {
            Session::destroy('user');
            header('location: index.php');
      } //-- end sign_out
}//-- end AuthController class