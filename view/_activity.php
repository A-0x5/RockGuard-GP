<?php
require_once 'app\controller\FeedbackController.php';

use RockGuard\app\controller\FeedbackController; ?>

<?php $feedbacks =  FeedbackController::all(); 
///print_r($feedbacks);
?>

<!-- Start activity -->
<div class="wrapper-activity">
      <div class="container">

            <div class="activity">
                  <!-- image area -->
                  <div class="image-area">
                        <img class="img-fluid" src="images/3_copy.png" alt="">
                  </div>
                  <!-- the result for activity -->
                  <div class="result">
                        <h1 class="text-center">The feedbacks you shared</h1>
                        <!-- if there is no activity -->
                        <div class="no-result text-white <?php echo empty($feedbacks) ? 'd-block' : 'd-none' ?>">
                              <p>You haven't shared anything</p>
                        </div>
                        <!-- if there is result -->
                        <div class="feedback-area <?php echo !empty($feedbacks) ? 'd-block' : 'd-none' ?>">
                              <ul class="unstyle-list">
                                    <?php foreach ($feedbacks as $feedback)
                                    echo '<li class="feedback-link mt-4"><a href="edit_feedback.php?id=' . $feedback['id'] .' "> ' . $feedback['url'] .'</a></li>';
                                    ?>
                              </ul>
                        </div>
                  </div>
            </div>

      </div>
</div>