<?php

namespace RockGuard\app\model;

require_once 'app\model\Session.php';

use RockGuard\app\model\Session;

class Auth
{

      /**
       * check
       *
       * @param  string $name
       * @return mixed
       */
      static public function check(string $name = 'user')
      {
            return Session::check($name);
      } //-- end check
      
      /**
       * user
       *
       * @return void
       */
      static public function user(){
            return Session::get('user');
      }//-- end user

      /**
       * register
       *
       * @return mixed
       */
      static public function register($user){
            return Session::set('user', $user);
      }//-- end register
}//-- end class Auth