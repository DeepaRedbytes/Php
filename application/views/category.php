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

<?php require_once('layouts/header.php');   ?>
<div class="machine-con" id="content-wrapper">
  <div class="card0 mb-3">
    <div class="card-header primary-color">
      <i class="fas fa-users"></i>
      Category List
      <span class="flastMessage" style="margin-left: 25%;"><?php echo $this->session->flashdata('category');?></span>
      <div class="add-align">
        <a href="category/create">  <button type="submit" class="signupbtn custome-button"><span class="normal-class">Add Category</span><span class="normal-icon"><i class="fas fa-check"></i></span></button></a>      
      </div>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>                      
              <th>Srn.</th>
              <th>Category Name</th>
              <th>Logo</th>
              <th>Description</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>                  
          <tbody>

          <?php $i=1; foreach($categoryList as $category) { ?>
            <tr id="<?php echo $category['id']; ?>">                     
              <td><?=$i;?></td>
              <td class="head"><?php echo $category['category']; ?></td>
              <td> <img class="user-img custimg text-center" src="<?=base_url();?>/<?php echo $category['image']; ?>"/></td>
              <td class="head"><?php echo $category['description']; ?></td>            
              <td><input type="checkbox" class="statusToggle" <?php if($category['status'] == 1) { ?> checked <?php } ?> data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger"></td>
              <td>
                <a href="category/create?id=<?php echo $category['id']; ?>"><button type="button" class="btn btn-info tb-btn">Edit</button></a>
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
        <!-- /.container-fluid -->

      </div>
      <!-- /.content-wrapper -->

    </div>
   
<?php require_once('layouts/footer.php'); ?>
<script type="text/javascript">
  $('.statusToggle').change(function(){
    var mode= $(this).prop('checked');
    var trid = $(this).closest('tr').attr('id'); 
    
    $.ajax({
      type:'POST',
      dataType:'JSON',
      url:'category/statusUpdate',
      data:{"mode": mode, "trid": trid},
      success:function(data){
      }
    });
  });
</script>
<script type="text/javascript">
  $('.deleteButton').click(function(){
    var mode= $(this).prop('checked');
    var trid = $(this).closest('tr').attr('id');     
    $.ajax({
      type:'POST',
      dataType:'JSON',
      url:'category/deleteEntry',
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