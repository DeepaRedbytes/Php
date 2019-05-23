<?php require_once('layouts/header.php');  ?>
<div class="machine-con" id="content-wrapper">
    <div class="card0 mb-3">
        <div class="card-header primary-color">
            <i class="fas fa-users"></i>RESOURCE
            <div class="add-align">
            <a href="resource/create" ><button type="submit" class="signupbtn custome-button"><span class="normal-class">Create</span><span class="normal-icon"><i class="fas fa-plus"></i></span></button></a>
            </div>
        </div>
        <div class="card-body">
          <?php foreach($resourceList as $resource) { ?> 


             <div class="row _faq_br">
                       
                        <div class="col-md-8">
                            
                <h6><?=$resource['title'];?></h6>
                                <!-- <a class="btn btn-link mb-rs-link" href="faq_create.html">Edit</a> -->  
                        </div>
                        <div class="col-md-1">
                                <a class="btn btn-info tb-btn" href="<?= base_url();?><?php echo $resource['link']; ?>" target="_blank">View</a>
                               
                        </div>
                        <div class="col-md-1">
                                <a class="btn btn-info tb-btn" href="resource/create?id=<?php echo $resource['id']; ?>">Edit</a>
                               
                        </div>
                        <div class="col-md-1">
                                
                                <button id="<?php echo $resource['id']; ?>" type="button" class="deleteButton btn btn-danger tb-btn">Delete</button>
                        </div>
              
                      
                                    
                    </div>




          <!-- <div class="row">
            <div class="col-md-12">
              <div class="box-faq-1">
						    <div class="box-faq-hd">
						      <i class="fa fa-question"></i>
						      <h6><?=$resourceList['title'];?></h6>
					      </div>
					      <p><?=$resourceList['link'];?></p>
                <a class="btn btn-link mb-rs-link" href="resource/create?id=<?php echo $faq['id']; ?>">Edit</a>
                <button type="button" id="<?php echo $resource['id']; ?>" class="deleteButton btn btn-danger tb-btn">Delete</button>
					    </div>           
            </div>
          </div> -->
        <?php } ?>   
      </div>
    </div>
<?php require_once('layouts/footer.php');  ?>
<script type="text/javascript">
setTimeout(function() {
  $('.flastMessage').hide('fast');
}, 10000);

$('.deleteButton').click(function(){
  var trid = $(this).attr('id'); 
  $.ajax({
    type:'POST',
    dataType:'JSON',
    url:'resource/deleteEntry',
    data:{"trid": trid},
    success:function(data){
      location.reload();
    }
  });
});
</script>