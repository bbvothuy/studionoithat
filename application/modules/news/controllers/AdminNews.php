<?php namespace GoCart\Controller;
/**
 * AdminNews Class
 *
 * @package     GoCart
 * @subpackage  Controllers
 * @category    AdminNews
 * @author      Clear Sky Designs
 * @link        http://gocartdv.com
 */

class AdminNews extends Admin
{
    
    function __construct()
    {
        parent::__construct();
        \CI::auth()->check_access('Admin', true);
        \CI::lang()->load('news');
        \CI::load()->model('news');
    }
        
    function index()
    {
        $data['news_title'] = lang('news');
        $data['news']      = \CI::News()->get_news_tiered();
        
        $this->view('news', $data);
    }
    
    /********************************************************************
    edit news
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
        $data['keyword']    = '';
        $data['language']   = '';
        $data['description']= '';
		$data['image']       = '';

        $data['news_title'] = lang('news_form');
        $data['news']       = \CI::News()->get_news();
        
        if($id)
        {
            
            $news           = \CI::News()->find($id);

            if(!$news)
            {
                //news does not exist
                \CI::session()->set_flashdata('error', lang('error_news_not_found'));
                redirect('admin/news');
            }
            
            
            //set values to db values
            $data['id']             = $news->id;
            $data['parent_id']      = $news->parent_id;
            $data['title']          = $news->title;
            $data['menu_title']     = $news->menu_title;
            $data['sequence']       = $news->sequence;
            $data['content']        = $news->content;
            $data['seo_title']      = $news->seo_title;
            $data['meta']           = $news->meta;
            $data['keyword']        = $news->keyword;
            $data['slug']           = $news->slug;
            $data['language']       = $news->language;
            $data['description']    = $news->description;
			$data['image'] 			= $news->image;
        }
        
        \CI::form_validation()->set_rules('title', 'lang:title', 'trim|required');
        \CI::form_validation()->set_rules('menu_title', 'lang:menu_title', 'trim');
        \CI::form_validation()->set_rules('slug', 'lang:slug', 'trim');
        \CI::form_validation()->set_rules('seo_title', 'lang:seo_title', 'trim');
        \CI::form_validation()->set_rules('meta', 'lang:meta', 'trim');
        \CI::form_validation()->set_rules('sequence', 'lang:sequence', 'trim|integer');
        \CI::form_validation()->set_rules('content', 'lang:content', 'trim');

        $data['categories'] = \CI::News()->category_find(false);

        // Validate the form
        if(\CI::form_validation()->run() == false)
        {
            $this->view('news_form', $data);
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
            $slug = ($id) ? \CI::News()->validate_slug($slug, $news->id) : \CI::News()->validate_slug($slug);

            $save = [];
            $save['id']         = $id;
            $save['parent_id']  = \CI::input()->post('parent_id');
            $save['title']      = \CI::input()->post('title');
            $save['menu_title'] = \CI::input()->post('menu_title'); 
            $save['sequence']   = \CI::input()->post('sequence');
            $save['content']    = \CI::input()->post('content');
            $save['seo_title']  = \CI::input()->post('seo_title');
            $save['meta']       = \CI::input()->post('meta');
            $save['keyword']    = \CI::input()->post('keyword');
            $save['language']   = \CI::input()->post('language');
            $save['description']= \CI::input()->post('description');
            $save['slug']       = $slug;
            
            //set the menu title to the news title if if is empty
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
			
            //save the news
            \CI::News()->save($save);

            \CI::session()->set_flashdata('message', lang('message_saved_news'));
            
            //go back to the news list
            redirect('admin/news');
        }
    }

    /********************************************************************
    delete news
    ********************************************************************/
    function delete($id)
    {
        
        $news   = \CI::News()->find($id);
        
        if($news)
        {
            \CI::News()->delete_news($id);
            \CI::session()->set_flashdata('message', lang('message_deleted_news'));
        }
        else
        {
            \CI::session()->set_flashdata('error', lang('error_news_not_found'));
        }
        
        redirect('admin/news');
    }

    function category($id = 0){
        if($id == 0) {
            $data['news_title'] = lang('manage_category');
            $data['categories'] = \CI::News()->category_find($id);
            $this->view('news_categories', $data);
        }else{
            // hardcode to set add new category
            if($id == 99999){
                $id = 0;
            }
            //set the default values
            $data['id']         = '';
            $data['title']      = '';
            $data['menu_title'] = '';
            $data['slug']       = '';
            $data['sequence']   = 0;
            $data['content']    = '';
            $data['seo_title']  = '';
            $data['meta']       = '';
            $data['keyword']       = '';
            $data['language']       = '';

            $data['news_title'] = lang('news_category_form');

            if($id)
            {
                $category = \CI::News()->category_find($id);

                if(!$category)
                {
                    //news does not exist
                    \CI::session()->set_flashdata('error', lang('error_news_not_found'));
                    redirect('admin/news/category/0');
                }

                //set values to db values
                $data['id']             = $category->id;
                $data['title']          = $category->title;
                $data['menu_title']     = $category->menu_title;
                $data['sequence']       = $category->sequence;
                $data['content']        = $category->content;
                $data['seo_title']      = $category->seo_title;
                $data['meta']           = $category->meta;
                $data['keyword']        = $category->keyword;
                $data['slug']           = $category->slug;
                $data['language']       = $category->language;
            }

            \CI::form_validation()->set_rules('title', 'lang:title', 'trim|required');
            \CI::form_validation()->set_rules('menu_title', 'lang:menu_title', 'trim');
            \CI::form_validation()->set_rules('slug', 'lang:slug', 'trim');
            \CI::form_validation()->set_rules('seo_title', 'lang:seo_title', 'trim');
            \CI::form_validation()->set_rules('meta', 'lang:meta', 'trim');
            \CI::form_validation()->set_rules('sequence', 'lang:sequence', 'trim|integer');
            \CI::form_validation()->set_rules('content', 'lang:content', 'trim');


            // Validate the form
            if(\CI::form_validation()->run() == false)
            {
                $this->view('news_category_form', $data);
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
                $slug = ($id) ? \CI::News()->validate_slug($slug, $category->id) : \CI::News()->validate_slug($slug);

                $save = [];
                $save['id']         = $id;
                $save['title']      = \CI::input()->post('title');
                $save['menu_title'] = \CI::input()->post('menu_title');
                $save['sequence']   = \CI::input()->post('sequence');
                $save['content']    = \CI::input()->post('content');
                $save['seo_title']  = \CI::input()->post('seo_title');
                $save['meta']       = \CI::input()->post('meta');
                $save['keyword']    = \CI::input()->post('keyword');
                $save['language']   = \CI::input()->post('language');
                $save['slug']       = $slug;

                //set the menu title to the news title if if is empty
                if ($save['menu_title'] == '')
                {
                    $save['menu_title'] = \CI::input()->post('title');
                }

                //save the news category
                \CI::News()->save_category($save);

                \CI::session()->set_flashdata('message', lang('message_saved_news_category'));

                //go back to the news list
                redirect('admin/news/category/0');
            }
        }
    }

    function delete_category($id)
    {

        $news   = \CI::News()->category_find($id);

        if($news)
        {
            \CI::News()->delete_category($id);
            \CI::session()->set_flashdata('message', lang('message_deleted_news'));
        }
        else
        {
            \CI::session()->set_flashdata('error', lang('error_news_not_found'));
        }

        redirect('admin/news/category/0');
    }
}