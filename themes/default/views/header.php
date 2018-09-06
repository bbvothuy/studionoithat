<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="google-site-verification" content="KdYoNTHHhpD_pOg_74qLmcEuz-jglMCyqbSJ7ZQNKDY" />
<meta name="msvalidate.01" content="3FE4EFBDF54271DF2856ACEFDD1D262B" />
<title><?php echo (!empty($seo_title)) ? $seo_title .' - ' : ''; echo config_item('company_name'); ?></title>

<link rel="shortcut icon" href="<?php echo theme_img('favicon.png');?>" type="image/png" />
<?php if(isset($keyword)):?>
	<meta name="keywords" content="<?php echo $keyword;?>" />
<?php else:?>
	<meta name="keywords" content="<?php echo config_item('default_meta_keywords');?>" />
<?php endif;?>
<?php $og_description = ''; if(isset($meta)):?>
	<?php $meta = strip_tags($meta); $og_description = $meta; echo (strpos($meta, '<meta') !== false) ? $meta : '<meta name="description" content="'.$meta.'" />';?>
<?php else:?>
    <meta name="description" content="<?php $og_description = config_item('default_meta_description'); echo config_item('default_meta_description');?>" />
<?php endif;?>

<meta property="og:type" content="product">
<meta property="og:title" content="<?php echo (!empty($seo_title)) ? $seo_title .' - ' : ''; echo config_item('company_name'); ?>">

<meta property="og:image" content="<?php if(isset($get_image_primary)) echo $get_image_primary;?>">
<meta property="og:image:secure_url" content="">

<meta property="og:price:amount" content="">
<meta property="og:price:currency" content="VND">

<meta property="og:description" content="<?php echo $og_description;?>">
<meta property="og:url" content="<?php echo base_url(uri_string());?>">
<meta property="og:site_name" content="Studionoithat.com">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script src='https://www.google.com/recaptcha/api.js?hl=vi'></script>

<?php
$_css = new CSSCrunch();
$_css->addFile('bootstrap.min');
$_css->addFile('font-awesome.min');
$_css->addFile('vendor');
$_css->addFile('styles');
$_css->addFile('mobile');
$_css->addFile('animate');

$_js = new JSCrunch();
$_js->addFile('jquery.min');
$_js->addFile('bootstrap.min');
$_js->addFile('script');
$_js->addFile('jquery.sliderPro.min');
$_js->addFile('bootbox.min');

if(true) //Dev Mode
{
    //in development mode keep all the css files separate
    $_css->crunch(true);
    $_js->crunch(true);
}
else
{
    //combine all css files in live mode
    $_css->crunch();
    $_js->crunch();
}


//with this I can put header data in the header instead of in the body.
if(isset($additional_header_info))
{
    echo $additional_header_info;
}
?>
<link href="/themes/default/assets/fonts/fonts.css" type="text/css" rel="stylesheet" />
<!-- slider banner --->
<script type="text/javascript">
	$( document ).ready(function(	) {
		$( '#slider-banner' ).sliderPro({
			width: 1440,
			height: 400,
			arrows: true,
			buttons: false,
			waitForLayers: true,
			thumbnailWidth: 220,
			thumbnailHeight: 100,
			thumbnailPointer: true,
			autoplay: true,
			autoScaleLayers: true,
			breakpoints: {
				500: {
					thumbnailWidth: 120,
					thumbnailHeight: 50
				}
			}
		});
	});
</script>
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '199542380653225');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=199542380653225&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

<!-- Google Tag Manager -->
<!--GTM-->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-N7FXMB');</script>

<!--GTA-->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-23662758-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<!-- End Google Tag Manager -->
</head>

<body>
<!-- NoScripty Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-N7FXMB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End NoScripty Google Tag Manager -->

<!-- header -->
<header class="header-wp">
	<div class="top-header-wp">
    	<div class="container">
        	<div class="row">
            	<div class="col-lg-6 col-md-1 col-sm-1 col-xs-1 mb-none">
                	<div class="welcome">
                    	<p class="welcome-p">Chào mừng bạn đến với Studio Nội Thất</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                	<div class="menu-mobile">
                        <div class="header">
                            <a href="#menu"><i class="glyphicon glyphicon-align-justify"></i></a>
                        </div>
                        <nav id="menu">
                            <ul>
                                <li><a href="/">Trang Chủ</a></li>
								<?php category_loop_mobile(0, false, false);?>                                
                            </ul>
                        </nav>
                    </div>
					
                	<div class="login-area">
						<?php if (CI::Login()->isLoggedIn(false, false)){$customer = CI::session()->userdata('customer');?>
						<ul>
							<li class="usrer-setting">
                            	<div class="dropdown">
                                  <a href="#!" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="glyphicon glyphicon-user"></i> <?php echo $customer->firstname;?>
                                    <span class="caret"></span>
                                  </a>
                                  <ul class="dropdown-menu">
                                    <li><a href="/my-account">Thông tin</a></li>
                                    <li><a href="/logout">Thoát</a></li>
                                  </ul>
                                </div>
                            </li>
                      	</ul>
						<?php }else{?>
                        <ul>
                        	<li class="sign-up-wp"> 
                        		<a href="#!" data-toggle="modal" data-target="#pupo-dangky"><i class="fa fa-user-plus"></i> Đăng Ký</a> 
                        	</li>
                        	<li class="login-wp"> 
                        		<a id="idLoginPopup" href="#!" data-toggle="modal" data-target="#pupo-dangnhap"><i class="fa fa-user"></i> Đăng Nhập</a> 
                        	</li>
                            <?php /*
							<li class="login-wp"> 
                        		<a id="idLoginPopup" href="#!" data-toggle="modal"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Giỏ Hàng <span>(0)</span></a> 
                        	</li>
                        	*/?>
                      	</ul>
						<?php }?>
                	</div>
					
                </div>
            </div>
        </div>
    </div>
    <div class="mid-header-wp">
    	<div class="container">
        	<div class="row">
            	<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                	<div class="logo-wp">
                    	<a href="/"><img src="/themes/default/assets/images/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                	<div class="top-search-wp">
                    	<div class="top-search-bg">
						<form action="/search" class="navbar-search pull-right" method="post" accept-charset="utf-8" style="width:100%">
                            <div class="top-search-m">
								<input type="text" class="form-control" name="term" class="search-query search-category" value="<?php if(isset($term) && $term !=''){ echo $term;}?>" placeholder="Nhập tên hoặc mã sản phẩm">
								<input type="hidden" class="form-control" name="category_id" value="" id="cat_id_search">
								<input type="hidden" class="form-control" name="category_name" value="" id="cat_name_search">

								<?php /*<ul class="dropdown-menu dropdown-menu1 dropdown-menu-right">
								  <?php 
									if(isset($cat_id) && $cat_id > 0)
										category_loop_tat_ca_sp(5, $cat_id);
									else
										category_loop_tat_ca_sp(5);
									?>
                                </ul>
 								*/?>
                            </div>
                            <div class="top-search-r">
                            	<button type="submit" class="btn btn-default button-search"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
						</form>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                	<div class="mid-head-right-b">
                    	<div class="wish-list-wp">
							<?php if (CI::Login()->isLoggedIn(false, false)){$customer = CI::session()->userdata('customer');?>
								<div class="cart-top dropdown" id="list-wishlist">
									<?php /*
									<a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span><i class="fa fa-heart"></i> Wishlist</span>
								  	</a>
								  	<div class="dropdown-menu" aria-labelledby="dLabel">
										<div class="drop-cart-wp" id="drop-wishlist-wp">
										</div>
								  	</div>
 									*/?>
								</div>
							<?php }else{?>
								<div class="cart-top dropdown" id="list-wishlist">
								  <a href="#" data-toggle="modal" data-target="#view-wishlist">
									<?php /*<span><i class="fa fa-heart"></i> Wishlist</span> */?>
								  </a>
								  <div class="dropdown-menu" aria-labelledby="dLabel">
									<div class="drop-cart-wp" id="drop-wishlist-wp">
									</div>
								  </div>
								</div>
							<?php }?>
                        </div>
                        <div class="cart-wp">
                        	<div class="cart-top dropdown" id="list-items">
                            	<div class="text-cart">
                              	<p>Giỏ hàng</p>
                                <span>Sản phẩm</span>
                              </div>
                              <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="/themes/default/assets/images/cart-icon.jpg" alt="">
                                <div class="cart-count">
                                    <span id="itemCount"><?php if (CI::Login()->isLoggedIn(false, false)){echo GC::totalItems();}else echo 0;?></span>
                                </div>
                              </a>
                              <div class="dropdown-menu" aria-labelledby="dLabel">
                                <div class="drop-cart-wp" id="drop-cart-wp">
                                    
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bot-header-wp">
    	<div class="container">
        	<div class="navigation-wp">
                <div id='cssmenu'>					
                    <ul class="submenu">
                       <li class='active'><a href='/'>Trang chủ</a></li>					   
					   <?php category_loop(0, false, false);?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- end header -->