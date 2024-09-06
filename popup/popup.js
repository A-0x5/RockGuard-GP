var toggleSwitch = document.getElementById('toggleSwitch');

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
