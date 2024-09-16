// Extract all links from the Search Engine Results Page (SERP)
const links = document.querySelectorAll('a');

// Store URLs that need to be scanned
const urlsToScan = [];

// Filter only the links that are relevant search results
links.forEach(link => {
    const url = link.href;

    // Exclude non-result URLs, like internal Google links
    if (url.startsWith('https://') && !url.includes('google.com')) {
        urlsToScan.push(url);
    }
});

// Send URLs to the background for scanning via VirusTotal and the database
chrome.runtime.sendMessage({ action: 'scanURLs', urls: urlsToScan });

// Receive scan results from the background script
chrome.runtime.onMessage.addListener((message, sender, sendResponse) => {
    const { url, result, error } = message;

    // Find the corresponding link and update the interface
    const link = Array.from(document.querySelectorAll('a')).find(a => a.href === url);

    if (link) {
        let icon = link.parentElement.querySelector('span.result-icon');
        if (!icon) {
            icon = document.createElement('span');
            icon.className = 'result-icon';
            icon.style.marginLeft = '5px';
            link.parentElement.appendChild(icon);
        }

        // Handle scan results and display appropriate icon
        if (result === 'error') {
            icon.textContent = '⚠️'; // Show error icon
            icon.title = `Error: ${error}`;
        } else {
            icon.textContent = result === 'clean' ? '✅' : result === 'malicious' ? '❌' : '❓';
            icon.title = `RockGuard scan result: ${result}`;

            // If the result is 'unknown', create the tooltip on hover
            if (result === 'unknown') {
                const tooltip = document.createElement('div');
                tooltip.className = 'tooltip';
                tooltip.innerHTML = `
                    <strong>RockGuard</strong><br>
                    <span style="color: rgb(200 102 249);">UNKNOWN</span><br>
                    Be Careful!<br>
                    Please visit our website to provide us with your feedback:<br>
                    <a href="http://localhost/RockGuard/feedback.php" target="_blank">http://localhost/RockGuard/feedback.php</a>
                `;

                // Ensure tooltip is clickable
                tooltip.style.pointerEvents = 'auto'; // Allow clicking inside the tooltip

                // Append the tooltip to the body, not inside the parent element
                document.body.appendChild(tooltip);

                // Position the tooltip when hovering over the icon
                let timeout;
                icon.addEventListener('mouseenter', () => {
                    const rect = icon.getBoundingClientRect();  // Get position of icon
                    tooltip.style.position = 'absolute';
                    tooltip.style.top = `${rect.top + window.scrollY + 30}px`; // Place below icon
                    tooltip.style.left = `${rect.left + window.scrollX - tooltip.offsetWidth - 10}px`; // Place on the left side of the icon
                    tooltip.style.display = 'block';
                    tooltip.style.opacity = '1'; // Show tooltip
                });

                // Add a delay before hiding the tooltip
                icon.addEventListener('mouseleave', () => {
                    timeout = setTimeout(() => {
                        tooltip.style.display = 'none';
                        tooltip.style.opacity = '0'; // Hide tooltip smoothly
                    }, 300); // 300ms delay to allow moving the mouse to the tooltip
                });

                // Keep the tooltip visible when interacting with it
                tooltip.addEventListener('mouseenter', () => {
                    clearTimeout(timeout); // Prevent tooltip from hiding while interacting
                    tooltip.style.display = 'block';
                    tooltip.style.opacity = '1'; // Keep it visible
                });

                tooltip.addEventListener('mouseleave', () => {
                    timeout = setTimeout(() => {
                        tooltip.style.display = 'none';
                        tooltip.style.opacity = '0'; // Hide tooltip after interaction
                    }, 300);
                });
            }
        }
    }
});









