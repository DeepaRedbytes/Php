<?php require_once('layouts/header.php');  ?>
<style>
  #field {
  margin-bottom: 20px;
}
label.cabinet {
  display: block;
  cursor: pointer;
}
label.cabinet input.file {
  position: relative;
  height: 100%;
  width: auto;
  opacity: 0;
  -moz-opacity: 0;
  filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0);
  margin-top: -30px;
}
#upload-demo {
  width: 250px;
  height: 250px;
  padding-bottom: 25px;
}
#upload-demo-banner {
  width: 360px;
  height: 230px;
  padding-bottom: 25px;
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
.gambar {
  width: 100%;
  height: 150px;
}
.cls-icon {
  top: 0;
  position: absolute;
  margin-top: 24px;
  color: black;
}
input[type="file"] {
  display: block;
}
.imageThumb {
  max-height: 75px;
  border: 2px solid;
  padding: 1px;
  cursor: pointer;
}
.pip {
  display: inline-block;
  margin: 10px 10px 0 0;
}
.remove {
  display: block;
  background: #444;
  border: 1px solid black;
  color: white;
  text-align: center;
  cursor: pointer;
}
.remove:hover {
  background: white;
  color: black;
}
.mandfeild{
  right: -9px;
  top: -5px;
  position: absolute;
  color: red;
}
.mandfeild1{
  right: 236px;
  top: -1px;
  position: absolute;
  color: red;
}
.mandfeild2{
  right: 215px;
  top: -1px;
  position: absolute;
  color: red;
}
.mandfeild3{
  right: 192px;
  top: -1px;
  position: absolute;
  color: red;
}
.validationError{
  color: red;
  font-size: 13px;
}
.weekDays-selector input {
  display: none!important;
}
.weekDays-selector{
    width: 100%;
}

.weekDays-selector input[type=checkbox] + label {
    display: inline-block;
    border-radius: 6px;
    background: #dddddd;
    height: 41px;
    padding-left: 0px;
    width: 39px;
    margin-right: 15px;
    line-height: 35px;
    text-align: center;
    cursor: pointer;
}

.weekDays-selector input[type=checkbox]:checked + label {
  background: #2AD705;
  color: #ffffff;


}
</style>

<?php
$i = "1"; 
$serviceID = ""; 
$name = ""; 
$description = "";
$start_time = "";
$end_time = "";
$location = "";
$cat  = "";
$address = "";
$terms_and_condition= "";
$price = "";
$price_type = "";
$status = 1; 
$highlights = "";
$banner_image = "theme/img/logo_thmb2.png"; 
$banner_imageInput = '';
$thumbnail = "theme/img/logo_thmb.png"; 
$thumbnailInput = '';
$days = [];
$latitude = 0; 
$longitude = 0; 
$exthighlight = "";
$email ="";
$phone="";
$serviceUrl = "";
// print_r($serviceDetail);die;
if(!empty($serviceDetail)) { 
    $myArray = (array) $serviceDetail['_id']; 
    $serviceID = $myArray['oid']; 
    $name = $serviceDetail['name']; 
    $cat = $serviceDetail['category_name'];
    $description = $serviceDetail['desc'];
    $status = $serviceDetail['status'];
    $start_time = $serviceDetail['start_time'];
    $end_time =  $serviceDetail['end_time'];
    $location =  $serviceDetail['location'];
    $latitude = $serviceDetail['latitude'];
    $longitude = $serviceDetail['longitude'];
    $address = $serviceDetail['address'];
    $price = $serviceDetail['price'];
    $terms_and_condition = $serviceDetail['terms_and_condition'];
    if(!empty($serviceDetail['price_type'])) { $price_type = $serviceDetail['price_type']; } 
    $exthighlight = $serviceDetail['exthighlight'];
    if(!empty($serviceDetail['highlights'])) { $highlights = $serviceDetail['highlights']; }
    if(!empty($serviceDetail['thumbnail'])) { $thumbnail = $serviceDetail['thumbnail']; }
    if(!empty($serviceDetail['thumbnail'])) { $thumbnailInput = $serviceDetail['thumbnail']; }
    if(!empty($serviceDetail['banner_image'])) { $banner_image = $serviceDetail['banner_image']; }
    if(!empty($serviceDetail['banner_image'])) { $banner_imageInput = $serviceDetail['banner_image']; }
    if(!empty($serviceDetail['email'])) { $email = $serviceDetail['email']; }
    if(!empty($serviceDetail['phone'])) { $phone = $serviceDetail['phone']; }
     if(!empty($serviceDetail['serviceUrl'])) { $serviceUrl = $serviceDetail['serviceUrl']; }

    if(!empty($serviceDetail['days'])) { $days = $serviceDetail['days'];
    $days = iterator_to_array($days); }


}?>

<body class="machine" id="page-top">

  <div id="wrapper">

    <!-- Sidebar -->

    <div class="machine-con add-user" id="content-wrapper">
      <div class="card0 mb-3">
        <div class="card-header primary-color">
          <i class=""></i>Service Details</div>
               <?php echo form_open('service/create', ['id' => 'createServiceForm','enctype'=>"multipart/form-data"]); ?>

                <div class="no-padding">
                    <div class="col-md-12 bottom-border">
                     <div class="col-md-4 no-padding display-center">
                          <label for="">Information about Service</label>
                      </div>
                     <div class="col-md-12"> 
                     <div class="row">
                        <div class="col-md-6 full-input fx-w mr-3">
                            <label for='name'>Service title :</label>
                            <input name="name" type="text" placeholder='Name' required value="<?=$name;?>">
                             <i class="mandfeild">*</i>
                        </div>
                        <div class="col-md-6 full-input fx-w mr-3">
                            <label for='name'>Address :</label>
                            <input type='text' name='address' placeholder='Address' required value="<?=$address;?>">
                             <i class="mandfeild">*</i>
                        </div>
                        <div class="col-md-6 full-input fx-w mr-3">
                            <label for='name'>Location :</label>
                            <input type='text' name='location' id="location" placeholder='Location' required value="<?=$location?>">
                             <i class="mandfeild">*</i>
                        </div>
                     </div>     
                     </div>
                      </div>   
                      <div class="col-md-12 bottom-border">
                          <div class="col-md-4 no-padding display-center"><label for="">Category</label></div>
                          <div class="col-md-12">
                            <div class="row">
                               <div class="col-md-4 full-input mr-3">
                                   <label for="name" style="width:56%">Type :</label>
                                    <select required name="category_name">
                                     <option disabled selected value="">Select</option>
                                      <?php foreach($category_array as $category){ ?>
                                     <option value="<?=$category['category'];?>" <?php echo ($category['category'] == $cat)?'selected':''?> ><?=$category['category'];?></option>
                                    <?php  }?>
                                                                      
                                   </select>
                                   <!-- <input type='text' name='name' placeholder='Dance, Singing,..'> -->
                                   <i class="mandfeild">*</i>
                               </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-md-10 full-input mr-3">
                                    <label for="name" class="active" style="width:45%">Availability:</label>
                                    <div class="weekDays-selector">

                                      <?php // if(!empty($days)){ ?>
                                      
                                          <input type="checkbox" id="weekday-all" onchange="checkAll(this)"/>
                                        <label for="weekday-all">All</label>
                                        <input type="checkbox" <?php if(in_array("Mon", $days)){ echo 'checked';}?> id="weekday-mon" class="weekday" name=days[] value="Mon"/>
                                        <label for="weekday-mon">Mon</label>
                                        <input type="checkbox" <?php if(in_array("Tue", $days)){ echo 'checked';}?>  id="weekday-tue" class="weekday" name=days[] value="Tue"/>
                                        <label for="weekday-tue">Tue</label>
                                        <input type="checkbox" <?php if(in_array("Wed", $days)){ echo 'checked';}?> id="weekday-wed" class="weekday" name=days[] value="Wed"/>
                                        <label for="weekday-wed">Wed</label>
                                        <input type="checkbox" <?php if(in_array("Thu", $days)){ echo 'checked';}?> id="weekday-thu" class="weekday" name=days[] value="Thu"/>
                                        <label for="weekday-thu">Thu</label>
                                        <input type="checkbox" <?php if(in_array("Fri", $days)){ echo 'checked';}?> id="weekday-fri" class="weekday" name=days[] value="Fri"/>
                                        <label for="weekday-fri">Fri</label>
                                        <input type="checkbox" <?php if(in_array("Sat", $days)){ echo 'checked';}?> id="weekday-sat" class="weekday" name=days[] value="Sat"/>
                                        <label for="weekday-sat" >Sat</label>
                                        <input type="checkbox" <?php if(in_array("Sun", $days)){ echo 'checked';}?> id="weekday-sun" class="weekday" name=days[] value="Sun"/>
                                        <label for="weekday-sun">Sun</label>
                                        <?php // }?>
                                        
                                      </div>
                                </div>
  
                              </div> 
                             <div class="row">
                              <div class="col-md-4 full-input mr-3">
                                  <label for='name'>Start Time :</label>
                                  <input id="timepicker" placeholder="00:00" name="start_time" class="validate ui-timepicker-input" required="" autocomplete="off" value="<?=$start_time?>">
                              </div>
                              <div class="col-md-4 full-input mr-3">
                                  <label for='name'> End Time :</label>
                                  <input id="timepicker1" placeholder="00:00" name="end_time" class="validate ui-timepicker-input" required="" autocomplete="off" value="<?=$end_time;?>">
                              </div>
                             </div> 
                          </div>
                        </div>
                    <div class="col-md-12 bottom-border">
                        <div class="col-md-4 no-padding display-center">
                             <label for="name">Service Highlights</label>
                         </div>
                         <div class="col-md-12">
                        <div class="row">
                           <div class="col-md-6  mr-3">
                               <label for='name'></label>




                              
                              <div id="id_of_div">
                              <?php  if(!empty($highlights)) {

                              foreach($highlights as $highlight){
                               ?>

                              <div id="element<?=$i;?>">
                                <input autocomplete="off" class="input" id="fieldCheck<?=$i;?>" name="highlights[]" type="text" value="<?php echo $highlight;?>">
                                <button id="remove<?=$i;?>" class="btn btn-danger remove-me-old">-</button>
                              </div>


                              <?php $i++;  } 
                            }?>


                              </div>
                               <div id="element">
                                <input autocomplete="off" class="input" id="field1" name="exthighlight" type="text" placeholder="Type something" data-items="8" value="<?php echo $exthighlight;?>"/>
                                <button id="b1" class="btn add-more-ele" type="button">+</button>
                              </div>

                               <?php /*<div id="field">

                                <?php $i=0; if($highlights == ""){ ?>
                                   <input autocomplete="off" class="input" id="field0" name="highlights[0]" type="text" placeholder="Type something" data-items="8"/>
                                <?php  }else{ ?>
                                    <?php  foreach($highlights as $highlight){ ?>
                                        <input type="text" id="field<?=$i;?>" name="highlights[<?=$i;?>]" value="<?php echo $highlight;?>">
                                    <?php $i++; } ?>
                                 <?php }?>
                                <button id="b1" class="btn add-more" type="button">+</button>
                            </div> */?>
                           </div>
                          
                        </div>   
                     </div>
                  </div>  
                <div class="col-md-12 bottom-border">
                      <div class="col-md-4 no-padding display-center">
                           <label for="">Description </label><i class="mandfeild1">*</i> 
                       </div>
                       <div class="col-md-12">
                      <div class="row">
                          <div class="col-md-8 full-input-txtarea mr-3">
                              <textarea type="text" placeholder="Description" rows="6" id="address" name="desc" required><?=$description?></textarea> 
                            </div>
                      </div>   
                      </div>
                </div>  
                <div class="col-md-12 bottom-border">
                    <div class="col-md-4 no-padding display-center">
                         <label for="">Terms & Condition </label><i class="mandfeild3">*</i> 
                     </div>
                     <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-8 full-input-txtarea mr-3">
                                <textarea type="text" placeholder="terms & condition" rows="6" id="address" name="terms_and_condition" required><?=$terms_and_condition;?></textarea> 
                              </div>
                        </div>    
                    </div>
              </div>  
              <div class="col-md-12 bottom-border">
                <div class="col-md-4 no-padding display-center">
                     <label for="">Pricing Details </label>
                 </div>
                 <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-5 full-input mr-3">
                            <label for="name" class="active" style=" width: 42%;">pricing:</label>
                            <input type="text" id="priceId" name="price" placeholder="500" value="<?php if($price != 0){ echo $price;}?>" 
                             onkeypress='return event.charCode >= 48 && event.charCode <= 57' >
                        </div>
                    </div>                    
                   <div class="row">
                        <div class="col-md-3 display-center ">
                            <label class="pure-material-radio">
                                <input type="radio" id="pType" name="price_type" <?php if($price_type == "hrs"){echo "checked";}?> value="hrs" >
                                <span>Per Hrs</span>
                            </label>
                             
                        </div> 
                        <div class="col-md-3 display-center">
                            <label class="pure-material-radio">
                                <input type="radio" id="pType" name="price_type" <?php if($price_type == "day"){echo "checked";}?>  value="day">
                                <span>Per Day</span>
                            </label>
                        </div>
                   </div>  
                </div>   
                </div>
          

          	<div class="col-md-12 bottom-border">
              <div class="col-md-4 no-padding display-center"><label for="">Contact Information</label></div>
              <div class="col-md-12">
                <div class="row">

                  <div class="col-md-3 full-input mr-3">
                    <label for='name'>Service URl:</label>
                    <input type='text' name='serviceUrl' placeholder='service Url' value="<?=$serviceUrl;?>">
                  </div>
                  <div class="col-md-3 full-input mr-3">
                    <label for='name'>Email ID :</label>
                    <input type='email' name='email' value="<?=$email;?>" required>
                    <i class="mandfeild">*</i>
                  </div>
                  <div class="col-md-4 full-input mr-3">
                    <label for='name'>Contact Number :</label>
                    <input type='text' name='phone' maxlength="10" value="<?=$phone;?>" required onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                    <i class="mandfeild">*</i>
                   </div>                
                </div>   
              </div>
            </div>
             <div class="col-md-12 bottom-border">
              <div class="col-md-4 no-padding display-center"><label for="">Thumb Images </label><i class="mandfeild2">*</i> </div>
              <div class="col-md-12">
                <div class="row mr-3">
                  <div class="col-md-3">
                    <?php echo form_error('thumbnail'); ?>
                    <label class="cabinet center-block">
                      <figure>
                        <img src="<?= base_url();?><?=$thumbnail;?>" class="gambar img-responsive img-thumbnail" id="item-img-output" />
                        <input type="hidden" name="hidden_image" id="hidden_image" />
                        <figcaption><i class="fa fa-camera"></i>
               
                          <?php if(empty($thumbnailInput)) { ?>
                            <input type="file" id="imageOption" class="item-img file center-block" name="thumbnail" required accept="image/*"/>
                          <?php } else {  ?>
                            <input type="file" id="imageOption" class="item-img file center-block" name="thumbnail" accept="image/*"/>
                          <?php } ?>
                      
                        </figcaption>
                      </figure>
                    </label>     
                  </div>
                </div>   
              </div>
            </div> 

            <div class="col-md-12 bottom-border">
              <div class="col-md-4 no-padding display-center"><label for="">Banner Images </label><i class="mandfeild2">*</i> </div>
              <div class="col-md-12">
                <div class="row mr-3">
                  <div class="col-md-3">
                    <?php echo form_error('banner_image'); ?>
                    <label class="cabinet center-block">
                      <figure style="width: 256px;">
                        <img src="<?= base_url();?><?=$banner_image;?>" class="gambar img-responsive img-thumbnail" id="item-img-output-banner" />
                        <input type="hidden" name="hidden_image_banner" id="hidden_image_banner" />
                        <figcaption><i class="fa fa-camera"></i>
                   
                          <?php if(empty($banner_imageInput)) { ?>
                            <input type="file" id="imageOption1" class="item-img-banner file center-block" name="banner_image" required accept="image/*" />
                          <?php } else {  ?>
                            <input type="file" id="imageOption1" class="item-img-banner file center-block" name="banner_image" accept="image/*"/>
                          <?php } ?>
                        </figcaption>
                      </figure>
                    </label>   
                  </div>
                  </div>
                </div>   
              </div>
      
          <div class="col-md-12 bottom-border">
              <div class="col-md-4 no-padding display-center">
                   <label for="">Action</label>
               </div>
               <div class="col-md-12">
              <div class="row">
                 <div class="col-md-4 full-input-txtarea mr-3">
                    <input type="checkbox" name="status" <?php if($status === 1) { ?> checked <?php } ?>data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger">
                 </div>
              </div>   
              </div>
        </div>

           <div class="clearfix">
               <div class="button-align">
                <input type="text" style="display: none;" name="service_id" value="<?=$serviceID;?>">
                <input type="text" name="latitude" id="latitude" value="<?=$latitude;?>" style="display: none;">
                  <input type="text" name="longitude" id="longitude" value="<?=$longitude;?>" style="display: none;">
                  <button type="submit" class="signupbtn custome-button"><span class="normal-class">Submit</span><span class="normal-icon"><i class="fas fa-check"></i></span></button>
               </div>
          </div>
       </div>
        <?php echo form_close(); ?>  
   </div>  
    </div>
    <!-- /.container-fluid -->

  </div>

  <!-- logo modal -->
  <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">
          </h4>
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

    <!-- Banner modal -->
  <div class="modal fade" id="cropImagePopBanner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">
          </h4>
        </div>
        <div class="modal-body">
          <div id="upload-demo-banner" class="center-block"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" id="cropImageBtnBanner" class="btn btn-primary">Crop</button>
        </div>
      </div>
    </div>
  </div>

 <?php require_once('layouts/footer.php');  ?>
  <!-- filepond js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.3/js/foundation.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.3/js/foundation/foundation.clearing.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/timepicker@1.11.12/jquery.timepicker.js"></script>
  <!-- Custom scripts for toggle button-->

<script type="text/javascript">
  
$(".weekday").click(function(){
$("#weekday-all").prop("checked", false);
});
</script>


<script type="text/javascript">
      $(document).ready(function() {
        $('body').on('change', '#priceId', function(){
          // console.log("test");
          if ($(this).val() != '') {
            $("#pType").attr('required', true);
          }
        });

        $('#priceId').change();
    });
</script>
<script>
    // Start upload banner image
    var $uploadCrop,
      $uploadCropBanner,
      tempFilename,
      rawImg,
      imageId;

    function readFileBanner(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          //$('.upload-demo').addClass('ready');
          $('#cropImagePopBanner').modal('show');
          rawImg = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
      }
      else {
        swal("Sorry - you're browser doesn't support the FileReader API");
      }
    }

    $('.item-img-banner').on('change', function () {
      imageId = $(this).data('id'); tempFilename = $(this).val();
      $('#cancelCropBtn').data('id', imageId); readFileBanner(this);
    });

    $uploadCropBanner = $('#upload-demo-banner').croppie({
      viewport: {
        width: 256,
        height: 150,
      },
      enforceBoundary: false,
      enableExif: true
    });

    $('#cropImagePopBanner').on('shown.bs.modal', function () {
      $uploadCropBanner.croppie('bind', {
        url: rawImg
      }).then(function () {
        console.log('jQuery bind complete');
      });
    });

    $('#cropImageBtnBanner').on('click', function (ev) {
      $uploadCropBanner.croppie('result', {
        type: 'base64',
        format: 'jpeg',
        size: { width: 256, height: 150 }
      }).then(function (resp) {
        $('#item-img-output-banner').attr('src', resp);
        $('#hidden_image_banner').val(resp);
        $('#cropImagePopBanner').modal('hide');
      });
    });



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

    $('.item-img').on('change', function () {
      imageId = $(this).data('id'); tempFilename = $(this).val();
      $('#cancelCropBtn').data('id', imageId); readFile(this);
    });

    $uploadCrop = $('#upload-demo').croppie({
      viewport: {
        width: 150,
        height:150,
      },
      enforceBoundary: false,
      enableExif: true
    });

    $('#cropImagePop').on('shown.bs.modal', function () {
      //  alert('Shown pop');
      $uploadCrop.croppie('bind', {
        url: rawImg
      }).then(function () {
        console.log('jQuery bind complete');
      });
    });

    $('#cropImageBtn').on('click', function (ev) {
      $uploadCrop.croppie('result', {
        type: 'base64',
        format: 'jpeg',
        size: { width: 150, height: 150 }
      }).then(function (resp) {
        $('#item-img-output').attr('src', resp);
        $('#hidden_image').val(resp);
        $('#cropImagePop').modal('hide');
      });
    });
</script>

  <script>
      //<!-- filepond -->
     $(document).ready(function () {
      var next = <?php echo $i; ?>;
      $(".add-more-ele").click(function (e) {
        e.preventDefault();
        var value = $('#field1').val(); 
        if(value != '') { 
        // var addto = "#field" + next;
        // var addRemove = "#field" + (next);
        next = next + 1;


        // var newDiv = '<div id=element' + (next) + '><input autocomplete="off" class="input" id="field' + next + '" name="field' + next + '" type="text"><button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >-</button></div>';
        // alert(newDiv);
        // $("#id_of_div").append($(newDiv).html());
        
        $('#field1').val("");
        $('#id_of_div').append('<div id=element' + (next) + '><input autocomplete="off" class="input" id="field' + next + '" name="highlights[]" type="text" value="'+value+'"><button id="remove' + (next) + '" class="btn btn-danger remove-me" >-</button></div>');


}
else {
  alert('Please enter some text');
}

        $('.remove-me').click(function (e) {
          e.preventDefault();
          var id=(this.id).charAt(this.id.length - 1);
          $("#element"+id).remove();
          return false;
        });
      });



      
      $('.remove-me-old').click(function (e) {
        e.preventDefault();
        var id=(this.id).charAt(this.id.length - 1);
        $("#element"+id).remove();
        return false;
      });




    });

  </script>

  <!-- stepper form validation -->
  

  
  <!-- timepicker -->
  <script>
  $(function() {
  $('#timepicker').timepicker({
    // timeFormat: 'H:i',
    dynamic: false,
    dropdown: true,
    scrollbar: true
  })
});
$(function() {
  $('#timepicker1').timepicker({
    // timeFormat: 'H:i',
    dynamic: false,
    dropdown: true,
    scrollbar: true
  });


});
</script>

<script type="text/javascript">
function Compare() {
var strStartTime = document.getElementById("timepicker").value;
var strEndTime = document.getElementById("timepicker1").value;
var startTime = new Date().setHours(GetHours(strStartTime), GetMinutes(strStartTime), 0);
var endTime = new Date(startTime)
endTime = endTime.setHours(GetHours(strEndTime), GetMinutes(strEndTime), 0);

if (startTime > endTime) {

alert("End time should be greater than start time");
}
if (startTime < endTime) {

alert("Start Time is less than end time");
}
}
function GetHours(d) {
var h = parseInt(d.split(':')[0]);
if (d.split(':')[1].split(' ')[1] == "pm") {
h = h + 12;
}
return h;
}
function GetMinutes(d) {
return parseInt(d.split(':')[1].split(' ')[0]);
}
</script>
<!-- week days -->
<script>
 function checkAll(ele) {
     var checkboxes = document.getElementsByTagName('input');
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
 }
</script>

<script>
  // This example displays an address form, using the autocomplete feature
  // of the Google Places API to help users fill in the information.

  // This example requires the Places library. Include the libraries=places
  // parameter when you first load the API. For example:
  // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

  var placeSearch, autocomplete;
  var componentForm = {
    locality: 'long_name',
    postal_code: 'short_name'
  };
    
          
  function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.    //autocomplete
    autocomplete = new google.maps.places.Autocomplete(
        (document.getElementById('location')),{
          types: ['geocode'],
          componentRestrictions: {country: 'fr'}
        }
    );

    var inputv = document.getElementById('location');
    google.maps.event.addDomListener(inputv,'keydown',function(e){
         if(e.keyCode===13 && !e.triggered){              
       google.maps.event.trigger(this,'keydown',{keyCode:40})         
       google.maps.event.trigger(this,'keydown',{keyCode:13,triggered:true})
     }
    });

    autocomplete.addListener('place_changed', fillInAddress);

    zipuser = new google.maps.places.Autocomplete(
        (document.getElementById('zipuser')),
        {
          types: ['geocode'],
          componentRestrictions: {country: 'fr'}
        }
     );    
    
    addEdit = new google.maps.places.Autocomplete(
        (document.getElementById('addressEdit')),
        {
          types: ['geocode'],
          componentRestrictions: {country: 'fr'}
        }
    );
    
    registration = new google.maps.places.Autocomplete(
        (document.getElementById('addressRegister')),
        {types: ['geocode']});

    //registration.addListener('place_changed', fillInRegistrationAddress);
  }




    function fillInAddress() {      
      var place = autocomplete.getPlace();
      var lat = place.geometry.location.lat(),
      lng = place.geometry.location.lng(); 
      $("#latitude").val(lat);        
      $("#longitude").val(lng);
    }

      
    
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhwbcYBb4yFbB39UJlTuDLnpD95R_9PD8&libraries=places&callback=initAutocomplete" async defer></script> 
    

</body>

