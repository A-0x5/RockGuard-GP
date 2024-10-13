<?php

require_once 'app/model/Auth.php';
require_once 'app/controller/FeedbackController.php';
require_once 'app/model/Session.php';

use RockGuard\app\controller\FeedbackController;
use RockGuard\app\model\Auth;
use RockGuard\app\model\Session;

use function RockGuard\include\function\error;
use function RockGuard\include\function\old;
use function RockGuard\include\function\success;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    FeedbackController::store();
}

?>
<!-- Start with image -->
<div class="container">
    <div class="wrapper feedback">

        <!-- if not login -->
        <div class="not-login <?php echo success() ? 'd-none' : (Auth::check() ? 'd-none' : 'd-block') ?>">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-white">We would love to hear your feedback</h1>
                    <div class="col-12 text-center">
                        <button class="btn text-white">Please sign in to continue!</button>
                    </div>
                    <div class="col-12 text-center">
                        <a class="btn btn-dark text-white mr-0" href="sign-in.php">Click here</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- already login -->
        <div class="already-login <?php echo success() ? 'd-none' : (Auth::check() ? 'd-block' : 'd-none') ?>">
            <h2 class="text-white">Please share your feedback with us concerning a website you consider to be unsafe</h2>
            <form class="form-feedback" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="left <?php echo !empty(error('url')) || !empty(error('result')) ? 'red-border' : '' ?> ">
                            <div class="input-group">
                                <input class="form-control" type="search" placeholder="Put Your Link Here .." aria-label="Put Your Link Here !" aria-describedby="basic-addon2" name="url" value="<?php echo old('url') ?>">
                                <?php echo !empty(error('url')) ? "<small class='error invalid-feedback d-block'>" . 'The URL is invalid, please try again!' . "</small>" : '' ?>
                            </div>
                            <p class="text-white">This website requested access to:</p>
                            <div class="check-box">
                                <div class="mb-3 mt-1">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="results[]" value="Types and bad grammar">
                                    <label class="form-check-label text-white" for="exampleCheck1">Types and bad grammar</label>
                                </div>
                                <div class="mb-3 mt-1">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck2" name="results[]" value="No content information">
                                    <label class="form-check-label text-white" for="exampleCheck2">No content information</label>
                                </div>
                                <div class="mb-3 mt-1">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck3" name="results[]"value="Urgent language">
                                    <label class="form-check-label text-white" for="exampleCheck3">Urgent language</label>
                                </div>
                                <div class="mb-3 mt-1">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck4" name="results[]" value="Mimicking a legitimate website">
                                    <label class="form-check-label text-white" for="exampleCheck4">Mimicking a legitimate website</label>
                                </div>
                                <div class="mb-3 mt-1">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck5" name="results[]" value="Request for sensitive information">
                                    <label class="form-check-label text-white" for="exampleCheck5">Request for sensitive information</label>
                                </div>
                                <div class="mt-1">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck6" name="results[]" value="Nothing suspicious">
                                    <label class="form-check-label text-white" for="exampleCheck6">Nothing suspicious</label>
                                </div>
                                <?php echo !empty(error('result')) ? "<small class='error invalid-feedback d-block'>" . error('result') . "</small>" : '' ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="right">
                            <p class="d-block text-white">Additional</p>
                            <div class="input-group">
                                <textarea class="form-control d-block" name="additional" id="floatingTextarea2" rows="4" placeholder="Write some additional!"><?php echo old('additional'); ?></textarea>
                            </div>
                            <p class="d-block text-white mt-4">Do you think it's safe?</p>
                            <div class="save-box">
                                <div class="custom-control p-0">
                                    <input class="custom-input" type="radio" name="is_save" id="yes" value="TRUE">
                                    <label class="text-white custom-label" for="yes">YES</label>
                                    <input class="custom-input" type="radio" name="is_save" id="no" value="FALSE">
                                    <label class="text-white custom-label" for="no">NO</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-2 mb-4">
                        <button type="submit" class="btn btn-send text-white mt-3 w-100 d-block">SEND</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- success flash message -->
        <div class="success-flash <?php echo success() ? 'd-flex' : 'd-none' ?>">
            <div class="message">
                <div class="row">
                    <div class="col-12">
                        <p class="text-white text-center">Thank You <?php echo Auth::user()['name'] ?>!</p>
                        <p class="text-white text-center">Your feedback has been successfully submitted</p>
                        <p class="text-white text-center mt-5">We would love to hear your thoughts</p>
                        <ul class="">
                            <li class="mr-1 text-white">
                                <a href="mailto:rockguardtool@outlook.com" class="text-white">
                                    <svg class="svg-inline--fa fa-google fa-w-16 fa-fw" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="google" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512" data-fa-i2svg="">
                                        <path fill="currentColor" d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"></path>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
