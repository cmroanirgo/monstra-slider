<h2 class="margin-bottom-1"><?php echo __($add_mode ? 'New Item' : 'Edit item', 'slider'); ?></h2>

<div class="row">
    <div class="col-md-6">

        <?php echo (Form::open()); ?>

        <?php echo (Form::hidden('csrf', Security::token())); ?>

        <?php if (isset($errors['slider_item_title_empty'])) $error_class = ' error'; else $error_class = ''; ?>

    
        <div class="form-group margin-top-2">
        <?php
            echo Form::label('slider_item_title', __('Item title', 'slider'));
            echo Form::input('slider_item_title', $slider_item_title, array('class' => (isset($errors['slider_item_title_empty']) || isset($errors['slider_item_title_empty'])) ? 'form-control error-field' : 'form-control'));
            if (isset($errors['slider_item_title_empty'])) echo Html::nbsp(4).'<span style="color:red;">'.$errors['slider_item_title_empty'].'</span>';
        ?>
        </div>
        <div class="form-group">
        <?php
            echo Form::label('slider_item_link', __('Item link', 'slider')); ?>
            <div class="input-group">
                <?php echo Form::input('slider_item_link', $slider_item_link, array('class' => 'form-control')) ?>
                <a href="#" class="btn btn-phone btn-default input-group-addon" data-toggle="modal" data-toggle="modal" data-target="#selectPageModal">...</a>
            </div>
        </div>
        <div class="form-group">
        <?php
            echo (
                Form::label('slider_item_summary', __('Item summary', 'slider')).
                Form::textarea('slider_item_summary', $slider_item_summary, array('class' => 'form-control'))
            );
        ?>
        </div>
        <div class="form-group">
        <?php
            echo (
                Form::label('slider_item_misc_text', __('Misc text', 'slider')).
                Form::input('slider_item_misc_text', $slider_item_misc_text, array('class' => 'form-control'))
            );
        ?>
        </div>
        <div class="form-group">
            <?php echo ( Form::label('slider_item_category', __('Item category', 'slider')) ); ?>
            <div class="input-group">
                <?php echo (Form::input('slider_item_category', $slider_item_category, array('class' => 'form-control'))); ?>
                <a href="#" class="btn btn-phone btn-default input-group-addon" data-toggle="modal" data-toggle="modal" data-target="#selectCategoryModal">...</a>
            </div>
        </div>
        <div class="form-group">
        <?php
            echo (
                Form::label('slider_item_target', __('Item target', 'slider')).
                Form::select('slider_item_target', $slider_item_target_array, $slider_item_target, array('class' => 'form-control'))
            );
        ?>
        </div>
        <div class="form-group">
        <?php
            echo (
                Form::label('slider_item_order', __('Item order', 'slider')).
                Form::select('slider_item_order', $slider_item_order_array, $slider_item_order, array('class' => 'form-control'))
            );
        ?>
        </div>    
        <div class="form-group">
            <?php echo Form::label('slider_item_image', __('Item image', 'slider')); ?>
            <div class="input-group">
                <?php echo Form::input('slider_item_image', $slider_item_image, array('class' => 'form-control')) ?>
                <a href="#" class="btn btn-phone btn-default input-group-addon" data-toggle="modal" data-target="#selectImageModal">...</a>
            </div>
            <br/>
            <img id="slider_item_image_preview" src="<?php echo $slider_item_image ?>" style="max-width:400px<?php echo isset($slider_item_image)?'':';display:none' ?>" />
        </div>
        <div class="form-group">

        <?php
            echo (
                Form::submit('slider_add_item', __('Save', 'slider'), array('class' => 'btn btn-phone btn-primary')).Html::nbsp(2).
                Html::anchor(__('Cancel', 'slider'), 'index.php?id=slider', array('title' => __('Cancel', 'slider'), 'class' => 'btn btn-phone btn-default')).
                Form::close()
            );
        ?>
        </div>
    </div>
</div>

<div class="modal fade" id="selectPageModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="close" data-dismiss="modal">&times;</div>
                <h4 class="modal-title"><?php echo __('Select page', 'slider'); ?></h4>
            </div>
            <div class="modal-body">
                <ul class="list-unstyled">
                <?php if (count($pages_list) > 0) foreach ($pages_list as $page) { ?>
                    <li><?php echo (!empty($page['parent'])) ? Html::nbsp().Html::arrow('right').Html::nbsp(2) : '' ; ?><a href="javascript:;" onclick="$.monstra.slider.selectPage('<?php echo (empty($page['parent'])) ? $page['slug'] : $page['parent'].'/'.$page['slug'] ; ?>', '<?php echo $page['title']; ?>');"><?php echo $page['title']; ?></a></li>
                <?php } ?>
                <?php if (count($components_list) > 0) foreach ($components_list as $component) { ?>
                    <li><a href="javascript:;" onclick="$.monstra.slider.selectPage('<?php echo $component; ?>', '<?php echo __(ucfirst($component), $component); ?>');"><?php echo __(ucfirst($component), $component); ?></a></li>
                <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="selectImageModal"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="close" data-dismiss="modal">&times;</div>
                <h4 class="modal-title"><?php echo __('Select image', 'slider'); ?></h4>
            </div>
            <div class="modal-body">
                <ul class="list-unstyled">
                <?php if (count($images) > 0) foreach ($images as $image) { ?>
                    <li><a href="javascript:;" onclick="$.monstra.slider.selectImage('<?php echo $image; ?>');"><?php echo $image; ?></a></li>
                <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="selectCategoryModal"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="close" data-dismiss="modal">&times;</div>
                <h4 class="modal-title"><?php echo __('Select category', 'slider'); ?></h4>
            </div>
            <div class="modal-body">
                <ul class="list-unstyled">
                <?php if (count($categories) > 0) foreach ($categories as $category) { ?>
                    <li><a href="javascript:;" onclick="$.monstra.slider.selectCategory('<?php echo $category; ?>');"><?php echo $category; ?></a></li>
                <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>