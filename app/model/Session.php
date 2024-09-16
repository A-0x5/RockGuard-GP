<?php

namespace RockGuard\app\model;

class Session
{

      /**
       * start session
       *
       * @return mixed
       */
      static public function start()
      {
            @session_start();
      } //-- end of session_start()


      /**
       * set
       *
       * @param  string $name
       * @param  mixed $value
       * @return mixed
       */
      static function set(string $name, mixed $value)
      {
            return $_SESSION[$name] = $value;
      } //-- end of set()


      /**
       * get
       *
       * @param  mixed $name
       * @return mixed
       */
      static function get(mixed $name)
      {
            return $_SESSION[$name];
      } //-- end of get()


      /**
       * destroy
       *
       * @param  mixed $name
       * @return mixed
       */
      static function destroy(mixed $name = null)
      {
            if ($name)
                  return $_SESSION[$name] = null;
            session_unset();
            session_destroy();
      } //-- end of destroy()

      
      /**
       * flash
       *
       * @param  mixed $value
       * @return mixed
       */
      static function flash(mixed $value)
      {
            $_SESSION['flash'] = $value;
      } //-- end of flash()


      /**
       * check
       *
       * @param  mixed $name
       * @return boolean
       */
      static function check(mixed $name)
      {
            return isset($_SESSION[$name]) && !empty($_SESSION[$name]) ? true : false;
      } //-- end of check()
}//-- end of session class