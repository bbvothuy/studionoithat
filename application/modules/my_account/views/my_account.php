<link href="/themes/default/assets/css/gumbo/grid.css" type="text/css" rel="stylesheet" />
<link href="/themes/default/assets/css/gumbo/forms.css" type="text/css" rel="stylesheet" />
<style>
.orderPhoto img{
	width:100%;
	max-width:120px;
}
.cartItem, .orderItem .col-nest {
    padding: 15px;
    border-top: 3px solid #e0e0e0;
}
.cartSummaryTotals {
    padding: 15px;
    border-top: 1px solid #e0e0e0;
    text-align: right;
}
.cartPromotions {
    padding: 15px;
    background-color: #fafafa;
    border-top: 1px solid #e0e0e0;
}
#addressFormWrapper .page-header{
	padding-bottom: 0;
    margin: 0;
}
#addressFormWrapper .page-header h3{
	margin-top: 0;
    margin-bottom: 10px;
}
</style>
<div class="product-content-wp">
	<div class="container">
    	<div class="breadcrumb-wp">
            <ol class="breadcrumb">
              <li><a class="pink" href="#"><i class="glyphicon glyphicon-home"></i></a></li>
              <li class="active">Tài khoản <?php echo $customer['firstname'];?></li>
            </ol>
        </div>
		<div class="">

		<div class="col-nest">
			<div class="col" data-cols="2/5">
				<?php echo form_open('my-account'); ?>

					<h3><?php echo lang('account_information');?></h3>

											
					<div class="col-nest">
					
						<div class="col" data-cols="1">
							<label for="account_firstname">Tên<?php //echo lang('account_firstname');?></label>
							<?php echo form_input(['name'=>'firstname', 'value'=> assign_value('firstname', $customer['firstname'])]);?>
						</div>

						<div class="col hide" data-cols="1/2">
							<label for="account_lastname"><?php echo lang('account_lastname');?></label>
							<?php echo form_input(['name'=>'lastname', 'value'=> assign_value('lastname', $customer['lastname'])]);?>
						</div>
					
						<div class="col" data-cols="1/2">
							<label for="account_email"><?php echo lang('account_email');?></label>
							<?php echo form_input(['name'=>'email', 'value'=> assign_value('email', $customer['email'])]);?>
						</div>
					
						<div class="col" data-cols="1/2">
							<label for="account_phone"><?php echo lang('account_phone');?></label>
							<?php echo form_input(['name'=>'phone', 'value'=> assign_value('phone', $customer['phone'])]);?>
						</div>
					</div>

					<label class="checklist">
						<input type="checkbox" name="email_subscribe" value="1" <?php if((bool)$customer['email_subscribe']) { ?> checked="checked" <?php } ?>/> <?php echo lang('account_newsletter_subscribe');?>
					</label>
				
					<div style="margin:10px 0px 10px; text-align:center;">
						<strong>Nếu quý khách không đổi mật khẩu, vui lòng bỏ qua<?php //echo lang('account_password_instructions');?></strong>
					</div>
				
					<div class="col-nest">
						<div class="col" data-cols="1/2">
							<label for="account_password"><?php echo lang('account_password');?></label>
							<?php echo form_password(['name'=>'password']);?>
						</div>

						<div class="col" data-cols="1/2">
							<label for="account_confirm"><?php echo lang('account_confirm');?></label>
							<?php echo form_password(['name'=>'confirm']);?>
						</div>
					</div>
				
					<input type="submit" value="<?php echo lang('form_submit');?>" class="blue" />
				</form>
			</div>

			<div id="addresses" class="col" data-cols="3/5"></div>
		</div>
		<div class="col-nest">
			<div class="col" data-cols="1">
				<div class="page-header" style="margin-top:30px;">
					<h2><?php echo lang('order_history');?></h2>
				</div>
				<?php if($orders):
					echo $orders_pagination;
				?>
				<table class="table bordered zebra">
					<thead>
						<tr>
							<th><?php echo lang('order_date');?></th>
							<th><?php echo lang('order_number');?></th>
							<th><?php echo lang('order_status');?></th>
						</tr>
					</thead>

					<tbody>
					<?php
					foreach($orders as $order): ?>
						<tr>
							<td>
								<?php $d = format_date($order->ordered_on); 
						
								$d = explode(' ', $d);
								echo $d[0].' '.$d[1].', '.$d[3];
						
								?>
							</td>
							<td><a href="<?php echo site_url('order-complete/'.$order->order_number); ?>"><?php echo $order->order_number; ?></a></td>
							<td><?php echo $order->status;?></td>
						</tr>
				
					<?php endforeach;?>
					</tbody>
				</table>
				<?php else: ?>
					<div class="alert yellow"><i class="close"></i><?php echo lang('no_order_history');?></div>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
    loadAddresses();
});

function closeAddressForm()
{
    $.gumboTray.close();
    loadAddresses();
}

function loadAddresses()
{
    //$('#addresses').spin();
    $('#addresses').load('<?php echo base_url('addresses');?>');
}
</script>