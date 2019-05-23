<?php require_once('layouts/header.php');  
$resourceID = "";
$title = "";
$link = ""; 
//$status = 1; 
if(!empty($resourceDetail)) { 
    if(!empty($resourceDetail['_id'])) {  $resourceID = (string)$resourceDetail['_id']; }
    $title = $resourceDetail['title'];
    $link = $resourceDetail['link'];
    //$status = $faqDetail['status'];
}?>

<div class="machine-con" id="content-wrapper">
    <div class="card0 mb-3">
        <div class="card-header primary-color">
            <i class="fas fa-users"></i>RESOURCE'S<div class="add-align"></div>
        </div>
        <div class="card-body">
            <div class="content">
                <div class="container-fluid">
                    <section class="content-wrap">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="_01_colBox">
                                    <?php echo form_open('resource/create', ['id' => 'createResourceForm','enctype'=>"multipart/form-data"]); ?>
                                    <div class="box-info">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" required="required" maxlength="100" value="<?=$title?>">
                                        </div>
                                        <div class="_eidt-01">
                                           <input type="file" name="link" id="link" <?php if($link == '') { ?>required="required" <?php }?>  accept="application/pdf"> 
                                            <span id="linkname"><?php if($link != '') { $arr = explode("/", $link); echo '(Previously selected file name : '.$arr['2'].')'; }?></span>
                                        </div><br/><br/>
                                        <button type="submit" class="btn btn-primary"><span class="normal-class">Save</span><span class="normal-icon"><i class="fas fa-check"></i></span></button>
                                    </div>
                                    <input type="text" name="resourceID" value="<?=$resourceID;?>" style="display: none;">
                                    <?php echo form_close(); ?> 
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
<?php require_once('layouts/footer.php');  ?>
<script src="<?= base_url();?>theme/js/editor.js"></script>

<script type="text/javascript">
    $('#link').on( 'change', function() {
   myfile= $( this ).val();
   var ext = myfile.split('.').pop();
   if(ext=="pdf"){
       $('#linkname').html("");
   } else{
       alert('Please select PDF file');
       $('#link').val("");
   }
});
</script>