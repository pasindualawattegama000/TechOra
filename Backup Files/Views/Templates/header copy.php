<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Free Movies</title>
    <style>

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

    li a,h4, li form {
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
        background-color: #FFF;
        border-radius:20px;
        color: black;
        text-decoration: none;
    }

    .active-link {
    border-bottom: 2px solid white; /* Adjust thickness as needed */
}
  
.nav-item.active {
  /* background-color: #4CAF50; */
  border-bottom: 2px solid white;
}

    </style>
</head>
<body>


<ul>
    <div class="nav-left">
      <li><h4>TechOra</h4></li>

      <li class="nav-item <?= (current_url() == site_url('home/index')) ? 'active' : '' ?>"> <a href="<?php echo site_url('home/index'); ?>">Home</a></li>

      <?php if($this->session->userdata('isUserLoggedIn')): ?>
            <li class="nav-item <?= (current_url() == site_url('questions/create')) ? 'active' : '' ?>"> <a href="<?php echo site_url('questions/create'); ?>">Ask Question</a></li>
            <li class="nav-item <?= (current_url() == site_url('profile/index')) ? 'active' : '' ?>"> <a href="<?php echo site_url('profile/index'); ?>">Profile</a></li>
           
      <?php endif; ?>
   

    </div>
    <div class="nav-center">
      <li class="nav-item <?= (current_url() == site_url('questions/searchQuestions')) ? 'active' : '' ?>">
        <form method="get" action="<?php echo site_url('questions/searchQuestions'); ?>">
          <input type="text" name="search" placeholder="Search For Questions">
          <input type="submit" value="Search">
        </form>
      </li>
    </div>
    <div class="nav-right">

        <?php if($this->session->userdata('isUserLoggedIn')): ?>
            <li><a href="<?php echo site_url('profile/index'); ?>"><?php echo $this->session->userdata('userName'); ?></a></li>
            <li> <a href="<?php echo site_url('users/logout'); ?>">Logout</a></li>
            
        <?php else: ?>
          <li class="nav-item <?= (current_url() == site_url('users/loadLogin')) ? 'active' : '' ?>"><a href="<?php echo site_url('users/loadLogin'); ?>">Login</a></li>
          <li class="nav-item <?= (current_url() == site_url('users/loadRegister')) ? 'active' : '' ?>"><a href="<?php echo site_url('users/loadRegister'); ?>">Signup</a></li>
        <?php endif; ?>

    </div>
</ul>


</body>
</html>
