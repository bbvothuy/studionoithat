<?php namespace GoCart\Controller;
/**
 * Page Class
 *
 * @package     GoCart
 * @subpackage  Controllers
 * @category    Page
 * @author      Clear Sky Designs
 * @link        http://gocartdv.com
 */

class News extends Front{
    public function show404()
    {
        $this->view('404');
    }

    public function index($slug=false, $show_title=true)
    {

        $news           = \CI::News()->find($slug);
        if(!$news)
        {
            throw_404();
        }
        else
        {
            //create view variable
            $data['news_title'] = false;
            if($show_title)
            {
                $data['news_title'] = $news->title;
            }
            $data['meta'] = $news->meta;
            $data['seo_title'] = (!empty($news->seo_title))?$news->seo_title:$news->title;
            $data['news'] = $news;

            //load the view
            $this->view('news', $data);
        }
    }

    public function api($slug)
    {
        \CI::load()->language('page');

        $page = $this->Page_model->slug($slug);

        if(!$page)
        {
            $json = json_encode(['error'=>lang('error_page_not_found')]);
        }
        else
        {
            $json = json_encode($page);
        }

        $this->view('json', ['json'=>json_encode($json)]);
    }
}

/* End of file Page.php */
/* Location: ./GoCart/controllers/Page.php */