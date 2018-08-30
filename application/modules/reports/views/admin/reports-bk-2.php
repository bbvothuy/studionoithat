<?php pageHeader(lang('reports'));?>

<div class="row">
    <div class="col-md-6">
        <h3><?php echo lang('sales');?></h3>
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

<div class="row">
    <div class="col-md-6">
        <h3><?php echo lang('best_sellers');?></h3>
    </div>
    <div class="col-md-6">
        <form class="form-inline pull-right">
            <input class="form-control datepicker" id="best_sellers_start_alt" type="text" name="best_sellers_start" placeholder="<?php echo lang('from');?>"/>
            <input class="form-control datepicker" id="best_sellers_end_alt" type="text" name="best_sellers_end" placeholder="<?php echo lang('to');?>"/>

            <input class="btn btn-primary" type="button" value="<?php echo lang('getBestSellers');?>" onclick="getBestSellers()"/>
        </form>
    </div>
</div>


<div class="row">
    <div class="col-md-12" id="best_sellers"></div>
</div>




<script type="text/javascript">

$(document).ready(function(){
    getBestSellers();
    get_monthly_sales();
    $('input:button').button();
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

</script>

<div id="saving_container" style="display:none;">
    <div id="saving" style="background-color:#000; position:fixed; width:100%; height:100%; top:0px; left:0px;z-index:100000"></div>
    <img id="saving_animation" src="<?php echo base_url('assets/img/storing_animation.gif');?>" alt="saving" style="z-index:100001; margin-left:-32px; margin-top:-32px; position:fixed; left:50%; top:50%"/>
    <div id="saving_text" style="text-align:center; width:100%; position:fixed; left:0px; top:50%; margin-top:40px; color:#fff; z-index:100001"><?php echo lang('loading');?></div>
</div>
