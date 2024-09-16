<?php

namespace RockGuard\app\controller;

require_once "app\model\User.php";
require_once "app\model\Session.php";

use Exception;
use RockGuard\app\model\Auth;
use RockGuard\app\model\Session;
use RockGuard\app\model\User;

class UserController
{
      /**
       * store
       *
       * @param  mixed $name
       * @param  mixed $email
       * @param  mixed $password
       */
      public static function store($name, $email, $password)
      {
            return User::create($name, $email, $password);
      } //-- end store function

      /**
       * update
       *
       * @param  mixed $name
       * @param  mixed $emil
       * @param  mixed $password
       * @param  mixed $image
       */
      public static function update()
      {
            try {

                  // check validation
                  if (!self::update_validation())
                        return;

                  // check if there is image
                  $image = $_FILES['image'];
                  // echo "<pre>";
                  // print_r($image['size'] != 0);
                  // die();
                  // check if there is image or not
                  $image_path = Auth::user()['image'];
                  if ($image['size'] != 0) {
                        $image_name      = $image['name'];
                        $image_tmp        = $image['tmp_name'];
                        $image_path = 'images/upload/' . rand(0, 10000) . '_' . $image_name;
                        move_uploaded_file($image_tmp, $image_path);
                  }

                  // oky the data is valid (:
                  User::update($_POST['name'], $_POST['email'], $_POST['password'], $image_path);

                  // modify the session information
                  Auth::register(User::find($_POST['email'], 'email'));
                  header('location: edit-profile.php');
            } catch (Exception $e) {
                  echo $e->getMessage();
            }
            //User::update($name, $emil, $password ,$image = null);
      } //-- end update function

      /**
       * update_validation
       *
       */
      public static function update_validation()
      {
            // validation the request
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $image = $_FILES['image'];
            $image_name      = $image['name'];
            $image_size      = $image['size'];
            $allow_image = ['png', 'jpg', 'gif', 'jpeg', 'tiff'];
            $image_extension = explode('.', $image_name);
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
            //check if the email exist in database before edit it
            if (User::check_email_before_update($email)) {
                  $errors['email'] = 'The email is exist in our records try with another one';
            }
            // Check If This Not Image
            if (!empty($image_name) && !in_array(end($image_extension), $allow_image)) {
                  $errors['image'] = ' This not allow please chose image';
            }
            // Check The Size
            if (!empty($image_name) && $image_size > 4000000) {
                  $errors['image'] = 'Big size ? try another one';
            }
            // Check if there is error before connect the database
            return !empty($errors) ?  Session::flash($errors) : true;
      } //-- end update validation
}//-- end user controller