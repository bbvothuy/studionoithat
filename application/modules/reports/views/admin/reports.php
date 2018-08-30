<style>
	.width110{
		 width: 110px !important;
		padding: 5px;
	}
</style>
<link rel="stylesheet" type="text/css" href="//ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
<?php pageHeader(lang('reports'));?>

<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#chart">Chart</a></li>
  <li><a data-toggle="tab" href="#best-sellers">Best Sellers</a></li>
  <li><a data-toggle="tab" href="#sales-report">Sales Report</a></li>
</ul>

<div class="tab-content">
	<div id="chart" class="tab-pane fade in active">
		<div class="row">
		<div class="col-md-6">
			
		</div>
		<div class="col-md-6">
			<form class="form-inline pull-right">
				<select name="year" id="sales_year" class="form-control">
					<?php foreach($years as $y):?>
						<option value="<?php echo $y;?>"><?php echo $y;?></option>
					<?php endforeach;?>
				</select>
				<input class="btn btn-primary" type="button" value="<?php echo lang('get_monthly_sales');?>" onclick="get_monthly_sales()"/>
			</form>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12" id="sales_container"></div>
	</div>
  </div>
  <div id="best-sellers" class="tab-pane fade">
    <div class="row" style="padding-bottom: 20px;">
		<div class="col-md-6">
			
		</div>
		<div class="col-md-6">
			<form class="form-inline pull-right">
				<input value="01/01/<?php echo date('Y');?>" class="form-control datepicker" id="best_sellers_start_alt" type="text" name="best_sellers_start" placeholder="<?php echo lang('from');?>"/>
				<input class="form-control datepicker" id="best_sellers_end_alt" type="text" name="best_sellers_end" placeholder="<?php echo lang('to');?>"/>

				<input class="btn btn-primary" type="button" value="<?php echo lang('getBestSellers');?>" onclick="getBestSellers()"/>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12" id="best_sellers"></div>
	</div>
  </div>
  
  <div id="sales-report" class="tab-pane fade">
    <div class="row">
		<div class="col-md-12" style="padding-bottom: 20px;">
			<form id="form-sales-report" class="form-inline pull-right">
				<input type="hidden" value="detail-report" name="type_report"/>
				<input class="form-control width110" placeholder="Term" name="key_search"/>			
				<select name="type_search" class="form-control width110">
					<option value="" selected="selected">-- Search --</option>
					<option value="name">Customer Name</option>
					<option value="phone">Phone</option>
					<option value="email">Email</option>
					<option value="address">Address</option>
					<option value="order-id">Order ID</option>					
				</select>
				<select name="country_zone" id="country_zone" class="form-control width110">
					<option value="" selected="selected">-- Province --</option>
					<?php foreach($zones as $key=>$zone){?>
						<option value="<?php echo $key;?>"><?php echo $zone;?></option>
					<?php }?>
				</select>
				<select name="zone" id="zone" class="form-control" style="max-width: 110px !important">
					<option value="" selected="selected">-- District --</option>
					<option class="value-zone" value="day">Quan 1</option>
				</select>				
				<select name="group_by" class="form-control width110">
					<option value="" selected="selected">-- Group --</option>
					<option value="day">Day</option>
					<option value="week">Week</option>
					<option value="month">Month</option>
					<option value="phone">Phone</option>
					<option value="email">Email</option>
					<option value="country-zone">Province</option>
					<option value="zone">Province + District</option>
				</select>
				<select name="status" class="form-control width110">
					<option value="" selected="selected">-- All Status --</option>
					<?php foreach(config_item('order_statuses') as $os):?>
					<option value="<?php echo $os;?>"><?php echo $os;?></option>
					<?php endforeach;?>
				</select>
				<input value="01/<?php echo date('m/Y');?>"class="form-control datepicker width110" id="sellers_start_alt" type="text" name="sellers_start_alt" placeholder="<?php echo lang('from');?>"/>
				<input class="form-control datepicker width110" id="sellers_end_alt" type="text" name="sellers_end_alt" placeholder="<?php echo lang('to');?>"/>
				<input class="btn btn-primary" type="button" value="Get Reports" onclick="getDetailReports()"/>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12" id="sales-report-detail"></div>
	</div>
  </div>
  
</div>



<script type="text/javascript">

$(document).ready(function(){
    getBestSellers();
    get_monthly_sales();
    $('input:button').button();
	
	$("#country_zone").change(function(){		
		var country_zone = $(this).val();
		if(country_zone == ''){
			$('#zone option').remove();
			$("#zone").append('<option value="" selected="selected">-- District --</option>');
		}else{
			$.post('/addresses/get-zone-options/' + country_zone + '/zone',{}, function(data){
				$('#zone option').remove();
				$("#zone").append('<option value="" selected="selected">-- District --</option>');
				$("#zone").append(data);
			});
			
		}
	});
});

function getBestSellers()
{
    $('body').spin();
	var best_sellers_start_alt 	= $('#best_sellers_start_alt').val();
	var best_sellers_end_alt 	= $('#best_sellers_end_alt').val();
	if(best_sellers_start_alt != ''){
		best_sellers_start_alt = best_sellers_start_alt.split("/").reverse().join("-");	
	}
	if(best_sellers_end_alt != ''){
		best_sellers_end_alt = best_sellers_end_alt.split("/").reverse().join("-");	
	}
 
    $.post('<?php echo site_url('admin/reports/best_sellers');?>',{start:best_sellers_start_alt, end:best_sellers_end_alt}, function(data){
        $('#best_sellers').html(data);
        setTimeout(function(){
            $('body').spin(false);
        }, 500);
    });
}

function get_monthly_sales()
{
    $('body').spin();
    $.post('<?php echo site_url('admin/reports/sales');?>',{year:$('#sales_year').val()}, function(data){
        $('#sales_container').html(data);
        setTimeout(function(){
            $('body').spin(false);
        }, 500);
    });
}


function getDetailReports()
{
	//alert("Sorry! This function is testing.");
	//return false; 
    $.post('<?php echo site_url('admin/reports/best_sellers');?>', $("#form-sales-report").serialize(), function(data){
        $('#sales-report-detail').html(data);
        setTimeout(function(){
            $('body').spin(false);
        }, 500);
    });
}


</script>
<script type="text/javascript" charset="utf8" src="//ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/plug-ins/1.10.16/sorting/numeric-comma.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/plug-ins/1.10.16/sorting/formatted-numbers.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/plug-ins/1.10.16/sorting/currency.js"></script>

<div id="saving_container" style="display:none;">
    <div id="saving" style="background-color:#000; position:fixed; width:100%; height:100%; top:0px; left:0px;z-index:100000"></div>
    <img id="saving_animation" src="<?php echo base_url('assets/img/storing_animation.gif');?>" alt="saving" style="z-index:100001; margin-left:-32px; margin-top:-32px; position:fixed; left:50%; top:50%"/>
    <div id="saving_text" style="text-align:center; width:100%; position:fixed; left:0px; top:50%; margin-top:40px; color:#fff; z-index:100001"><?php echo lang('loading');?></div>
</div>
