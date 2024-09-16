<?php


require_once 'app\controller\FeedbackController.php';

use RockGuard\app\controller\FeedbackController;

use function RockGuard\include\function\error;
use function RockGuard\include\function\old;



// check if isset id and not empty
if (!isset($_GET['id']) or empty($_GET['id'])) {
      header('location: index.php');
      die();
}

// get the feedback data
$feedback = FeedbackController::find($_GET['id']);

$feedback ? '' : header('location: index.php');
$feedback_results = explode(',', $feedback['results']);


// when make some edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      FeedbackController::update($feedback['id']);
} //-- end of function

?>
<!-- Start with image -->
<div class="container">
      <div class="wrapper feedback">
            <!-- already login -->
            <div class="already-login">
                  <h2 class="text-white">Please share your feedback with us concerning a website you consider to be unsafe</h2>
                  <form class="form-feedback" method="POST">
                        <div class="row">
                              <div class="col-md-6">
                                    <div class="left <?php echo !empty(error('url')) || !empty(error('result')) ? 'red-border' : '' ?> ">
                                          <div class="input-group">
                                                <input class="form-control" type="search" placeholder="Put Your Link Here .." aria-label="Put Your Link Here !" aria-describedby="basic-addon2" name="url" value="<?php echo old('url', $feedback['url']) ?>">
                                                <?php echo !empty(error('url'))  ? "<small class='error invalid-feedback d-block' >" . 'The url is invalid, please try again!' . "</small>" : '' ?>
                                          </div>
                                          <p class="text-white">This website requested access to :</p>
                                          <div class="check-box">
                                                <div class="mb-3 mt-1">
                                                      <input type="checkbox" class="form-check-input" <?php echo in_array('Types and bad grammar', $feedback_results) ? 'checked' : '' ?> id="exampleCheck1" name="results[]" value="Types and bad grammar">
                                                      <label class="form-check-label text-white" for="exampleCheck1">Types and bad grammar</label>
                                                </div>
                                                <div class="mb-3 mt-1">
                                                      <input type="checkbox" class="form-check-input" <?php echo in_array('No content information', $feedback_results) ? 'checked' : '' ?> id="exampleCheck2" name="results[]" value="No content information">
                                                      <label class="form-check-label text-white" for="exampleCheck2">No content information</label>
                                                </div>
                                                <div class="mb-3 mt-1">
                                                      <input type="checkbox" class="form-check-input" <?php echo in_array('Urgent language', $feedback_results) ? 'checked' : '' ?> id="exampleCheck3" name="results[]" value="Urgent language">
                                                      <label class="form-check-label text-white" for="exampleCheck3">Urgent language</label>
                                                </div>
                                                <div class="mb-3 mt-1">
                                                      <input type="checkbox" class="form-check-input" <?php echo in_array('Mimicking a legitimate website', $feedback_results) ? 'checked' : '' ?> id="exampleCheck4" name="results[]" value="Mimicking a legitimate website">
                                                      <label class="form-check-label text-white" for="exampleCheck4">Mimicking a legitimate website</label>
                                                </div>
                                                <div class="mt-1">
                                                      <input type="checkbox" class="form-check-input" <?php echo in_array('Request for sensitive information', $feedback_results) ? 'checked' : '' ?> id="exampleCheck5" name="results[]" value="Request for sensitive information">
                                                      <label class="form-check-label text-white" for="exampleCheck5">Request for sensitive information</label>
                                                </div>
                                                <?php echo !empty(error('result'))  ? "<small class='error invalid-feedback d-block' >" . error('result') . "</small>" : '' ?>
                                          </div>
                                    </div>
                              </div>
                              <div class="col-md-6">
                                    <div class="right">
                                          <p class="d-block text-white">Additional</p>
                                          <div class="input-group">
                                                <textarea class="form-control d-block" name="additional" id="floatingTextarea2" rows="4" placeholder="Write some additional !"><?php echo old('additional', $feedback['additional']); ?></textarea>
                                          </div>
                                          <p class="d-block text-white mt-4">Do you think its safe ?</p>
                                          <div class="save-box">
                                                <div class="custom-control p-0">
                                                      <input class="custom-input" <?php echo $feedback['is_save'] == 'TRUE' ? 'checked' : '' ?> type="radio" name="is_save" id="yes" value="TRUE">
                                                      <label class="text-white custom-label" for="yes">YES</label>
                                                      <input class="custom-input" <?php echo $feedback['is_save'] == 'FALSE' ? 'checked' : '' ?> type="radio" name="is_save" id="no" value="FALSE">
                                                      <label class="text-white custom-label" for="no">NO</label>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                        <div class="row">
                              <div class="col-12 mt-2 mb-4">
                                    <button type="submit" class="btn btn-send text-white mt-3 w-100 d-block" type="submit">UPDATE</button>
                              </div>
                        </div>
                  </form>
            </div>

      </div>
</div>