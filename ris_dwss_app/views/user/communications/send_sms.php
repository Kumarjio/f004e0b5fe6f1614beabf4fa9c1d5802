<?php $session = $this->session->userdata('user_session'); ?>

<script>
    //<![CDATA[
        jQuery(document).ready(function() {
        	$('.select-all-checkbox').on('ifChecked', function(event){
			    $('.group-' + $(this).val()).iCheck('check');
			});

			$('.select-all-checkbox').on('ifUnchecked', function(event){
			    $('.group-' + $(this).val()).iCheck('uncheck');
			});
        });
    //]]>
</script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('communication_sendsms'); ?></h1>
        </div>
    </div>
</div>

<?php if(count($users_details) > 0){ ?>
	<div class="row">
		<div class="col-sm-12">
			<div class="tabbable tabs-left">
				<form id="add" method="post" class="form-horizontal" action="<?php echo USER_URL . 'communication/send'; ?>">
					<div class="form-group">
		            	<div class="col-lg-12">
							<ul id="sms_communication" class="nav nav-tabs tab-green">
								<?php $i = 0; ?>
								<?php foreach ($users_details as $key => $users_group) { ?>
									<li class="<?php echo (++$i == 1) ? 'active' : ''; ?>">
										<a href="#panel_tab<?php echo $key; ?>" data-toggle="tab">
											<i class="pink icon-cog"></i> <?php echo $users_group['name']; ?>
										</a>
									</li>
								<?php } ?>
							</ul>
							<div class="tab-content">
								<?php $i = 0; ?>
								<?php foreach ($users_details as $key => $users_group) { ?>
									<div class="tab-pane <?php echo (++$i == 1) ? 'active' : ''; ?>" id="panel_tab<?php echo $key; ?>">
										<h2 class="text-center"><?php echo $users_group['name']; ?></h2>
										<hr />
										<div class="">
											<label class="checkbox-inline">
					                            <input type="checkbox" value="<?php echo $key; ?>" class="square-grey select-all-checkbox">
					                            <?php echo $this->lang->line('communication_all_users'); ?>
					                        </label>
											<?php foreach ($users_group['users'] as $user) { ?>
												<label class="checkbox-inline">
						                            <input type="checkbox" value="<?php echo $user->id .'--'. $user->mobile . '--'. $user->email; ?>" name="users[]" class="square-grey group-<?php echo $key; ?>">
						                            <?php echo $user->supplier_name , ' ('. $user->shop_name .')'; ?>
						                        </label>
											<?php } ?>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>

					<div class="form-group">
		                <label for="question" class="col-lg-1 control-label">
		                    <?php echo $this->lang->line('communication_title'); ?>
		                    <span class="text-danger">&nbsp;</span>
		                </label>
		                <div class="col-lg-6">
		                    <input type="text" name="title"  class="form-control" placeholder="<?php echo $this->lang->line('communication_title'); ?>"/>
		                </div>
		            </div>

					<div class="form-group">
		                <label for="question" class="col-lg-1 control-label">
		                    <?php echo $this->lang->line('communication_description'); ?>
		                    <span class="text-danger">*</span>
		                </label>
		                <div class="col-lg-6">
		                    <textarea name="description" maxlength="160" class="required form-control" rows="5" onkeypress="return taLimit(this)" onkeyup="return taCount(this,'myCounter')"></textarea>
		                    <p class="text-right mar-tp-10">Remaining word : <b class=" text-danger"><span id="myCounter">160</span></b></p>
		                </div>
		            </div>

		            <div class="form-group">
		                <label class="col-lg-1 control-label">&nbsp;</label>
		                <div class="col-lg-6">
		                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('communication_sendsms'); ?>"><?php echo $this->lang->line('communication_sendsms'); ?></button>
		                    <a href="<?php echo USER_URL . 'communication' ?>" class="btn btn-default" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('cancel'); ?>"><?php echo $this->lang->line('cancel'); ?></a>
		                </div>
		            </div>
				</form>
			</div>
		</div>
	</div>
<?php } ?>

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