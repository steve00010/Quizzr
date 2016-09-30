    
<div class="main">
    <h1 class="page-header">Create Tests</h1>
    <!-- Trigger the modal with a button -->

    <!-- Modal -->
    <?php $this->load->view("newtest"); ?>
    <br />
    <h2>View Tests</h2>
    <hr>
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
      <td> <?=$i;
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
