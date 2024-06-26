<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/signupStyles.css'); ?>">

    <!-- Including jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Including Underscore.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
    <!-- Including Backbone.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>

</head>


<body>
    <div class="register-box">
        <h2 class="heading"> Register </h2>

        <!-- Status message -->
        
        <div id="message" style="display: none; color: green;">Successfully Registered User!</div>

        <form id = "registerForm">
            <div class="form-field">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" placeholder="" required>
            </div>

            <div class="form-field">
                <label for="last_name">Surname</label>
                <input type="text" id="last_name" name="last_name" placeholder=""  required>
            </div>

            <div class="form-field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder=""  required>
            </div>

            <div class="form-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="" required>
            </div>


            <div class="form-field">
                <input type="submit" name="signupSubmit" value="Register">
            </div>
            <p>Already have an account? <a href="<?php echo site_url('Navigation/loadLogin'); ?>">Login here</a></p>
        </form>
        
    </div>


    
<script>
    // Define a Backbone model for person data.
    var UserModel = Backbone.Model.extend({
        defaults: {
            firstname: '',
            lastname: '',
            email: '',
            password: ''
        }
    });

    // Define a Backbone view for handling the login form.
    var PersonView = Backbone.View.extend({
        el: "#registerForm",
        events: {
            'submit': 'savePerson'
        },

        initialize: function(){
            this.model = new UserModel();
        },

        savePerson: function(event){
            event.preventDefault();
            var firstname = this.$('#first_name').val();
            var lastname = this.$('#last_name').val();
            var email = this.$('#email').val();
            var password = this.$('#password').val();

            this.model.set({firstname: firstname, lastname: lastname, email: email, password: password});


            // AJAX call to send data to the server and handle responses.
            $.ajax({
                url: 'http://localhost/TechOra/index.php/api/Users/registration',
                type: 'POST',
                data: this.model.toJSON(),

                success: function(response) {
                    console.log('Data saved successfully');
                    console.log('Condition:', response.message);

                    var color = 'green';
                    $('#message').text(response.message).css('color', color).show();


                    setTimeout(function() {
                        $('#message').hide();
                    }, 6000); // Hide after 6 seconds
                },

                error: function(xhr, status, error) {


                    var message = '';
                    var color = '';

                    if (error === 'Bad Request') {
                        message = 'Username Already exists';
                        color = 'red';
                
                    } else {
                        // Default message if condition is neither A nor B
                        message = 'Failed to register user.';
                        color = 'black';
                    }
                
                $('#message').text('Registration failed: ' + message).css('color', 'red').show();
            }
            });
        },

      
    });

    // Instantiate the view.
    var personView = new PersonView();
</script>

</body>
</html>
