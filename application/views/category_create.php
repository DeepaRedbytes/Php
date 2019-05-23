<?php require_once('layouts/header.php');   ?>
    <style>
    #field {
    margin-bottom:20px;
      }
      label.cabinet{
  display: block;
  cursor: pointer;
}

label.cabinet input.file{
  position: relative;
  height: 100%;
  width: auto;
  opacity: 0;
  -moz-opacity: 0;
  filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
  margin-top:-30px;
}

#upload-demo{
  width: 250px;
  height: 250px;
  padding-bottom:25px;
}
figure figcaption {
    /* position: absolute; */
    bottom: 0;
    color: #fff;
    width: 100%;
    padding-left: 9px;
    padding-bottom: 5px;
    text-shadow: 0 0 10px #000;
    margin-top: -24px;
}
.gambar{
  width:160px;
  height: 163px;
}
    </style>
  

<?php 
$catID = ""; 
$category = ""; 
$description = ""; 
$status = 1; 
$imageInput = '';
$image = "theme/img/logo_thmb.png"; 
if(!empty($categoryDetail)) { 
    $myArray = (array) $categoryDetail['_id']; 
    $catID = $myArray['oid']; 
    $category = $categoryDetail['category'];
    $description = $categoryDetail['description'];
    $status = $categoryDetail['status'];
    $image =  $categoryDetail['image']; 
    $imageInput = $categoryDetail['image']; 
}?>

<div class="machine-con add-user" id="content-wrapper">
  <div class="card0 mb-3">
    <div class="card-header primary-color"><i class="fas fa-users"></i>Create Category</div>
      <?php echo form_open('category/create', ['id' => 'createCategoryForm','enctype'=>"multipart/form-data"]); ?>
          <div class="container no-padding">
              <div class="col-md-12 bottom-border">
                  <div class="row">
                    <div class="col-md-4 no-padding display-center">
                        <label for="email">Category Name</label>
                    </div>
                    <div class="col-md-8">
                      <input type="text" name="category" placeholder="Category Name" id="category" required value="<?=$category;?>">
                    </div>
                  </div>
              </div>   
              <div class="col-md-12 bottom-border">
                  <div class="row">
                      <div class="col-md-4 no-padding display-center">
                        <label for="address">Short description</label>
                      </div>
                      <div class="col-md-8">
                        <textarea type="text" name="description" placeholder="Description" id="description"  required><?=$description;?></textarea> 
                      </div>
                  </div>
              </div>
              <div class="col-md-12 bottom-border">
                  <div class="row">
                    <div class="col-md-4 no-padding display-center">
                      <label for="opration">Status</label>
                    </div>
                    <div class="col-md-8 check-box">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="row">                      
                            <div class="col-md-3 display-center"><input <?php if($status == 1) { echo 'checked'; } ?> type="radio" name="status" value="true"> Active</div>  
                            <div class="col-md-3 display-center"><input <?php if($status == 0) { echo 'checked'; } ?> type="radio" name="status" value="false"> Inactive</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="col-md-12 bottom-border">
                  <div class="row">
                      <div class="col-md-4 no-padding display-center"><label for="phone">Logo</label></div>
                      <div class="col-md-8">
                        <label class="cabinet center-block">
                          <figure>
                            <img src="<?=base_url();?>/<?php echo $image; ?>" class="gambar img-responsive img-thumbnail" id="item-img-output" />
                            <figcaption><i class="fa fa-camera"></i>
                              <?php if(empty($imageInput)) { ?> 
                                <input type="file" class="item-img file center-block" name="file_photo" accept="image/*" required/>
                              <?php } else {  ?>
                                <input type="file" class="item-img file center-block" name="file_photo" accept="image/*"/>
                          <?php } ?>
                            </figcaption>                             
                          </figure>                            
                        </label>
                      </div>
                  </div>
              </div>      
              <div class="clearfix">
                  <div class="button-align">
                      <input type="text" style="display: none;" name="cat_id" value="<?=$catID;?>">
                      <button type="submit" class="signupbtn custome-button"><span class="normal-class">Submit</span><span class="normal-icon"><i class="fas fa-check"></i></span></button>
                  </div>
              </div>
          </div>
      <?php echo form_close(); ?> 
  </div>
</div>
        <!-- /.container-fluid -->

</div>
      <!-- /.content-wrapper -->
</div>
   

           <!-- logo modal -->
  <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"></h4>
        </div>
        <div class="modal-body">
          <div id="upload-demo" class="center-block"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
        </div>
      </div>
    </div>
  </div>



  <?php require_once('layouts/footer.php'); ?>            
   


          












    <script>
    $(document).ready(function(){
    var next = 1;
    $(".add-more").click(function(e){
        e.preventDefault();
        var addto = "#field" + next;
        var addRemove = "#field" + (next);
        next = next + 1;
        var newIn = '<input autocomplete="off" class="input" id="field' + next + '" name="field' + next + '" type="text">';
        var newInput = $(newIn);
        var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >-</button></div><div id="field">';
        var removeButton = $(removeBtn);
        $(addto).after(newInput);
        $(addRemove).after(removeButton);
        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
        $("#count").val(next);  
        
            $('.remove-me').click(function(e){
                e.preventDefault();
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#field" + fieldNum;
                $(this).remove();
                $(fieldID).remove();
            });
    });
    

    
});


// image upload

function initImageUpload(box) {
  let uploadField = box.querySelector('.image-upload');

  uploadField.addEventListener('change', getFile);

  function getFile(e){
    let file = e.currentTarget.files[0];
    checkType(file);
  }
  
  function previewImage(file){
    let thumb = box.querySelector('.js--image-preview'),
        reader = new FileReader();

    reader.onload = function() {
      thumb.style.backgroundImage = 'url(' + reader.result + ')';
    }
    reader.readAsDataURL(file);
    thumb.className += ' js--no-default';
  }

  function checkType(file){
    let imageType = /image.*/;
    if (!file.type.match(imageType)) {
      throw 'Datei ist kein Bild';
    } else if (!file){
      throw 'Kein Bild gewählt';
    } else {
      previewImage(file);
    }
  }
  
}

// initialize box-scope
var boxes = document.querySelectorAll('.box');

for (let i = 0; i < boxes.length; i++) {
  let box = boxes[i];
  initDropEffect(box);
  initImageUpload(box);
}



/// drop-effect
function initDropEffect(box){
  let area, drop, areaWidth, areaHeight, maxDistance, dropWidth, dropHeight, x, y;
  
  // get clickable area for drop effect
  area = box.querySelector('.js--image-preview');
  area.addEventListener('click', fireRipple);
  
  function fireRipple(e){
    area = e.currentTarget
    // create drop
    if(!drop){
      drop = document.createElement('span');
      drop.className = 'drop';
      this.appendChild(drop);
    }
    // reset animate class
    drop.className = 'drop';
    
    // calculate dimensions of area (longest side)
    areaWidth = getComputedStyle(this, null).getPropertyValue("width");
    areaHeight = getComputedStyle(this, null).getPropertyValue("height");
    maxDistance = Math.max(parseInt(areaWidth, 10), parseInt(areaHeight, 10));

    // set drop dimensions to fill area
    drop.style.width = maxDistance + 'px';
    drop.style.height = maxDistance + 'px';
    
    // calculate dimensions of drop
    dropWidth = getComputedStyle(this, null).getPropertyValue("width");
    dropHeight = getComputedStyle(this, null).getPropertyValue("height");
    
    // calculate relative coordinates of click
    // logic: click coordinates relative to page - parent's position relative to page - half of self height/width to make it controllable from the center
    x = e.pageX - this.offsetLeft - (parseInt(dropWidth, 10)/2);
    y = e.pageY - this.offsetTop - (parseInt(dropHeight, 10)/2) - 30;
    
    // position drop and animate
    drop.style.top = y + 'px';
    drop.style.left = x + 'px';
    drop.className += ' animate';
    e.stopPropagation();
    
  }
}


</script>
<script>
        // Start upload preview image
        //$(".gambar").attr("src", "img/logo.png");
            var $uploadCrop,
            tempFilename,
            rawImg,
            imageId;
             function readFile(input) {
             if (input.files && input.files[0]) {
              var reader = new FileReader();
             reader.onload = function (e) {
            $('.upload-demo').addClass('ready');
             $('#cropImagePop').modal('show');
              rawImg = e.target.result;
           }
            reader.readAsDataURL(input.files[0]);
           }
            else {
             swal("Sorry - you're browser doesn't support the FileReader API");
             }
             }
            $uploadCrop = $('#upload-demo').croppie({
              viewport: {
              width: 150,
              height: 200,
              },
              enforceBoundary: false,
              enableExif: true
              });
               $('#cropImagePop').on('shown.bs.modal', function(){
                //  alert('Shown pop');
                $uploadCrop.croppie('bind', {
                    url: rawImg
                 }).then(function(){
                    console.log('jQuery bind complete');
                   });
                   });
        
              $('.item-img').on('change', function () { imageId = $(this).data('id'); tempFilename = $(this).val();
                                                                                                                 $('#cancelCropBtn').data('id', imageId); readFile(this); });
               $('#cropImageBtn').on('click', function (ev) {
                    $uploadCrop.croppie('result', {
                  type: 'base64',
                  format: 'jpeg',
                  size: {width: 150, height: 200}
                }).then(function (resp) {
                    $('#item-img-output').attr('src', resp);
                 $('#cropImagePop').modal('hide');
               });
                 });
      // End upload preview image
   </script>    

  </body>

</html>
