
<div class="main">
    <h2>View Users</h2>
    <hr>
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
</div>
</div>
</div>
