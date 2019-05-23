<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>CS | Add User</title>

  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/style.css" rel="stylesheet">
  <link href="https://foliotek.github.io/Croppie/croppie.css" rel="stylesheet">

  <!-- STEPPER -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css"> -->
  <link rel="stylesheet" href="https://www.samclarke.com/assets/migrating-to-hugo/monokai.css">

  <!-- END STEPPER -->


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
      width: 160px;
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
  </style>

</head>

<body class="machine" id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top no-padding">


    <a class="navbar-brand mr-1" href="index.html"><img class=" logo text-center" src="img/logo.png" />Community
      Services</a>

    <button class="btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <img class=" mennu text-center" src="img/menu.png" />
    </button>

    <!-- Navbar Search -->
    <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

    </div>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">


      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw circle-css"></i><i class="fas fa-sort-down align-drop"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="#">Activity Log</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <span class="logout">Logout</span><span><img class=" log-image text-center" src="img/logout.png" /></a></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="#">Activity Log</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">

      <li class="nav-item active">
        <a class="nav-link main-link " href="dashboard.html">
          <i class="fas fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link main-link" href="user.html">
          <i class="fas fa-users"></i>
          <span>User List</span>
        </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link main-link activeclass" href="service_list.html">
          <i class="fas fa-cogs"></i>
          <span>Service List</span>
        </a>
      </li>

      <li class="nav-item active">
        <a class="nav-link main-link" href="category_list.html">
          <i class="fas fa-list-alt"></i>
          <span>Categories List</span>
        </a>
      </li>
      <li class="nav-item active">
          <a class="nav-link main-link" href="ads_request.html">
          
            <i class="fas fa-ad"></i>
            <span>Ads Request</span>
          </a>
        </li>

          <li class="nav-item active">
              <a class="nav-link main-link ">
                  <i class="fas fa-file-contract"></i>
                  <span>Legal</span>
              </a>
              <ul class="submenu navbar-nav">
                  <li class="nav-item active"><a class="nav-link main-link" href="about_us.html">About Us</a></li>
                  <li class="nav-item active"><a class="nav-link main-link" href="terms_condition.html">Terms and condition</a></li>
                  <li class="nav-item active"><a class="nav-link main-link" href="faq.html">Faq's</a></li>
              </ul>
          </li>
    </ul>


    <div class="machine-con add-user" id="content-wrapper">



      <div class="card0 mb-3">
        <div class="card-header primary-color">
          <i class="fas fa-users"></i>
          Create Service</div>
        <form action="#">

          <div class="section scrollspy" id="linear">
            <div class="row">

              <div class="col l6 m12 s12">
                <div class="card">
                  <div class="card-content">
                    <ul class="stepper" id="myDIV">
                      <li class="step active">
                        <div data-step-label="There's labels too!" class="step-title waves-effect waves-dark"> Give your
                          service a title</div>
                        <div class="step-content">
                          <div class="row">
                            <div class="input-field col-10 s12">
                              <input name="email" type="text" class="validate" required>
                              <label for="text">Service Name</label>
                            </div>
                          </div>
                          <div class="step-actions">
                            <button class="signupbtn custome-button next-step"><span
                                class="normal-class">Continue</span></button>

                          </div>
                        </div>
                      </li>
                      <li class="step">
                        <div class="step-title waves-effect waves-dark"> Describe your service</div>
                        <div class="step-content">
                          <div class="row">
                            <div class="input-field col-10 s12">
                              <textarea id name="desc" type="text" class="validate" required></textarea>
                              <label for="text">short description</label>
                            </div>
                          </div>
                          <div class="step-actions">
                            <button class="signupbtn custome-button next-step"><span
                                class="normal-class">Continue</span></button>
                            <button class="signupbtn custome-button previous-step"><span
                                class="normal-class">Back</span></button>
                          </div>
                        </div>
                      </li>
                      <li class="step">
                        <div class="step-title waves-effect waves-dark"> Set the date of your service</div>
                        <div class="step-content">
                          <div class="row">
                            <div class="input-field col-md-5 s12">
                              <input id name="date" type="date" class="validate" required>
                              <label for="date">Start Date</label>
                            </div>
                            <div class="input-field col-md-5 s12">
                              <input id name="date" type="date" class="validate" required>
                              <label for="date">End Date</label>
                            </div>
                          </div>

                          <div class="step-actions">
                            <button class="signupbtn custome-button next-step"><span
                                class="normal-class">Continue</span></button>
                            <button class="signupbtn custome-button previous-step"><span
                                class="normal-class">Back</span></button>
                          </div>
                        </div>
                      </li>
                      <li class="step">
                        <div class="step-title waves-effect waves-dark">Location</div>
                        <div class="step-content">
                          <div class="row">
                            <div class="input-field col-10 s12">
                              <input id name="password" type="text" class="validate" required>
                              <label for="text">Location</label>
                            </div>
                          </div>
                          <div class="step-actions">
                            <button class="signupbtn custome-button next-step"><span
                                class="normal-class">Continue</span></button>
                            <button class="signupbtn custome-button previous-step"><span
                                class="normal-class">Back</span></button>
                          </div>
                        </div>
                      </li>
                      <li class="step">
                        <div class="step-title waves-effect waves-dark">Service Type</div>
                        <div class="step-content">
                          <div class="row">
                            <div class="input-field col-10 s12">
                              <select required>
                                <option value="">Select</option>
                                <option value="type">type</option>
                                <option value="type">type</option>
                                <option value="type">type</option>
                              </select>
                              <label for="password">Service Type</label>
                            </div>
                          </div>
                          <div class="step-actions">
                            <button class="signupbtn custome-button next-step"><span
                                class="normal-class">Continue</span></button>
                            <button class="signupbtn custome-button previous-step"><span
                                class="normal-class">Back</span></button>
                          </div>
                        </div>
                      </li>
                      <li class="step">
                        <div class="step-title waves-effect waves-dark">Media</div>
                        <div class="step-content">
                          <div class="row">

                            <div class="input-field col-10 s12 field">
                              <input type="file" id="files" name="files[]" multiple class="validate" required>
                              <label for="password">Upload your images</label>
                            </div>
                          </div>
                          <div class="step-actions">
                            <button class="signupbtn custome-button"><span class="normal-class">Submit</span><span
                                class="normal-icon"><i class="fas fa-check"></i></span></button>
                            <button class="signupbtn custome-button previous-step"><span
                                class="normal-class">Back</span></button>
                          </div>
                        </div>
                      </li>
                      <!-- <li class="step">
                      <div class="step-title waves-effect waves-dark">Step 3</div>
                      <div class="step-content">
                        Finish!
                        <div class="clearfix">
                            <div class="button-align">
                              <button type="submit" class="signupbtn custome-button"><span class="normal-class">Submit</span><span class="normal-icon"><i class="fas fa-check"></i></span></button>
                            </div>
                          </div>


                        

                        
                      </div>
                    </li> -->

                    </ul>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </form>


      </div>
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

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>



  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/admin.min.js"></script>
  <script src="js/demo/datatables-demo.js"></script>
  <script src="https://foliotek.github.io/Croppie/croppie.js"></script>
  <!-- filepond js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.3/js/foundation.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.3/js/foundation/foundation.clearing.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

  <!-- STEPPER FORM -->
  <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script> -->
  <script src="js/materialize.js"></script>


  <script>


    // Start upload preview image
    $(".gambar").attr("src", "img/logo.png");
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
    $('#cropImagePop').on('shown.bs.modal', function () {
      //	alert('Shown pop');
      $uploadCrop.croppie('bind', {
        url: rawImg
      }).then(function () {
        console.log('jQuery bind complete');
      });
    });

    $('.item-img').on('change', function () {
      imageId = $(this).data('id'); tempFilename = $(this).val();
      $('#cancelCropBtn').data('id', imageId); readFile(this);
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
            // End upload preview image
  </script>




  <script>
    $(document).ready(function () {
      if (window.File && window.FileList && window.FileReader) {
        $("#files").on("change", function (e) {
          var files = e.target.files,
            filesLength = files.length;
          for (var i = 0; i < filesLength; i++) {
            var f = files[i]
            var fileReader = new FileReader();
            fileReader.onload = (function (e) {
              var file = e.target;
              $("<span class=\"pip\">" +
                "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                "<br/><span class=\"remove\">Remove image</span>" +
                "</span>").insertAfter("#files");
              $(".remove").click(function () {
                $(this).parent(".pip").remove();
              });

              // Old code here
              /*$("<img></img>", {
                class: "imageThumb",
                src: e.target.result,
                title: file.name + " | Click to remove"
              }).insertAfter("#files").click(function(){$(this).remove();});*/

            });
            fileReader.readAsDataURL(f);
          }
        });
      } else {
        alert("Your browser doesn't support to File API")
      }
    });

  </script>


  <script>
    $(document).ready(function () {
      var next = 1;
      $(".add-more").click(function (e) {
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
        $("#field" + next).attr('data-source', $(addto).attr('data-source'));
        $("#count").val(next);

        $('.remove-me').click(function (e) {
          e.preventDefault();
          var fieldNum = this.id.charAt(this.id.length - 1);
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

      function getFile(e) {
        let file = e.currentTarget.files[0];
        checkType(file);
      }

      function previewImage(file) {
        let thumb = box.querySelector('.js--image-preview'),
          reader = new FileReader();

        reader.onload = function () {
          thumb.style.backgroundImage = 'url(' + reader.result + ')';
        }
        reader.readAsDataURL(file);
        thumb.className += ' js--no-default';
      }

      function checkType(file) {
        let imageType = /image.*/;
        if (!file.type.match(imageType)) {
          throw 'Datei ist kein Bild';
        } else if (!file) {
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
    function initDropEffect(box) {
      let area, drop, areaWidth, areaHeight, maxDistance, dropWidth, dropHeight, x, y;

      // get clickable area for drop effect
      area = box.querySelector('.js--image-preview');
      area.addEventListener('click', fireRipple);

      function fireRipple(e) {
        area = e.currentTarget
        // create drop
        if (!drop) {
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
        x = e.pageX - this.offsetLeft - (parseInt(dropWidth, 10) / 2);
        y = e.pageY - this.offsetTop - (parseInt(dropHeight, 10) / 2) - 30;

        // position drop and animate
        drop.style.top = y + 'px';
        drop.style.left = x + 'px';
        drop.className += ' animate';
        e.stopPropagation();

      }
    }

  </script>

  <!-- stepper form validation -->
  <script>
    var validation = $.isFunction($.fn.valid) ? 1 : 0;

    $.fn.isValid = function () {
      if (validation) {
        return this.valid();
      } else {
        return true;
      }
    };

    if (validation) {
      $.validator.setDefaults({
        errorClass: 'invalid',
        validClass: "valid",
        errorPlacement: function (error, element) {
          if (element.is(':radio') || element.is(':checkbox')) { // Input checkboxes or radio, maybe switches?
            error.insertBefore($(element).parent());
          } else {
            error.insertAfter(element); // default error placement.
            // element.closest('label').data('error', error);
            // element.next().attr('data-error', error);
          }
        },
        success: function (element) {
          if (!$(element).closest('li').find('label.invalid:not(:empty)').length) {
            $(element).closest('li').removeClass('wrong');
          }
        }
      });
    }

    $.fn.getActiveStep = function () {
      active = this.find('.step.active');
      return $(this.children('.step:visible')).index($(active)) + 1;
    };

    $.fn.activateStep = function () {
      $(this).addClass("step").stop().slideDown(function () {
        $(this).css({
          'height': 'auto',
          'margin-bottom': ''
        });
      });
    };

    $.fn.deactivateStep = function () {
      $(this).removeClass("step").stop().slideUp(function () {
        $(this).css({
          'height': 'auto',
          'margin-bottom': '10px'
        });
      });
    };

    $.fn.showError = function (error) {
      if (validation) {
        name = this.attr('name');
        form = this.closest('form'); // Change if not using FORM elements
        var obj = {};
        obj[name] = error;
        form.validate().showErrors(obj);
        this.closest('li').addClass('wrong');
      } else {
        this.removeClass('valid').addClass('invalid');
        this.next().attr('data-error', error);
      }
    };



    $.fn.destroyFeedback = function () {
      active = this.find('.step.active.feedbacking');
      if (active) {
        active.removeClass('feedbacking');
        active.find('.step-content').find('.wait-feedback').remove();
      }
      return true;
    };

    $.fn.resetStepper = function (step) {
      if (!step) step = 1;
      form = $(this).closest('form'); // Change if not using FORM elements
      $(form)[0].reset();
      Materialize.updateTextFields();
      return $(this).openStep(step);
    };

    $.fn.submitStepper = function (step) {
      form = this.closest('form'); // Change if not using FORM elements
      if (form.isValid()) {
        form.submit();
      }
    };

    $.fn.nextStep = function (ignorefb) {
      stepper = this;
      form = this.closest('form');
      active = this.find('.step.active');
      next = $(this.children('.step:visible')).index($(active)) + 2;
      feedback = $(active.find('.step-content').find('.step-actions').find('.next-step')).data("feedback");
      if (form.isValid()) {
        if (feedback && ignorefb) {
          stepper.activateFeedback();
          return window[feedback].call();
        }
        active.removeClass('wrong').addClass('done');
        this.openStep(next);
        return this.trigger('nextstep');
      } else {
        return active.removeClass('done').addClass('wrong');
      }
    };

    $.fn.prevStep = function () {
      active = this.find('.step.active');
      prev = $(this.children('.step:visible')).index($(active));
      active.removeClass('wrong');
      this.openStep(prev);
      return this.trigger('prevstep');
    };

    $.fn.openStep = function (step, callback) {
      $this = this;
      step_num = step - 1;
      step = this.find('.step:visible:eq(' + step_num + ')');
      if (step.hasClass('active')) return;
      active = this.find('.step.active');
      prev_active = next = $(this.children('.step:visible')).index($(active));
      order = step_num > prev_active ? 1 : 0;
      if (active.hasClass('feedbacking')) $this.destroyFeedback();
      active.closeAction(order);
      step.openAction(order, function () {
        $this.trigger('stepchange').trigger('step' + (step_num + 1));
        if (step.data('event')) $this.trigger(step.data('event'));
        if (callback) callback();
      });
    };

    $.fn.closeAction = function (order, callback) {
      closable = this.removeClass('active').find('.step-content');
      if (!this.closest('ul').hasClass('horizontal')) {
        closable.stop().slideUp(300, "easeOutQuad", callback);
      } else {
        if (order == 1) {
          closable.animate({
            left: '-100%'
          }, function () {
            closable.css({
              display: 'none',
              left: '0%'
            }, callback);
          });
        } else {
          closable.animate({
            left: '100%'
          }, function () {
            closable.css({
              display: 'none',
              left: '0%'
            }, callback);
          });
        }
      }
    };

    $.fn.openAction = function (order, callback) {
      openable = this.removeClass('done').addClass('active').find('.step-content');
      if (!this.closest('ul').hasClass('horizontal')) {
        openable.slideDown(300, "easeOutQuad", callback);
      } else {
        if (order == 1) {
          openable.css({
            left: '100%',
            display: 'block'
          }).animate({
            left: '0%'
          }, callback);
        } else {
          openable.css({
            left: '-100%',
            display: 'block'
          }).animate({
            left: '0%'
          }, callback);
        }
      }
    };

    $.fn.activateStepper = function () {
      $(this).each(function () {
        var $stepper = $(this);
        if (!$stepper.parents("form").length) {
          method = $stepper.data('method');
          action = $stepper.data('action');
          method = (method ? method : "GET");
          action = (action ? action : "?");
          $stepper.wrap('<form action="' + action + '" method="' + method + '"></div>');
        }
        $stepper.find('li.step.active').openAction(1);

        $stepper
          // .on("click", '.step:not(.active)', function () {
          //   object = $($stepper.children('.step:visible')).index($(this));
          //   if (!$stepper.hasClass('linear')) {
          //     $stepper.openStep(object + 1);
          //   } else {
          //     active = $stepper.find('.step.active');
          //     if ($($stepper.children('.step:visible')).index($(active)) + 1 == object) {
          //       $stepper.nextStep(true);
          //     } else if ($($stepper.children('.step:visible')).index($(active)) - 1 == object) {
          //       $stepper.prevStep();
          //     }
          //   }
          // })
          .on("click", '.next-step', function (e) {
            e.preventDefault();
            $stepper.nextStep(true);
          }).on("click", '.previous-step', function (e) {
            e.preventDefault();
            $stepper.prevStep();
            // May want to ammend to 'a' tag for R purposes or more than likely use an ID selector
            // for shiny observer purposes... so for R if the action button for submissions was 
            // `input$form_step_submit`:
            //}).on("click", "#form_step_submit", function(e) { 
          }).on("click", "button:submit:not(.next-step, .previous-step)", function (e) {
            e.preventDefault();
            form = $stepper.closest('form');
            if (form.isValid()) {
              form.submit();
            }
          });
      });
    };

    function someFunction() {
      setTimeout(function () {
        $('#feedbacker').nextStep();
      }, 200);
    }
    $(document).ready(function () {
      $('ul.tabs').tabs()
      $('.rt-select').material_select();
      //Init for stepper
      $('.stepper').activateStepper();
      //$(selector).nextStep();

    });
  </script>


  <!-- steper form horizontal/vertical at mobile view -->
  <!-- <script>
    function myFunction(x) {
      if (x.matches) { // If media query matches
        var element = document.getElementById("myDIV");
      element.classList.remove("horizontal");
    
      } else {
        var element = document.getElementById("myDIV");
      element.classList.add("horizontal");
        
      }
    }
    
    var x = window.matchMedia("(max-width: 850px)")
    myFunction(x) // Call listener function at run time
    x.addListener(myFunction) // Attach listener function on state changes
    </script> -->

</body>

</html>