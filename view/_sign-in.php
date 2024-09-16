<?php

require_once 'app\controller\AuthController.php';

use RockGuard\app\controller\AuthController;
use function RockGuard\include\function\error;
use function RockGuard\include\function\old;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      AuthController::sign_in();
}

?>


<div class="wrapper-sign">
      <!-- Start with image -->
<div class="container">
      <div class="sign-in">
                  <div class="image-area">
                        <img class="img-fluid" src="./images/login-image.png" alt="image">
                  </div>
                  <!-- start form -->
                  <div class="form-area">
                        <h2 class="text-center">Login</h2>
                        <span>Sign in to continue</span>
                        <!-- start form-->
                        <form action="" method="POST">
                              <div class="form-group">
                                    <label for="email">EMAIL</label>
                                    <input class="form-control <?php echo error('email') != false ? 'is-invalid' : '' ?>" type="email" id="email" name="email"  value="<?php echo old('email') ?>" placeholder="Enter Email">
                                    <?php echo error('email') != false  ? "<small class='error invalid-feedback' >" . error('email') . "</small>" : '' ?>
                              </div>
                              <div class="form-group mt-4">
                                    <label for="password">PASSWORD</label>
                                    <input class="form-control <?php echo error('password') != false ? 'is-invalid' : '' ?>" type="password" id="password" name="password" placeholder="Enter Password">
                                    <?php echo error('password') != false  ? "<small class='error invalid-feedback' >" . error('password') . "</small>" : '' ?>
                                    <a class="forgot-password" href="forget-password.php">Forgot Your Password?</a>
                              </div>
                             <div class="form-group text-center mt-4 w-100">
                                    <button class="btn btn-dark text-white mr-0 mr-md-2 mb-2 mr-md-0 btn-login d-block w-100" type="submit">Sign in</button>
                                    <a class="btn btn-register text-white mr-0 mr-md-2 mb-2 mr-md-0 d-block w-100 mt-2" href="sign-up.php">New User</a>
                             </div>
                        </form>
                        <!-- end form-->
                  </div>
      </div>
</div>
</div>