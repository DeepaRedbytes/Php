<?php require_once('layouts/header.php');  ?>
<div class="machine-con" id="content-wrapper">
    <div class="card0 mb-3">
        <div class="card-header primary-color">
            <i class="fas fa-users"></i>FAQ
            <div class="add-align">
            <a href="faq/create" ><button type="submit" class="signupbtn custome-button"><span class="normal-class">Create</span><span class="normal-icon"><i class="fas fa-plus"></i></span></button></a>
            </div>
        </div>
        <div class="card-body">
          <?php foreach($faqList as $faq) { ?> 
          <div class="row">
            <div class="col-md-12">
              <div class="box-faq-1">
						    <div class="box-faq-hd">
						      <i class="fa fa-question"></i>
						      <h6><?=$faq['question'];?></h6>	
                  <div class="">
                    <a class="btn btn-info tb-btn" href="faq/create?id=<?php echo $faq['id']; ?>">Edit</a>
                    <button type="button" id="<?php echo $faq['id']; ?>" class="deleteButton btn btn-danger tb-btn">Delete</button>
                  </div>
					      </div>
					      <p><?=$faq['answer'];?></p> 
					    </div>           
            </div>
          </div>
        <?php } ?>   
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


setTimeout(function() {
  $('.flastMessage').hide('fast');
}, 10000);


$('.deleteButton').click(function(){
  var trid = $(this).attr('id'); 
  $.ajax({
    type:'POST',
    dataType:'JSON',
    url:'faq/deleteEntry',
    data:{"trid": trid},
    success:function(data){
      location.reload();
    }
  });
});
</script>