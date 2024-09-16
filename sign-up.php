<?php

namespace RockGuard\sign_in;

require_once 'app\model\Auth.php';
use RockGuard\app\model\Auth;


// Open Buffer
ob_start();

// start session
@session_start();

// check if there is session or not
Auth::check() ? header('location: index.php') : '' ;


// make navbar to show if there is navigation on this page or not
$navbar = true;

// make var to show if The language us arabic or english
$lang = 'en';

// make the title of the page
$page_title = 'Rock Guard | Sign up';

// Call connect File

// Call init File
include_once 'app/config/init.php';

// Call home page
include_once 'view/_sign-up.php';

include_once $template . 'footer.php';

// Exit Open Buffer
ob_end_flush();

?>