<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Studionoithat<?php echo (isset($page_title))?' :: '.$page_title:''; ?></title>

<link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/admin.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/font-awesome.css');?>" rel="stylesheet" type="text/css" />
<link type="text/css" href="<?php echo base_url('assets/css/redactor.css');?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('assets/css/pickadate/default.css');?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('assets/css/pickadate/default.date.css');?>" rel="stylesheet" />

<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-2.1.3.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-ui.js');?>"></script>

<script type="text/javascript" src="<?php echo base_url('assets/js/pickadate/picker.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/pickadate/picker.date.js');?>"></script>

<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/redactor.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/imagemanager.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/spin.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/mustache.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/redactor_lang/'.config_item('language').'.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.canvasjs.min.js');?>"></script>

<?php if(CI::auth()->isLoggedIn(false, false)):?>

<script type="text/javascript">
$(document).ready(function(){
    $('.datepicker').pickadate({formatSubmit:'yyyy-mm-dd', hiddenName:true, format:'dd/mm/yyyy'});
    //$('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});

    $('.redactor').redactor({
        lang: '<?php echo config_item('language');?>',
        minHeight: 200,
        pastePlainText: true,
        linebreaks:true,
		replaceDivs: false,
        imageUpload: '<?php echo site_url('admin/wysiwyg/upload_image');?>',
        imageManagerJson: '<?php echo site_url('admin/wysiwyg/get_images');?>',
        imageUploadErrorCallback: function(json)
        {
            alert(json.error);
        },
        plugins: ['imagemanager']
    });
});
</script>
<?php endif;?>
</head>
<body>
<?php if(CI::auth()->isLoggedIn(false, false)):?>
	<?php
		$admin = CI::session()->userdata('admin');
        //print_r($admin);
		if($admin['group_id'] != GROUP_SUPPLIER){ // supplier
	?>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#primary-navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url('admin');?>">
                    <?php
                    if(config_item('store_name') != 'default'){
                        $store = config_item('store');
                        echo $store->store_name;
                    }else {
                        echo 'Studionoithat';
                    }
                    ?>

                </a>
            </div>

            <?php
            if(config_item('store_name') != 'default') {?>
                <div class="collapse navbar-collapse" id="primary-navbar">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo lang('common_sales'); ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo site_url('admin/orders');?>"><?php echo lang('common_orders'); ?></a></li>
                                <?php if(CI::auth()->check_access('Admin')) : ?>
                                    <li><a href="<?php echo site_url('admin/reports');?>"><?php echo lang('common_reports'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>

                        <?php
                        // Restrict access to Admins only
                        if(CI::auth()->check_access('Admin')) : ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo lang('common_catalog'); ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo site_url('admin/categories');?>"><?php echo lang('common_categories'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/products');?>"><?php echo lang('common_products'); ?></a></li>
									<li><a href="<?php echo site_url('admin/product_bonus');?>">Bonus Product</a></li>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo lang('common_content'); ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo site_url('admin/banners');?>"><?php echo lang('common_banners'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/pages');?>"><?php echo lang('common_pages'); ?></a></li>
									<li><a href="<?php echo site_url('admin/news');?>">News</a></li>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo lang('common_administrative'); ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo site_url('admin/settings/form_store/'.$store->id);?>"><?php echo lang('common_gocart_configuration'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/sitemap');?>"><?php echo 'Sitemap'; ?></a></li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo lang('common_actions');?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo site_url('admin/dashboard');?>"><?php echo lang('common_dashboard'); ?></a></li>
                                <li><a href="<?php echo site_url();?>"><?php echo lang('common_front_end'); ?></a></li>
                                <li><a href="<?php echo site_url('admin/logout');?>"><?php echo lang('common_log_out'); ?></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            <?php }else{?>
            <div class="collapse navbar-collapse" id="primary-navbar">
                <ul class="nav navbar-nav">
                    <?php if(CI::auth()->check_access('Admin')) : ?>
                        <?php if($admin['group_id'] == GROUP_SUPERADMIN){?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo lang('common_sales'); ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo site_url('admin/orders');?>"><?php echo lang('common_orders'); ?></a></li>

                                    <li><a href="<?php echo site_url('admin/customers');?>"><?php echo lang('common_customers'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/customers/groups');?>"><?php echo lang('common_groups'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/customers/suppliers');?>">Suppliers</a></li>
                                    <li><a href="<?php echo site_url('admin/reports');?>"><?php echo lang('common_reports'); ?></a></li>
                                    <!--
                                    <li><a href="<?php echo site_url('admin/coupons');?>"><?php echo lang('common_coupons'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/gift-cards');?>"><?php echo lang('common_gift_cards'); ?></a></li>
                                    -->
                                    <li><a href="<?php echo site_url('admin/customers/contact_list');?>">Contacts</a></li>

                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo lang('common_catalog'); ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo site_url('admin/categories');?>"><?php echo lang('common_categories'); ?></a></li>
                                <li><a href="<?php echo site_url('admin/products');?>"><?php echo lang('common_products'); ?></a></li>
                                <li><a href="<?php echo site_url('admin/products/product_bonus');?>">Bonus Product</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo lang('common_content'); ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo site_url('admin/banners');?>"><?php echo lang('common_banners'); ?></a></li>
                                <li><a href="<?php echo site_url('admin/pages');?>"><?php echo lang('common_pages'); ?></a></li>
                                <li><a href="<?php echo site_url('admin/news');?>">News</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo lang('common_administrative'); ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo site_url('admin/settings');?>"><?php echo lang('common_gocart_configuration'); ?></a></li>
                                <li><a href="<?php echo site_url('admin/settings/stores');?>"><?php echo lang('stores'); ?></a></li>
                                <li><a href="<?php echo site_url('admin/shipping');?>"><?php echo lang('common_shipping_modules'); ?></a></li>
                                <li><a href="<?php echo site_url('admin/payments');?>"><?php echo lang('common_payment_modules'); ?></a></li>
                                <li><a href="<?php echo site_url('admin/settings/canned_messages');?>"><?php echo lang('common_canned_messages'); ?></a></li>
                                <li><a href="<?php echo site_url('admin/locations');?>"><?php echo lang('common_locations'); ?></a></li>
                                <li><a href="<?php echo site_url('admin/users');?>"><?php echo lang('common_administrators'); ?></a></li>
                                <li><a href="<?php echo site_url('admin/sitemap');?>"><?php echo 'Sitemap'; ?></a></li>
                            </ul>
                        </li>
                        <?php }?>
                        <?php if($admin['group_id'] == GROUP_ADMIN){?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo lang('common_sales'); ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo site_url('admin/orders');?>"><?php echo lang('common_orders'); ?></a></li>

                                    <li><a href="<?php echo site_url('admin/customers');?>"><?php echo lang('common_customers'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/customers/groups');?>"><?php echo lang('common_groups'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/customers/suppliers');?>">Suppliers</a></li>
                                    <li><a href="<?php echo site_url('admin/reports');?>"><?php echo lang('common_reports'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/customers/contact_list');?>">Contacts</a></li>

                                </ul>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo lang('common_catalog'); ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo site_url('admin/categories');?>"><?php echo lang('common_categories'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/products');?>"><?php echo lang('common_products'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/products/product_bonus');?>">Bonus Product</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo lang('common_content'); ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo site_url('admin/banners');?>"><?php echo lang('common_banners'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/pages');?>"><?php echo lang('common_pages'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/news');?>">News</a></li>
                                </ul>
                            </li>
                        <?php }?>
                        <?php if($admin['group_id'] == GROUP_SELLER){?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo lang('common_sales'); ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo site_url('admin/orders');?>"><?php echo lang('common_orders'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/customers');?>"><?php echo lang('common_customers'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/customers/groups');?>"><?php echo lang('common_groups'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/customers/suppliers');?>">Suppliers</a></li>
                                    <li><a href="<?php echo site_url('admin/reports');?>"><?php echo lang('common_reports'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/customers/contact_list');?>">Contacts</a></li>

                                </ul>
                            </li>
                        <?php }?>

                        <?php if($admin['group_id'] == GROUP_EDITOR){?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo lang('common_catalog'); ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo site_url('admin/categories');?>"><?php echo lang('common_categories'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/products');?>"><?php echo lang('common_products'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/products/product_bonus');?>">Bonus Product</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo lang('common_content'); ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo site_url('admin/banners');?>"><?php echo lang('common_banners'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/pages');?>"><?php echo lang('common_pages'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/news');?>">News</a></li>
                                </ul>
                            </li>
                        <?php }?>

                    <?php endif; ?>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo lang('common_actions');?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo site_url('admin/dashboard');?>"><?php echo lang('common_dashboard'); ?></a></li>
                            <li><a href="<?php echo site_url();?>" target="_blank"><?php echo lang('common_front_end'); ?></a></li>
                            <li><a href="<?php echo site_url('admin/logout');?>"><?php echo lang('common_log_out'); ?></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <?php }?>
        </div>
    </nav>
	<?php }else{?>	
	<nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#primary-navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url('admin');?>">
                    Studionoithat
                </a>
            </div>
			<div class="collapse navbar-collapse" id="primary-navbar">			
                <ul class="nav navbar-nav">
					<li>
                        <a href="<?php echo site_url('admin/products');?>">Product list</a>
                    </li>
					
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo lang('common_actions');?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">							
                            <li><a href="<?php echo site_url();?>" target="_blank"><?php echo lang('common_front_end'); ?></a></li>
                            <li><a href="<?php echo site_url('admin/logout');?>"><?php echo lang('common_log_out'); ?></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
		</div>
	</nav>
	<?php }?>
<?php endif;?>
<div class="container">
    <?php
    //lets have the flashdata overright "$message" if it exists
    if(CI::session()->flashdata('message'))
    {
        $message    = CI::session()->flashdata('message');
    }

    if(CI::session()->flashdata('error'))
    {
        $error  = CI::session()->flashdata('error');
    }

    if(function_exists('validation_errors') && validation_errors() != '')
    {
        $error  = validation_errors();
    }
    ?>

    <div id="js_error_container" class="alert alert-error" style="display:none;">
        <p id="js_error"></p>
    </div>

    <div id="js_note_container" class="alert alert-note" style="display:none;">

    </div>

    <?php if (!empty($message)): ?>
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
</div>

<div class="container">
