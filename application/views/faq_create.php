<?php require_once('layouts/header.php');  
$faqID = "";
$question = "";
$answer = ""; 
//$status = 1; 
if(!empty($faqDetail)) { 
    if(!empty($faqDetail['_id'])) {  $faqID = (string)$faqDetail['_id']; }
    $question = $faqDetail['question'];
    $answer = $faqDetail['answer'];
    //$status = $faqDetail['status'];
}?>

<div class="machine-con" id="content-wrapper">
    <div class="card0 mb-3">
        <div class="card-header primary-color">
            <i class="fas fa-users"></i>FAQ'S<div class="add-align"></div>
        </div>
        <div class="card-body">
            <div class="content">
                <div class="container-fluid">
                    <section class="content-wrap">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="_01_colBox">
                                    <?php echo form_open('faq/create', ['id' => 'createFaqForm','enctype'=>"multipart/form-data"]); ?>
                                    <div class="box-info">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="question" name="question" placeholder="Title" required="required" maxlength="100" value="<?=$question?>">
                                        </div>
                                        <div class="_eidt-01">
                                            <!-- <textarea id="answer" name="answer"><?=$answer;?></textarea> -->
                                            <textarea name="answer" placeholder="Answer" rows="6" cols="119"  maxlength="700" required><?=$answer;?></textarea>
                                        </div>
                                        <button type="submit" class="btn  btn-primary"  onclick="textSubmit()"><span class="normal-class">Save</span><span class="normal-icon"><i class="fas fa-check"></i></span></button>
                                    </div>
                                    <input type="text" name="faqID" value="<?=$faqID;?>" style="display: none;">
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
<script>
    $(document).ready(function () {
        //$("#answer").Editor();
    });
</script>
<script>
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $(".hd-menu").toggleClass("toggled");
    });
    $(document).ready(function () {
        $(".js-sidebar-expand").click(function () {
            $("body").toggleClass("sbr-btn-toggle");
        });
    });

//     function textSubmit() {
//   var text = $("#answer").val();
//   console.log(text);
//   console.log("here");
  
//   var htmlText = $(text).text();
//   console.log(htmlText);
// }
</script>