<?php if($store_id > 0) pageHeader(lang('edit_store')); else pageHeader(lang('create_store'));?>

<?php echo form_open_multipart('admin/settings/form_store/'.$store_id);?>
    <fieldset>
        <legend><?php echo lang('shop_details');?></legend>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Store Name</label>
                    <?php echo form_input(array('class'=>'form-control', 'name'=>'store_name', 'value'=>assign_value('store_name', $store_name)));?>
                </div>
            </div>
			
			<div class="col-md-3">
                <div class="form-group">
                    <label>Domain Name</label>
                    <?php echo form_input(array('class'=>'form-control', 'name'=>'domain', 'value'=>assign_value('domain', $domain)));?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Theme</label>
                    <?php echo form_input(array('class'=>'form-control', 'name'=>'theme', 'value'=>assign_value('theme', $theme), 'class' => 'form-control'));?>
                </div>
            </div>            
			<div class="col-md-3">
                <div class="form-group">
                    <label>Styles</label>
                    <?php echo form_input(array('class'=>'form-control', 'name'=>'style', 'value'=>assign_value('style', $style), 'class' => 'form-control'));?>
                </div>
            </div>            
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Price (+ X%)</label>
                    <?php echo form_input(array('class'=>'form-control', 'name'=>'config_price', 'value'=>assign_value('config_price', $config_price), 'class' => 'form-control'));?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label><?php echo lang('default_meta_keywords');?></label>
                    <?php echo form_input(array('class'=>'form-control', 'name'=>'default_meta_keywords', 'value'=>assign_value('default_meta_keywords', $default_meta_keywords), 'class' => 'form-control'));?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label><?php echo lang('default_meta_description');?></label>
                    <?php echo form_input(array('class'=>'form-control', 'name'=>'default_meta_description', 'value'=>assign_value('default_meta_description', $default_meta_description), 'class' => 'form-control'));?>
                </div>
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend><?php echo lang('email_settings');?></legend>
        <div class="row form-group">			
            <div class="col-md-4">
                <div class="form-group">
                    <label><?php echo lang('email_to');?></label>
                    <?php echo form_input(array('class'=>'form-control', 'name'=>'email_to', 'value'=>assign_value('email_to', $email_to), 'class' => 'form-control'));?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label><?php echo lang('email_from');?></label>
                    <?php echo form_input(array('class'=>'form-control', 'name'=>'email_from', 'value'=>assign_value('email_from', $email_from), 'class'=>'form-control'));?>
                </div>
            </div>
        </div>

    </fieldset>

    <a href="/admin/settings/stores" class="btn btn-danger"><?php echo lang('cancel');?></a> 
    <input type="submit" class="btn btn-primary" value="<?php echo lang('save');?>" />

</form>
	