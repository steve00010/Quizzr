<link href="http://<?=base_url()?>assets/css/settings.css" rel="stylesheet">

<div class="container">
  <!-- Example row of columns -->
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><span id="usernamestorage"><?=ucfirst($user['Username']);?></span> - Profile</h3>
        </div>
        <div class="panel-body">
          <h4>User Details</h4>
          <p>Email: <?=$user['email'];?></p>
          <p>Status: <?php 
                switch($user['status']) {
            case 1: echo '<span style="color:#27ae60;">Public</span>'; break;
            case 0: echo '<span style="color:#c0392b;">Private</span>'; break;
          } ?>

          </p>

         <h4> Change users password:</h4>
        <div id="changepword">
        <form>
        New Password:<br>
        <input type="password" name="newpword1" id="newpword1" required><br>
        New Password (Repeat):<br>
        <input type="password" name="newpword2" id="newpword2" required><br><br>
        <button class="btn btn-primary" type="button" id="pwordsubmit">Submit</button><br>
        </form>
        <div id="pwordfeedback" style="display:none">
          <div id="alertdiv1" class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <div class="textmsg"></div>
        </div>
        </div>
        </div>
        <hr>
        <h4>Change user email:</h4>
          New Email: <br>
            <input type="text" name="newemail" id="newemail"><br><br>
        <button class="btn btn-primary" id="emailsubmit">Submit</button>
        <div id="emailfeedback"  style="display:none">
            <div id="alertdiv2" class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <div class="textmsg"></div>
        </div>
        </div>
        <hr>
        <h4>Change profile status:</h4>
          <input type="radio" id="radio_pub" name="status" value="prv" <?php if ($user['status'] == 1) { echo "checked";} ?>> Public<br>
          <input type="radio" id="radio_prv" name="status" value="pub" <?php if ($user['status'] == 0) { echo "checked";} ?>> Private<br><br>
      <button class="btn btn-primary" id="statussubmit">Submit</button><br><br>
            <div id="statusfeedback"  style="display:none">
        <div id="alertdiv3" class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <div class="textmsg"></div>
        </div>
      </div>
      <hr>
      <h4>Delete Account</h4>

      <button class="btn btn-danger" id="deletesubmit">Delete</button> <br><br>
                  <div id="deletefeedback"  style="display:none">
        <div id="alertdiv4" class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <div class="textmsg"></div>
        </div>
      </div>
      <div id="statusfeedback"></div>
          <hr>
          <h3>Users previous results</h3>
          <table class="table table-striped table-hover ">
          <thead>
            <tr>
              <th>#</th>
              <th>Test Name</th>
              <th>Score %</th>
              <th>Test link</th>
            </tr>
          </thead>
          <tbody>
           <?php
           foreach($user['oldtests'] as $t){
            ?>
            <tr>
              <td>
              <?=$t[0]+1;?>
              </td>
              <td>
              <?=$t[1];?>
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
          <h3>Tests created</h3>
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
           foreach($user['createdtests'] as $k=>$t){
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
</div>

</div>

