<div class="row">
<?php $group_by = true; $total_tmp = 0; if($condition['group_by'] == ''){$group_by = false;?>
<table id="table-detail-filter" class="table table-striped">
    <thead>
        <tr>
            <th>Order ID</th>
			<th>Date</th>
			<th>Status</th>	
            <th>Customer Name</th>
			<th>Phone</th>
			<th>Email</th>
			<th>Address</th>
			<th>District</th>          
			<th>City</th>
			<th>Total</th>
        </tr>
    </thead>

    <tbody>    
    <?php foreach($report_details as $order): ?>
	<tr>
        <td>
            <a href="/admin/orders/order/<?php echo $order->order_number;?>"><?php echo $order->invoice_number;?></a>
        </td>
		<td>
            <?php echo date('d/m/Y', strtotime($order->ordered_on)); ?>
        </td>
		<td>
            <?php echo $order->status; ?>
        </td>
		<td>
            <?php echo $order->company ? $order->company.', '.$order->firstname : $order->firstname; ?>
        </td>
		<td>
            <?php echo $order->phone; ?>
        </td>
		<td>
            <?php echo $order->email; ?>
        </td>
		<td>
            <?php echo $order->address1; ?>
        </td>
		<td>
            <?php echo $order->district_name; ?>
        </td>
		<td>
            <?php echo $order->city_name; ?>
        </td>
		<td>
            <?php $tmp = number_format($order->total - $order->decrease); echo $tmp; $total_tmp = $total_tmp + $order->total - $order->decrease;?>
        </td>
	</tr>    
	<?php endforeach; ?>
    </tbody>	
	<?php if(count($report_details) > 0){?>
		<tfoot>
			<tr>				
				<td colspan="9" align="right"><b>Total<b/></td>
				<td><b><?php echo format_currency($total_tmp);?></b></td>
			</tr>
		</tfoot>
	<?php }?>
	
</table>
<?php }else{
	if($condition['group_by'] == 'day' || $condition['group_by'] == 'week' || $condition['group_by'] == 'month'){?>
		<table class="table table-striped" id="table-detail-filter">
			<thead>
				<tr>
					<th>Date</th>					
					<th>Total</th>
				</tr>
			</thead>

			<tbody>
			<?php echo (count($report_details) < 1)?'<tr><td style="text-align:center;">'.lang('no_orders') .'</td></tr>':''?>
			<?php foreach($report_details as $order): ?>
			<tr>
				<td>
					<?php echo $order->day;?>
				</td>
				<td>
					<?php echo format_currency($order->total - $order->total_decrease); $total_tmp = $total_tmp + $order->total - $order->total_decrease;?>
				</td>
			</tr>    
			<?php endforeach; ?>
			<?php if(count($report_details) > 0){?>
			<tr>				
				<td align="right"><b>Total<b/></td>
				<td><b><?php echo format_currency($total_tmp);?></b></td>
			</tr>
			</tbody>
			<?php }?>
		</table>
	<?php }?>
	
	<?php if($condition['group_by'] == 'phone' || $condition['group_by'] == 'email'){?>
		<table class="table table-striped" id="table-detail-filter">
			<thead>
				<tr>
					<th><?php if($condition['group_by'] == 'phone') echo 'Phone'; else echo 'Email';?></th>
					<th>Total</th>
				</tr>
			</thead>

			<tbody>
			<?php echo (count($report_details) < 1)?'<tr><td style="text-align:center;">'.lang('no_orders') .'</td></tr>':''?>
			<?php foreach($report_details as $order): ?>
			<tr>
				<td>
					<?php if($condition['group_by'] == 'phone') echo $order->phone; else echo $order->email;?>
				</td>
				<td>
					<?php echo format_currency($order->total - $order->total_decrease); $total_tmp = $total_tmp + $order->total - $order->total_decrease;?>
				</td>
			</tr>    
			<?php endforeach; ?>
			
			</tbody>
			<?php if(count($report_details) > 0){?>
			<tfoot>
				<tr>				
					<td align="right"><b>Total<b/></td>
					<td><b><?php echo format_currency($total_tmp);?></b></td>
				</tr>
			</tfoot>
			<?php }?>
		</table>
	<?php }?>
	
	<?php if($condition['group_by'] == 'country-zone' || $condition['group_by'] == 'zone'){?>
		<table class="table table-striped" id="table-detail-filter">
			<thead>
				<tr>
					<th>
						City
					</th>
					<?php if($condition['group_by'] == 'zone'){?>
					<th>
						District
					</th>
					<?php }?>
					<th>
						Total
					</th>
				</tr>
			</thead>

			<tbody>
			<?php echo (count($report_details) < 1)?'<tr><td style="text-align:center;">'.lang('no_orders') .'</td></tr>':''?>
			<?php foreach($report_details as $order): ?>
			<tr>
				<td>
					<?php echo $order->city_name; ?>
				</td>
				<?php if($condition['group_by'] == 'zone'){?>
				<td>
					<?php echo $order->district_name; ?>
				</td>
				<?php }?>
				<td>
					<?php echo format_currency($order->total - $order->total_decrease); $total_tmp = $total_tmp + $order->total - $order->total_decrease;?>
				</td>
			</tr>    
			<?php endforeach; ?>
			
			</tbody>
			<?php if(count($report_details) > 0){?>
			<tfoot>
				<tr>	
					<td></td>
					<td align="right"><b>Total<b/></td>
					<td><b><?php echo format_currency($total_tmp);?></b></td>
				</tr>
			</tfoot>
			<?php }?>
		</table>
	<?php }?>
	
<?php }?>
<script>

  $(function(){
    $("#table-detail-filter").dataTable({
		"bPaginate": false,
		"aaSorting": [],
		<?php if($group_by == false){?>
		"aoColumnDefs": [
			{ "sType": "formatted-num", "aTargets": [9] }
		]
		<?php }?>
	});	
  })
  </script>