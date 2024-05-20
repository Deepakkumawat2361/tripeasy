<label for="custom-datetime">Select a date and time:</label>
<input type="text" id="custom-datetime" name="custom-datetime">
<script>
// Get a reference to the input field
var customDateTimeInput = document.getElementById('custom-datetime');

// Initialize a datepicker when the page is loaded
window.addEventListener('load', function() {
    initializeDateTimePicker();
});

// Function to initialize the datetime picker
function initializeDateTimePicker() {
    // Use a third-party library or build your own datetime picker
    
    // Here's a simple example using the JavaScript built-in Date object
    customDateTimeInput.addEventListener('focus', function() {
        var currentDate = new Date();
        var year = currentDate.getFullYear();
        var month = String(currentDate.getMonth() + 1).padStart(2, '0'); // January is 0
        var day = String(currentDate.getDate()).padStart(2, '0');
        var hours = String(currentDate.getHours()).padStart(2, '0');
        var minutes = String(currentDate.getMinutes()).padStart(2, '0');
        
        // Populate the input field with the current date and time
        customDateTimeInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
    });
}

</script>