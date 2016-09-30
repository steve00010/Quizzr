<div class="main">
  <h1 class="page-header">Dashboard</h1>

  <div class="row placeholders">
    <div class="col-xs-6 col-sm-3 placeholder">
      <h4>Tests Created</h4>
      <span ><?php echo $totaltests; ?></span>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder">
      <h4>Total Users</h4>
      <span><?php echo $totalusers; ?></span>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder">
      <h4>Tests Taken</h4>
      <span><?php echo $teststaken; ?></span>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder">
      <h4>Average Test Length</h4>
      <span><?php echo $testavg; ?> questions</span>
    </div>
  </div>
<div class="row">
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapseOne">User sign up history - click to collapse</a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div class="panel-body">
          <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapseTwo">Test creation history - click to collapse</a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse in">
                <div class="panel-body">
          <div id="chartContainer1" style="height: 300px; "></div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <h2 class="sub-header"><a href="admin/users" >Users <br>(Latest 10)</a></h2>
  <table class="table table-striped table-hover ">
  <thead>
  <tr>
    <th>#</th>
    <th>Username</th>
    <th>Email</th>
    <th>Admin</th>
    <th>Admin link</th>
    
  </tr>
  </thead>
  <tbody>
  <?php $i = 1;
  if ($user) {
      foreach ($user as $row) {
          ?>
  <tr>
    <td> <?=$i;
          ?> </td>
    <td> <?=$this->SessionModel->echoName($row['username']);
          ?> </td>
    <td> <?=$this->SessionModel->echoName($row['email']);
          ?> </td>
    <td> <?php if($row['admin'] == 0) {
          ?><span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:#c0392b;"></i>
          <?php } else { ?> <span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:#27ae60;"></span>
          <?php } ?> </td>
    <td> <a href="http://<?=base_url().'admin/viewuser/'.$row['uniqid'];
          ?>">Link</a> </td>
  </tr>

  <?php
    ++$i;
      }
  } ?>
  </tbody>
  </table>
  <h2 class="sub-header"><a href="admin/tests" >Tests <br>(Latest 10)</a></h2>
  <table class="table table-striped table-hover ">
    <thead>
  <tr>
    <th>#</th>
    <th>Test Name</th>
    <th># of Questions</th>
    <th>Author</th>
    <th>Status</th>
    <th>Admin View</th>
    <th>Test link</th>
  </tr>
</thead>
<tbody>
  <?php $i = 1;
  if ($test) {
      foreach ($test as $row) {
          ?>
  <tr>
    <td> <?=11-$i;
          ?> </td>
    <td> <?=$row['Name'];
          ?> </td>
    <td> <?=$row['noQ'];
          ?> </td>
    <td> <?=$this->SessionModel->echoName($row['CreatorName']);
          ?> </td>
    <td>
      <?php switch($row['status']) {
        case 0: echo 'Public'; break;
        case 1: echo 'Private'; break;
        case 2: echo 'Passworded'; break;
      } ?>
    </td>
    <td> <a href="http://<?=base_url().'test/admintest/'.$row['uniqid'];
          ?>">Link</a> </td>
    <td> <a href="http://<?=base_url().'test/taketest/'.$row['uniqid'];
            ?>">Link</a> </td>
  </tr>

<?php
    ++$i;
      }
  } ?>
  </tbody>
</table>

</div>
</div>
</div>
<script src="http://canvasjs.com/assets/script/canvasjs.min.js"></script>

