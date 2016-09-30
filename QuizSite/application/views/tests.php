<br>
<br>
<br>
<div class="container">
<div class="main">
<div class="jumbotron">
  <h1>Test homepage</h1>
  <p>Here you can view public tests and take them by linking on their link! <br>
  View the tests you've created and your past results on your profile.
  </p>

  <p><?php if($this->SessionModel->checkLogged()) {
    ?>You can also create your own test by clicking here: <br><?php
  $this->load->view("newtest");
}?></p>
</div>

<h2>Public Tests</h2>
    <hr>
    <table class="table table-striped table-hover ">
      <thead>
    <tr>
      <th>Test Name</th>
      <th># of Questions</th>
      <th>Author</th>
      <th>Test link</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 1;
    
        foreach ($testl as $row) {
            ?>
    <tr>
      <td> <?=$row['Name'];
            ?> </td>
      <td> <?=$row['noQ'];
            ?> </td>
      <td> <?=$this->SessionModel->echoName($row['CreatorName']);
            ?> </td>
      <td> <a href="http://<?=base_url().'test/taketest/'.$row['uniqid'];
            ?>">Link</a> </td>
    </tr>

  <?php
      ++$i;
        }
     ?>
    </tbody>
</table>
</div>
</div>
