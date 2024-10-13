<?php

require_once 'app\model\Auth.php';
require_once 'app\controller\UserController.php';

use RockGuard\app\controller\UserController;
use RockGuard\app\model\Auth;

use function RockGuard\include\function\error;
use function RockGuard\include\function\old;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
     UserController::update();
}
?>

<!-- Start activity -->
<div class="wrapper-profile">
      <div class="container">
            <div class="profile">
                  <!-- image area -->
                  <div class="image-area">
                        <img class="img-fluid" src="images/3_copy.png" alt="logo image">
                  </div>
                  <!-- Profile image -->
                  <div class="profile-form">
                        <h1 class="text-center text-center w-100">Your Profile</h1>
                        <div class="profile-image w-100">
                              <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="profile-image w-100 text-center">
                                          <img class="img-fluid" id='output' src="<?php echo Auth::user()['image'] != null ? Auth::user()['image'] : 'images/robot02_90810.png' ?>" alt="profile image" width="95">
                                          <span style="cursor:pointer" class="text-white d-block" onclick="document.getElementById('image').click()">Change</span>
                                          <?php echo error('image') != false  ? "<small class='error invalid-feedback d-block' >" . error('image') . "</small>" : '' ?>
                                          <input type="file" name="image" id="image" accept="image/*" onchange="loadFile(event)" style="display: none;">
                                    </div>
                                    <div class="form-group mt-4">
                                          <label for="name">NAME</label>
                                          <input class="form-control <?php echo error('name') != false ? 'is-invalid' : '' ?>" type="text" id="name" name="name" placeholder="Enter Name" value="<?php echo old('name', Auth::user()['name']) ?>">
                                          <?php echo error('name') != false  ? "<small class='error invalid-feedback' >" . error('name') . "</small>" : '' ?>
                                    </div>
                                    <div class="form-group mt-4">
                                          <label for="email">EMAIL</label>
                                          <input class="form-control <?php echo error('email') != false ? 'is-invalid' : '' ?>" type="email" id="email" name="email" placeholder="Enter Email" value="<?php echo old('email', Auth::user()['email']) ?>">
                                          <?php echo error('email') != false  ? "<small class='error invalid-feedback' >" . error('email') . "</small>" : '' ?>
                                    </div>
                                    <div class="form-group mt-4">
                                          <label for="password">PASSWORD</label>
                                          <input class="form-control <?php echo error('password') != false ? 'is-invalid' : '' ?>" type="password" id="password" name="password" placeholder="Enter Password" value="<?php echo old('password', Auth::user()['password']) ?>">
                                          <?php echo error('password') != false  ? "<small class='error invalid-feedback' >" . error('password') . "</small>" : '' ?>
                                    </div>
                                    <div class="form-group text-center mt-4 w-100">
                                          <button class="btn btn-register text-white mr-0 mr-md-2 mb-2 mr-md-0 w-100 d-block" type="submit"><i class="fas fa-user-edit fa-fw"></i> Edit Profile</button>
                                    </div>
                              </form>
                        </div>
                  </div>
            </div>
      </div>
</div>