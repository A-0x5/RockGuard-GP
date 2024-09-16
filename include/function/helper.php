<?php

namespace RockGuard\include\function;

require_once 'app\model\Session.php';

use RockGuard\app\model\Session;

/**
 * getTitle
 *
 * @return void
 */
function getTitle(): void
{
    echo isset($GLOBALS['page_title']) ? $GLOBALS['page_title'] : 'RockGuard';
} //-- end getTitle function


/**
 * error
 *
 * @param  string $name
 * @return mixed
 */
function error(string $name): mixed
{

    return Session::check('flash') && !empty(Session::get('flash')[$name])
        ? Session::get('flash')[$name] : false;
} //-- end error function


/**
 * old
 *
 * @param  string $input
 * @param  string $value
 * @return mixed
 */
function old(string $input, string $value = null) : mixed
{
    return isset($_POST[$input]) && !empty($_POST[$input]) ? $_POST[$input] : $value;
}//-- end old function


function success(){

    return Session::check('flash') && !empty(Session::get('flash')['success'])
        ? Session::get('flash')['success'] : false;
}//-- end success function