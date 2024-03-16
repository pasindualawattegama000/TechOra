<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body, html {
            /* height: 100%;
            margin: 0; */
            /* font-family: Arial, sans-serif; */
            background-color: #F5F5F5;
            /* display: flex;
            justify-content: center;
            align-items: center; */
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
</head>
<body>
    <div class="register-box">
        <h2 class="heading"> Login </h2>

            <!-- Status message -->
        <?php  
            if(!empty($success_msg)){ 
                echo '<p class="status-msg success">'.$success_msg.'</p>'; 
            }elseif(!empty($error_msg)){ 
                echo '<p class="status-msg error">'.$error_msg.'</p>'; 
            } 
        ?>

        <form action="/register" method="post">
            <div class="form-field">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="" required>
            </div>
            <div class="form-field">
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="" required>
            </div>
            <div class="form-field">
                <input type="submit" value="Login">
            </div>
        </form>
    </div>
</body>
</html>
