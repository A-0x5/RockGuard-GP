      <?php require_once "app\model\Auth.php";

      use RockGuard\app\model\Auth; ?>

      <!-- start navbar-->
      <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                  <!-- <a class="navbar-brand fw-500" href="index.html">Netflix<span class="text-primary">ify</span></a> -->

                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav-link navbar-nav mt-md-1">
                              <li class="nav-item  mb-2 text-white"><a href="index.php" class="<?php echo $_SERVER['PHP_SELF'] == '/index.php' ? 'active' : ''; ?>"><i class="fas fa-home fa-fw"></i> Home</a></li>
                              <li class="nav-item mb-2  text-white"><a href="about-us.php" class="<?php echo $_SERVER['PHP_SELF'] == '/about-us.php' ? 'active' : ''; ?>"><i class="fas fa-book fa-fw"></i> About Us</a></li>
                              <li class="nav-item   mb-2 text-white"><a href="security_checker.php" class="<?php echo $_SERVER['PHP_SELF'] == '/security_checker.php' ? 'active' : ''; ?>"><i class="fas fa-exclamation-triangle fa-fw"></i> Security Checker</a></li>
                              <li class="nav-item  mb-2  text-white"><a href="feedback.php" class="<?php echo $_SERVER['PHP_SELF'] == '/feedback.php' ? 'active' : ''; ?>"><i class="fas fa-bullhorn fa-fw"></i> User Feedback</a></li>
                        </ul>
                  </div>
                  <?php
                  if (Auth::check()) {
                  ?>
                        <!-- User profile -->
                        <ul class="profile-dropdown">
                              <li class="nav-item dropdown">
                                    <a class="profile-image" data-toggle="dropdown" href="#" aria-expanded="false">
                                          <img style="border-radius: 30px;" src="<?php echo Auth::user()['image'] != null ? Auth::user()['image'] : 'images/robot02_90810.png' ?>" alt="user image" width="50px">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left" style="left: inherit;right: 0px;">
                                          <span class="dropdown-item dropdown-header text-center"><?php echo Auth::user()['name']; ?></span>
                                          <span class="dropdown-item text-center"><?php echo Auth::user()['email']; ?></span>
                                          <div class="dropdown-divider mt-4 mb-4"></div>
                                          <div class="dropdown-item-hover mt-3">
                                                <a href="activity.php" class="dropdown-item <?php echo $_SERVER['PHP_SELF'] == '/activity.php' ? 'active-h' : ''; ?>"><i class="fas fa-save fa-fw"></i> My Activity</a>
                                                <a href="edit-profile.php" class="dropdown-item mt-3 <?php echo $_SERVER['PHP_SELF'] == '/edit-profile.php' ? 'active-h' : ''; ?>"><i class="fas fa-user-edit fa-fw"></i> Edit Profile</a>
                                                <form method="POST" action="index.php">
                                                      <button type="submit" class='dropdown-item mb-2 mt-3' style="cursor:pointer"><i class="fas fa-sign-out-alt fa-fw"></i> Sign Out</button>
                                                </form>
                                          </div>
                                    </div>
                              </li>
                        </ul>
                  <?php } else {
                  ?>
                        <!-- Login & Register -->
                        <ul class="navbar-nav ml-auto mt-md-1 nav-auth">
                              <li class="nav-item ml-3"><a class="btn btn-dark text-white mr-0 mr-md-2 mb-2 mr-md-0 btn-login" href="sign-in.php"><i class="fas fa-sign-in-alt fa-fw"></i> Sign in </a></li>
                              <li class="nav-item"><a class="btn text-white btn-register" href="sign-up.php"><i class="fas fa-user-plus fa-fw"></i> Sign up </a></li>
                        </ul>
                  <?php } ?>
                  
            </div>
      </nav>