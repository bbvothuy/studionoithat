<?php namespace GoCart\Controller;
/**
 * AdminPages Class
 *
 * @package     GoCart
 * @subpackage  Controllers
 * @category    AdminPages
 * @author      Clear Sky Designs
 * @link        http://gocartdv.com
 */

class AdminPages extends Admin
{
    
    function __construct()
    {
        parent::__construct();

        \CI::auth()->check_access('Admin', true);
        \CI::lang()->load('pages');
        \CI::load()->model('pages');
    }
        
    function index()
    {
        $data['page_title'] = lang('pages');
        $data['pages']      = \CI::Pages()->get_pages_tiered();
        
        $this->view('pages', $data);
    }
    
    /********************************************************************
    edit page
    ********************************************************************/
    function form($id = false)
    {

        //set the default values
        $data['id']         = '';
        $data['title']      = '';
        $data['menu_title'] = '';
        $data['slug']       = '';
        $data['sequence']   = 0;
        $data['parent_id']  = 0;
        $data['content']    = '';
        $data['seo_title']  = '';
        $data['meta']       = '';
		$data['image']       = '';
        
        $data['page_title'] = lang('page_form');
        $data['pages']      = \CI::Pages()->get_pages();
        
        if($id)
        {
            
            $page           = \CI::Pages()->find($id);

            if(!$page)
            {
                //page does not exist
                \CI::session()->set_flashdata('error', lang('error_page_not_found'));
                redirect('admin/pages');
            }
            
            
            //set values to db values
            $data['id']             = $page->id;
            $data['parent_id']      = $page->parent_id;
            $data['title']          = $page->title;
            $data['menu_title']     = $page->menu_title;
            $data['sequence']       = $page->sequence;
            $data['content']        = $page->content;
            $data['seo_title']      = $page->seo_title;
            $data['meta']           = $page->meta;
            $data['slug']           = $page->slug;
			$data['image'] 			= $page->image;
        }
        
        \CI::form_validation()->set_rules('title', 'lang:title', 'trim|required');
        \CI::form_validation()->set_rules('menu_title', 'lang:menu_title', 'trim');
        \CI::form_validation()->set_rules('slug', 'lang:slug', 'trim');
        \CI::form_validation()->set_rules('seo_title', 'lang:seo_title', 'trim');
        \CI::form_validation()->set_rules('meta', 'lang:meta', 'trim');
        \CI::form_validation()->set_rules('sequence', 'lang:sequence', 'trim|integer');
        \CI::form_validation()->set_rules('parent_id', 'lang:parent_id', 'trim|integer');
        \CI::form_validation()->set_rules('content', 'lang:content', 'trim');
        
        // Validate the form
        if(\CI::form_validation()->run() == false)
        {
            $this->view('page_form', $data);
        }
        else
        {
            \CI::load()->helper('text');
            
            //first check the slug field
            $slug = \CI::input()->post('slug');
            
            //if it's empty assign the name field
            if(empty($slug) || $slug=='')
            {
                $slug = \CI::input()->post('title');
            }
            
            $slug   = url_title(convert_accented_characters($slug), 'dash', TRUE);
            
            //validate the slug
            $slug = ($id) ? \CI::Pages()->validate_slug($slug, $page->id) : \CI::Pages()->validate_slug($slug);

            $save = [];
            $save['id']         = $id;
            $save['parent_id']  = \CI::input()->post('parent_id');
            $save['title']      = \CI::input()->post('title');
            $save['menu_title'] = \CI::input()->post('menu_title'); 
            $save['sequence']   = \CI::input()->post('sequence');
            $save['content']    = \CI::input()->post('content');
            $save['seo_title']  = \CI::input()->post('seo_title');
            $save['meta']       = \CI::input()->post('meta');
            $save['slug']       = $slug;

            if(config_item('store_name') != 'default'){
                $store = config_item('store');
                $store_id = $store->id;
                if($store_id > 0){
                    $save['store_id'] = $store_id;
                }
            }

            //set the menu title to the page title if if is empty
            if ($save['menu_title'] == '')
            {
                $save['menu_title'] = \CI::input()->post('title');
            }
            
			
			$config['upload_path'] 		= 'uploads/images/full';
			$config['allowed_types'] 	= 'gif|jpg|png';
			$config['max_width'] 		= '2048';
			$config['max_height'] 		= '1536';
			$config['encrypt_name'] 	= true;
			\CI::load()->library('upload', $config);
			$uploaded = \CI::upload()->do_upload('image');			
			$image = \CI::upload()->data();			
			if($uploaded){
				$save['image'] = $image['file_name'];
				\CI::load()->library('image_lib');
			
				//this is the larger image
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'uploads/images/full/'.$image['file_name'];
				$config['new_image'] = 'uploads/images/medium/'.$image['file_name'];
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 700;
				$config['height'] = 500;
				\CI::image_lib()->initialize($config);
				\CI::image_lib()->resize();
				\CI::image_lib()->clear();

				//small image
				list($width, $height, $type, $attr) = getimagesize('uploads/images/medium/'.$image['file_name']);
				
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'uploads/images/medium/'.$image['file_name'];
				$config['new_image'] = 'uploads/images/small/'.$image['file_name'];
				$config['maintain_ratio'] = false;
				$config['width'] = 370;
				$config['height'] = 222;
				$config['x_axis'] = $width/2-$config['width']/2;
				$config['y_axis'] = $height/2-$config['height']/2;
				\CI::image_lib()->initialize($config);
				\CI::image_lib()->crop();
				\CI::image_lib()->clear();

				//cropped thumbnail
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'uploads/images/small/'.$save['image'];
				$config['new_image'] = 'uploads/images/thumbnails/'.$save['image'];
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 150;
				$config['height'] = 80;
				\CI::image_lib()->initialize($config); 
				\CI::image_lib()->resize(); 
				\CI::image_lib()->clear();	
			}			
			
            //save the page
            \CI::Pages()->save($save);

            \CI::session()->set_flashdata('message', lang('message_saved_page'));
            
            //go back to the page list
            redirect('admin/pages');
        }
    }
    
    function link_form($id = false)
    {
        
        //set the default values
        $data['id']         = '';
        $data['title']      = '';
        $data['url']        = '';
        $data['new_window'] = false;
        $data['sequence']   = 0;
        $data['parent_id']  = 0;

        
        $data['page_title'] = lang('link_form');
        $data['pages']      = \CI::Pages()->get_pages();
        if($id)
        {
            $page           = \CI::Pages()->find($id);

            if(!$page)
            {
                //page does not exist
                \CI::session()->set_flashdata('error', lang('error_link_not_found'));
                redirect('admin/pages');
            }
            
            
            //set values to db values
            $data['id']         = $page->id;
            $data['parent_id']  = $page->parent_id;
            $data['title']      = $page->title;
            $data['url']        = $page->url;
            $data['new_window'] = (bool)$page->new_window;
            $data['sequence']   = $page->sequence;
        }
        
        \CI::form_validation()->set_rules('title', 'lang:title', 'trim|required');
        \CI::form_validation()->set_rules('url', 'lang:url', 'trim|required');
        \CI::form_validation()->set_rules('sequence', 'lang:sequence', 'trim|integer');
        \CI::form_validation()->set_rules('new_window', 'lang:new_window', 'trim|integer');
        \CI::form_validation()->set_rules('parent_id', 'lang:parent_id', 'trim|integer');
        
        // Validate the form
        if(\CI::form_validation()->run() == false)
        {
            $this->view('link_form', $data);
        }
        else
        {   
            $save = [];
            $save['id']         = $id;
            $save['parent_id']  = \CI::input()->post('parent_id');
            $save['title']      = \CI::input()->post('title');
            $save['menu_title'] = \CI::input()->post('title'); 
            $save['url']        = \CI::input()->post('url');
            $save['sequence']   = \CI::input()->post('sequence');
            $save['new_window'] = (bool)\CI::input()->post('new_window');
            if(config_item('store_name') != 'default') {
                $store = config_item('store');
                $store_id = $store->id;
                if ($store_id > 0) {
                    $save['store_id'] = $store_id;
                }
            }
            //save the page
            \CI::Pages()->save($save);
            
            \CI::session()->set_flashdata('message', lang('message_saved_link'));
            
            //go back to the page list
            redirect('admin/pages');
        }
    }
    
    /********************************************************************
    delete page
    ********************************************************************/
    function delete($id)
    {
        
        $page   = \CI::Pages()->find($id);
        
        if($page)
        {
            $store      = config_item('store');
            $store_id   = $store->id;
            if($store_id > 0){
                if($store_id != $page->store_id)
                    redirect('admin/pages');
            }

            \CI::Pages()->delete_page($id);
            \CI::session()->set_flashdata('message', lang('message_deleted_page'));
        }
        else
        {
            \CI::session()->set_flashdata('error', lang('error_page_not_found'));
        }
        
        redirect('admin/pages');
    }
}   