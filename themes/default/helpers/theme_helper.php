<?php

include('crunch.php');
include('Parsedown.php');
include('content_filter.php');

function category_loop($parent = 0, $ulattribs=false, $ul=true)
{
    $cats = CI::Categories()->get_categories_tiered();

    $items = false;
    if(isset($cats[$parent]))
    {
        $items = $cats[$parent];
    }
    
    if($items)
    {
        echo ($ul)?'<ul '.$ulattribs.'>':'';
        foreach($items as $item)
        {   

            $selected = (CI::uri()->segment(2) == $item->slug)?'class="selected"':'';
            
            //add the chevron if this has a drop menu
            $name = $item->name;
            if(CI::Categories()->tier($item->id))
            {
                //$name .= ' <i class="icon-chevron-down dropdown"></i>';
				$anchor = '<a href="/'.$item->slug.'">'.$name.'</a>';
            }else{
				$anchor = anchor('/'.$item->slug, $name, $selected);
			}
            
            echo '<li>'.$anchor;
            category_loop($item->id, 'submenu2', true);
            echo '</li>';
        }
        echo ($ul)?'</ul>':'';
    }
}

function category_loop_mobile($parent = 0, $ulattribs=false, $ul=true)
{
    $cats = CI::Categories()->get_categories_tiered();

    $items = false;
    if(isset($cats[$parent]))
    {
        $items = $cats[$parent];
    }
    
    if($items)
    {
        echo ($ul)?'<ul '.$ulattribs.'>':'';
        foreach($items as $item)
        {   

			if($ul){
				$selected = (CI::uri()->segment(2) == $item->slug)?'class="selected"':'';				
				//add the chevron if this has a drop menu
				$name = $item->name;
				$anchor = anchor('/'.$item->slug, $name, $selected);				
				echo '<li>'.$anchor;				
				echo '</li>';
			}else{
				$selected = (CI::uri()->segment(2) == $item->slug)?'class="selected"':'';
				
				//add the chevron if this has a drop menu
				$name = $item->name;
				if(CI::Categories()->tier($item->id))
				{
					//$name .= ' <i class="icon-chevron-down dropdown"></i>';
					$anchor = '<span>' . $name . '</span>';
				}else{
					$anchor = anchor('/'.$item->slug, $name, $selected);
				}
				echo '<li>'.$anchor;
				category_loop($item->id, '', true);
				echo '</li>';
			}
        }
        echo ($ul)?'</ul>':'';
    }
}

function category_loop_tat_ca_sp($parent, $cat_id = ''){	
	$cats = CI::Categories()->get_categories_tiered();
    $items = false;
    if(isset($cats[$parent]))
    {
        $items = $cats[$parent];
    }
    
    if($items)
    {        
        foreach($items as $item)
        {
            if($item->id == $cat_id)
				echo '<li class="active"><a class="category-search" data-cat-name="'.$item->name.'" data-cat-id="'.$item->id.'">'.$item->name;
			else
				echo '<li><a class="category-search" data-cat-name="'.$item->name.'" data-cat-id="'.$item->id.'">'.$item->name;
            echo '</a></li>';
        }        
    }
}

function category_left($parent, $cate_id){
	$cats = CI::Categories()->get_categories_tiered();
    $items = false;
    if(isset($cats[$parent]))
    {
        $items = $cats[$parent];
    }
    
    if($items)
    {        
        foreach($items as $item)
        {
			if($item->id == $cate_id)
				$class = 'class="active"';
			else $class = '';
			
			if(isset($cats[$item->id]) && !empty($cats[$item->id])){
				echo '<li><a id="parent-id-'.$item->id.'" '.$class.' data-cat-id="'.$item->id.'">'.$item->name;
				echo '</a><ul>';
					sub_category_left($item->id, $cate_id);						
				echo '</ul></li>';
			}else{
				echo '<li><a '.$class.' href="'.url_cate($item->slug).'"data-cat-id="'.$item->id.'">'.$item->name;
				echo '</a></li>';
			}
           
        }        
    }
}
function sub_category_left($parent, $cate_id){
	$cats = CI::Categories()->get_categories_tiered();
    $items = false;
    if(isset($cats[$parent]))
    {
        $items = $cats[$parent];
    }
    
    if($items)
    {        
        foreach($items as $item)
        {
			if($item->id == $cate_id)
				$class = 'class="active"';
			else $class = '';			
			echo '<li><a parent-id="'.$parent.'" id="child-id-'.$item->id.'" '.$class.' href="'.url_cate($item->slug).'"data-cat-id="'.$item->id.'">'.$item->name;
			echo '</a></li>';
           
        }        
    }
}

function page_loop($parent = 0, $ulattribs=false, $ul=true)
{
    $pages = CI::Pages()->get_pages_tiered();

    $items = false;
    if(isset($pages[$parent]))
    {
        $items = $pages[$parent];
    }

    if($items)
    {
        echo ($ul)?'<ul '.$ulattribs.'>':'';
        foreach($items as $item)
        {
            echo '<li>';
            $chevron = ' <i class="icon-chevron-down dropdown"></i>';
            
            if($item->slug == '')
            {
                //add the chevron if this has a drop menu
                $name = $item->title;
                if(isset($pages[$item->id]))
                {
                    $name .= $chevron;
                }

                $target = ($item->new_window)?' target="_blank"':'';
                $anchor = '<a href="'.$item->url.'"'.$target.'>'.$name.'</a>';
            }
            else
            {
                //add the chevron if this has a drop menu
                $name = $item->menu_title;
                if(isset($pages[$item->id]))
                {
                    $name .= $chevron;
                }
                $selected = (CI::uri()->segment(2) == $item->slug)?'class="selected"':'';
                $anchor = anchor('page/'.$item->slug, $name, $selected);
            }

            echo $anchor;
            page_loop($item->id);
            echo '</li>';
        }
        echo ($ul)?'</ul>':'';
    }
}