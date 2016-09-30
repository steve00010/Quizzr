<div class="jumbotron">
  <div class="container text-center">
    <h1>Welcome to Quizzr<i class="fa fa-bolt"></i>!</h1>
    <br>
    <p>Create a test. Send to your students. Get results.</p>
    <p>Easy.</p>
    <?php if($auth['LOGGED_IN']) {
              ?>
    <p><a class="btn btn-primary btn-lg" href="#" role="button" style="border-radius: 24px;">Get Started Now &raquo;</a></p>
    <?php } else { ?>
    <p><a class="btn btn-primary btn-lg" data-toggle="modal" data-target="#LoginModal" role="button" style="border-radius: 24px;">Get Started Now &raquo;</a></p>
    <?php } ?>
  </div>
</div>

<div class="container mainhome">
  <!-- Example row of columns -->
  <div class="row">
    <div class="col-md-5 col-md-offset-1" >
      <h2>Easy to take</h2>
      <p> <img src="http://<?=base_url()?>assets/img/head1.jpg" width=400px/ style="box-shadow: 5px 5px 5px #000000;"> </p>
      <br>
      <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
    </div>
    <div class="col-md-5 col-md-offset-1">
      <h2>Perfect for teachers and students</h2>
      <p><img src="http://<?=base_url()?>assets/img/head2.jpg" width=400px height=200px style="box-shadow: 5px 5px 5px #000000;"/> </p>
      <br>
      <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
    </div>

  </div>




</div>
<!-- /container -->
