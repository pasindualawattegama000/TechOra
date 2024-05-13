<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Question</title>


    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/postQuestionsStyle.css'); ?>">

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