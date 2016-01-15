<?php

// Add plugin navigation link
Navigation::add(__('Slider', 'slider'), 'content', 'slider', 4);

/**
 * Slider Admin Class
 */
class SliderAdmin extends Backend
{
    /**
     * Slider table
     *
     * @var object
     */
    public static $slider = null;

    /**
     * Main
     */
    public static function main()
    {
        // Get slider table
        SliderAdmin::$slider = new Table('slider');

        // Get pages table
        $pages = new Table('pages');

        // Create target array
        $slider_item_target_array = array( '' => '',
                                         '_blank' => '_blank',
                                         '_parent' => '_parent',
                                         '_top' => '_top');

        // Create order array
        $slider_item_order_array = range(0, 40);

        // Check for get actions
        // ---------------------------------------------
        if (Request::get('action')) {

            $add_mode = false;
            $item = array();

            // Switch actions
            // -----------------------------------------
            switch (Request::get('action')) {

                // Edit slider item
                // -----------------------------------------
                case "add":
                    $add_mode = true;
                    // fall thru to edit

                case "edit":

                    if ($add_mode) {
                        // set defaults
                        $item['title']        = '';
                        $item['summary']      = '';
                        $item['link']         = '';
                        $item['category']     = '';
                        $item['target']       = '';
                        $item['order']        = '';
                        $item['misc_text']    = '';
                        $item['image']        = '';
                    }
                    else {
                        // Select item
                        $item = SliderAdmin::$slider->select('[id="'.Request::get('item_id').'"]', null);    
                    }
                    
                    $map_fields = array(
                            'slider_item_title'        => 'title',
                            'slider_item_summary'      => 'summary',
                            'slider_item_link'         => 'link',
                            'slider_item_category'     => 'category',
                            'slider_item_target'       => 'target',
                            'slider_item_order'        => 'order',
                            'slider_item_misc_text'    => 'misc_text',
                            'slider_item_image'        => 'image'
                        );

                    $errors = array();

                    // Edit current slider item
                    if (Request::post('slider_add_item')) {

                        if (Security::check(Request::post('csrf'))) {

                            // apply posted data
                            // eg.  
                            //          if (Request::post('slider_item_title')) $item['title'] = Request::post('slider_item_title'); 
                            //
                            $data = array();
                            foreach ($map_fields as $key => $value) {
                                //if (Request::post($key)) 
                                $item[$value] = Request::post($key); 
                                $data[$value] = $item[$value];
                            }
                            // apply specialized fixups needed for DB:
                            $data['category'] = Security::safeName($data['category'], '-', true);

                            if (trim($item['title']) == '') {
                                // bad food
                                $errors['slider_item_title_empty'] = __('Required field', 'slider');
                            }

                            // Update slider item
                            if (count($errors) == 0) {
                                if ($add_mode)
                                    SliderAdmin::$slider->insert($data);
                                else
                                    SliderAdmin::$slider->update(Request::get('item_id'), $data);

                                Request::redirect('index.php?id=slider');
                            }

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }

                    }

                    // Display view
                    $v = View::factory('slider/views/backend/edit');
                    foreach ($map_fields as $key => $value) {
                        $v->assign($key, $item[$value]);
                    }
                    $v->assign('add_mode', $add_mode)
                            ->assign('slider_item_target_array', $slider_item_target_array)
                            ->assign('slider_item_order_array', $slider_item_order_array)
                            ->assign('errors', $errors)
                            ->assign('categories', SliderAdmin::getCategories())
                            ->assign('images', SliderAdmin::getImages())
                            ->assign('pages_list', SliderAdmin::getPages())
                            ->assign('components_list', SliderAdmin::getComponents())
                            ->display();

                break;

                // Add slider item
                // -----------------------------------------
                /*
                case "add":

                    $slider_item_title = '';
                    $slider_item_summary = '';
                    $slider_item_link = '';
                    $slider_item_category = '';
                    $slider_item_target = '';
                    $slider_item_order = '';
                    $slider_item_has_button = 0; //false;
                    $slider_item_button_class = '';
                    $slider_item_image = '';
                    $errors = array();

                    // Get current category
                    $slider_item_category = $current_category = (Request::get('category')) ? Request::get('category') : '' ;

                    // Add new slider item
                    if (Request::post('slider_add_item')) {

                        if (Security::check(Request::post('csrf'))) {

                            if (trim(Request::post('slider_item_title')) == '') {

                                if (Request::post('slider_item_title')) $slider_item_title = Request::post('slider_item_title'); else $slider_item_title = '';
                                if (Request::post('slider_item_summary')) $slider_item_summary = Request::post('slider_item_summary'); else $slider_item_summary = '';
                                if (Request::post('slider_item_link')) $slider_item_link = Request::post('slider_item_link'); else $slider_item_link = '';
                                if (Request::post('slider_item_category')) $slider_item_category = Request::post('slider_item_category'); else $slider_item_category = $current_category;
                                if (Request::post('slider_item_target')) $slider_item_target = Request::post('slider_item_target'); else $slider_item_target = '';
                                if (Request::post('slider_item_order')) $slider_item_order = Request::post('slider_item_order'); else $slider_item_order = '';
                                if (Request::post('slider_item_has_button')) $slider_item_has_button = Request::post('slider_item_has_button'); else $slider_item_has_button = 0;
                                if (Request::post('slider_item_button_class')) $slider_item_button_class = Request::post('slider_item_button_class'); else $slider_item_button_class = '';
                                if (Request::post('slider_item_image')) $slider_item_image = Request::post('slider_item_image'); else $slider_item_image = '';

                                $errors['slider_item_title_empty'] = __('Required field', 'slider');
                            }

                            // Insert new slider item
                            if (count($errors) == 0) {
                                SliderAdmin::$slider->insert(array('title' => Request::post('slider_item_title'),
                                                               'summary'       => Request::post('slider_item_summary'),
                                                               'link'       => Request::post('slider_item_link'),
                                                               'category'   => Security::safeName(Request::post('slider_item_category'), '-', true),
                                                               'target'     => Request::post('slider_item_target'),
                                                               'order'      => Request::post('slider_item_order'),
                                                               'has_button' => Request::post('slider_item_has_button'),
                                                               'button_class'=> Request::post('slider_item_button_class'),
                                                               'image'      => Request::post('slider_item_image')
                                                               ));

                                Request::redirect('index.php?id=slider');
                            }

                        } else { die('Request was denied because it contained an invalid security token. Please refresh the page and try again.'); }
                    }

                    // Display view
                    View::factory('slider/views/backend/add')
                            ->assign('slider_item_title', $slider_item_title)
                            ->assign('slider_item_summary', $slider_item_summary)
                            ->assign('slider_item_link', $slider_item_link)
                            ->assign('slider_item_category', $slider_item_category)
                            ->assign('slider_item_target', $slider_item_target)
                            ->assign('slider_item_order', $slider_item_order)
                            ->assign('slider_item_has_button', $slider_item_has_button)
                            ->assign('slider_item_button_class', $slider_item_button_class)
                            ->assign('slider_item_image', $slider_item_image)
                            ->assign('slider_item_target_array', $slider_item_target_array)
                            ->assign('slider_item_order_array', $slider_item_order_array)
                            ->assign('errors', $errors)
                            ->assign('categories', SliderAdmin::getCategories())
                            ->assign('images', SliderAdmin::getImages())
                            ->assign('pages_list', SliderAdmin::getPages())
                            ->assign('components_list', SliderAdmin::getComponents())
                            ->display();

                break;
                */
                case "usage":
                    // Display view
                    View::factory('slider/views/backend/usage')
                            ->assign('slider', SliderAdmin::$slider)
                            ->display();
                    break;

            }

        } else {

            // Delete slider item
            if (Request::get('delete_item')) {
                SliderAdmin::$slider->delete((int) Request::get('delete_item'));
            }

            // Display view
            View::factory('slider/views/backend/index')
                    ->assign('categories', SliderAdmin::getCategories())
                    ->assign('slider', SliderAdmin::$slider)
                    ->display();

        }

    }

    private static function _getImages($rootdir, $files_list, $base='') 
    {
        // Array of image types
        $image_types = array('jpg', 'png', 'gif');

        $dir = $rootdir.$base;
        $_dir = $dir;
        if (is_dir($dir)) {
            $dir = opendir ($dir);
            while (false !== ($file = readdir($dir))) {
                if (($file !=".") && ($file !=".."))
                { 
                    if (is_dir($_dir.$file)) {
                        $files_list = SliderAdmin::_getImages($rootdir, $files_list, $base.$file.'/');
                    }
                    elseif (in_array(File::ext($file), $image_types)) {
                        $files_list[] = $base.$file;
                    } 
                }

            }
            closedir($dir);
        }
    
        return $files_list;
    }

    /*
     * Get image files
     */
    public static function getImages()
    {
        $files = SliderAdmin::_getImages(ROOT . DS . 'public' . DS . 'uploads' . DS, array());
        natcasesort($files);
        return $files;
    }

    /**
     * Get categories
     */
    public static function getCategories()
    {
        $categories = array();

        $_categories = SliderAdmin::$slider->select(null, 'all', null, array('category'));

        foreach ($_categories as $category) {
            $categories[] = $category['category'];
        }

        return array_unique($categories);
    }

    /**
     * Get pages
     */
    protected static function getPages()
    {
        // Init vars
        $pages_array = array();
        $count = 0;

        // Get pages table
        $pages = new Table('pages');

        // Get Pages List
        $pages_list = $pages->select('[slug!="error404" and status="published"]');

        foreach ($pages_list as $page) {

            $pages_array[$count]['title']   = Html::toText($page['title']);
            $pages_array[$count]['parent']  = $page['parent'];
            $pages_array[$count]['date']    = $page['date'];
            $pages_array[$count]['author']  = $page['author'];
            $pages_array[$count]['slug']    = ($page['slug'] == Option::get('defaultpage')) ? '' : $page['slug'] ;

            if (isset($page['parent'])) {
                $c_p = $page['parent'];
            } else {
                $c_p = '';
            }

            if ($c_p != '') {
                $_page = $pages->select('[slug="'.$page['parent'].'"]', null);

                if (isset($_page['title'])) {
                    $_title = $_page['title'];
                } else {
                    $_title = '';
                }
                $pages_array[$count]['sort'] = $_title . ' ' . $page['title'];
            } else {
                $pages_array[$count]['sort'] = $page['title'];
            }
            $_title = '';
            $count++;
        }

        // Sort pages
        $_pages_list = Arr::subvalSort($pages_array, 'sort');

        // return
        return $_pages_list;
    }

    /**
     * Get components
     */
    protected static function getComponents()
    {
        $components = array();

        if (count(Plugin::$components) > 0) {
            foreach (Plugin::$components as $component) {
                if ($component !== 'pages' && $component !== 'sitemap') $components[] = Text::lowercase($component);
            }
        }

        return $components;
    }

}
