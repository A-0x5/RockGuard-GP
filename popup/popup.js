var toggleSwitch = document.getElementById('toggleSwitch');
<<<<<<< HEAD
var isEnabled = true; // Default state: extension is enabled

// Function to update extension state in local storage
function updateExtensionState(state) {
    chrome.storage.local.set({ extensionEnabled: state });
}

// Retrieve the extension state from local storage when the page loads
chrome.storage.local.get('extensionEnabled', function(data) {
    if (data.extensionEnabled === false) {
        toggleSwitch.style.backgroundColor = '#FF0000'; // Red: extension is disabled
        isEnabled = false;
    } else {
        toggleSwitch.style.backgroundColor = '#00FF00'; // Green: extension is enabled
        isEnabled = true;
    }
});

// Handle toggle button click
document.getElementById('toggleBtn').addEventListener('click', function () {
    if (isEnabled) {
        toggleSwitch.style.backgroundColor = '#FF0000'; // Change to red when disabled
        isEnabled = false;
        updateExtensionState(false); // Store the disabled state
        chrome.runtime.sendMessage({ action: 'disableExtension' }); // Send a message to disable the extension
    } else {
        toggleSwitch.style.backgroundColor = '#00FF00'; // Change to green when enabled
        isEnabled = true;
        updateExtensionState(true); // Store the enabled state
        chrome.runtime.sendMessage({ action: 'enableExtension' }); // Send a message to enable the extension
    }
});


=======

document.getElementById('toggleBtn').addEventListener('click', function () {
    if (toggleSwitch.style.backgroundColor === 'rgb(0, 255, 0)') {
        toggleSwitch.style.backgroundColor = '#FF0000'; // Red color
        // Add code to disable your extension here
    } else {
        toggleSwitch.style.backgroundColor = '#00FF00'; // Green color
        // Add code to enable your extension here
    }
});

// Set initial state to enabled
toggleSwitch.style.backgroundColor = '#00FF00'; // Green color
>>>>>>> 300775e1ee3ed157559b3ef46805858649dece24
