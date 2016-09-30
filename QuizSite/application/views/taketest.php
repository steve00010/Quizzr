<link href="http://<?=base_url()?>assets/css/taketest.css" rel="stylesheet">
<div class="container taketest">
  <!-- Example row of columns -->
	<div class="row">
		<div class="col-md-12">
			<h2><?=$testdata[0];?></h2>
			<?php if($view) { ?>
			<span style="display:none" id="uniqid"><?=$user['uniqid'];?></span>
			<span style="display:none" id="testid"><?=$user['testid'];?></span>
			<h2> Viewing <?=$user['name'];?>'s results</h2>
			<?php } ?>
			<hr>
			<h5>Author: <?=$testdata[1];?></h5>
		</div>
	</div>
	<?php foreach ($testdata[3] as $key => $question) { ?>

	<div class="row">
		<div class="col-md-12">
			<h3><?=$question['title'];?></h3>
			<br>
			<?php foreach ($question['aArray'] as $key2 => $qtitle) { ?>
			<div id="resultbox<?php echo $key.'-'.$key2 ?>">
				<input id="testinput<?php echo $key.';'.$key2 ?>" class="radio-custom" name="radio-group<?php echo $key;?>" type="radio">
            	<label for="testinput<?php echo $key.';'.$key2 ?>" class="radio-custom-label"><?=$qtitle;?></label>
            	</div>
            	<br>
			<?php } ?>
			<hr>
		</div>
	</div>
	<?php } ?>
	<div class="row">
		<div class="col-md-12">
			<h2 id="resulttext">Finished? <br> Get your results:</h2>
			<span id="finishtest" class="btn btn-success">Finish</span>	
			<br>
		</div>
	</div>
</div>