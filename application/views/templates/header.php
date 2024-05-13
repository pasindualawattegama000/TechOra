<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>TechOra</title>


<!-- Link to external CSS file -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/headerStyles.css'); ?>">


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
