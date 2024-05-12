<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>TechOra</title>
    <style>

    ul {
        display: flex;
        justify-content: space-between; 
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #333;
    }

    .nav-left, .nav-center, .nav-right {
        display: flex;
        align-items: center; 
    }

    .nav-right{
      padding-right: 2%;
    }

    .nav-center {
        flex-grow: 1; 
        justify-content: center; 
    }

    li a,h4, li form {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    li form input[type="text"], li form input[type="submit"] {
        padding: 0;
        background: #fff;
        border: 1px solid #ccc;
        color: black;
        border-radius: 20px;
    }

    li form input[type="text"] {
      padding: 0px 0px 0px 20px;
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
    border-bottom: 2px solid white; 
}
  
.nav-item.active {
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
            <li class="nav-item <?= (current_url() == site_url('navigation/loadPostQuestions')) ? 'active' : '' ?>"> <a href="<?php echo site_url('navigation/loadPostQuestions'); ?>">Ask Question</a></li>
            <li class="nav-item <?= (current_url() == site_url('navigation/loadProfile')) ? 'active' : '' ?>"> <a href="<?php echo site_url('navigation/loadProfile'); ?>">Profile</a></li>
      <?php endif; ?>
   
    </div>
    <div class="nav-center">
      <li class="nav-item <?= (current_url() == site_url('search/Questions')) ? 'active' : '' ?>">
        <form method="get" action="<?php echo site_url('search/Questions'); ?>">
          <input type="text" name="search" placeholder="Search For Questions">
          <input type="submit" value="Search">
        </form>
      </li>
    </div>
    <div class="nav-right">

        <?php if($this->session->userdata('isUserLoggedIn')): ?>
            <li><a href="<?php echo site_url('navigation/loadProfile'); ?>"><?php echo $this->session->userdata('userName'); ?></a></li>
            <li> <a href="<?php echo site_url('navigation/logout'); ?>">Logout</a></li>
            
        <?php else: ?>
          <li class="nav-item <?= (current_url() == site_url('navigation/loadLogin')) ? 'active' : '' ?>"><a href="<?php echo site_url('navigation/loadLogin'); ?>">Login</a></li>
          <li class="nav-item <?= (current_url() == site_url('navigation/loadRegister')) ? 'active' : '' ?>"><a href="<?php echo site_url('navigation/loadRegister'); ?>">Signup</a></li>
        <?php endif; ?>

    </div>
</ul>

</body>
</html>
