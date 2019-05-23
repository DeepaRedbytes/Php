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

    <ul class="nav nav-tabs navpd" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link pd_navlink active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Admin</a>
      </li>
      <li class="nav-item">
        <a class="nav-link pd_navlink" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">User</a>
      </li>      
    </ul>

    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>                      
                  <th>Srn.</th>
                  <th>Start Date</th>    
                  <th>Title</th>
                  <th>Category</th>
                  <th>Logo</th> 
                  <!-- <th>Description</th> -->             
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>                  
              <tbody>
                <?php $i=1; foreach($adListAdmin as $adListA) { ?> 
                  <tr id="<?php echo $adListA['id']; ?>">                    
                    <td><?=$i;?></td>  
                    <td><?php echo date("d-m-Y",strtotime($adListA['start_date'])); ?></td> 
                    <td><?php echo $adListA['title'];?></td>
                    <td><?=$adListA['type'];?></td>
                    <td><img class="user-img custimg text-center" src="<?= base_url();?><?php echo $adListA['thumbnail']; ?>"/></td>
                    <!-- <td><?php echo substr($adListA['description'], 0, 30); ?></td> -->
                    <td><input type="checkbox" class="statusToggle" <?php if($adListA['status'] == 1) { ?> checked <?php } ?> data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger"></td>
                    <td>
                      <a href="advertisement/create?id=<?php echo $adListA['id']; ?>"><button type="button" class="btn btn-info tb-btn">Edit</button></a>
                      <button type="button" class="deleteButton btn btn-danger tb-btn">Delete</button>
                    </td>
                  </tr>
                <?php $i++; } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
              <thead>
                <tr>              
                  <th>Srn.</th>
                  <th>User</th>
                  <th>Start Date</th>    
                  <th>Title</th>
                  <th>Category</th>
                  <th>Logo</th> 
                  <th>Description</th>             
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>                  
              <tbody>
                <?php $i=1; foreach($adList as $ad) { ?>
                  <tr id="<?php echo $ad['id']; ?>">                    
                    <td><?=$i;?></td>         
                    <td><?php echo $ad['user_name'];?></td>       
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
              </tbody>
            </table>
          </div>
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

$('#profile-tab').click(function(){
  $('.add-align').show();
});
$('#home-tab').click(function(){
  $('.add-align').hide();
});
 
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

$(document).ready(function() {
  $('#dataTable1').DataTable({
    "columnDefs": [{
      "targets": [5,8,7],
      "orderable": false
    }]
  });
});

</script>
