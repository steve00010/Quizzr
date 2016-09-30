<link href="http://<?=base_url()?>assets/css/settings.css" rel="stylesheet">

<div class="container">
  <!-- Example row of columns -->
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?=$auth['Username'];?> - Profile</h3>
        </div>
        <div class="panel-body">
          <h4>Your Details</h4>
          <p>Email: <?=$email;?></p>
          <p>Status: <?php 
                switch($status) {
            case 1: echo '<span style="color:#27ae60;">Public</span>'; break;
            case 0: echo '<span style="color:#c0392b;">Private</span>'; break;
          } ?>

          </p>
          <a href="http://<?=base_url()?>user/settings">Change your settings</a>
          <hr>
          <h3>Your previous results</h3>
          <table class="table table-striped table-hover ">
          <thead>
            <tr>
              <th>#</th>
              <th>Test Name</th>
              <th>Date </th>
              <th>Score %</th>
              <th>Test link</th>
            </tr>
          </thead>
          <tbody>
           <?php
           foreach($oldtests as $t){
            ?>
            <tr>
              <td>
              <?=$t[0]+1;?>
              </td>
              <td>
              <?=$t[1];?>
              </td>
              <td>
              <?php
              echo date("M j Y",$t[5]);  
              ?>
              </td>
              <td>
              <?=$t[2];?>
              </td>
              <td>
               <a href="http://<?=base_url().'test/taketest/'.$t[4];
                    ?>">Link</a>
              
              </td>
            <?php
           }
           ?>
            </tbody>
        </table>
        </div>
          <hr>
          <div class="panel-body">
          <h3>Tests you've created</h3>
          <table class="table table-striped table-hover ">
          <thead>
            <tr>
              <th>#</th>
              <th>Test Name</th>
              <th>Number of Questions</th>
              <th>Times taken</th>
              <th>Test Link</th>
              <th>Test Admin</th>


            </tr>
          </thead>
          <tbody>
           <?php
           foreach($createdtests as $k=>$t){
            ?>
            <tr>
              <td>
              <?=$k+1;?>
              </td>
              <td>
              <?=$t[1];?>
              </td>
              <td>
              <?=$t[2];?>
              </td>
              <td>
              <?=$t[3];?>
              </td>
              <td>
               <a href="http://<?=base_url().'test/taketest/'.$t[4];
                    ?>">Link</a>
              
              </td>
              <td>
               <a href="http://<?=base_url().'test/admintest/'.$t[4];
                    ?>">Link</a>
              
              </td>
            <?php
           }
           ?>
            </tbody>
        </table>
          </div>

      </div>
    </div>
  </div>



</div>
<!-- /container -->
