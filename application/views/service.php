<?php require_once('layouts/header.php'); ?>
<div class="machine-con" id="content-wrapper">
  <div class="card0 mb-3">
    <div class="card-header primary-color">
      <i class="fas fa-users"></i>
      Service List
      <span class="flastMessage" style="margin-left: 25%;"><?php echo $this->session->flashdata('service');?></span>
      <div class="add-align">
        <a href="<?= base_url()?>index.php/service/create"> <button type="submit" class="signupbtn custome-button"><span class="normal-class">Add Service</span><span class="normal-icon"><i class="fas fa-check"></i></span></button></a>
      </div>
    </div>
    <ul class="nav nav-tabs navpd" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link pd_navlink active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Admin</a>
      </li>
      <li class="nav-item">
        <a class="nav-link pd_navlink" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">User</a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Srn.</th>
                  <th>Service Name</th>
                  <th>Category</th>
                  <th>Price</th>
                  <th>Logo</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
                 
              <tbody>
                <?php $i=1; foreach($servicesAdmin as $serviceA) { ?>                
                  <tr id="<?php echo $serviceA['_id']; ?>">
                    <td><?= $i;?></td>
                    <td><?= $serviceA['name'];?></td>
                    <td><?= $serviceA['category_name'];?></td>
                    <td><?php if($serviceA['price'] != 0){echo $serviceA['price'];}?></td>
                    <td> 
                      <?php if(isset($serviceA['thumbnail'])){ ?>
                        <img class="user-img custimg text-center" src="<?php echo base_url().'/'.$serviceA['thumbnail'];?>"/>
                      <?php }?>
                    </td>                    
                    <td><input type="checkbox" class="statusToggle" <?php if($serviceA['status'] == 1) { ?> checked <?php } ?> data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger"></td>
                    <td>
                      <a href="service/create?id=<?php echo $serviceA['id']; ?>"><button type="button" class="btn btn-info tb-btn">Edit</button></a>
                      <button type="button" class="deleteButton btn btn-danger tb-btn">Delete</button>
                    </td>
                  </tr>
                <?php $i++; } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>


      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Srn.</th>
                  <th>User</th>
                  <th>Service Name</th>
                  <th>Category</th>
                  <th>Logo</th>
                  <th>Price</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>                          
              <tbody>
                <?php $i=1; foreach($services as $service) { ?>                
                  <tr id="<?php echo $service['_id']; ?>">
                    <td><?= $i;?></td>
                    <td><?= $service['user_name'];?></td>
                    <td><?= $service['name'];?></td>
                    <td><?= $service['category_name'];?></td>
                    <td> 
                      <?php if(isset($service['thumbnail'])){ ?>
                        <img class="user-img custimg text-center" src="<?php echo base_url().'/'.$service['thumbnail'];?>"/>
                      <?php }?>
                    </td>
                    <td><?php if($service['price'] != 0){echo $service['price'];}?></td>
                    <td><input type="checkbox" class="statusToggle" <?php if($service['status'] == 1) { ?> checked <?php } ?> data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger"></td>
                    <td>
                      <a href="service/create?id=<?php echo $service['id']; ?>"><button type="button" class="btn btn-info tb-btn">Edit</button></a>
                      <button type="button" class="deleteButton btn btn-danger tb-btn">Delete</button>
                    </td>
                  </tr>
                <?php $i++; } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>  
  </div>
</div>
</div>
</div>
   

<?php require_once('layouts/footer.php'); ?>
<script type="text/javascript">
  $('.statusToggle').change(function(){
    var mode= $(this).prop('checked');
    var trid = $(this).closest('tr').attr('id');   
    $.ajax({
      type:'POST',
      dataType:'JSON',
      url:'service/statusUpdate',
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

 
$('#profile-tab').click(function(){
  $('.add-align').hide();
});
$('#home-tab').click(function(){
  $('.add-align').show();
});

$('.deleteButton').click(function(){
  var answer = confirm('Are you sure you want to delete this service?');
  if (answer) {
    var mode= $(this).prop('checked');
    var trid = $(this).closest('tr').attr('id'); 
    $.ajax({
      type:'POST',
      dataType:'JSON',
      url:'service/deleteEntry',
      data:{"mode": mode, "trid": trid},
      success:function(data){
        location.reload();
      }
    });
  }
});
$(document).ready(function() {
  $('#dataTable1').DataTable({
    "columnDefs": [{
      "targets": [4,6,7],
      "orderable": false
    }]
  });
});
</script>