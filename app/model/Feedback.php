<?php

namespace RockGuard\app\model;

class Feedback
{

      /**
       * get all feedback for registered user
       *
       * @return mixed
       */
      public static function all($user_id)
      {
            $statement = $GLOBALS['conn']->prepare("SELECT `url`, `id` FROM `feedbacks` WHERE `user_id` = ?");
            $statement->execute([$user_id]);
            return $statement->fetchAll();
      } //-- end of all function

       /**
       * create feedback
       *
       * @param  mixed $
       * @param  mixed $
       * @param  mixed $
       */
      public static function create($url, $result, $is_save, $additional, $user_id)
      {
            $statement = $GLOBALS['conn']->prepare('INSERT INTO `feedbacks` (`url`, `results`, `is_save`, `additional`, `user_id`) Values(?,?,?,?,?)');
            return $statement->execute([
                  $url,
                  $result,
                  $is_save,
                  $additional,
                  $user_id
            ]);
      }//-- end create function
      
      /**
       * update
       *
       * @param  mixed $url
       * @param  mixed $result
       * @param  mixed $is_save
       * @param  mixed $additional
       * @param  mixed $user_id
       * @return mixed
       */
      public static function update($url, $result, $is_save, $additional, $id, $user_id){
            $statement = $GLOBALS['conn']->prepare("UPDATE feedbacks SET `url` = :url_des, `results` = :result_des, `is_save` = :is_save_des, `additional` = :additional_des WHERE `id` = :id_des AND `user_id` = :user_id_des");
            return $statement->execute([
                  'url_des'      => $url,
                  'result_des'         => $result,
                  'is_save_des'        => $is_save,
                  'additional_des'   => $additional,
                  'id_des'   => $id,
                  'user_id_des'       => Auth::user()['id'],
            ]);
      }//-- end update function


      /**
       * find
       * @param  mixed $checkable
       * @return mixed
       */
      public static function find($checkable)
      {
            $statement = $GLOBALS['conn']->prepare("SELECT * FROM `feedbacks` WHERE `id` = ? AND `user_id` = ? ");
            $statement->execute([$checkable, Auth::user()['id']]);
            return $statement->fetch();
      } //-- end find feedback

      
}//-- end class Feedback