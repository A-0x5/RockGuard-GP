<?php

require_once 'app/model/Auth.php';
require_once 'app/controller/SecurityCheckerController.php';
require_once 'app/model/Session.php';

use RockGuard\app\controller\SecurityCheckerController;
use RockGuard\app\model\Auth;
use RockGuard\app\model\Session;

// Check if the user is logged in
if (!Auth::check()) {
    ?>
    <div class="container">
        <div class="wrapper feedback">
            <div class="not-login d-block">
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-white">You must be logged in to use the security checker</h1>
                        <div class="col-12 text-center">
                            <button class="btn text-white">Please sign in to continue!</button>
                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-dark text-white mr-0" href="sign-in.php">Click here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    return; // End the script here if the user is not logged in
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    SecurityCheckerController::store(); // Use the store function from SecurityCheckerController
}

?>
<!-- Start with image -->
<div class="container p-0">
    <div class="wrapper security_checker">
        <div class="content">
            <div class="col-12 mb-5">
                <h1 class="text-white text-center">Start the free security Checker</h1>
            </div>
            <form class="col-12 mb-4" action="" method="POST">
                <div class="input-group">
                    <input name="url" style="padding:10px" class="form-control" type="search" 
                        placeholder="Put Your Link Here !" 
                        aria-label="Put Your Link Here !" 
                        aria-describedby="basic-addon2" 
                        required
                        value="<?php echo isset($_POST['url']) ? htmlspecialchars($_POST['url']) : ''; ?>">
                </div>
                <button type="submit" class="btn btn-send text-white mt-3 w-100 d-block">SEND</button>
            </form>

            <?php
            // Check if the form was submitted and the URL is set
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['url'])) {
                $url_to_check = $_POST['url'];
                $result = SecurityCheckerController::scanUrlWithVirusTotal($url_to_check); // Use the scan function

                echo '<div class="col-12 col-md-6 m-md-auto">';
                echo '<div class="result">';

                if ($result === 0) {
                    // Dangerous link
                    echo '<div class="dangerous d-block">';
                    echo '<img src="images/dangerous.png" alt="dangerous result" class="img-fluid">';
                    echo '</div>';
                } else {
                    // Safe link
                    echo '<div class="true d-block">';
                    echo '<img src="images/safe.png" alt="safe result" class="img-fluid">';
                    echo '</div>';
                }

                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>




