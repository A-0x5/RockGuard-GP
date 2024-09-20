<?php

namespace RockGuard\app\model;

require_once 'app\database\Database.php';
require_once 'app\model\Auth.php';

use RockGuard\app\model\Auth;

class User
{

      
      /**
       * find
       *
       * @param  mixed $value
       * @param  mixed $checkable
       * @return mixed
       */
      public static function find(string $value, $checkable = 'id')
      {
            $statement = $GLOBALS['conn']->prepare("SELECT * FROM `users` WHERE $checkable = ?");
            $statement->execute([$value]);
            return $statement->fetch();
      } //-- end find user


      /**
       * check
       *
       * @param  mixed $email
       * @param  mixed $password
       */
      public static function check(string $email, $password)
      {
            $statement = $GLOBALS['conn']->prepare("SELECT `email`, `password` FROM `users` WHERE `email` = ? && `password` = ?");
            $statement->execute([$email, $password]);
            return $statement->fetchAll();
      } //-- end check function


      /**
       * create
       *
       * @param  mixed $name
       * @param  mixed $email
       * @param  mixed $password
       */
      public static function create($name, $email, $password)
      {
            $statement = $GLOBALS['conn']->prepare('INSERT INTO `users` (`name`, `email`, `password`) Values(?,?,?)');
            return $statement->execute([
                  $name,
                  $email,
                  $password
            ]);
      }

      /**
       * update
       *
       * @param  mixed $name
       * @param  mixed $email
       * @param  mixed $password
       * @param  mixed $image
       */
      public static function update($name, $email, $password, $image = null)
      {
            $statement = $GLOBALS['conn']->prepare("UPDATE users SET `name` = :name_des, `email` = :email_des, `password` = :password_des, `image` = :image_des WHERE `id` = :id_des");
            return $statement->execute(array(
                  'name_des'      => $name,
                  'email_des'         => $email,
                  'password_des'        => $password,
                  'image_des'   => $image,
                  'id_des'       => Auth::user()['id']
            ));
      } //-- end update function
      
      /**
       * check_email_before_update
       *
       * @param  mixed $email
       * @return mixed
       */
      public static function check_email_before_update($email){
            $statement = $GLOBALS['conn']->prepare("SELECT COUNT(`email`) FROM `users` WHERE `email` = ? AND `id` != ?");
            $statement->execute([$email, Auth::user()['id']]);
            return $statement->fetchColumn();
      }//-- end check_email_before_update function

     
}//-- end user model
