<?php defined('BASEPATH') OR exit('No direct script access allowed');
//DO NOT EDIT THIS FILE
$document_root = $_SERVER["DOCUMENT_ROOT"];
//ClassMap for autoloader
$classes = array (
  'GoCart\\Controller\\AdminCod' => $document_root . '/addons/cod/controllers/AdminCod.php',
  'GoCart\\Controller\\Cod' => $document_root . '/addons/cod/controllers/Cod.php',
  'GoCart\\Controller\\AdminFlatRate' => $document_root . '/addons/flat_rate/controllers/AdminFlatRate.php',
  'GoCart\\Controller\\FlatRate' => $document_root . '/addons/flat_rate/controllers/FlatRate.php',
  'GoCart\\Controller\\Addresses' => $document_root . '/application/modules/addresses/controllers/Addresses.php',
  'GoCart\\Controller\\AdminBanners' => $document_root . '/application/modules/banners/controllers/Banners.php',
  'Banners' => $document_root . '/application/modules/banners/models/Banners.php',
  'GoCart\\Controller\\Cart' => $document_root . '/application/modules/cart/controllers/Cart.php',
  'GoCart\\Controller\\AdminCategories' => $document_root . '/application/modules/categories/controllers/AdminCategories.php',
  'GoCart\\Controller\\Category' => $document_root . '/application/modules/categories/controllers/Category.php',
  'Categories' => $document_root . '/application/modules/categories/models/Categories.php',
  'GoCart\\Controller\\Checkout' => $document_root . '/application/modules/checkout/controllers/Checkout.php',
  'GoCart\\Controller\\AdminCoupons' => $document_root . '/application/modules/coupons/controllers/AdminCoupons.php',
  'Coupons' => $document_root . '/application/modules/coupons/models/Coupons.php',
  'GoCart\\Controller\\AdminCustomers' => $document_root . '/application/modules/customers/controllers/AdminCustomers.php',
  'Customers' => $document_root . '/application/modules/customers/models/Customers.php',
  'GoCart\\Controller\\AdminDashboard' => $document_root . '/application/modules/dashboard/controllers/AdminDashboard.php',
  'GoCart\\Controller\\AdminDigitalProducts' => $document_root . '/application/modules/digital_products/controllers/AdminDigitalProducts.php',
  'GoCart\\Controller\\DigitalProducts' => $document_root . '/application/modules/digital_products/controllers/DigitalProducts.php',
  'DigitalProducts' => $document_root . '/application/modules/digital_products/models/Digitalproducts.php',
  'GoCart\\Controller\\AdminGiftCards' => $document_root . '/application/modules/gift_cards/controllers/AdminGiftCards.php',
  'GiftCards' => $document_root . '/application/modules/gift_cards/models/Giftcards.php',
  'GoCart\\Controller\\AdminLocations' => $document_root . '/application/modules/locations/controllers/AdminLocations.php',
  'Locations' => $document_root . '/application/modules/locations/models/Locations.php',
  'GoCart\\Controller\\AdminLogin' => $document_root . '/application/modules/login/controllers/AdminLogin.php',
  'GoCart\\Controller\\Login' => $document_root . '/application/modules/login/controllers/Login.php',
  'Login' => $document_root . '/application/modules/login/models/Login.php',
  'GoCart\\Controller\\MyAccount' => $document_root . '/application/modules/my_account/controllers/MyAccount.php',
  'GoCart\\Controller\\AdminOrders' => $document_root . '/application/modules/orders/controllers/AdminOrders.php',
  'Orders' => $document_root . '/application/modules/orders/models/Orders.php',
  'GoCart\\Controller\\AdminPages' => $document_root . '/application/modules/pages/controllers/AdminPages.php',
  'GoCart\\Controller\\Page' => $document_root . '/application/modules/pages/controllers/Page.php',
  'Pages' => $document_root . '/application/modules/pages/models/Pages.php',
  'GoCart\\Controller\\AdminPayments' => $document_root . '/application/modules/payments/controllers/AdminPayments.php',
  'GoCart\\Controller\\AdminProducts' => $document_root . '/application/modules/products/controllers/AdminProducts.php',
  'GoCart\\Controller\\Product' => $document_root . '/application/modules/products/controllers/Product.php',
  'ProductOptions' => $document_root . '/application/modules/products/models/Productoptions.php',
  'Products' => $document_root . '/application/modules/products/models/Products.php',
  'GoCart\\Controller\\AdminReports' => $document_root . '/application/modules/reports/controllers/AdminReports.php',
  'GoCart\\Controller\\Search' => $document_root . '/application/modules/search/controllers/Search.php',
  'Search' => $document_root . '/application/modules/search/models/Search.php',
  'GoCart\\Controller\\AdminSettings' => $document_root . '/application/modules/settings/controllers/AdminSettings.php',
  'Messages' => $document_root . '/application/modules/settings/models/Messages.php',
  'Settings' => $document_root . '/application/modules/settings/models/Settings.php',
  'GoCart\\Controller\\AdminShipping' => $document_root . '/application/modules/shipping/controllers/AdminShipping.php',
  'GoCart\\Controller\\AdminSitemap' => $document_root . '/application/modules/sitemap/controllers/AdminSitemap.php',
  'Tax' => $document_root . '/application/modules/tax/models/Tax.php',
  'GoCart\\Controller\\AdminUsers' => $document_root . '/application/modules/users/controllers/AdminUsers.php',
  'GoCart\\Controller\\AdminWysiwyg' => $document_root . '/application/modules/wysiwyg/controllers/AdminWysiwyg.php',
  'Auth' => $document_root . '/application/libraries/Auth.php',
  'Breadcrumbs' => $document_root . '/application/libraries/Breadcrumbs.php',
  'GoCart\\Emails' => $document_root . '/application/libraries/Emails.php',
  'MY_Form_validation' => $document_root . '/application/libraries/MY_Form_validation.php',
  'MY_Image_lib' => $document_root . '/application/libraries/MY_Image_lib.php',
  'Session' => $document_root . '/application/libraries/Session.php',
  'xmlparser' => $document_root . '/application/libraries/xmlparser.php',
  'GoCart\\Controller\\Admin' => $document_root . '/application/core/AdminController.php',
  'CI' => $document_root . '/application/core/CI.php',
  'GoCart\\Controller' => $document_root . '/application/core/Controller.php',
  'GoCart\\Controller\\Front' => $document_root . '/application/core/FrontController.php',
  'GC' => $document_root . '/application/core/GC.php',
  'GoCart' => $document_root . '/application/core/GoCart.php',
  'GoCart\\Libraries\\View' => $document_root . '/application/core/View.php',
  'GoCart\\Controller\\AdminNews' => $document_root . '/application/modules/news/controllers/AdminNews.php',
  'GoCart\\Controller\\News' => $document_root . '/application/modules/news/controllers/News.php',
  'News' => $document_root . '/application/modules/news/models/News.php',
);

//Available Payment Modules
$GLOBALS['paymentModules'] =array (
  0 => 
  array (
    'name' => 'Charge on Delivery',
    'key' => 'cod',
    'class' => 'Cod',
  ),
);

//Available Shipping Modules
$GLOBALS['shippingModules'] = array (
  0 => 
  array (
    'name' => 'Flat Rate',
    'key' => 'flat-rate',
    'class' => 'FlatRate',
  ),
);

//Theme Shortcodes
$GLOBALS['themeShortcodes'] = array (
  0 => 
  array (
    'shortcode' => 'banner',
    'method' => 
    array (
      0 => 'Banners',
      1 => 'show_collection',
    ),
  ),
  1 => 
  array (
    'shortcode' => 'category',
    'method' => 
    array (
      0 => 'GoCart\\Controller\\Category',
      1 => 'shortcode',
    ),
  ),
);

//Complete Module List
$GLOBALS['modules'] = array (
  0 => $document_root . '/application/modules/addresses',
  1 => $document_root . '/application/modules/banners',
  2 => $document_root . '/application/modules/cart',
  3 => $document_root . '/application/modules/categories',
  4 => $document_root . '/application/modules/checkout',
  5 => $document_root . '/application/modules/coupons',
  6 => $document_root . '/application/modules/customers',
  7 => $document_root . '/application/modules/dashboard',
  8 => $document_root . '/application/modules/digital_products',
  9 => $document_root . '/application/modules/gift_cards',
  10 => $document_root . '/application/modules/locations',
  11 => $document_root . '/application/modules/login',
  12 => $document_root . '/application/modules/my_account',
  13 => $document_root . '/application/modules/orders',
  14 => $document_root . '/application/modules/pages',
  15 => $document_root . '/application/modules/payments',
  16 => $document_root . '/application/modules/products',
  17 => $document_root . '/application/modules/reports',
  18 => $document_root . '/application/modules/search',
  19 => $document_root . '/application/modules/settings',
  20 => $document_root . '/application/modules/shipping',
  21 => $document_root . '/application/modules/sitemap',
  22 => $document_root . '/application/modules/tax',
  23 => $document_root . '/application/modules/users',
  24 => $document_root . '/application/modules/wysiwyg',
  25 => $document_root . '/addons/cod',
  26 => $document_root . '/addons/flat_rate',
  27 => $document_root . '/application/modules/news',
);

//Defined Routes
$routes = array (
  0 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/cod/form',
    2 => 'GoCart\\Controller\\AdminCod#form',
  ),
  1 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/cod/install',
    2 => 'GoCart\\Controller\\AdminCod#install',
  ),
  2 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/cod/uninstall',
    2 => 'GoCart\\Controller\\AdminCod#uninstall',
  ),
  3 => 
  array (
    0 => 'GET|POST',
    1 => '/cod/process-payment',
    2 => 'GoCart\\Controller\\Cod#processPayment',
  ),
  4 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/flat-rate/form',
    2 => 'GoCart\\Controller\\AdminFlatRate#form',
  ),
  5 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/flat-rate/install',
    2 => 'GoCart\\Controller\\AdminFlatRate#install',
  ),
  6 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/flat-rate/uninstall',
    2 => 'GoCart\\Controller\\AdminFlatRate#uninstall',
  ),
  7 => 
  array (
    0 => 'GET|POST',
    1 => '/addresses',
    2 => 'GoCart\\Controller\\Addresses#index',
  ),
  8 => 
  array (
    0 => 'GET|POST',
    1 => '/addresses/json',
    2 => 'GoCart\\Controller\\Addresses#addressJSON',
  ),
  9 => 
  array (
    0 => 'GET|POST',
    1 => '/addresses/form/[i:id]?',
    2 => 'GoCart\\Controller\\Addresses#form',
  ),
  10 => 
  array (
    0 => 'GET|POST',
    1 => '/addresses/delete/[i:id]',
    2 => 'GoCart\\Controller\\Addresses#delete',
  ),
  11 => 
  array (
    0 => 'GET|POST',
    1 => '/addresses/get-zone-options/[i:id]/[:type]',
    2 => 'GoCart\\Controller\\Addresses#getZoneOptions',
  ),
  12 => 
  array (
    0 => 'GET',
    1 => '/admin/banners',
    2 => 'GoCart\\Controller\\AdminBanners#index',
  ),
  13 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/banners/banner_collection_form/[i:id]?',
    2 => 'GoCart\\Controller\\AdminBanners#banner_collection_form',
  ),
  14 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/banners/delete_banner_collection/[i:id]',
    2 => 'GoCart\\Controller\\AdminBanners#delete_banner_collection',
  ),
  15 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/banners/banner_collection/[i:id]',
    2 => 'GoCart\\Controller\\AdminBanners#banner_collection',
  ),
  16 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/banners/banner_form/[i:banner_collection_id]/[i:id]?',
    2 => 'GoCart\\Controller\\AdminBanners#banner_form',
  ),
  17 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/banners/delete_banner/[i:id]',
    2 => 'GoCart\\Controller\\AdminBanners#delete_banner',
  ),
  18 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/banners/organize',
    2 => 'GoCart\\Controller\\AdminBanners#organize',
  ),
  19 => 
  array (
    0 => 'GET|POST',
    1 => '/cart/summary',
    2 => 'GoCart\\Controller\\Cart#summary',
  ),
  20 => 
  array (
    0 => 'GET|POST',
    1 => '/cart/add-to-cart',
    2 => 'GoCart\\Controller\\Cart#addToCart',
  ),
  21 => 
  array (
    0 => 'GET|POST',
    1 => '/cart/update-cart',
    2 => 'GoCart\\Controller\\Cart#updateCart',
  ),
  22 => 
  array (
    0 => 'GET|POST',
    1 => '/cart/submit-coupon',
    2 => 'GoCart\\Controller\\Cart#submitCoupon',
  ),
  23 => 
  array (
    0 => 'GET|POST',
    1 => '/cart/submit-gift-card',
    2 => 'GoCart\\Controller\\Cart#submitGiftCard',
  ),
  24 => 
  array (
    0 => 'GET',
    1 => '/admin/categories',
    2 => 'GoCart\\Controller\\AdminCategories#index',
  ),
  25 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/categories/form/[i:id]?',
    2 => 'GoCart\\Controller\\AdminCategories#form',
  ),
  26 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/categories/delete/[i:id]',
    2 => 'GoCart\\Controller\\AdminCategories#delete',
  ),
  27 => 
  array (
    0 => 'GET|POST',
    1 => '/category/[:slug]/[:sort]?/[:dir]?/[:page]?',
    2 => 'GoCart\\Controller\\Category#index',
  ),
  28 => 
  array (
    0 => 'GET|POST',
    1 => '/checkout',
    2 => 'GoCart\\Controller\\Checkout#index',
  ),
  29 => 
  array (
    0 => 'GET|POST',
    1 => '/checkout/address-list',
    2 => 'GoCart\\Controller\\Checkout#addressList',
  ),
  30 => 
  array (
    0 => 'GET|POST',
    1 => '/checkout/submit-order',
    2 => 'GoCart\\Controller\\Checkout#submitOrder',
  ),
  31 => 
  array (
    0 => 'GET|POST',
    1 => '/order-complete/[:order_id]',
    2 => 'GoCart\\Controller\\Checkout#orderComplete',
  ),
  32 => 
  array (
    0 => 'GET|POST',
    1 => '/order-complete-email/[:order_id]',
    2 => 'GoCart\\Controller\\Checkout#orderCompleteEmail',
  ),
  33 => 
  array (
    0 => 'GET|POST',
    1 => '/checkout/address',
    2 => 'GoCart\\Controller\\Checkout#address',
  ),
  34 => 
  array (
    0 => 'GET|POST',
    1 => '/checkout/payment-methods',
    2 => 'GoCart\\Controller\\Checkout#paymentMethods',
  ),
  35 => 
  array (
    0 => 'GET|POST',
    1 => '/checkout/shipping-methods',
    2 => 'GoCart\\Controller\\Checkout#shippingMethods',
  ),
  36 => 
  array (
    0 => 'GET|POST',
    1 => '/checkout/set-shipping-method',
    2 => 'GoCart\\Controller\\Checkout#setShippingMethod',
  ),
  37 => 
  array (
    0 => 'GET',
    1 => '/admin/coupons',
    2 => 'GoCart\\Controller\\AdminCoupons#index',
  ),
  38 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/coupons/form/[i:id]?',
    2 => 'GoCart\\Controller\\AdminCoupons#form',
  ),
  39 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/coupons/delete/[i:id]',
    2 => 'GoCart\\Controller\\AdminCoupons#delete',
  ),
  40 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/customers/export',
    2 => 'GoCart\\Controller\\AdminCustomers#export',
  ),
  41 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/customers/get_subscriber_list',
    2 => 'GoCart\\Controller\\AdminCustomers#getSubscriberList',
  ),
  42 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/customers/form/[i:id]?',
    2 => 'GoCart\\Controller\\AdminCustomers#form',
  ),
  43 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/customers/addresses/[i:id]',
    2 => 'GoCart\\Controller\\AdminCustomers#addresses',
  ),
  44 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/customers/delete/[i:id]?',
    2 => 'GoCart\\Controller\\AdminCustomers#delete',
  ),
  45 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/customers/groups',
    2 => 'GoCart\\Controller\\AdminCustomers#groups',
  ),
  46 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/customers/group_form/[i:id]?',
    2 => 'GoCart\\Controller\\AdminCustomers#groupForm',
  ),
  47 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/customers/delete_group/[i:id]?',
    2 => 'GoCart\\Controller\\AdminCustomers#deleteGroup',
  ),
  48 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/customers/address_list/[i:id]?',
    2 => 'GoCart\\Controller\\AdminCustomers#addressList',
  ),
  49 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/customers/address_form/[i:customer_id]/[i:id]?',
    2 => 'GoCart\\Controller\\AdminCustomers#addressForm',
  ),
  50 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/customers/delete_address/[i:customer_id]/[i:id]',
    2 => 'GoCart\\Controller\\AdminCustomers#deleteAddress',
  ),
  51 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/customers/contact_list',
    2 => 'GoCart\\Controller\\AdminCustomers#contact_list',
  ),
  52 => 
  array (
    0 => 'GET',
    1 => '/admin/dashboard',
    2 => 'GoCart\\Controller\\AdminDashboard#index',
  ),
  53 => 
  array (
    0 => 'GET',
    1 => '/admin',
    2 => 'GoCart\\Controller\\AdminDashboard#index',
  ),
  54 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/digital_products/form/[i:id]?',
    2 => 'GoCart\\Controller\\AdminDigitalProducts#form',
  ),
  55 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/digital_products/delete/[i:id]',
    2 => 'GoCart\\Controller\\AdminDigitalProducts#delete',
  ),
  56 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/digital_products',
    2 => 'GoCart\\Controller\\AdminDigitalProducts#index',
  ),
  57 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/gift-cards/form',
    2 => 'GoCart\\Controller\\AdminGiftCards#form',
  ),
  58 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/gift-cards/delete/[i:id]',
    2 => 'GoCart\\Controller\\AdminGiftCards#delete',
  ),
  59 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/gift-cards/enable',
    2 => 'GoCart\\Controller\\AdminGiftCards#enable',
  ),
  60 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/gift-cards/disable',
    2 => 'GoCart\\Controller\\AdminGiftCards#disable',
  ),
  61 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/gift-cards/settings',
    2 => 'GoCart\\Controller\\AdminGiftCards#settings',
  ),
  62 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/gift-cards',
    2 => 'GoCart\\Controller\\AdminGiftCards#index',
  ),
  63 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/locations/zone_areas/[i:id]',
    2 => 'GoCart\\Controller\\AdminLocations#zone_areas',
  ),
  64 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/locations/delete_zone_area/[i:id]',
    2 => 'GoCart\\Controller\\AdminLocations#delete_zone_area',
  ),
  65 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/locations/zone_area_form/[i:zone_id]/[i:id]?',
    2 => 'GoCart\\Controller\\AdminLocations#zone_area_form',
  ),
  66 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/locations/zones/[i:id]',
    2 => 'GoCart\\Controller\\AdminLocations#zones',
  ),
  67 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/locations/zone_form/[i:id]?',
    2 => 'GoCart\\Controller\\AdminLocations#zone_form',
  ),
  68 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/locations/delete_zone/[i:id]',
    2 => 'GoCart\\Controller\\AdminLocations#delete_zone',
  ),
  69 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/locations/get_zone_menu',
    2 => 'GoCart\\Controller\\AdminLocations#get_zone_menu',
  ),
  70 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/locations/country_form/[i:id]?',
    2 => 'GoCart\\Controller\\AdminLocations#country_form',
  ),
  71 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/locations/delete_country/[i:id]',
    2 => 'GoCart\\Controller\\AdminLocations#delete_country',
  ),
  72 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/locations/organize_countries',
    2 => 'GoCart\\Controller\\AdminLocations#organize_countries',
  ),
  73 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/locations',
    2 => 'GoCart\\Controller\\AdminLocations#index',
  ),
  74 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/login',
    2 => 'GoCart\\Controller\\AdminLogin#login',
  ),
  75 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/logout',
    2 => 'GoCart\\Controller\\AdminLogin#logout',
  ),
  76 => 
  array (
    0 => 'GET|POST',
    1 => '/login/[:redirect]?',
    2 => 'GoCart\\Controller\\Login#login',
  ),
  77 => 
  array (
    0 => 'GET|POST',
    1 => '/logout',
    2 => 'GoCart\\Controller\\Login#logout',
  ),
  78 => 
  array (
    0 => 'GET|POST',
    1 => '/forgot-password',
    2 => 'GoCart\\Controller\\Login#forgotPassword',
  ),
  79 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/forgot-password',
    2 => 'GoCart\\Controller\\AdminLogin#forgotPassword',
  ),
  80 => 
  array (
    0 => 'GET|POST',
    1 => '/register',
    2 => 'GoCart\\Controller\\Login#register',
  ),
  81 => 
  array (
    0 => 'GET|POST',
    1 => '/my-account',
    2 => 'GoCart\\Controller\\MyAccount#index',
  ),
  82 => 
  array (
    0 => 'GET|POST',
    1 => '/my-account/downloads',
    2 => 'GoCart\\Controller\\MyAccount#downloads',
  ),
  83 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/orders/form/[i:id]?',
    2 => 'GoCart\\Controller\\AdminOrders#form',
  ),
  84 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/orders/export',
    2 => 'GoCart\\Controller\\AdminOrders#export',
  ),
  85 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/orders/bulk_delete',
    2 => 'GoCart\\Controller\\AdminOrders#bulk_delete',
  ),
  86 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/orders/order/[:orderNumber]',
    2 => 'GoCart\\Controller\\AdminOrders#order',
  ),
  87 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/orders/sendNotification/[:orderNumber]',
    2 => 'GoCart\\Controller\\AdminOrders#sendNotification',
  ),
  88 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/orders/packing_slip/[:orderNumber]',
    2 => 'GoCart\\Controller\\AdminOrders#packing_slip',
  ),
  89 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/orders/edit_status',
    2 => 'GoCart\\Controller\\AdminOrders#edit_status',
  ),
  90 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/orders/delete/[i:id]',
    2 => 'GoCart\\Controller\\AdminOrders#delete',
  ),
  91 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/orders',
    2 => 'GoCart\\Controller\\AdminOrders#index',
  ),
  92 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/orders/index/[:orderBy]?/[:orderDir]?/[:code]?/[i:page]?',
    2 => 'GoCart\\Controller\\AdminOrders#index',
  ),
  93 => 
  array (
    0 => 'GET|POST',
    1 => '/digital-products/download/[i:fileId]/[i:orderId]',
    2 => 'GoCart\\Controller\\DigitalProducts#download',
  ),
  94 => 
  array (
    0 => 'GET',
    1 => '/admin/pages',
    2 => 'GoCart\\Controller\\AdminPages#index',
  ),
  95 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/pages/form/[i:id]?',
    2 => 'GoCart\\Controller\\AdminPages#form',
  ),
  96 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/pages/link_form/[i:id]?',
    2 => 'GoCart\\Controller\\AdminPages#link_form',
  ),
  97 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/pages/delete/[i:id]',
    2 => 'GoCart\\Controller\\AdminPages#delete',
  ),
  98 => 
  array (
    0 => 'GET|POST',
    1 => '/page/[:slug]',
    2 => 'GoCart\\Controller\\Page#index',
  ),
  99 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/payments',
    2 => 'GoCart\\Controller\\AdminPayments#index',
  ),
  100 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/products/product_autocomplete',
    2 => 'GoCart\\Controller\\AdminProducts#product_autocomplete',
  ),
  101 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/products/bulk_save',
    2 => 'GoCart\\Controller\\AdminProducts#bulk_save',
  ),
  102 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/products/product_image_form',
    2 => 'GoCart\\Controller\\AdminProducts#product_image_form',
  ),
  103 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/products/product_image_upload',
    2 => 'GoCart\\Controller\\AdminProducts#product_image_upload',
  ),
  104 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/products/form/[i:id]?/[i:copy]?',
    2 => 'GoCart\\Controller\\AdminProducts#form',
  ),
  105 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/products/gift-card-form/[i:id]?/[i:copy]?',
    2 => 'GoCart\\Controller\\AdminProducts#giftCardForm',
  ),
  106 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/products/delete/[i:id]',
    2 => 'GoCart\\Controller\\AdminProducts#delete',
  ),
  107 => 
  array (
	0 => 'GET|POST',
    1 => '/admin/products/product_bonus',
    2 => 'GoCart\\Controller\\AdminProducts#product_bonus',
  ),
  108 => 
  array (
    0 => 'GET|POST',
    1 => '/product/get_product/[:slug]',
    2 => 'GoCart\\Controller\\Product#get_product',
  ),
  109 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/reports',
    2 => 'GoCart\\Controller\\AdminReports#index',
  ),
  110 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/reports/best_sellers',
    2 => 'GoCart\\Controller\\AdminReports#best_sellers',
  ),
  111 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/reports/sales',
    2 => 'GoCart\\Controller\\AdminReports#sales',
  ),
  112 => 
  array (
    0 => 'GET|POST',
    1 => '/search/[:code]?/[:sort]?/[:dir]?/[:page]?',
    2 => 'GoCart\\Controller\\Search#index',
  ),
  113 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/settings',
    2 => 'GoCart\\Controller\\AdminSettings#index',
  ),
  114 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/settings/canned_messages',
    2 => 'GoCart\\Controller\\AdminSettings#canned_messages',
  ),
  115 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/settings/canned_message_form/[i:id]?',
    2 => 'GoCart\\Controller\\AdminSettings#canned_message_form',
  ),
  116 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/settings/delete_message/[i:id]',
    2 => 'GoCart\\Controller\\AdminSettings#delete_message',
  ),
  117 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/shipping',
    2 => 'GoCart\\Controller\\AdminShipping#index',
  ),
  118 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/sitemap',
    2 => 'GoCart\\Controller\\AdminSitemap#index',
  ),
  119 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/sitemap/new-sitemap',
    2 => 'GoCart\\Controller\\AdminSitemap#newSitemap',
  ),
  120 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/sitemap/generate-products',
    2 => 'GoCart\\Controller\\AdminSitemap#generateProducts',
  ),
  121 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/sitemap/generate-pages',
    2 => 'GoCart\\Controller\\AdminSitemap#generatePages',
  ),
  122 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/sitemap/generate-categories',
    2 => 'GoCart\\Controller\\AdminSitemap#generateCategories',
  ),
  123 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/sitemap/complete-sitemap',
    2 => 'GoCart\\Controller\\AdminSitemap#completeSitemap',
  ),
  124 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/users',
    2 => 'GoCart\\Controller\\AdminUsers#index',
  ),
  125 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/users/form/[i:id]?',
    2 => 'GoCart\\Controller\\AdminUsers#form',
  ),
  126 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/users/delete/[i:id]',
    2 => 'GoCart\\Controller\\AdminUsers#delete',
  ),
  127 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/wysiwyg/upload_image',
    2 => 'GoCart\\Controller\\AdminWysiwyg#upload_image',
  ),
  128 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/wysiwyg/get_images',
    2 => 'GoCart\\Controller\\AdminWysiwyg#get_images',
  ),
  129 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/settings/stores/[i:id]?',
    2 => 'GoCart\\Controller\\AdminSettings#stores',
  ),
  130 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/settings/form_store/[i:id]?/[:page]?',
    2 => 'GoCart\\Controller\\AdminSettings#form_store',
  ),
  131 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/settings/permissions/[i:id]?',
    2 => 'GoCart\\Controller\\AdminSettings#permissions',
  ),
  132 => 
  array (
    0 => 'GET|POST',
    1 => '/product/add_cart_product/[:slug]',
    2 => 'GoCart\\Controller\\Product#add_cart_product',
  ),
  133 => 
  array (
    0 => 'GET|POST',
    1 => '/product/get_list_items',
    2 => 'GoCart\\Controller\\Product#get_list_items',
  ),
  134 => 
  array (
    0 => 'GET|POST',
    1 => '/product/add_wishlist',
    2 => 'GoCart\\Controller\\Product#add_wishlist',
  ),
  135 => 
  array (
    0 => 'GET|POST',
    1 => '/product/get_list_wishlist',
    2 => 'GoCart\\Controller\\Product#get_list_wishlist',
  ),
  136 => 
  array (  
    0 => 'GET|POST',
    1 => '/admin/products/[i:rows]?/[:order_by]?/[:sort_order]?/[:code]?/[i:page]?',
    2 => 'GoCart\\Controller\\AdminProducts#index',
  ),
  137 => 
  array (
    0 => 'GET|POST',
    1 => '/cart/addShiping',
    2 => 'GoCart\\Controller\\Cart#addShiping',
  ), 
  138 =>
  array (
    0 => 'GET|POST',
    1 => '/product/others/[:slug]',
    2 => 'GoCart\\Controller\\Product#others',
  ),
  139 =>
  array (
      0 => 'GET|POST',
      1 => '/admin/customers/suppliers',
      2 => 'GoCart\\Controller\\AdminCustomers#suppliers',
  ),
  140 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/sitemap/ping-search-engines',
    2 => 'GoCart\\Controller\\AdminSitemap#pingSearchEngines',
  ),
  141 => 
  array (
    0 => 'GET|POST',
    1 => '/admin/sitemap/download-sitemap',
    2 => 'GoCart\\Controller\\AdminSitemap#downloadSiteMap',
  ),
  142 =>
        array (
            0 => 'GET',
            1 => '/admin/news',
            2 => 'GoCart\\Controller\\AdminNews#index',
        ),
    143 =>
        array (
            0 => 'GET|POST',
            1 => '/admin/news/form/[i:id]?',
            2 => 'GoCart\\Controller\\AdminNews#form',
        ),
    144 =>
        array (
            0 => 'GET|POST',
            1 => '/admin/news/category_form/[i:id]?',
            2 => 'GoCart\\Controller\\AdminNews#category_form',
        ),
    145 =>
        array (
            0 => 'GET|POST',
            1 => '/admin/news/category/[i:id]?',
            2 => 'GoCart\\Controller\\AdminNews#category',
        ),
    146 =>
        array (
            0 => 'GET|POST',
            1 => '/admin/news/delete/[i:id]',
            2 => 'GoCart\\Controller\\AdminNews#delete',
        ),
    147 =>
        array (
            0 => 'GET|POST',
            1 => '/admin/news/delete_category/[i:id]',
            2 => 'GoCart\\Controller\\AdminNews#delete_category',
        ),
    148 =>
        array (
            0 => 'GET|POST',
            1 => '/news/category/[:slug]',
            2 => 'GoCart\\Controller\\News#category',
        ),
    149 =>
        array (
            0 => 'GET|POST',
            1 => '/news/search/[:slug]',
            2 => 'GoCart\\Controller\\News#search',
        ),
    150 =>
        array (
            0 => 'GET|POST',
            1 => '/news/[:slug]',
            2 => 'GoCart\\Controller\\News#index',
        ),
	151 =>
        array (
            0 => 'GET|POST',
            1 => '/admin/customers/[:order_by]?/[:direction]?/[i:page]?',
            2 => 'GoCart\\Controller\\AdminCustomers#index',
        ),
	152 =>
        array (
            0 => 'GET|POST',
            1 => '/product/get_update',
            2 => 'GoCart\\Controller\\Product#get_update',
        ),
    153 =>
        array (
            0 => 'GET|POST',
            1 => '/product/get_all_data_products/[:pid]/[:cid]',
            2 => 'GoCart\\Controller\\Product#get_all_data_products',
        ),
	154 =>
        array (
            0 => 'GET|POST',
            1 => '/[:slug].html',
            2 => 'GoCart\\Controller\\Product#index',
        ),		
	155 =>
        array (
            0 => 'GET|POST',
            1 => '/[:slug].htm',
            2 => 'GoCart\\Controller\\Product#index',
        ),
	156 =>
	array (
		0 => 'GET|POST',
		1 => '/[:slug].html/[].html',
		2 => 'GoCart\\Controller\\Product#index',
	),	
	157 =>
        array (
            0 => 'GET|POST',
            1 => '/[].html/[:slug]',
            2 => 'GoCart\\Controller\\Product#index',
        ), 
	158 =>
		array (
		0 => 'GET|POST',
		1 => '/[]/[:slug].html',
		2 => 'GoCart\\Controller\\Product#index',
	), 	
	159 => 
	  array (
		0 => 'GET|POST',
		1 => '/[:slug]/[:sort]?/[:dir]?/[:page]?',
		2 => 'GoCart\\Controller\\Category#index',
	  ),
);