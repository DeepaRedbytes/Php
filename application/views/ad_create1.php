<?php require_once('layouts/header.php');  ?>

  

    <!-- Custom fonts for this template-->
    <link href="https://foliotek.github.io/Croppie/croppie.css" rel="stylesheet">


    <!-- STEPPER -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css"> -->
    <link rel="stylesheet" href="https://www.samclarke.com/assets/migrating-to-hugo/monokai.css">



        <div class="machine-con add-user" id="content-wrapper">



            <div class="card0 mb-3">
                <div class="card-header primary-color">
                    <i class="fas fa-users"></i>
                    Create Ad</div>

                <?php echo form_open('advertisement/create', ['id' => 'createCategoryForm','enctype'=>"multipart/form-data"]); ?>

                    <div class="section scrollspy" id="linear">
                        <div class="row">
                            <!-- <?php //echo //form_open('advertisement/create', ['id'=>'service_post']); ?> -->
                            
                            <div class="col l6 m12 s12">
                                
                                <div class="card">
                                    <div class="card-content">
                                        <ul class="stepper" id="myDIV">
                                            <li class="step active">
                                                <div data-step-label="There's labels too!"
                                                    class="step-title waves-effect waves-dark"> Give your
                                                    Ad a title</div>
                                                <div class="step-content">
                                                    <div class="row">
                                                        <div class="input-field col-10 s12">
                                                            <input name="title" type="text" class="validate" required>
                                                            <label for="text">Ad Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="step-actions">
                                                        <button class="signupbtn custome-button next-step"><span
                                                                class="submit-class">Continue</span></button>

                                                    </div>
                                                </div>
                                            </li>
                                            <li class="step">
                                                <div class="step-title waves-effect waves-dark"> Describe your service
                                                </div>
                                                <div class="step-content">
                                                    <div class="row">
                                                        <div class="input-field col-10 s12">
                                                            <textarea id name="desc" type="text" class="validate"
                                                                required></textarea>
                                                            <label for="text">short description</label>
                                                        </div>
                                                    </div>
                                                    <div class="step-actions">
                                                        <button class="signupbtn custome-button next-step"><span
                                                                class="submit-class">Continue</span></button>
                                                        <button class="signupbtn custome-button previous-step"><span
                                                                class="submit-class">Back</span></button>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="step">
                                                <div class="step-title waves-effect waves-dark"> Set status of your
                                                    service</div>
                                                <div class="step-content">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">

                                                                <div class="col-md-3 display-center">

                                                                    <input type="radio" name="status" value="yes" required>
                                                                    Active
                                                                </div>

                                                                <div class="col-md-3 display-center">
                                                                    <input type="radio" name="status" value="no" >
                                                                    Inactive
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="step-actions">
                                                        <button class="signupbtn custome-button next-step"><span
                                                                class="submit-class">Continue</span></button>
                                                        <button class="signupbtn custome-button previous-step"><span
                                                                class="submit-class">Back</span></button>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="step">
                                                <div class="step-title waves-effect waves-dark">Logo</div>
                                                <div class="step-content">
                                                    <div class="row">

                                                        <div class="col-md-8">
                                                            <label class="cabinet center-block">
                                                                <figure>
                                                                    <img src=""
                                                                        class="gambar img-responsive img-thumbnail"
                                                                        id="item-img-output" />
                                                                    <figcaption><i class="fa fa-camera"></i>
                                                                        <input type="file"
                                                                            class="item-img file center-block"
                                                                            name="logo" />
                                                                    </figcaption>

                                                                </figure>

                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="step-actions">
                                                        <button type="submit" class="signupbtn custome-button"><span
                                                                class="submit-class">Submit</span><span
                                                                class="submit-icon"><i
                                                                    class="fas fa-check"></i></span></button>
                                                        <button class="signupbtn custome-button previous-step"><span
                                                                class="submit-class">Back</span></button>
                                                    </div>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                 
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

<?php require_once('layouts/footer.php'); ?>

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
    <script>
        // Start upload preview image
        $(".gambar").attr("src", "<?= base_url();?>theme/img/logo.png");
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
            if (step.hasClass('invalid')) return;
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

                $stepper.
            
                // on("click", '.step:not(.active)', function () {
                //     object = $($stepper.children('.step:visible')).index($(this));
                //     if (!$stepper.hasClass('linear')) {
                //         $stepper.openStep(object + 1);
                //     } else {
                //         active = $stepper.find('.step.active');
                //         if ($($stepper.children('.step:visible')).index($(active)) + 1 == object) {
                //             $stepper.nextStep(true);
                //         } else if ($($stepper.children('.step:visible')).index($(active)) - 1 == object) {
                //             $stepper.prevStep();
                //         }
                //     }
                // })
                on("click", '.next-step', function (e) {
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

</body>

</html>