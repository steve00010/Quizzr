
<link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
<br>
<br>
<div class="container">

	<div class="row">
		<div class="col-md-12">
			<h2><?=ucfirst($testdata['testname']);?> - <a href="<?php echo 'http://'.base_url().'test/taketest/'.$testdata['testcode'];?>">Take test</a></h2>
			<span style="display: none" id="testcode"><?=$testdata['testcode'];?></span>
      <?php $this->load->view("edittest"); ?>
      <br>
      <p>Status:
      <?php
      echo (($testdata['status'] == 0) ? 'Public' : 'Private');
      ?></p>
		</div>
	</div>
	  <div class="row">
	  <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapseOne">Scores over time - click to collapse</a>
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
                    <a data-toggle="collapse" href="#collapseTwo">Answer breakdown - click to collapse</a>
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
	<hr>
	<div class="row placeholders">
    <div class="col-xs-6 col-sm-3 placeholder">
      <h4>Times Taken</h4>
      <span ><?php echo $testtakers['total'];?></span>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder">
      <h4>Average Score</h4>
      <span><?php echo $testtakers['ascore'];?></span>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder">
      <h4>Highest Score (%)</h4>
      <span><?php echo $testtakers['highlow'][1];?></span>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder">
      <h4>Lowest Score (%)</h4>
      <span><?php echo $testtakers['highlow'][0];?></span>
    </div>
  </div>
  <hr>
	<div>
	<h2>Test results</h2>
	<table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>User</th>
              <th>Date</th>
              <th>Score %</th>
              <th>Test View</th>
            </tr>
          </thead>
          <tbody>
	<?php 	foreach($testtakers['tarray'] as $k=>$user){ ?>
	<tr>
		<td><?=$k+1;?></td>
		<td><?=$user['user']?></td>
		<td>              <?php
              echo date("M j Y",$user['date']);  
              ?></td>
		<td><?=$user['score']?></td>
		<td><a href="http://<?=base_url();?>test/usertestview/<?=$testdata['testcode'];?>/<?=$user['uniqid']?>">Link</a></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
	</div>
</div>
<script src="http://canvasjs.com/assets/script/canvasjs.min.js"></script>
