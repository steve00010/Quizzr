<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../../favicon.ico">

  <title>
    <?php 
    if(isset($title)) {
      echo $title;
    }else {
      echo 'Quizzr';
    }

    ?>
  </title>

  <!-- Bootstrap core CSS -->
  <link href="http://<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="http://<?=base_url()?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template -->
  <link href="http://<?=base_url()?>assets/css/bstheme.css" rel="stylesheet">
</head>

<body>

  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="http://<?=base_url()?>">Quizzr <i class="fa fa-bolt"></i></a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
          <li id="HomeLink"><a href="http://<?=base_url()?>">Home</a></li>
          <li id="AboutLink"><a href="http://<?=base_url()?>test/show">Tests</a></li>
          <li id="AboutLink"><a href="http://<?=base_url()?>index/about">About</a></li>
          <?php if($auth['LOGGED_IN']) {
                if($auth['Admin']) {
              ?>
            <li id="AdminLink"><a href="http://<?=base_url()?>admin"><i class="fa fa-code-fork"></i> Admin</a></li>
            <?php } ?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> <?=$auth['Username'];?> <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="http://<?=base_url()?>user/profile"><i class="fa fa-home"></i> Profile</a></li>
                  <li><a href="http://<?=base_url()?>user/settings"><i class="fa fa-cog"></i> Settings</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="http://<?=base_url()?>auth/logout"><i class="fa fa-sign-out"></i> Logout</a></li>
                </ul>
              </li>
              <?php } else { ?>
                <li><a href="#" data-toggle="modal" data-target="#LoginModal" id="ShowReg"><i class="fa fa-users"></i> Login</a></li>
                <?php } ?>
        </ul>
      </div>
      <!--/.nav-collapse -->
    </div>
  </nav>
  <div id="LoginModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content loginmodalcontent">
        <div class="modal-header loginmodalheader">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Login or Register</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="uname" id="unamelabel">Username</label>
                <input type="text" placeholder="Username" id="uname" name="uname" class="form-control">
              </div>
              <div class="form-group">
                <label for="pword" id="pwordlabel">Password</label>
                <input type="password" placeholder="Password" id="pword" name="pword" class="form-control">
              </div>
              <span id="SigninBut" class="btn btn-success btn-block">Login</span>
              <br>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="uname1" id="uname1label">Username</label>
                <input type="text" placeholder="Username" id="uname1" name="uname1" class="form-control">
              </div>
              <div class="form-group">  
                <label for="email1" id="email1label">Email</label>
                <input type="email" placeholder="Email" id="email1" name="email1" class="form-control">
              </div>
              <div class="form-group">
                <label for="pword1" id="pword1label">Password</label>
                <input type="password" placeholder="Password" id="pword1" name="pword1" class="form-control">
              </div>
                <span id="RegBut" class="btn btn-primary btn-block">Register</span>
              </div>
            </div>
            </div>
            
        <div class="modal-footer loginmodalheader">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Main jumbotron for a primary marketing message or call to action -->
<div class="wrapper">