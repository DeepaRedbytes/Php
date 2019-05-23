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
  height: 163px;
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
.validationError{
  color: red;
  font-size: 13px;
}
</style>

<?php 
$evntID = ""; 
$title = ""; 
$venue = ""; 
$location = ""; 
$latitude = ""; 
$longitude = ""; 
$type = "";
$language = ""; 
$duration = ""; 
$age = ""; 
$price = "";
$paymentmode = "";
$eventUrl = "";
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
$publist_end_date = ""; 
$publist_start_date = ""; 
$status = 1; 

if(!empty($eventDetail)) { 
    if(!empty($eventDetail['_id'])) {  $evntID = (string)$eventDetail['_id']; }
    $title = $eventDetail['title'];
    $venue = $eventDetail['venue'];
    $location = $eventDetail['location'];
    $latitude = $eventDetail['latitude'];
    $longitude = $eventDetail['longitude'];
    $type = $eventDetail['type'];
    $language = $eventDetail['language'];
    $duration = $eventDetail['duration'];
    $age = $eventDetail['age'];
    $price = $eventDetail['price'];
    $paymentmode = $eventDetail['paymentmode'];
    $eventUrl = $eventDetail['eventUrl'];
    $start_date = $eventDetail['start_date'];
    $start_time = $eventDetail['start_time'];
    $end_date = $eventDetail['end_date'];
    $end_time = $eventDetail['end_time'];
    $description = $eventDetail['description'];
    $terms = $eventDetail['terms']; 
    if(!empty($eventDetail['thumbnail'])) { $thumbnail = $eventDetail['thumbnail']; }
    if(!empty($eventDetail['thumbnail'])) { $thumbnailInput = $eventDetail['thumbnail']; }
    if(!empty($eventDetail['banner_image'])) { $banner_image = $eventDetail['banner_image']; }
    if(!empty($eventDetail['banner_image'])) { $banner_imageInput = $eventDetail['banner_image']; }

    if(!empty($eventDetail['publist_start_date'])) { 
      $publist_start_date = $eventDetail['publist_start_date'];
    }
    if(!empty($eventDetail['publist_end_date'])) { 
      $publist_end_date = $eventDetail['publist_end_date']; 
    }    
    $status = $eventDetail['status'];
}?>

<div class="machine-con add-user" id="content-wrapper">
  <div class="card0 mb-3">
    <div class="card-header primary-color"><i class=""></i>Create Event</div>

<?php //echo validation_errors('<div class="error">', '</div>'); ?>

      <?php /* if($this->session->flashdata('error')){ ?>
        <div class="row">
                  <div class="col-md-12">
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                </div>
            </div>
        </div>
        <?php }*/ ?>


      <?php echo form_open('event/create', ['id' => 'createEventForm','enctype'=>"multipart/form-data"]); ?>
        <div class="no-padding">
          <div class="col-md-12 bottom-border">
            <div class="col-md-4 no-padding display-center"><label for="">Information about Event</label></div>
            <div class="col-md-12"> 
              <div class="row">
                <div class="col-md-6 full-input fx-w mr-3">
                    <label for='name'>Event title/name :</label>
                    <input type='text' name='title' placeholder='Event title' value="<?=$title;?>" required>
                    <i class="mandfeild">*</i>
                </div>
                <div class="col-md-6 full-input fx-w mr-3">
                    <label for='name'>Venue :</label>                    
                    <input type='text' name='venue' placeholder='Ex : Amanora Mall Pune' required value="<?=$venue;?>" required>
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
                     <label for='name'>Event type :</label>
                     <input type='text' name='type' placeholder='Dance, Singing,..' value="<?=$type;?>" required><i class="mandfeild">*</i>
                   </div>
                   <div class="col-md-3 full-input mr-3">
                       <label for='name'>Language :</label>
                       <input type='text' name='language' placeholder='English' value="<?=$language;?>">
                   </div>
                   <div class="col-md-2 full-input mr-3">
                       <label for='name'>Duration :</label>
                       <input type='text' name='duration' id="duration" placeholder='1:30 Hrs' value="<?=$duration;?>">  <!-- min="1" max="5" -->
                   </div>
                   <div class="col-md-2 full-input mr-3">
                      <label for='name'>Age :</label>
                      <input type='text' name='age' id="age" placeholder='4+' value="<?=$age;?>">
                  </div>
              </div>

              <div class="row">
                <div class="col-md-3 full-input mr-3">
                    <label for='name'>Price:</label>
                    <input type='text' name='price' placeholder='500' value="<?=$price;?>">
                </div>
                <div class="col-md-3 full-input mr-3">
                    <label for='name'>Event URl:</label>
                    <input type='text' name='eventUrl' placeholder='event Url' value="<?=$eventUrl;?>">
                </div>
                <div class="col-md-4 full-input mr-3">
                    <label for='name'>Payment Method:</label>
                    <input type='text' name='paymentmode' placeholder='Paypal' value="<?=$paymentmode;?>">
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
                      <input type='date' name='start_date' placeholder='Dance, Singing,..' value="<?=$start_date;?>" required><i class="mandfeild">*</i>
                  </div>
                  <div class="col-md-2 full-input mr-3">
                      <label for='name'>Time :</label>
                      <input id="timepicker" placeholder="00:00" name="start_time" class="validate ui-timepicker-input" equired="" autocomplete="off" value="<?=$start_time;?>">
                  </div>
                  <div class="col-md-3 full-input mr-3">
                      <label for='name'>End Date :</label>
                      <input type='date' name='end_date' placeholder='English' value="<?=$end_date;?>">
                  </div>
                  <div class="col-md-2 full-input mr-3">
                      <label for='name'>Time :</label>
                      <input id="timepicker1" placeholder="00:00" name="end_time" class="validate ui-timepicker-input" equired="" autocomplete="off" value="<?=$end_time;?>">
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
                        <figcaption><i class="fa fa-camera"></i>
                          <?php if(empty($thumbnailInput)) { ?>
                            <input type="file" id="imageOption" class="item-img file center-block" name="thumbnail" required />
                          <?php } else {  ?>
                            <input type="file" id="imageOption" class="item-img file center-block" name="thumbnail" />
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
                      <figure style="width: 304px;">
                        <img src="<?= base_url();?><?=$banner_image;?>" class="gambar img-responsive img-thumbnail" id="item-img-output-banner" />
                        <figcaption><i class="fa fa-camera"></i>
                          <?php if(empty($banner_imageInput)) { ?>
                            <input type="file" id="imageOption1" class="item-img-banner file center-block" name="banner_image" required />
                          <?php } else {  ?>
                            <input type="file" id="imageOption1" class="item-img-banner file center-block" name="banner_image" />
                          <?php } ?>
                        </figcaption>
                      </figure>
                    </label>   
                  </div>
                  </div>
                </div>   
              </div>
            </div> 

            <div class="col-md-12 bottom-border">
              <div class="col-md-4 no-padding display-center"><label for="">Admin Options</label></div>
              <div class="col-md-12">
                <div class="row">
                   <div class="col-md-4 full-input mr-3">
                      <label for='name'>Publish Start Date :</label>
                      <input type='date' name='publist_start_date' value="<?=$publist_start_date;?>" required>
                      <i class="mandfeild">*</i>
                   </div>
                   <div class="col-md-4 full-input mr-3">
                      <label for='name'>Publish End Date :</label>
                      <input type='date' name='publist_end_date' value="<?=$publist_end_date;?>" required>
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
                  <input type="text" name="eventID" value="<?=$evntID;?>" style="display: none;">
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
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/timepicker@1.11.12/jquery.timepicker.js"></script>

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
        width: 300,
        height: 180,
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
        size: { width: 360, height: 230 }
      }).then(function (resp) {
        $('#item-img-output-banner').attr('src', resp);
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
        size: { width: 150, height: 200 }
      }).then(function (resp) {
        $('#item-img-output').attr('src', resp);
        $('#cropImagePop').modal('hide');
      });
    });
</script>
<!-- End upload preview image  -->


<!-- timepicker -->
<script>
  $(function() {
    $('#timepicker').timepicker({
      //timeFormat: 'h:mm p',
      dynamic: false,
      dropdown: true,
      scrollbar: true
    });
  });
  $(function() {
    $('#timepicker1').timepicker({
      //timeFormat: 'h:mm p',
      dynamic: false,
      dropdown: true,
      scrollbar: true
    });
  });
</script>
<script type="text/javascript">
$('#duration').keypress(function(event) {
  if ((event.which != 58 || $(this).val().indexOf(':') != -1) && (event.which < 48 || event.which > 57)) {
    event.preventDefault();
  }
});

$('#age').keypress(function(event) {
  if ((event.which != 43 || $(this).val().indexOf('+') != -1) && (event.which < 48 || event.which > 57)) {
    event.preventDefault();
  }
});
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
    registration.addListener('place_changed', fillInRegistrationAddress);
  }




    function fillInAddress() {      
      var place = autocomplete.getPlace();
      var lat = place.geometry.location.lat(),
      lng = place.geometry.location.lng(); 
      $("#latitude").val(lat);        
      $("#longitude").val(lng);
    }

      
    // function geolocate() {          
    //   if (navigator.geolocation) {
    //     navigator.geolocation.getCurrentPosition(function(position) {
    //       var geolocation = {
    //         lat: position.coords.latitude,
    //         lng: position.coords.longitude
    //       };
    //       console.log("Geolocation:"+geolocation);
    //       var circle = new google.maps.Circle({
    //         center: geolocation,
    //         radius: position.coords.accuracy
    //       }); 
    //       autocomplete.setBounds(circle.getBounds());
    //     });
    //   } 
    // }

    // function geolocateZip() {
    //   if (navigator.geolocation) {
    //     navigator.geolocation.getCurrentPosition(function(position) {
    //       var geolocation = {
    //         lat: position.coords.latitude,
    //         lng: position.coords.longitude
    //       };
    //       console.log("Geolocation:"+geolocation);
    //       var circle = new google.maps.Circle({
    //         center: geolocation,
    //         radius: position.coords.accuracy
    //       });            
    //       zipuser.setBounds(circle.getBounds());
    //     });
    //   } 
    // }
      
      
    // function geolocateAddEdit() {
    //   if (navigator.geolocation) {
    //     navigator.geolocation.getCurrentPosition(function(position) {
    //       var geolocation = {
    //         lat: position.coords.latitude,
    //         lng: position.coords.longitude
    //       };
    //       console.log("Geolocation:"+geolocation);
    //       var circle = new google.maps.Circle({
    //         center: geolocation,
    //         radius: position.coords.accuracy
    //       });
    //       addEdit.setBounds(circle.getBounds());
    //     });
    //   } 
    // }
      
    // function geolocateRegistration() {
    //   if (navigator.geolocation) {
    //     navigator.geolocation.getCurrentPosition(function(position) {
    //       var geolocation = {
    //         lat: position.coords.latitude,
    //         lng: position.coords.longitude
    //       };
    //       console.log("Geolocation:"+geolocation);
    //       var circle = new google.maps.Circle({
    //         center: geolocation,
    //         radius: position.coords.accuracy
    //       });            
    //       registration.setBounds(circle.getBounds());
    //     });
    //   } 
    // }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhwbcYBb4yFbB39UJlTuDLnpD95R_9PD8&libraries=places&callback=initAutocomplete" async defer></script>        