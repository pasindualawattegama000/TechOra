<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>


body {
    /* font-family: Arial, sans-serif; */
    background-color: #f4f4f4;
    /* margin: 20px;
    padding: 0; */
}

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
    margin-bottom: 30px; 
}

.form-group label {
    display: block;
    margin-bottom: 5px; 
    font-size: 16px;
    font-weight: bold; 
}


.form-group input[type="text"],
.form-group textarea {
    width: 100%;
    padding: 10px;
    margin-top: 0; 
    display: block; 
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 16px;
}

.form-group input[type="file"] {
    border: none;
    margin-top: 8px;
}

.button-group button,
.button-group input[type="submit"] {
    width: calc(50% - 4px); 
    padding: 10px;
    margin: 8px 1%; 
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    display: inline-block; 
    box-sizing: border-box;
}

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


#message {
    padding: 10px;
    margin-top: 10px;
    border-radius: 5px;
    display: none;
}

#message.success {
    color: green;
    border: 2px solid green; 
    background-color: #f0fff0; 
}


#message.error {
    color: red;
    border: 2px solid red; 
    background-color: #fff0f0; /
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

    <div id="message" style="display: none; color: green;">Successfully Registered User!</div>

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
            event.preventDefault(); 

            var formData = new FormData(this.el); // Serialize form data

            // Send AJAX request to the RESTful backend endpoint
            $.ajax({
                url: 'http://localhost/TechOra/index.php/api/Questions/postQuestion', 
                type: 'POST',
                data: formData,
                processData: false, 
                contentType: false, 
                success: function(response) {
                 
                    var message = response.message;
                    var statusClass = response.status ? 'success' : 'error';

                    $('#message').removeClass('success error').addClass(statusClass).text(message).show();


                    if (response.status) {
                                $('#title').val(''); 
                                $('#body').val(''); 
                                $('#image').val(''); 
                                $('#tags').val(''); 
                             }


                    setTimeout(function() {
                        $('#message').hide();
                        if (response.status) {
                            
                        }
                    }, 6000);
                },


                error: function(xhr, status, error) {
                    // Handle error
                    console.error('Error: ' + error);
                    $('#message').removeClass('success').addClass('error').text('Error Posting Question, Check Image Type..').show();
                    setTimeout(function() {
                        $('#message').hide();
                    }, 6000);
                }
            });
        }
    });

    // Instantiating the form view
    var formView = new FormView();
</script>

</body>
</html>