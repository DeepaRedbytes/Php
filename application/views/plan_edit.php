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
  
<div class="machine-con add-user" id="content-wrapper">
  <div class="card0 mb-3">
    <div class="card-header primary-color"><i class="fas fa-users"></i> Edit Plan</div>
      <?php echo form_open('plan/edit/'.$plan['id']); ?>
          <div class="container no-padding">
              <div class="col-md-12 bottom-border">
                  <div class="row">
                    <div class="col-md-4 no-padding display-center">
                        <label for="email">Name</label>
                    </div>
                    <div class="col-md-8">
                      <input type="text" name="planname" placeholder="Plan Name" id="category" required value="<?php echo $plan['planname']?>">
                    </div>
                  </div>
              </div>
              <div class="col-md-12 bottom-border">
                  <div class="row">
                    <div class="col-md-4 no-padding display-center">
                        <label for="email">Type</label>
                    </div>
                    <div class="col-md-8">
                      <!-- <input type="text" name="type" placeholder="Plan type" id="category" required value="<?php //echo $plan['type']?>"> -->
                      <select required name="type">
                       <option disabled value="">Select</option>
                            <option value="service" <?php echo ($plan['type'] == 'service')?'selected':'service'?> ><?='service'?></option>
                            <option value="advertisement" <?php echo ($plan['type'] == 'advertisement')?'selected':'advertisement'?> ><?='advertisement'?></option>
                            <option value="event" <?php echo ($plan['type'] == 'event')?'selected':'event'?> ><?='event'?></option>                             
                     </select>

                    </div>
                  </div>
              </div>
              <div class="col-md-12 bottom-border">
                  <div class="row">
                    <div class="col-md-4 no-padding display-center">
                        <label for="email">Price</label>
                    </div>
                    <div class="col-md-8">
                      <input type="number" min="10" max="9999" name="price" placeholder="Plan price" id="category" required value="<?php echo $plan['price']?>">
                    </div>
              </div> 
              </div>    
              <div class="col-md-12 bottom-border">
                  <div class="row">
                    <div class="col-md-4 no-padding display-center">
                        <label for="email">Minimum Days</label>
                    </div>
                    <div class="col-md-8">
                      <input type="number" min="1" max="300" name="day" placeholder="Minimun days" id="day" required value="<?php echo $plan['day']?>">
                    </div>
              </div>  
              </div>    
              <div class="clearfix">
                  <div class="button-align">
                      <button type="submit" name="save_plan_btn" class="signupbtn custome-button"><span class="normal-class">Submit</span><span class="normal-icon"><i class="fas fa-check"></i></span></button>
                  </div>
              </div>
          </div>
      <?php echo form_close(); ?> 
  </div>
</div>
      <!-- /.content-wrapper -->
   

  <?php require_once('layouts/footer.php'); ?>            
  
  </body>

</html>
