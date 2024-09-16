<?php

namespace RockGuard\app\config;

require_once 'app\model\Session.php';
use RockGuard\app\model\Session;

/*
==========================================================================
== init Files
== Include connect File | Header File | Navbar File |Footer File | 
==========================================================================
*/

// Make variable for the folder path
$template = 'include/template/';

$function = 'include/function/';

$language = 'include/language/';

$libraries    = 'include/library/';

$js = 'src/js/';

$css = 'src/css/';

$lang = 'en';

// Check if the page is in english or arabic
include_once $language . $lang . '.php';

// Include functions
include_once $function . 'helper.php';

// Include header
include_once $template . 'header.php';

// Check if the page have navigation or not
$navbar ? include_once $template . 'navbar.php' : '';

// check the session flash
// if (Session::check('flash') && !empty(Session::check('flash')))
//       print_r(Session::get('flash')['name']);

// remove all flash session
Session::destroy('flash');