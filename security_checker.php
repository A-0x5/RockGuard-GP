<?php

namespace RockGuard\sign_in;

require_once 'app/model/Auth.php';
use RockGuard\app\model\Auth;

// Open Buffer
ob_start();

// Start session
@session_start();


// Make navbar to show if there is navigation on this page or not
$navbar = true;

// Make var to show if the language is Arabic or English
$lang = 'en';

// Make the title of the page
$page_title = 'Rock Guard | Security Checker';

// Call connect File
include_once 'app/database/database.php';

// Call init File
include_once 'app/config/init.php';

// Call home page
include_once 'view/_security_checker.php';

include_once $template . 'footer.php';

// Exit Open Buffer
ob_end_flush();

?>

