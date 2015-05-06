<?php $session = $this->session->userdata('user_session'); ?>
<script>
    //<![CDATA[
        jQuery(document).ready(function() {
            jQuery.validator.setDefaults({ ignore: ":hidden:not(select)" });
            jQuery("#add").validate({
                errorPlacement: function(error, element) {
                    if (element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                        error.appendTo(element.parent());
                    }
                    else {
                        error.insertAfter(element);
                    }
                }
            });

            jQuery('#supplier_id').change(function(){
                jQuery.ajax({
                    type: 'GET',
                    url: '<?php echo USER_URL ."get_product_by_supplier_selloffer/"; ?>' + jQuery('#supplier_id').val(),
                    success: function(data){
                        jQuery('#product_id').empty();
                        jQuery('#product_id').append(data);
                        jQuery("#product_id").trigger("chosen:updated");
                    }
                });
                jQuery(this).parent().find('.error').hide();
                jQuery('#product_id').parent().find('.error').hide();
            });

            jQuery('#product_id').change(function(){
                jQuery(this).parent().find('.error').remove();
            });

            jQuery('.summernote-sm').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ]
            });
        });
    //]]>
</script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('add') ,' ', $this->lang->line('supplierrequriment'); ?></h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form id="add" method="post" class="form-horizontal" action="<?php echo USER_URL . 'supplierrequriment/sms/send/' . $supplierrequriment->id; ?>">
            <?php for($i=0; $i<=4; $i++) { ?>
                <div class="form-group">
                    <label for="question" class="col-lg-2 control-label">
                        <?php echo $this->lang->line('supplierrequriment_mobile_no'); ?>
                        <span class="text-danger"><?php echo ($i == 0) ? '*' : ''; ?></span>
                    </label>
                    <div class="col-lg-9">
                        <input type="text" name="mobile[<?php echo $i; ?>]" maxlength="10" class="<?php echo ($i == 0) ? 'form-control required' : 'form-control'; ?>" placeholder="<?php echo $this->lang->line('supplierrequriment_mobile_no'); ?>"/>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="question" class="col-lg-2 control-label">
                    <?php echo $this->lang->line('supplierrequriment_description'); ?>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-9">
                    <textarea name="description" maxlength="160" class="required form-control" rows="5" onkeypress="return taLimit(this)" onkeyup="return taCount(this,'myCounter')"></textarea>
                    <p class="text-right mar-tp-10">Remaining word : <b class=" text-danger"><span id="myCounter">160</span></b></p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('supplierrequriment_sendsms'); ?>"><?php echo $this->lang->line('supplierrequriment_sendsms'); ?></button>
                    <a href="<?php echo USER_URL . 'supplierrequriment/sms/'. $supplierrequriment->id; ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label">&nbsp;</label>
                <div class="col-lg-9">
                    <?php echo $this->lang->line('compulsory_note'); ?>
                </div>
            </div>
        </form>
    </div>
</div>

<script language="Javascript">
    maxL=160;
    var bName = navigator.appName;
    function taLimit(taObj) {
        if (taObj.value.length==maxL) return false;
        return true;
    }
    function taCount(taObj,Cnt) { 
        objCnt=createObject(Cnt);
        objVal=taObj.value;
        if (objVal.length>maxL) objVal=objVal.substring(0,maxL);
        if (objCnt) {
            if(bName == "Netscape"){    
                objCnt.textContent=maxL-objVal.length;}
            else{objCnt.innerText=maxL-objVal.length;}
        }
        return true;
    }
    function createObject(objId) {
        if (document.getElementById) return document.getElementById(objId);
        else if (document.layers) return eval("document." + objId);
        else if (document.all) return eval("document.all." + objId);
        else return eval("document." + objId);
    }
</script>