<div id="addressFormWrapper">
    <div class="page-header">
        <?php if($addressCount > 0):?>
            <button class="red pull-right input-xs hide" type="cancel" onclick="closeAddressForm();"><?php echo lang('form_cancel');?></button>
        <?php endif;?>
        <h3>Thông tin giao hàng<?php //echo lang('address_form');?></h3>
    </div>
    
    <div id="addressError" class="alert red hide"></div>

    <?php echo form_open('addresses/form/'.$id, ['id'=>'addressForm']);?>
        <div class="col-nest">
            <div class="col" data-cols="1">
            <label><?php echo lang('address_company');?></label>
                <?php echo form_input(['name'=>'company', 'value'=> assign_value('company',$company)]);?>
            </div>
        </div>

        <div class="col-nest">
            <div class="col" data-cols="1" data-medium-cols="1/2" data-small-cols="1/2">
                <label class="required"><?php echo lang('address_firstname');?> <sup>*</sup></label>
                <?php echo form_input(['name'=>'firstname', 'value'=> assign_value('firstname',$firstname), 'id' => 'firstname']);?>
            </div>

            <div class="col hide" data-cols="1/2" data-medium-cols="1/2" data-small-cols="1/2">
                <label class="required"><?php echo lang('address_lastname');?></label>
                <?php echo form_input(['name'=>'lastname', 'value'=> assign_value('lastname',$lastname)]);?>
            </div>
        </div>
        
        <div class="col-nest">
            <div class="col" data-cols="1/2" data-medium-cols="1/2" data-small-cols="1/2">
                <label class="required"><?php echo lang('address_email');?> <sup>*</sup></label>
                <?php echo form_input(['name'=>'email', 'value'=>assign_value('email',$email), 'id' => 'email', 'type' => 'email]', 'required' => 'required]']);?>
            </div>
            <div class="col" data-cols="1/2" data-medium-cols="1/2" data-small-cols="1/2">
                <label class="required"><?php echo lang('address_phone');?> <sup>*</sup></label>
                <?php echo form_input(['name'=>'phone', 'value'=> assign_value('phone',$phone), 'id' => 'phone', 'type' => 'number', 'required' => 'required]']);?>
            </div>
        </div>
        <div class="col-nest">
            <div class="col" data-cols="1">
                <label class="required"><?php echo lang('address');?> <sup>*</sup></label>
                <?php
                echo form_input(['name'=>'address1', 'value'=>assign_value('address1',$address1), 'id' => 'address1']);
                //echo form_input(['name'=>'address2', 'value'=> assign_value('address2',$address2)]);
                ?>
            </div>
        </div>
        <div class="col-nest hide">
            <div class="col" data-cols="1">
                <label><?php echo lang('address_country');?></label>
                <?php echo form_dropdown('country_id', $countries_menu, assign_value('country_id', $country_id), 'id="country_id"');?>
            </div>
        </div>
        <div class="col-nest">
            <div class="col hide" data-cols="1/3" data-medium-cols="1/3" data-small-cols="1/3">
                <label class="required"><?php echo lang('address_city');?></label>
                <?php echo form_input(['name'=>'city', 'value'=>assign_value('city',$city)]);?>
            </div>
			
			
            <div class="col" data-cols="1/3" data-medium-cols="1/3" data-small-cols="1/3">
                <label>TP/Tỉnh</label>
                <?php echo form_dropdown('city', @$zones_menu_2, assign_value('city', @$city), 'id="zone_id"');?>
            </div>
			
			<div class="col" data-cols="1/3" data-medium-cols="1/3" data-small-cols="1/3">
                <label class="required">Quận</label>                
				<?php echo form_dropdown('zone_id', @$city_zone, assign_value('zone_id', @$zone_id), 'id="city_zone_id"');?>
            </div>
            
			<div class="col hide" data-cols="1/3" data-medium-cols="1/3" data-small-cols="1/3">
                <label class="required"><?php echo lang('address_zip');?></label>
                <?php echo form_input(['maxlength'=>'10', 'name'=>'zip', 'value'=> assign_value('zip',$zip)]);?>
            </div>
			
			<div class="col" data-cols="1/3" data-medium-cols="1/3" data-small-cols="1/3">
                <label class="required">Phường</label>
				<?php echo form_dropdown('ward_id', @$ward, assign_value('ward_id', @$ward_id), 'id="ward_id"');?>
            </div>
        </div>

        <div class="button-product-detail hide" style="padding-bottom:20px;text-align:right"> <button class="btn btn-cart save-info" type="submit">Lưu thông tin<?php //echo lang('save_address');?></button>
    </form>

    <script>
	function addShiping(){
		//cart/addShiping
		var country_zone_id = $('#zone_id').val();
		var city_zone_id = $('#city_zone_id').val();
		var ward_id = $('#ward_id').val();
		$.post( "<?php echo site_url('cart/addShiping');?>", {country_zone_id: country_zone_id, city_zone_id: city_zone_id, ward_id: ward_id}, function( data ) {
			//getCartSummary();
			$(".total-shipping").html(data.total_shipping);
			$(".total-price").html(data.total_price);
			//console.log( data );
		}, "json");
	}
    $(function(){
        $('#country_id').change(function(){
            //$('#zone_id').load('<?php echo site_url('addresses/get-zone-options');?>/'+$('#country_id').val()+'/country');
        });
		
		
		$('#zone_id').change(function(){
			$("#city_zone_id option").remove();
			$("#ward_id option").remove();
			var zone_id = $('#zone_id').val();
			if(zone_id == null){
				zone_id = 0;
			}
			
            $('#city_zone_id').load('<?php echo site_url('addresses/get-zone-options');?>/'+zone_id+'/zone', function(){
				var city_zone_id = $('#city_zone_id').val();
				if(city_zone_id == null){
					city_zone_id = 0;
				}
				$('#ward_id').load('<?php echo site_url('addresses/get-zone-options');?>/'+city_zone_id+'/ward', function(){
					addShiping();
				});
			});
        });
		
		$('#city_zone_id').change(function(){
			var city_zone_id = $('#city_zone_id').val();
			if(city_zone_id == null){
				city_zone_id = 0;
			}
            $('#ward_id').load('<?php echo site_url('addresses/get-zone-options');?>/'+city_zone_id+'/ward', function(){
				addShiping();
			});
        });
		
		$('#ward_id').change(function(){            
			addShiping();
        });
		
        $('#addressForm').on('submit', function(event){		
			
            //$('.addressFormWrapper').spin();
            submit_order = true;
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function(data){
                if(data == 1)
                {
                    closeAddressForm();
                }
                else
                {
                    $('#addressFormWrapper').html(data);
                }
            });
        })
    });

	<?php if(!isset($edit_address)){?>
	setTimeout(function(){
		var zone_id = $('#zone_id').val();
			if(zone_id == null){
				zone_id = 0;
			}
		$('#city_zone_id').load('<?php echo site_url('addresses/get-zone-options');?>/'+zone_id+'/zone', function(){
			var city_zone_id = $('#city_zone_id').val();
				if(city_zone_id == null){
					city_zone_id = 0;
				}
			$('#ward_id').load('<?php echo site_url('addresses/get-zone-options');?>/'+city_zone_id+'/ward', function(){
				addShiping();
			});
		});
	}, 500);
	<?php }?>
		
    <?php if(validation_errors()):
        $errors = \CI::form_validation()->get_error_array(); ?>

        var formErrors = <?php echo json_encode($errors);?>
        
        for (var key in formErrors) {
            if (formErrors.hasOwnProperty(key)) {
                //$('[name="'+key+'"]').parent().append('<div class="form-error text-red">'+formErrors[key]+'</div>')
				$('[name="'+key+'"]').parent().append('<div class="form-error text-red">Thông tin yêu cầu cần có</div>')
            }
        }
		$.LoadingOverlay('hide');
		$('#btn_cod').attr('disabled', false).removeClass('disabled');
    <?php endif;?>
    </script>
</div>