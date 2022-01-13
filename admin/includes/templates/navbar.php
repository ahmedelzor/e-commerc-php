

<nav class="navbar navbar-expand-lg navbar-light " style="background:linear-gradient(to right, rgba(119, 103, 82, 0.3)70%,rgba(104, 91, 91, 0.3));font-size: 16px;">
  <a class="navbar-brand" href="./dashboard.php"><img src="./logo 1.png" style="width:100px;" alt=""></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-navbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="app-navbar">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="./dashboard.php"><?php echo lang('Home_Admin') ?> <span class="sr-only">Toggle navigation</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./Categories.php"><?php echo lang('Categories')?></a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="./items.php"><?php echo lang('Component')?></a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="./members.php"><?php echo lang('Organs')?></a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="./comments.php"><?php echo lang('COMMENTS')?></a>
        </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
    <li class="navbar nav-item dropdown">
        <a style="color:darkred;" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
        
        <?php echo $_SESSION['Username'] ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="./members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>"><?php echo lang('EDIT')?> </a>
          <a class="dropdown-item" href="../index.php"><?php echo lang('VISIT_SHOP')?></a>
          <a class="dropdown-item" href="./logout.php"> <?php echo lang('LOGOUE')?></a>
        </div>
      </li>
    </form>
  </div>
</nav>