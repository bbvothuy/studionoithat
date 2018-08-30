<?php pageHeader('Bonus Product'); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript">
function areyousure()
{
    return confirm('<?php echo lang('confirm_delete_product');?>');
}
</script>
<style type="text/css">
    .pagination {
        margin:0px;
        margin-top:-3px;
    }
</style>
<table class="table table-striped">
	<thead>
		<tr>                
			<th>Name</th>
			<th>Product Name</th>
			<th>Type</th>
			<th>Value</th>
			<th>Quantity</th>
			<!--
			<th>Date Start</th>
			<th>Date End</th>
			-->
			<th>Status</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<form method="post" >		
			<tr>
				<td width="20%">
					<input type="text" name="name" value="" class="form-control" placeholder="Display name">
				</td>
				<td td width="25%">
					<input type="text" value="" class="form-control product-name" placeholder="Input to search">
					<input type="hidden" name="product_id" value="">
				</td>
				<td>
					<select class="form-control" name="bonus_type">
						<option value="0">Tặng miễn phí</option>
						<option value="1">Giảm % giá</option>
						<option value="2">Giảm tiền</option>
					</select>
				</td>
				<td width="8%">
					<input type="text" name="value" value="" class="form-control tableInput">
				</td>
				<td width="6%">
					<input type="text" name="quantity" value="" class="form-control tableInput">
				</td>
				<!--
				<td width="10%">
					<?php echo form_input(['name'=>'enable_date', 'data-value'=>assign_value('enable_date', @$enable_date), 'class'=>'datepicker form-control']); ?>
				</td>
				<td width="10%">
					<?php echo form_input(['name'=>'disable_date', 'data-value'=>assign_value('disable_date', @$disable_date), 'class'=>'datepicker form-control']); ?>					
				</td>
				-->
				<td>
					<select class="form-control" name="active">
						<option value="1">On</option>
						<option value="0">Off</option>
					</select>
				</td>
				<td>
					<input name="submit" class="btn btn-primary" type="submit" value="Add New">
				</td>
			</tr>
		</form>
		
		<?php foreach($products as $product){?>
		
			<tr id="row_<?php echo $product->id;?>">
				<form method="post">
				<td width="20%">
					<input readonly type="text" name="name" value="<?php echo $product->name;?>" class="form-control group-disabled">
				</td>
				<td width="25%">
					<input readonly type="text" name="product_name" value="<?php echo $product->product_name;?>" class="form-control product-name group-disabled">
					<input type="hidden" name="product_id" value="<?php echo $product->product_id;?>">
				</td>
				<td>
					<select class="form-control" name="bonus_type" disabled>
						<option value="0" <?php if($product->bonus_type == 0) echo 'selected="selected"';?>>Tặng miễn phí</option>
						<option value="1" <?php if($product->bonus_type == 1) echo 'selected="selected"';?>>Giảm % giá</option>
						<option value="2" <?php if($product->bonus_type == 2) echo 'selected="selected"';?>>Giảm tiền</option>
					</select>
				</td>			
				<td>
					<input readonly type="text" name="value" value="<?php echo $product->value;?>" class="form-control group-disabled">
				</td>
				<td>
					<input readonly type="text" name="quantity" value="<?php echo $product->quantity;?>" class="form-control group-disabled">
				</td>
				<!--
				<td width="10%">
					<?php echo form_input(['name'=>'enable_date', 'data-value'=>assign_value('enable_date', $product->enable_date), 'class'=>'datepicker form-control']); ?>
				</td>
				<td width="10%">
					<?php echo form_input(['name'=>'disable_date', 'data-value'=>assign_value('disable_date', $product->disable_date), 'class'=>'datepicker form-control']); ?>					
				</td>
				-->
				<td>
					<select class="form-control group-disabled" name="active" disabled>
						<option value="0" <?php if($product->active == 0) echo 'selected="selected"';?>>On</option>
						<option value="1" <?php if($product->active == 1) echo 'selected="selected"';?>>Off</option>
					</select>
				</td>
				<td>
					<input name="id" type="hidden" value="<?php echo $product->id;?>">
					<input data-id="<?php echo $product->id;?>" id="edit_<?php echo $product->id;?>" class="btn btn-primary edit-row" value="Edit" style="width: 58px;">
					<input data-id="<?php echo $product->id;?>" id="update_<?php echo $product->id;?>" name="submit" class="btn btn-primary" type="submit" value="Update" style="display:none">
					<input class="btn btn-danger" type="submit" name="submit" value="Delete">
				</td>
				</form>
			</tr>
		
		<?php }?>
	</tbody>
</table>
<script>
	//$.post("<?php echo site_url('admin/products/product_autocomplete/');?>", { name: $('#product_search').val(), limit:10},
	$(".edit-row").click(function(){		
		var id = $(this).data("id");
		var row_id = "#row_"+id;
		$(row_id+ " .group-disabled").prop('readonly', false);
		$(row_id+ " select").prop('disabled', false);
		$("#update_"+id).show();
		$("#edit_"+id).hide();
		console.log($("#update_"+id));
		//$(this).hide();
	});
	
	var _this;
	$( ".product-name" ).autocomplete({
      source: function( request, response ) {
		_this = $(this.element);
		//console.log(_this);
        $.ajax({
          url: "<?php echo site_url('admin/products/product_autocomplete/');?>",
          dataType: "json",
		  method: "post",
		  data: { name: request.term, limit:20, type: 2},
          success: function( data ) {
			  console.log(data);
            response( data );
          }
        });
      },
      minLength: 3,
      select: function( event, ui ) {
		  $(_this).next().next().val(ui.item.id);
		  //console.log(ui.item.id);
		  //console.log(_this);
      },
      open: function() {
        //$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        //$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });
</script>