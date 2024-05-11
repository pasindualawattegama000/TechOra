<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body, html {
            background-color: #F5F5F5;
        }

        .register-box {
      
            width: 350px;
            margin: auto;
            margin-top:5%;
            padding:20px;

            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .heading{
            text-align:center;
        }

        .form-field {
            margin-bottom: 15px;
        }

        .form-field input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-field input[type="submit"] {
            background-color: #4681f4;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-field input[type="submit"]:hover {
            background-color: #45a049;
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
            <p>Already have an account? <a href="<?php echo site_url('Users/loadLogin'); ?>">Login here</a></p>
        </form>
        
    </div>


    
    <script>
    var PersonModel = Backbone.Model.extend({
        defaults: {
            firstname: '',
            lastname: '',
            email: '',
            password: ''
        }
    });

    var PersonView = Backbone.View.extend({
        el: "#registerForm",
        events: {
            'submit': 'savePerson'
        },

        initialize: function(){
            this.model = new PersonModel();
        },

        savePerson: function(event){
            event.preventDefault();
            var firstname = this.$('#first_name').val();
            var lastname = this.$('#last_name').val();
            var email = this.$('#email').val();
            var password = this.$('#password').val();

            this.model.set({firstname: firstname, lastname: lastname, email: email, password: password});

            // Send data to the server
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
                    }, 6000); // Hide message after 6 seconds
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

    var personView = new PersonView();
</script>

</body>
</html>
