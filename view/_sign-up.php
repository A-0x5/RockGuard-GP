<?php

require_once 'app\controller\AuthController.php';

use RockGuard\app\controller\AuthController;
use function RockGuard\include\function\error;
use function RockGuard\include\function\old;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      AuthController::sign_up();
}

?>
<div class="wrapper-sign">
      <div class="container">
            <div class="sign-in">
                  <div class="image-area">
                        <img class="img-fluid" src="./images/login-image.png" alt="image">
                  </div>
                  <!-- start form -->
                  <div class="form-area">
                        <h2 style="font-size: 2.2rem;">Create new Account</h2>
                        <span><a href="sign-in.php" class='text-white'>Already Registered? login</a></span>
                        <!-- start form-->
                        <form method="POST">
                              <div class="form-group">
                                    <label for="name">NAME</label>
                                    <input class="form-control <?php echo error('name') != false ? 'is-invalid' : '' ?>" type="text" id="name" name="name" value="<?php echo old('name') ?>" placeholder="Enter Name">
                                    <?php echo error('name') != false  ? "<small class='error invalid-feedback' >" . error('name') . "</small>" : '' ?>
                              </div>
                              <div class="form-group mt-4">
                                    <label for="email">EMAIL</label>
                                    <input class="form-control <?php echo error('email') != false ? 'is-invalid' : '' ?>" type="email" id="email" name="email" value="<?php echo old('email') ?>" placeholder="Enter Email">
                                    <?php echo error('email') != false  ? "<small class='error invalid-feedback' >" . error('email') . "</small>" : '' ?>
                              </div>
                              <div class="form-group mt-4">
                                    <label for="password">PASSWORD</label>
                                    <input class="form-control <?php echo error('password') != false ? 'is-invalid' : '' ?>" type="password" id="password" name="password" placeholder="Enter Password">
                                    <?php echo error('password') != false  ? "<small class='error invalid-feedback' >" . error('password') . "</small>" : '' ?>
                              </div>
                              <div class="form-group text-center mt-4 w-100">
                                    <button class="btn btn-register text-white mr-0 mr-md-2 mb-2 mr-md-0 w-100 d-block" type="submit"><i class="fas fa-user-plus fa-fw"></i> Sing Up</button>
                              </div>
                        </form>
                        <!-- end form-->
                  </div>
            </div>
      </div>
</div>