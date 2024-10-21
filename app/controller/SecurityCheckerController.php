<?php
namespace RockGuard\app\controller;

require_once 'app/model/SecurityChecker.php';
require_once 'app/model/Session.php';
require_once 'app/model/Auth.php';

use Exception;
use RockGuard\app\model\Auth;
use RockGuard\app\model\SecurityChecker;
use RockGuard\app\model\Session;

class SecurityCheckerController
{
    /**
     * Scan the URL using the VirusTotal API
     *
     * @param string $url
     * @return int 0 for dangerous, 1 for safe
     */
    public static function scanUrlWithVirusTotal($url)
    {
        $apiKey = ''; // API key

        // API endpoint to scan the URL
        $apiUrl = "https://www.virustotal.com/vtapi/v2/url/report?apikey={$apiKey}&resource=" . urlencode($url);

        // Send the request using cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode the JSON response
        $result = json_decode($response, true);

        // Check for positive results (malicious URLs)
        if (isset($result['positives']) && $result['positives'] > 0) {
            return 0; // Not safe
        }

        return 1; // Safe
    }

    /**
     * Save the security scan result of the URL in the database
     */
    public static function store()
    {
        try {
            if (!Auth::check()) {
                Session::flash(['error' => 'You must be logged in to proceed with the scan.']);
                return;
            }

            if (!self::validate_store()) {
                return;
            }

            // Scan the URL using VirusTotal API
            $url = $_POST['url'];

            // Check if the URL exists in the database
            $existingUrl = SecurityChecker::findByUrl($url);
            if ($existingUrl) {
                // If the URL exists, return the scan result
                return $existingUrl['label']; 
            }

            // If the URL does not exist, use the API
            $scan_result = self::scanUrlWithVirusTotal($url); // 0 = not safe, 1 = safe

            // Save the scan result in the `urls` table
            SecurityChecker::create($url, $scan_result, Auth::user()['id']);
            // You can use flash to confirm the message here
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /**
     * Validate the input data
     *
     * @return bool
     */
    public static function validate_store()
    {
        // Retrieve the data
        $url = $_POST['url'];

        $errors = [];

        // Validate the URL
        if (!str_starts_with($url, 'http')) {
            $errors['url'] = 'Invalid URL, please try again!';
        }

        // Return any validation errors
        return !empty($errors) ? Session::flash($errors) : true;
    }

    /**
     * Update the security scan result
     *
     * @param int $id
     * @return void
     */
    public static function update($id)
    {
        try {
            if (!self::validate_store()) {
                return;
            }

            // Rescan the URL using VirusTotal API
            $url = $_POST['url'];
            $scan_result = self::scanUrlWithVirusTotal($url);

            // Update the security scan result in the `urls` table
            SecurityChecker::update($id, $url, $scan_result, Auth::user()['id']);

            // Redirect the user after success
            header('location: edit_security.php?id=' . $id);
            die();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Retrieve all scan results for the user
     *
     * @return mixed
     */
    public static function all()
    {
        try {
            return SecurityChecker::all(Auth::user()['id']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Find a specific scan result using the ID
     *
     * @param int $id
     * @return mixed
     */
    public static function find($id)
    {
        try {
            return SecurityChecker::find($id);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

