<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>


    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/loginStyles.css'); ?>">

    <!-- Including jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Including Underscore.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
    <!-- Including Backbone.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>


</head>
<body>
    <div class="register-box">
        <h2 class="heading"> Login </h2>

         <!-- Status message -->
        <div id="message" style="display: none; color: green;">Successfully Registered User!</div>

        <form id="loginForm">
            <div class="form-field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="" required>
            </div>
            <div class="form-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="" required>
            </div>
            <div class="form-field">
                <input type="submit" value="Login">
            </div>
            <p>Don't have an account? <a href="<?php echo site_url('Navigation/loadRegister'); ?>">Register Now</a></p>
        </form>
    </div>


<script>
    // Define a Backbone model for person data.
    var UserModel = Backbone.Model.extend({
        defaults: {
            email: '',
            password: ''
        }
    });

    // Define a Backbone view for handling the login form.
    var PersonView = Backbone.View.extend({
        el: "#loginForm", // DOM element to bind the view.
        events: {
            'submit': 'savePerson' 
        },

        initialize: function() {
            this.model = new UserModel(); 
        },

        savePerson: function(event) {
            event.preventDefault(); 

            var email = this.$('#email').val();
            var password = this.$('#password').val();

           
            this.model.set({email: email, password: password});

            // AJAX call to send data to the server and handle responses.
            $.ajax({
                url: 'http://localhost/TechOra/index.php/api/Users/login',
                type: 'POST',
                data: this.model.toJSON(), // Convert model data to JSON for sending.

                // Handle successful request.
                success: function(response) {
                    console.log('Request successful');
                    $('#message').text(response.message).css('color', 'green').show();
                    window.location.href = 'http://localhost/TechOra/index.php/home';

       
                    setTimeout(function() {
                        $('#message').hide();
                    }, 10000); 
                },

                // Handle errors during the request.
                error: function(xhr, status, error) {
                    var message = '';
                    var color = '';

                    if (error === 'Unauthorized') {
                        message = 'Invalid Email or Password';
                        color = 'red';
                    } else {
                        message = 'Validation Errors';
                        color = 'black';
                    }

                    $('#message').text('Login failed: ' + message).css('color', color).show();
                }
            });
        },
    });

    // Instantiate the view.
    var personView = new PersonView();

</script>


</body>
</html>
