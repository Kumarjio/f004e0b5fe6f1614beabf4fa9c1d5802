<?php $session = $this->session->userdata('user_session'); ?>
<script type="text/javascript" >
    $(document).ready(function() {
        loadDatatable();
    });
</script>

<div class="row">
    <div class="col-sm-12 col-sm-12 col-md-12 col-lg-12">
        <div class="page-header">
            <h1><?php echo $this->lang->line('market_fee_structure'); ?></h1>
        </div>
    </div>
</div>

<form id="add" method="post" class="form-horizontal" action="<?php echo USER_URL . 'market/market_fee'; ?>">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="icon-cog"></i> <?php echo $this->lang->line('market_fees'); ?>
            <div class="panel-tools">
                <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
            </div>
        </div>
        <div class="panel-body"> 
            <div id="mainpanel" class="box-body table-responsive">
                <div class="form-group">
                    <label for="question" class="col-lg-3 control-label">
                        <?php echo $this->lang->line('market_fees'); ?>
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-6">
                        <input type="text" name="market_fee" class="form-control required" placeholder="<?php echo $this->lang->line('market_fees'); ?>" value="<?php echo $market_fees->market_fee; ?>"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="icon-cog"></i> <?php echo $this->lang->line('licence_fees'); ?>
            <div class="panel-tools">
                <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
            </div>
        </div>
        <div class="panel-body"> 
            <div id="mainpanel" class="box-body table-responsive">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="question" class="col-lg-3 control-label">
                                <?php echo $this->lang->line('licence_saikut_fee'); ?>
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                <input type="text" name="licence_saikut_fee" class="form-control required" placeholder="<?php echo $this->lang->line('licence_saikut_fee'); ?>" value="<?php echo $market_fees->licence_saikut_fee; ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="question" class="col-lg-3 control-label">
                                <?php echo $this->lang->line('licence_a_fee'); ?>
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                <input type="text" name="licence_a_fee" class="form-control required" placeholder="<?php echo $this->lang->line('licence_a_fee'); ?>" value="<?php echo $market_fees->licence_a_fee; ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="question" class="col-lg-3 control-label">
                                <?php echo $this->lang->line('licence_dalal_fee'); ?>
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                <input type="text" name="licence_dalal_fee" class="form-control required" placeholder="<?php echo $this->lang->line('licence_dalal_fee'); ?>" value="<?php echo $market_fees->licence_dalal_fee; ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="question" class="col-lg-3 control-label">
                                <?php echo $this->lang->line('licence_chutak_vapar_fee'); ?>
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                <input type="text" name="licence_chutak_vapar_fee" class="form-control required" placeholder="<?php echo $this->lang->line('licence_chutak_vapar_fee'); ?>" value="<?php echo $market_fees->licence_chutak_vapar_fee; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="question" class="col-lg-3 control-label">
                                <?php echo $this->lang->line('licence_processor_fee'); ?>
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                <input type="text" name="licence_processor_fee" class="form-control required" placeholder="<?php echo $this->lang->line('licence_processor_fee'); ?>" value="<?php echo $market_fees->licence_processor_fee; ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="question" class="col-lg-3 control-label">
                                <?php echo $this->lang->line('licence_a_1_fee'); ?>
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                <input type="text" name="licence_a_1_fee" class="form-control required" placeholder="<?php echo $this->lang->line('licence_a_1_fee'); ?>" value="<?php echo $market_fees->licence_a_1_fee; ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="question" class="col-lg-3 control-label">
                                <?php echo $this->lang->line('licence_vakrhai_fee'); ?>
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                <input type="text" name="licence_vakrhai_fee" class="form-control required" placeholder="<?php echo $this->lang->line('licence_vakrhai_fee'); ?>" value="<?php echo $market_fees->licence_vakrhai_fee; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="icon-cog"></i> <?php echo $this->lang->line('market_details'); ?>
            <div class="panel-tools">
                <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
            </div>
        </div>
        <div class="panel-body"> 
            <div id="mainpanel" class="box-body table-responsive">
                <div class="form-group">
                    <label for="question" class="col-lg-3 control-label">
                        <?php echo $this->lang->line('commission_100_unit_grain'); ?>
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-6">
                        <input type="text" name="commission_100_unit_grain" class="form-control required" placeholder="<?php echo $this->lang->line('commission_100_unit_grain'); ?>" value="<?php echo $market_fees->commission_100_unit_grain; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="question" class="col-lg-3 control-label">
                        <?php echo $this->lang->line('commission_100_unit_vegetable'); ?>
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-6">
                        <input type="text" name="commission_100_unit_vegetable" class="form-control required" placeholder="<?php echo $this->lang->line('commission_100_unit_vegetable'); ?>" value="<?php echo $market_fees->commission_100_unit_vegetable; ?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="icon-cog"></i> <?php echo $this->lang->line('weight_charges'); ?>
            <div class="panel-tools">
                <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
            </div>
        </div>
        <div class="panel-body"> 
            <div id="mainpanel" class="box-body table-responsive">
                <legend>Grains</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="question" class="col-lg-3 control-label">
                                    <?php echo $this->lang->line('weight_charge_till_50_grain'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" name="weight_charge_till_50_grain" class="form-control required" placeholder="<?php echo $this->lang->line('weight_charge_till_50_grain'); ?>" value="<?php echo $market_fees->weight_charge_till_50_grain; ?>" />
                                </div>
                            </div>        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="question" class="col-lg-3 control-label">
                                    <?php echo $this->lang->line('weight_charge_above_50_grain'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" name="weight_charge_above_50_grain" class="form-control required" placeholder="<?php echo $this->lang->line('weight_charge_above_50_grain'); ?>" value="<?php echo $market_fees->weight_charge_above_50_grain; ?>" />
                                </div>
                            </div>        
                        </div>
                    </div>

                <legend>Vegetables</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="question" class="col-lg-3 control-label">
                                    <?php echo $this->lang->line('weight_charge_till_50_vegetable'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" name="weight_charge_till_50_vegetable" class="form-control required" placeholder="<?php echo $this->lang->line('weight_charge_till_50_vegetable'); ?>" value="<?php echo $market_fees->weight_charge_till_50_vegetable; ?>" />
                                </div>
                            </div>        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="question" class="col-lg-3 control-label">
                                    <?php echo $this->lang->line('weight_charge_above_50_vegetable'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" name="weight_charge_above_50_vegetable" class="form-control required" placeholder="<?php echo $this->lang->line('weight_charge_above_50_vegetable'); ?>" value="<?php echo $market_fees->weight_charge_above_50_vegetable; ?>" />
                                </div>
                            </div>        
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="icon-cog"></i> <?php echo $this->lang->line('labour_fees'); ?>
            <div class="panel-tools">
                <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
            </div>
        </div>
        <div class="panel-body"> 
            <div id="mainpanel" class="box-body table-responsive">
                <legend>Grains</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="question" class="col-lg-3 control-label">
                                    <?php echo $this->lang->line('labour_charge_till_50_grain'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" name="labour_charge_till_50_grain" class="form-control required" placeholder="<?php echo $this->lang->line('labour_charge_till_50_grain'); ?>" value="<?php echo $market_fees->labour_charge_till_50_grain; ?>" />
                                </div>
                            </div>        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="question" class="col-lg-3 control-label">
                                    <?php echo $this->lang->line('labour_charge_above_50_grain'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" name="labour_charge_above_50_grain" class="form-control required" placeholder="<?php echo $this->lang->line('labour_charge_above_50_grain'); ?>" value="<?php echo $market_fees->labour_charge_above_50_grain; ?>" />
                                </div>
                            </div>        
                        </div>
                    </div>

                <legend>Vegetables</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="question" class="col-lg-3 control-label">
                                    <?php echo $this->lang->line('labour_charge_till_50_vegetable'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" name="labour_charge_till_50_vegetable" class="form-control required" placeholder="<?php echo $this->lang->line('labour_charge_till_50_vegetable'); ?>" value="<?php echo $market_fees->labour_charge_till_50_vegetable; ?>" />
                                </div>
                            </div>        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="question" class="col-lg-3 control-label">
                                    <?php echo $this->lang->line('labour_charge_above_50_vegetable'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" name="labour_charge_above_50_vegetable" class="form-control required" placeholder="<?php echo $this->lang->line('labour_charge_above_50_vegetable'); ?>" value="<?php echo $market_fees->labour_charge_above_50_vegetable; ?>" />
                                </div>
                            </div>        
                        </div>
                    </div>

                <hr />
                <div class="form-group">
                    <label for="question" class="col-lg-3 control-label">
                        <?php echo $this->lang->line('potato_oninon_per_bag'); ?>
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-6">
                        <input type="text" name="potato_oninon_per_bag" class="form-control required" placeholder="<?php echo $this->lang->line('potato_oninon_per_bag'); ?>" value="<?php echo $market_fees->potato_oninon_per_bag; ?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-12">
            <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line('update'); ?>"><?php echo $this->lang->line('update'); ?></button>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-12">
            <?php echo $this->lang->line('compulsory_note'); ?>
        </div>
    </div>
</form>