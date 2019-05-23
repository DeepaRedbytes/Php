<?php require_once('layouts/header.php');  ?>  
<div class="machine-con" id="content-wrapper">
  <div class="card0 mb-3">
    <div class="card-header primary-color">
      <i class="fas fa-users"></i>Event List
      <span class="flastMessage" style="margin-left: 25%;"><?php echo $this->session->flashdata('event');?></span>
      <div class="add-align">
        <a href="<?= base_url();?>index.php/event/create">  <button type="submit" class="signupbtn custome-button"><span class="normal-class">Create Event</span><span class="normal-icon"><i class="fas fa-check"></i></span></button></a>
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
                  <th>Title</th>
                  <th>Start Date</th>
                  <th>Category</th>
                  <th>Logo</th>                       
                  <!-- <th>Description</th> -->             
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>   
              <tbody>
                <?php $i = 1; foreach($eventListAdmin as $eventsAdmin) { ?> 
                  <tr id="<?php echo $eventsAdmin['id']; ?>">                    
                    <td><?=$i;?></td>
                    <td><?php echo $eventsAdmin['title'];?></td>
                    <td><?php echo date("d-m-Y",strtotime($eventsAdmin['start_date'])); ?></td>
                    <td><?=$eventsAdmin['type'];?></td>
                    <td><img class="user-img custimg text-center" src="<?= base_url();?><?php echo $eventsAdmin['thumbnail']; ?>"/></td>
                    <!-- <td><?php echo substr($eventsAdmin['description'], 0, 30); ?></td> -->
                    <td><input type="checkbox" class="statusToggle" <?php if($eventsAdmin['status'] == 1) { ?> checked <?php } ?> data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger"></td>
                    <td>
                      <a href="event/create?id=<?php echo $eventsAdmin['id']; ?>"><button type="button" class="btn btn-info tb-btn">Edit</button></a>
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
                  <th>Title</th>
                  <th>Start Date</th>    
                  <th>Category</th>
                  <th>Price</th>
                  <th>Logo</th>
                  <th>Description</th>             
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>                  
              <tbody>
                <?php $i=1; foreach($eventList as $events) { ?> 
                  <tr id="<?php echo $events['id']; ?>">                    
                    <td><?=$i;?></td>
                    <td><?php echo $events['user_name'];?></td>
                    <td><?php echo $events['title'];?></td>
                    <td><?php echo date("d-m-Y",strtotime($events['start_date'])); ?></td> 
                    <td><?=$events['type'];?></td>
                    <td><?php echo $events['price'];?></td>
                    <td><img class="user-img custimg text-center" src="<?= base_url();?><?php echo $events['thumbnail']; ?>"/></td>                      
                    <!-- <td><?php echo date("d-m-Y",strtotime($events['publist_start_date'])); ?></td> -->
                    <td><?php echo substr($events['description'], 0, 30); ?></td>
                    <td><input type="checkbox" class="statusToggle" <?php if($events['status'] == 1) { ?> checked <?php } ?> data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger"></td>
                    <td>
                      <a href="event/create?id=<?php echo $events['id']; ?>"><button type="button" class="btn btn-info tb-btn">Edit</button></a>
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
  $('.add-align').hide();
});
$('#home-tab').click(function(){
  $('.add-align').show();
});

$('.deleteButton').click(function(){
  var answer = confirm('Are you sure you want to delete this event?');
  if (answer) {
    var mode= $(this).prop('checked');
    var trid = $(this).closest('tr').attr('id'); 
    $.ajax({
      type:'POST',
      dataType:'JSON',
      url:'event/deleteEntry',
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
      "targets": [6,8,9],
      "orderable": false
    }]
  });
});
</script>

