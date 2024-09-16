// API Key for VirusTotal
const API_KEY = '16476e088d461e487a2a930e6366eed3a4df29c311d06e81a9ae1db0aed0415b'; 

// URL for the local API that checks the database
const API_DB_URL = 'http://localhost/rockguard/api.php'; 

// Listen for messages from other parts of the extension
chrome.runtime.onMessage.addListener((message, sender, sendResponse) => {
    // Handle the disable extension action
    if (message.action === 'disableExtension') {
        chrome.storage.local.set({ extensionEnabled: false }); // Update the extension state to disabled
        console.log('Extension disabled');
    } 
    // Handle the enable extension action
    else if (message.action === 'enableExtension') {
        chrome.storage.local.set({ extensionEnabled: true }); // Update the extension state to enabled
        console.log('Extension enabled');
    } 
    // Handle the scan URLs action
    else if (message.action === 'scanURLs') {
        // Check if the extension is enabled before proceeding
        chrome.storage.local.get('extensionEnabled', function(data) {
            if (!data.extensionEnabled) {
                console.log('Extension is disabled. Ignoring scanURLs request.'); // Log a message if the extension is disabled
                return; // Do not proceed with URL scanning
            }

            const urls = message.urls; // Get the URLs from the message
            console.log('Received URLs to scan:', urls);
            checkURLs(urls, sender.tab.id); // Start URL scanning
        });
    }
});

// Function to check URLs by querying the database and VirusTotal
async function checkURLs(urls, tabId) {
    let failedUrls = new Set(); // Store URLs that failed the check

    for (let i = 0; i < urls.length; i++) {
        const url = urls[i];

        try {
            // Check the database for the URL
            const dbResponse = await fetch(`${API_DB_URL}?url=${encodeURIComponent(url)}`);
            const dbData = await dbResponse.json();

            if (dbData.label !== null) {
                // If the result is found in the database
                const result = dbData.label === 1 ? 'clean' : 'malicious';
                console.log(`Found result in database for ${url}: ${result}`);
                chrome.tabs.sendMessage(tabId, { url, result }); // Send the result to the content script
                continue; // Skip to the next URL
            }

            // If the result is not in the database, check VirusTotal
            const apiUrl = `https://www.virustotal.com/vtapi/v2/url/report?apikey=${API_KEY}&resource=${encodeURIComponent(url)}`;
            console.log('Requesting URL from VirusTotal:', apiUrl);

            const response = await fetch(apiUrl, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`Failed to fetch: ${response.status} ${response.statusText}`); // Handle fetch errors
            }

            const text = await response.text();
            console.log('Response text from VirusTotal:', text);

            if (text.trim() === '') {
                throw new Error('Empty response body'); // Handle empty responses
            }

            let data;
            try {
                data = JSON.parse(text); // Parse the response text
            } catch (e) {
                throw new Error('Failed to parse JSON: ' + e.message); // Handle JSON parsing errors
            }

            let result = 'unknown'; // Default result
            if (data.response_code === 1) {
                result = data.positives > 0 ? 'malicious' : 'clean'; // Determine if the URL is malicious or clean
            }

            // Clear previous errors for this URL
            if (failedUrls.has(url)) {
                console.log(`Clearing previous error for ${url}`);
                failedUrls.delete(url);
            }

            console.log(`Sending result for ${url}: ${result}`);
            chrome.tabs.sendMessage(tabId, { url, result }); // Send the result to the content script

        } catch (error) {
            console.error('Error fetching VirusTotal API or database:', error.message);

            // Send error message to the content script
            chrome.tabs.sendMessage(tabId, { url, result: 'error', error: error.message });

            // Add the URL to the set of failed URLs and retry
            failedUrls.add(url);
            console.log('Retrying...');

            // Retry the URL after waiting 5 seconds
            await sleep(5000);
            i--; // Retry the same URL
        }

        await sleep(1500); // Wait before processing the next URL
    }
}

// Function to sleep for a given number of milliseconds
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
























