<!-- Start with image -->
<div class="container p-0">
    <div class="wrapper security_checker">
        <!-- Start form -->
        <div class="content">
            <!-- Heading -->
            <div class="col-12 mb-5">
                <h1 class="text-white text-center">Start the free security Checker</h1>
            </div>
            <!-- Start form -->
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
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['url'])) {
                $api_key = '16476e088d461e487a2a930e6366eed3a4df29c311d06e81a9ae1db0aed0415b'; // API key
                $url_to_check = $_POST['url'];

                // Set up cURL request
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://www.virustotal.com/vtapi/v2/url/report');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                    'apikey' => $api_key,
                    'resource' => $url_to_check,
                    'scan' => 1 // Request a scan if no previous data is available
                ));

                // Execute the request
                $response = curl_exec($ch);

                // Check if there was an error executing cURL
                if ($response === false) {
                    echo '<div class="alert alert-danger">Error: ' . curl_error($ch) . '</div>';
                    curl_close($ch);
                    exit();
                }

                curl_close($ch);

                // Decode the response to JSON format
                $result = json_decode($response, true);

                // Check if the response is empty or invalid
                if (is_null($result)) {
                    echo '<div class="alert alert-danger">Error: Invalid API response</div>';
                    exit();
                }

                echo '<div class="col-12 col-md-6 m-md-auto">';
                echo '<div class="result">';

                // Check the response_code and ensure the response is valid
                if (isset($result['response_code']) && $result['response_code'] == 1) {
                    if (isset($result['positives']) && $result['positives'] > 0) {
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
                } else {
                    // Unknown link
                    echo '<div class="unknown text-center p-3 d-block" style="flex-direction: column;align-items: center;">';
                    echo '<p>Your URL is:</p>';
                    echo '<p>Unknown</p>';
                    echo '<p class="m-0">Watch out! No data available for this URL.</p>';
                    echo '</div>';
                }

                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>

