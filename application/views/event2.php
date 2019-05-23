<?php require_once('layouts/header.php');  ?>  
<div class="machine-con" id="content-wrapper">
    <div class="card0 mb-3">
      <div class="card-header primary-color">
        <i class="fas fa-users"></i>
        Event List
        <span class="flastMessage" style="margin-left: 25%;"><?php echo $this->session->flashdata('event');?></span>
        <div class="add-align">
          <a href="<?= base_url();?>index.php/event/create">  <button type="submit" class="signupbtn custome-button"><span class="normal-class">Create Event</span><span class="normal-icon"><i class="fas fa-check"></i></span></button></a>              
        </div>
      </div>
      
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>                      
                <!-- <th>ID</th> -->
                <th>Event Start Date</th>    
                <th>Title</th>
                <th>Category</th>
                <th>Logo</th>                
                <th>Published Start Date</th>            
                <th>Description</th>             
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>                  
            <tbody>
              <?php foreach($eventList as $events) { ?> 
                <tr id="<?php echo $events['id']; ?>">                    
                  <!-- <td>1</td> -->
                  <td><?php echo date("d-m-Y",strtotime($events['start_date'])); ?></td>
                  <td><?php echo $events['title'];?></td>
                  <td><?=$events['type'];?></td>
                  <td><img class="user-img custimg text-center" src="<?= base_url();?><?php echo $events['thumbnail']; ?>"/></td>
                  
                  <td><?php echo date("d-m-Y",strtotime($events['publist_start_date'])); ?></td>
                  <td><?php echo substr($events['description'], 0, 50); ?></td>
                  <td><input type="checkbox" class="statusToggle" <?php if($events['status'] == 1) { ?> checked <?php } ?> data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger"></td>
                  <td>
                    <a href="event/create?id=<?php echo $events['id']; ?>"><button type="button" class="btn btn-info tb-btn">Edit</button></a>
                    <button type="button" class="deleteButton btn btn-danger tb-btn">Delete</button>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
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
      url:'event/deleteEntry',
      data:{"mode": mode, "trid": trid},
      success:function(data){
        location.reload();
      }
    });
  });
</script>

