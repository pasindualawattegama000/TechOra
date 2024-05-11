<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>

/* General styling */
body {
    /* font-family: Arial, sans-serif; */
    background-color: #f4f4f4;
    /* margin: 20px;
    padding: 0; */
}

/* Styles the form */
#askQuestionForm {
    background-color: #ffffff;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    margin-top: 2%;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.form-group,
.button-group {
    margin-bottom: 15px;
}

.form-group {
    margin-bottom: 30px; /* Increase space between form groups */
}

/* Styles the labels */
.form-group label {
    display: block;
    margin-bottom: 5px; /* Reduced space between label and input */
    font-size: 16px;
    font-weight: bold; /* Optional: makes the label text bold */
}

/* Styles inputs and textarea */
.form-group input[type="text"],
.form-group textarea {
    width: 100%;
    padding: 10px;
    margin-top: 0; /* Removed top margin to bring label closer */
    display: block; /* Ensures input takes a new line after label */
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 16px;
}

/* Styles the file input */
.form-group input[type="file"] {
    border: none;
    margin-top: 8px;
}

/* Styles the buttons */
.button-group button,
.button-group input[type="submit"] {
    width: calc(50% - 4px); /* Adjusted width to account for the 1% margin on either side */
    padding: 10px;
    margin: 8px 1%; /* Keep the margin to maintain spacing */
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    display: inline-block; /* This will place buttons side by side */
    box-sizing: border-box; /* This ensures that padding and border are included in the width */
}

/* Additional CSS to ensure the buttons don't wrap */
.button-group {
    white-space: nowrap;
    overflow: hidden;
}



.button-group button[type="reset"] {
    background-color: #f44336;
    color: white;
}

.button-group input[type="submit"] {
    background-color: #4CAF50;
    color: white;
}

.button-group button[type="reset"]:hover,
.button-group input[type="submit"]:hover {
    opacity: 0.9;
}

    </style>

    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Include Underscore.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
    <!-- Include Backbone.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>

</head>
<body>
    
<form id="askQuestionForm" >
    <div id="message" style="display: none; color: green;">Successfully Registered User!</div>

    <h2>Post A Public Question</h2><br>
    <div class="form-group">
        <label for="title">Title Of The Question</label>
        <input type="text" id ="title" name="title" placeholder="Title" required >
    </div>
    <div class="form-group">
         <label for="body">Body Of The Question</label>
        <textarea name="body" id="body" placeholder="Body" required rows="10"></textarea>
    </div>
    <div class="form-group">
        <label for="image">Image Of The Issue</label>
        <input type="file" id="image" name="image">
    </div>
    <div class="form-group">
        <label for="tags">Tags</label>
        <input type="text" id="tags" name="tags" placeholder="Tags (comma separated)" required>
    </div>
    <div class="button-group">
        <button type="reset">Clear Fields</button>
        <input type="submit" value="Post your question">
    </div>
</form>


<script>
    // Backbone View for the form
    var FormView = Backbone.View.extend({
        el: '#askQuestionForm',
        events: {
            'submit': 'handleSubmit'
        },
        handleSubmit: function(event) {
            event.preventDefault(); // Prevent default form submission

            var formData = new FormData(this.el); // Serialize form data

            // Send AJAX request to backend
            $.ajax({
                // ++++++++++++++++++++++++++++++++++++++++DANGER+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                url: 'http://localhost/TechOra/index.php/Questions/postQuestion', // Replace 'backend.php' with your PHP endpoint
                type: 'POST',
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Set content type to false for FormData
                success: function(response) {
                    // Handle success response
                    // console.log('Fuck yea');
                // Display message based on condition
                var message = '';
                    var color = '';
                    if (response.condition === 'A') {
                        message = 'Successfully Posted The Question';
                        color = 'green';
                    } else if (response.condition === 'B') {
                        message = 'Failed To Post Question... Please Try Again.';
                        color = 'red';
                    } 
                    else if (response.condition === 'D') {
                        message = 'No user logged in';
                        color = 'red';
                    } 
                    else {
                        // Default message if condition is neither A nor B
                        message = 'Image Format Is Not Supported';
                        color = 'red';
                    }

                    $('#message').text(message).css('color', color).show();


                    setTimeout(function() {
                        $('#message').hide();
                    }, 6000); // Hide message after 6 seconds
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error);
                }
            });
        }
    });

    // Instantiate the form view
    var formView = new FormView();

</script>

</body>
</html>