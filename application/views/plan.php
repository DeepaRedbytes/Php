<style type="text/css">

.head {
  /*display: inline-block;*/
  /*position: relative;*/
  max-width: 100px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  vertical-align: top;
}
</style>

<?php require_once('layouts/header.php'); ?>
<div class="machine-con" id="content-wrapper">
  <div class="card0 mb-3">
    <div class="card-header primary-color">
      <i class="fas fa-users"></i>
      Plan List
      <span class="flastMessage" style="margin-left: 25%;"><?php echo $this->session->flashdata('plan');?></span>
      <div class="add-align">
        <a href="plan/create"><button type="submit" class="signupbtn custome-button"><span class="normal-class">Add Plan</span><span class="normal-icon"><i class="fas fa-check"></i></span></button></a>      
      </div>

    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>                      
              <th>Srn.</th>
              <th>name</th>
              <th>Type</th>             
              <th>Price</th>
              <th>Action</th>
            </tr>
          </thead>                  
          <tbody>

            <?php $i=1; foreach($plan_details as $plan) { ?>
            <tr id="<?php echo $plan['id']; ?>">                     
              <td><?=$i;?></td>
              <td class="head"><?php echo $plan['planname']; ?></td>  
              <td class="head"><?php echo $plan['type']; ?></td>                        
              <td class="head"><?php echo $plan['price']; ?></td>
              <td>
                <a href="plan/edit/<?php echo $plan['id']?>"><button type="button" class="btn btn-info tb-btn">Edit</button></a>
                <button type="button" class="deleteButton btn btn-danger tb-btn">Delete</button>
              </td>
            </tr>
          <?php $i++; 
        } ?> 
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
        <!-- /.container-fluid -->


      <!-- /.content-wrapper -->

   
<?php require_once('layouts/footer.php'); ?>
<script type="text/javascript">
  $('.deleteButton').click(function(){
    var mode= $(this).prop('checked');
    var trid = $(this).closest('tr').attr('id');     
    $.ajax({
      type:'POST',
      dataType:'JSON',
      url:'plan/deleteEntry',
      data:{"mode": mode, "trid": trid},
      success:function(data){
        location.reload();
      }
    });
  });
</script>
<script> 
    setTimeout(function() {
        $('.flastMessage').hide('fast');
    }, 10000);
</script>