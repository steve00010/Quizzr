<link href="http://<?=base_url()?>assets/css/settings.css" rel="stylesheet">
<div class="container">
  <!-- Example row of columns -->
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?=$auth['Username'];?> - Settings</h3>
        </div>
        <div class="panel-body">
        <h4>Change your password:</h4>
        <div id="changepword">
        <form>
        	Current Password:<br>
  			<input type="password" name="currpword" id="currpword" required><br>
  			New Password:<br>
  			<input type="password" name="newpword1" id="newpword1" required><br>
  			New Password (Repeat):<br>
  			<input type="password" name="newpword2" id="newpword2" required><br><br>
  			<button class="btn btn-primary" id="pwordsubmit">Submit</button><br><br>
  			</form>
  			<div id="pwordfeedback" style="display:none">
  				<div id="alertdiv1" class="alert alert-dismissible alert-danger">
				  <button type="button" class="close" data-dismiss="alert">&times;</button>
				  <div class="textmsg"></div>
				</div>
  			</div>
        </div>
        <hr>
        <h4>Change your email:</h4>
        	New Email: <br>
          	<input type="text" name="newemail" id="newemail"><br><br>
  			<button class="btn btn-primary" id="emailsubmit">Submit</button>
  			<div id="emailfeedback" style="display:none">
  				  <div id="alertdiv2" class="alert alert-dismissible alert-danger">
				  <button type="button" class="close" data-dismiss="alert">&times;</button>
				  <div class="textmsg"></div>
				</div>
  			</div>
        <hr>
        <h4>Change profile status:</h4>
        	<input type="radio" name="status" value="prv" checked> Public<br>
        	<input type="radio" name="status" value="pub"> Private<br><br>
			<button class="btn btn-primary" id="statusubmit">Submit</button>
			<div id="statusfeedback" style="display:none">
            <div id="alertdiv2" class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <div class="textmsg"></div>
        </div>
        <hr>
        </div>
       </div>
       </div>
       </div>
       </div>