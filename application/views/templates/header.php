<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Free Movies</title>
    <style>
    /* Updated styles */
    ul {
        display: flex;
        justify-content: space-between; /* Aligns items on the main-axis */
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #333;
    }

    .nav-left, .nav-center, .nav-right {
        display: flex;
        align-items: center; /* Aligns items on the cross-axis */
    }

    .nav-right{
      padding-right: 2%;
    }

    .nav-center {
        flex-grow: 1; /* Allows the center section to grow */
        justify-content: center; /* Centers items in the middle */
    }

    li a, li form {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    /* Adjusted styles for input elements */
    li form input[type="text"], li form input[type="submit"] {
        padding: 0;
        background: #fff;
        border: 1px solid #ccc;
        color: black;
        border-radius: 20px;
    }

    li form input[type="text"] {
      padding: 0px 0px 0px 20px; /* Increased left padding */
        width: 400px;
    }

    li form input[type="submit"] {
        padding: 0px 10px;
    }

    li a:hover {
        background-color: #111;
    }

        /* Make TechOra bold and bigger */
        .nav-left > li:first-child a {
        font-weight: bold; /* Makes the text bold */
        font-size: 20px; /* Adjusts the size. Feel free to change this value */
    }
    </style>
</head>
<body>

<ul>
    <div class="nav-left">
      <li><a class="active" href="<?php echo site_url('home/index'); ?>">TechOra</a></li>
      <li><a href="<?php echo site_url('home/index'); ?>">Home</a></li>
      <li><a href="<?php echo site_url('questions/create'); ?>">Ask Question</a></li>
      <li><a href="<?php echo site_url('users/profile'); ?>">Profile</a></li>
    </div>
    <div class="nav-center">
      <li>
        <form method="get" action="<?php echo site_url('questions/searchQuestions'); ?>">
          <input type="text" name="search" placeholder="Search For Questions">
          <input type="submit" value="Search">
        </form>
      </li>
    </div>
    <div class="nav-right">

      <li><a href="<?php echo site_url('auth/login'); ?>">Login</a></li>
      <li><a href="<?php echo site_url('auth/register'); ?>">Signup</a></li>
    </div>
</ul>

</body>
</html>
