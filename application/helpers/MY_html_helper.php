<?php

function load_jquery($front = false)
{

	//jquery & jquery ui files & path
	$path			= 'js/jquery';

	$jquery			= 'jquery-1.5.1.min.js';
	$jquery_ui		= 'jquery-ui-1.8.11.custom.min.js';
	$jquery_ui_css	= 'jquery-ui-1.8.11.custom.css';

	//load jquery ui css

	if($front)
	{
		echo link_tag($path.'/'.$front.'/'.$jquery_ui_css);
	}
	else
	{
		echo link_tag($path.'gocart/'.$jquery_ui_css);
	}
	//load scripts
	echo load_script($path.'/'.$jquery);
	echo load_script($path.'/'.$jquery_ui);

	//colorbox
	$path			= $path.'/colorbox';
	$colorbox		= 'jquery.colorbox-min.js';
	$colorbox_css	= 'colorbox.css';

	echo link_tag($path.'/'.$colorbox_css);
	echo load_script($path.'/'.$colorbox);
}

function load_script($path)
{
	return '<script type="text/javascript" src="/'.$path.'"></script>';
}

function pageHeader($string, $submit = false)
{
	if($submit == false){
		echo '<div class="page-header"><h1>'.$string.'</h1></div>';
	}else{
		echo '<div class="page-header row">';
		echo '<div class="col-md-6">';
		echo '<h1>'.$string.'</h1>';
		echo '</div>';
		echo '<div class="col-md-6 submit-on-top">';
		echo '<button type="submit" class="btn btn-primary">Save</button>';
		echo '</div>';
		echo '</div>';
	}
}
