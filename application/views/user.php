<?php require_once('layouts/header.php');  ?>
  <div class="machine-con" id="content-wrapper">         
    <div class="card0 mb-3">
      <div class="card-header primary-color">
        <i class="fas fa-users"></i>User List<div class="add-align"></div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Srn.</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Logged In</th>
                <th>Subscription</th>
                <th>Status </th>
              </tr>
            </thead>                  
              <tbody>
                <?php $i=1; foreach($userList as $users) { ?>
                  <tr id="<?php echo $users['id']; ?>">
                    <td><?= $i;?></td>
                    <td> <img class="user-img custimg text-center" src="<?php echo $users['profile_image']; ?>"/></td>
                    <td><?php echo $users['user_name']; ?></td>
                    <td><?php echo $users['email']; ?></td>
                    <td><?php echo $users['login_type']; ?></td>
                    <td>Silver</td>
                    <td><input type="checkbox" class="statusToggle" <?php if($users['status'] == 1) { ?> checked <?php } ?> data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger"></td>
                  </tr>
                <?php $i++; } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content-wrapper -->
</div>
<?php require_once('layouts/footer.php');  ?>
<script type="text/javascript">
  $('.statusToggle').change(function(){
    var mode= $(this).prop('checked');
    var trid = $(this).closest('tr').attr('id');   
    $.ajax({
      type:'POST',
      dataType:'JSON',
      url:'user/statusUpdate',
      data:{"mode": mode, "trid": trid},
      success:function(data) {
      }
    });
  });


  $(document).ready(function() {
  $('#dataTable1').DataTable({
    "columnDefs": [{
      "targets": [1,6],
      "orderable": false
    }]
  });
});

</script>