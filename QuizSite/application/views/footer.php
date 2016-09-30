
</div>

<?php

if(!isset($nofooter)) {
  ?>
<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-6 copyright">Quizzr
        <br />2016 © All Rights Reserved.</div>
      <div class="col-md-6 text-right">
        <a href="#" class="social fa fa-facebook"></a>
        <a href="#" class="social fa fa-twitter"></a>
        <a href="#" class="social fa fa-google-plus"></a>
      </div>
    </div>
  </div>
</footer>
<?php
}
?>
  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://<?=base_url()?>assets/js/bootstrap.min.js"></script>
  <script src="http://<?=base_url()?>assets/js/contact.js"></script>

  <?php 
    if(isset($customScript)){
      foreach ($customScript as $key => $value) {
        echo '<script src="http://'.base_url().'assets/js/'.$value.'"></script>';
      }
    }
    if (isset($customJS)) {
      echo $customJS;

    } 
    ?>
</body>

</html>
