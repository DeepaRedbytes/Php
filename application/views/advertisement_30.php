<?php require_once('layouts/header.php');  ?>
<div class="machine-con" id="content-wrapper">
  <div class="card0 mb-3">
    <div class="card-header primary-color">
      <i class="fas fa-users"></i>Advertisement List
      <span class="flastMessage" style="margin-left: 25%;"><?php echo $this->session->flashdata('advertisement');?></span>
      <div class="add-align">
        <a href="<?= base_url();?>index.php/advertisement/create">  <button type="submit" class="signupbtn custome-button"><span class="normal-class">Create Advertisement</span><span class="normal-icon"><i class="fas fa-check"></i></span></button></a>
      </div>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>              
              <th>Srn.</th>
              <th>Event Start Date</th>    
              <th>Title</th>
              <th>Category</th>
              <th>Logo</th> 
              <th>Description</th>             
              <th>Status</th>
              <th>Action</th>
              </tr>
            </thead>                  
            <tbody>
              <?php $i=1; foreach($adListAdmin as $ad) { ?>
                <tr id="<?php echo $ad['id']; ?>">                    
                  <td><?=$i;?></td>                
                  <td><?php echo date("d-m-Y",strtotime($ad['start_date'])); ?></td>
                  <td><?php echo $ad['title'];?></td>
                  <td><?=$ad['type'];?></td>
                  <td><img class="user-img custimg text-center" src="<?= base_url();?><?php echo $ad['thumbnail']; ?>"/></td>                      
                  
                  <td><?php echo substr($ad['description'], 0, 50); ?></td>
                  <td><input type="checkbox" class="statusToggle" <?php if($ad['status'] == 1) { ?> checked <?php } ?> data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger"></td>
                  <td>
                    <a href="advertisement/create?id=<?php echo $ad['id']; ?>"><button type="button" class="btn btn-info tb-btn">Edit</button></a>
                    <button type="button" class="deleteButton btn btn-danger tb-btn">Delete</button>
                  </td>
                </tr>
              <?php $i++; }  ?>
              <!-- end data -->
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
   
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="login.html">Logout</a>
      </div>
    </div>
  </div>
</div>
<?php require_once('layouts/footer.php');  ?>

<script type="text/javascript">
$('.statusToggle').change(function(e){
  e.preventDefault();
  var mode= $(this).prop('checked');
  var trid = $(this).closest('tr').attr('id');   
  $.ajax({
    type:'POST',
    dataType:'JSON',
    url:'event/statusUpdate',
    data:{"mode": mode, "trid": trid},
    success:function(data) {
    }
  });
});
</script>
<script> 
    setTimeout(function() {
        $('.flastMessage').hide('fast');
    }, 10000);
</script>
<script type="text/javascript">
  $('.deleteButton').click(function(){
    var mode= $(this).prop('checked');
    var trid = $(this).closest('tr').attr('id'); 
    $.ajax({
      type:'POST',
      dataType:'JSON',
      url:'advertisement/deleteEntry',
      data:{"mode": mode, "trid": trid},
      success:function(data){
        location.reload();
      }
    });
  });
</script>
