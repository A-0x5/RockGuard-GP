<?php

namespace RockGuard\app\controller;

require_once 'app/model/Feedback.php';
require_once 'app/model/Session.php';
require_once 'app/model/Auth.php';

use Exception;
use RockGuard\app\model\Auth;
use RockGuard\app\model\Feedback;
use RockGuard\app\model\Session;

use function RockGuard\include\function\error;
use function RockGuard\include\function\success;

class FeedbackController
{
    /**
     * Function to scan a URL with VirusTotal API
     * 
     * @param string $url
     * @return int 0 for unsafe, 1 for safe
     */
    public static function scanUrlWithVirusTotal($url)
    {
        $apiKey = '16476e088d461e487a2a930e6366eed3a4df29c311d06e81a9ae1db0aed0415b'; //  API key 

        // API endpoint to scan the URL
        $apiUrl = "https://www.virustotal.com/vtapi/v2/url/report?apikey={$apiKey}&resource=" . urlencode($url);

        // Initialize cURL request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode the JSON response from VirusTotal
        $result = json_decode($response, true);

        // Check if there are positives (malicious) results in the scan
        if (isset($result['positives']) && $result['positives'] > 0) {
            return 0; // Unsafe
        }

        return 1; // Safe
    }

    /**
     * Store feedback and scan the URL with VirusTotal
     *
     * @return void
     */
    public static function store()
    {
        try {
            // Validate the input data
            if (!self::validate_store()) {
                return;
            }

            // Scan the URL with VirusTotal API
            $url = $_POST['url'];
            $scan_result = self::scanUrlWithVirusTotal($url); // 0 = unsafe, 1 = safe

            // Store feedback in the database
            $is_save = isset($_POST['is_save']) && !empty($_POST['is_save']) ? $_POST['is_save'] : null;
            $result = implode(',', $_POST['results']);
            Feedback::create($url, $result, $is_save, $_POST['additional'], Auth::user()['id']);

            // Store the URL scan result in the 'urls' table
            self::storeUrlResult($url, $scan_result);

            // Flash success message to the session
            Session::flash(['success' => 'Successfully added']);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /**
     * Validate the store data
     *
     * @return mixed
     */
    public static function validate_store()
    {
        // Get the input data
        $url = $_POST['url'];
        $results = isset($_POST['results']) && !empty($_POST['results']) ? $_POST['results'] : null;

        $errors = [];

        // Validate URL format
        if (!str_starts_with($url, 'http')) {
            $errors['url'] = 'The URL is invalid, please try again!';
        }

        // Ensure results are provided
        if (!$results) {
            $errors['result'] = 'Please choose at least one result!';
        }

        // Return any validation errors
        return !empty($errors) ? Session::flash($errors) : true;
    }

    /**
     * Store the URL scan result in the 'urls' table
     *
     * @param string $url
     * @param int $scan_result 0 for unsafe, 1 for safe
     * @return void
     */
    public static function storeUrlResult($url, $scan_result)
    {
        try {
            // Connect to the database and insert the URL and its status
            $db = self::getDatabaseConnection();
            $stmt = $db->prepare("INSERT INTO urls (url, label) VALUES (:url, :label)");
            $stmt->bindParam(':url', $url);
            $stmt->bindParam(':label', $scan_result);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Database error: ' . $e->getMessage();
        }
    }

    /**
     * Get a PDO database connection
     *
     * @return PDO
     */
    private static function getDatabaseConnection()
    {
        $host = 'localhost';
        $db = 'rock_guard';
        $user = 'root';
        $pass = '';

        try {
            return new \PDO("mysql:host={$host};dbname={$db}", $user, $pass);
        } catch (Exception $e) {
            echo 'Database connection error: ' . $e->getMessage();
            exit;
        }
    }

    /**
     * Update feedback and re-scan the URL with VirusTotal
     *
     * @param int $id
     * @return void
     */
    public static function update($id)
    {
        try {
            // Validate the input data
            if (!self::validate_store()) {
                return;
            }

            // Re-scan the URL with VirusTotal API
            $url = $_POST['url'];
            $scan_result = self::scanUrlWithVirusTotal($url); // 0 = unsafe, 1 = safe

            // Update the feedback in the database
            $is_save = isset($_POST['is_save']) && !empty($_POST['is_save']) ? $_POST['is_save'] : null;
            $result = implode(',', $_POST['results']);
            Feedback::update($url, $result, $is_save, $_POST['additional'], $id, Auth::user()['id']);

            // Update the URL scan result in the 'urls' table
            self::updateUrlResult($id, $url, $scan_result);

            // Redirect after successful update
            header('location: edit_feedback.php?id=' . $id);
            die();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Update the URL scan result in the 'urls' table
     *
     * @param int $id
     * @param string $url
     * @param int $scan_result 0 for unsafe, 1 for safe
     * @return void
     */
    public static function updateUrlResult($id, $url, $scan_result)
    {
        try {
            // Connect to the database and update the URL status
            $db = self::getDatabaseConnection();
            $stmt = $db->prepare("UPDATE urls SET url = :url, label = :label WHERE id = :id");
            $stmt->bindParam(':url', $url);
            $stmt->bindParam(':label', $scan_result);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Database error: ' . $e->getMessage();
        }
    }

    /**
     * Get all feedback for the current user
     *
     * @return mixed
     */
    public static function all()
    {
        try {
            return Feedback::all(Auth::user()['id']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Find a specific feedback by ID
     *
     * @param int $id
     * @return mixed
     */
    public static function find($id)
    {
        try {
            return Feedback::find($id);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}








