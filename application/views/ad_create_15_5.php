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
  height: 180px;
}
.gambarBanner {
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
  color: red;
}
.mandfeild2{
  color: red;
}
.validationError{
  color: red;
  font-size: 13px;
}
</style>

<?php 
$adID = ""; 
$title = ""; 
$venue = ""; 
$location = ""; 
$latitude = 0; 
$longitude = 0; 
$type = "";
$language = ""; 
//$duration = ""; 
//$age = ""; 
$price = "";
//$paymentmode = "";
$start_date = ""; 
$start_time = ""; 
$end_date = ""; 
$end_time = ""; 
$description = ""; 
$terms = "";
$banner_image = "theme/img/logo_thmb2.png"; 
$banner_imageInput = '';
$thumbnail = "theme/img/logo_thmb.png"; 
$thumbnailInput = '';
// $publist_end_date = ""; 
// $publist_start_date = ""; 
$adUrl = "";
$email = "";
$phone = "";
$status = 1; 
$price_on = "";
if(!empty($adDetail)) { 
    if(!empty($adDetail['_id'])) {  $adID = (string)$adDetail['_id']; }
    $title = $adDetail['title'];
    $venue = $adDetail['venue'];
    $location = $adDetail['location'];
    $latitude = $adDetail['latitude'];
    $longitude = $adDetail['longitude'];
    $type = $adDetail['type'];
    $language = $adDetail['language'];
    $price = $adDetail['price'];
    //$paymentmode = $adDetail['paymentmode'];
    $adUrl = $adDetail['adUrl'];
    $start_date = $adDetail['start_date'];
    $start_time = $adDetail['start_time'];
    $end_date = $adDetail['end_date'];
    $end_time = $adDetail['end_time'];
    $description = $adDetail['description'];
    $terms = $adDetail['terms']; 
    if(!empty($adDetail['thumbnail'])) { $thumbnail = $adDetail['thumbnail']; }
    if(!empty($adDetail['thumbnail'])) { $thumbnailInput = $adDetail['thumbnail']; }
    if(!empty($adDetail['banner_image'])) { $banner_image = $adDetail['banner_image']; }
    if(!empty($adDetail['banner_image'])) { $banner_imageInput = $adDetail['banner_image']; }
    if(!empty($adDetail['price_on'])) { $price_on = $adDetail['price_on']; }

    // if(!empty($adDetail['publist_start_date'])) { 
    //   $publist_start_date = $adDetail['publist_start_date'];
    // }
    // if(!empty($adDetail['publist_end_date'])) { 
    //   $publist_end_date = $adDetail['publist_end_date']; 
    // }    
    $email = $adDetail['email'];
    $phone = $adDetail['phone'];
    $status = $adDetail['status'];
}?>

<div class="machine-con add-user" id="content-wrapper">
  <div class="card0 mb-3">
    <div class="card-header primary-color"><i class=""></i>Create Advertisement</div>

      <?php echo form_open('advertisement/create', ['id' => 'createAdForm','enctype'=>"multipart/form-data"]); ?>
        <div class="no-padding">
          <div class="col-md-12 bottom-border">
            <div class="col-md-4 no-padding display-center"><label for="">Information about Advertisement</label></div>
            <div class="col-md-12"> 
              <div class="row">
                <div class="col-md-6 full-input fx-w mr-3">
                    <label for='name'>Advertisement title/name :</label>
                    <input type='text' pattern=".*\S+.*" name='title' placeholder='Advertisement title' value="<?=$title;?>" required>
                    <i class="mandfeild">*</i>
                </div>
                <div class="col-md-6 full-input fx-w mr-3">
                    <label for='name'>Venue :</label>                    
                    <input type='text' pattern=".*\S+.*" name='venue' placeholder='Ex : Amanora Mall Pune' required value="<?=$venue;?>" required>
                    <i class="mandfeild">*</i>
                </div>
                <div class="col-md-6 full-input fx-w mr-3">
                    <label for='name'>Location :</label>
                    <input type='text' name='location' id="location" placeholder='Location' value="<?=$location;?>" required>
                    <i class="mandfeild">*</i>                    
                </div>
              </div>     
            </div>
          </div>   

          <div class="col-md-12 bottom-border">
            <div class="col-md-4 no-padding display-center"><label for="">Category</label></div>
            <div class="col-md-12">
              <div class="row">
                 <div class="col-md-3 full-input mr-3">
                     <label for='name'>Advertisement type :</label>
                     <input type='text' name='type' placeholder='Dance, Singing,..' value="<?=$type;?>" required><i class="mandfeild">*</i>
                   </div>
                   <div class="col-md-3 full-input mr-3">
                       <label for='name'>Language :</label>
                       <!-- <input type='text' name='language' placeholder='English' value="<?=$language;?>"> -->
                       <select id="language" name="language">
                        <option value="" <?php if($language == '') { echo 'selected'; } ?> >Select</option>
                        <option value="English" <?php if($language == 'English') { echo 'selected'; } ?> >English</option>
                        <option value="Mandarin" <?php if($language == 'Mandarin') { echo 'selected'; } ?> >Mandarin</option>
                        <option value="Arabic" <?php if($language == 'Arabic') { echo 'selected'; } ?> >Arabic+</option>
                        <option value="Cantonese" <?php if($language == 'Cantonese') { echo 'selected'; } ?> >Cantonese</option>
                        <option value="Vietnamese" <?php if($language == 'Vietnamese') { echo 'selected'; } ?> >Vietnamese</option>
                        <option value="Italian" <?php if($language == 'Italian') { echo 'selected'; } ?> >Italian</option>
                      </select>
                   </div>
                   <div class="col-md-2 full-input mr-3">
                      <label for='name'>Price:</label>
                    <input type='text' id="priceId" maxlength="6" name='price' onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder='500' value="<?=$price;?>">
                   </div>
                   <div class="col-md-2 display-center _divwidth">
                    <label class="pure-material-radio">
                        <input class="radioButton" type="radio" id="pon" name="price_on" <?php if($price_on == "AUD"){echo "checked";}?> value="AUD" >
                        <span>AUD</span>
                    </label>
                   </div> 
                   <div class="col-md-2 display-center _divwidth">
                      <label class="pure-material-radio">
                          <input class="radioButton" type="radio" id="pon" name="price_on" <?php if($price_on == "USD"){echo "checked";}?> value="USD" >
                          <span>USD</span>
                      </label>
                   </div>
              </div>
            </div>
          </div>   

          <div class="col-md-12 bottom-border">
            <div class="col-md-4 no-padding display-center"><label for="">Date</label></div>
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-3 full-input mr-3">
                      <label for='name'>Start Date :</label>
                      <input type='date' id="start_date" name='start_date' placeholder='Date' value="<?=$start_date;?>" required><i class="mandfeild">*</i>
                  </div>
                  <div class="col-md-2 full-input mr-3">
                      <label for='name'>Time :</label>
                      <!-- <input id="timepicker" placeholder="00:00" name="start_time" class="validate ui-timepicker-input" equired="" autocomplete="off" value="<?=$start_time;?>"> -->
                      <input id="start" name="start_time" class="validate ui-timepicker-input" placeholder="00:00" value="<?=$start_time?>" required=""/>
                  </div>
                  <div class="col-md-3 full-input mr-3">
                      <label for='name'>End Date :</label>
                      <input type='date' id="end_date" name='end_date' placeholder='Date' value="<?=$end_date;?>">
                  </div>
                  <div class="col-md-2 full-input mr-3">
                      <label for='name'>Time :</label>
                      <!-- <input id="timepicker1" placeholder="00:00" name="end_time" class="validate ui-timepicker-input" equired="" autocomplete="off" value="<?=$end_time;?>"> -->
                      <input id="end" name="end_time" class="validate ui-timepicker-input" placeholder="00:00" value="<?=$end_time?>" required=""/>
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
                    <textarea type="text" placeholder="Description" rows="6" id="description" name="description" required><?=$description?></textarea>
                  </div>
                </div>   
              </div>
            </div> 

            <div class="col-md-12 bottom-border">
              <div class="col-md-4 no-padding display-center"><label for="">Terms & Condition </label></div>
              <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8 full-input-txtarea mr-3">
                      <textarea type="text" placeholder="terms & condition" rows="6" id="terms" name="terms"><?=$terms?></textarea> 
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
                            <input type="file" id="imageOption" class="item-img file center-block" name="thumbnail" accept="image/*" required />
                          <?php } else {  ?>
                            <input type="file" id="imageOption" class="item-img file center-block" name="thumbnail" accept="image/*" />
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
                        <img src="<?= base_url();?><?=$banner_image;?>" class="gambarBanner img-responsive img-thumbnail" id="item-img-output-banner" />
                        <input type="hidden" name="hidden_image_banner" id="hidden_image_banner" />
                        <figcaption><i class="fa fa-camera"></i>
                          <?php if(empty($banner_imageInput)) { ?>
                            <input type="file" id="imageOption1" class="item-img-banner file center-block" name="banner_image" accept="image/*" required />
                          <?php } else {  ?>
                            <input type="file" id="imageOption1" class="item-img-banner file center-block" name="banner_image" accept="image/*" />
                          <?php } ?>
                        </figcaption>
                      </figure>
                    </label>   
                  </div>
                  </div>
                </div>   
              </div>
            </div> 

            <?php /*?><div class="col-md-12 bottom-border">
              <div class="col-md-4 no-padding display-center"><label for="">Admin Options</label></div>
              <div class="col-md-12">
                <div class="row">
                   <div class="col-md-4 full-input mr-3">
                      <label for='name'>Publish Start Date :</label>
                      <input type='date' id="publist_start_date" name='publist_start_date' value="<?=$publist_start_date;?>" required placeholder='Date'>
                      <i class="mandfeild">*</i>
                   </div>
                   <div class="col-md-4 full-input mr-3">
                      <label for='name'>Publish End Date :</label>
                      <input type='date' id="publist_end_date" name='publist_end_date' value="<?=$publist_end_date;?>" required placeholder='Date'>
                      <i class="mandfeild">*</i>
                   </div>                
                </div>   
              </div>
            </div>
            <?php */?>

            <div class="col-md-12 bottom-border">
              <div class="col-md-4 no-padding display-center"><label for="">Contact Information</label></div>
              <div class="col-md-12">
                <div class="row">

                  <div class="col-md-3 full-input mr-3">
                    <label for='name'>Ad URl:</label>
                    <input type='text' name='adUrl' placeholder='advertisement Url' value="<?=$adUrl;?>">
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
                <div class="col-md-4 no-padding display-center"><label for="">Status</label></div>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-4 full-input-txtarea mr-3">
                      <input type="checkbox" name="status" class="statusToggle" <?php if($status == 1) { ?> checked <?php } ?> data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger">
                    </div>
                  </div>   
                </div>
            </div>

            <div class="clearfix">
               <div class="button-align">
                  <button type="submit" class="signupbtn custome-button"><span class="normal-class">Submit</span><span class="normal-icon"><i class="fas fa-check"></i></span></button>
                  <input type="text" name="adID" value="<?=$adID;?>" style="display: none;">
                  <input type="text" name="latitude" id="latitude" value="<?=$latitude;?>" style="display: none;">
                  <input type="text" name="longitude" id="longitude" value="<?=$longitude;?>" style="display: none;">
               </div>
            </div>
       </div>
      <?php echo form_close(); ?> 
   </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content-wrapper -->
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
<!-- <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/timepicker@1.11.12/jquery.timepicker.js"></script> -->


<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2019.1.220/styles/kendo.common-material.min.css" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2019.1.220/styles/kendo.material.min.css" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2019.1.220/styles/kendo.material.mobile.min.css" />
<script src="https://kendo.cdn.telerik.com/2019.1.220/js/kendo.all.min.js"></script>
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
        height: 200,
      },
      enforceBoundary: false,
      enableExif: true
    });

    $('#cropImagePop').on('shown.bs.modal', function () {
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
        size: { width: 150, height: 200 }
      }).then(function (resp) {
        $('#item-img-output').attr('src', resp);
        $('#hidden_image').val(resp);
        $('#cropImagePop').modal('hide');
      });
    });
</script>
<!-- End upload preview image  -->
<script type="text/javascript">
$(document).ready(function() {
  $('body').on('change', '#priceId', function(){
    if ($(this).val() != '') {
      $("#pon").attr('required', true);
    }
  });
  $('#priceId').change();
});

$(function(){
  $('input[type="radio"]').click(function(){
    var price = $('#priceId').val();
    if(price == '') { 
      alert('Please enter some price');
      $('.radioButton').prop('checked', false);
    }
  });
});
</script>

<!-- timepicker -->
<script>
// $(function() {
//   $('#timepicker').timepicker({
//   });
// });
// $(function() {
//   $('#timepicker1').timepicker({
//   });
// });

$(document).ready(function() {
  function startChange() {
    var startTime = start.value();
    if (startTime) {
      startTime = new Date(startTime);
      end.max(startTime);
      startTime.setMinutes(startTime.getMinutes() + this.options.interval);
      end.min(startTime);
      //end.value(startTime);
    }
  }

  //init start timepicker
  var start = $("#start").kendoTimePicker({
      change: startChange
  }).data("kendoTimePicker");

  //init end timepicker
  var end = $("#end").kendoTimePicker().data("kendoTimePicker");

  //define min/max range
  start.min("6:00 AM");
  start.max("11:00 PM");

  //define min/max range
  end.min("6:30 AM");
  end.max("11:30 PM");
});

</script>

<script>
  var placeSearch, autocomplete;
  var componentForm = {
    locality: 'long_name',
    postal_code: 'short_name'
  };
    
  function initAutocomplete() { 
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






<!-- 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"
        type="text/javascript"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/start/jquery-ui.css"
      rel="Stylesheet" type="text/css" /> -->

<script type="text/javascript">


var today = new Date().toISOString().split('T')[0];
//document.getElementsByName("publist_start_date")[0].setAttribute('min', today);


var start = document.getElementById('start_date');
var end = document.getElementById('end_date');

start.addEventListener('change', function() {
    if (start.value)
        end.min = start.value;
}, false);
end.addEventListener('change', function() {
    if (end.value)
        start.max = end.value;
}, false);

// var newstart = document.getElementById('publist_start_date');
// var newend = document.getElementById('publist_end_date');
// newstart.addEventListener('change', function() {
//     if (newstart.value)
//         newend.min = newstart.value;
// }, false);
// newend.addEventListener('change', function() {
//     if (newend.value)
//         newstart.max = newend.value;
// }, false);
</script>    