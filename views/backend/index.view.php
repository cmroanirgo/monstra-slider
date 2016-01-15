<h2 class="margin-bottom-1"><?php echo __('Slider', 'slider'); ?></h2>

<?php if ($slider->count() == 0) { ?>
<div class="vertical-align margin-bottom-1">
    <div class="text-left row-phone">
        <h3><?php echo __('Category', 'slider'); ?>: <?php echo 'default'; ?></h3>
    </div>
    <div class="text-right row-phone">
        <?php
            echo (
                Html::anchor(__('Create New Item', 'slider'), 'index.php?id=slider&action=add', array('title' => __('Create New Item', 'slider'), 'class' => 'btn btn-phone btn-primary'))
            );
        ?>
    </div>
</div>
<?php } ?>

<?php
    foreach ($categories as $category) {
        $items = $slider->select('[category="'.$category.'"]', 'all', null, array('id', 'title', 'summary', 'image', 'link', 'target', 'order', 'category'), 'order', 'ASC');
        $category_to_add = ($category == '') ? '' : '&category='.$category;
?>

<div class="vertical-align margin-bottom-1">
    <div class="text-left row-phone">
        <h3><?php echo __('Category', 'slider'); ?>: <?php echo ($category == '') ? 'default' : $category; ?></h3>
    </div>
    <div class="text-right row-phone">
        <br>
        <?php
            echo (
                Html::anchor(__('Create New Item', 'slider'), 'index.php?id=slider&action=add'.$category_to_add , array('title' => __('Create New Item', 'slider'), 'class' => 'btn btn-phone btn-primary'))
            );
        ?>
    </div>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th><?php echo __('Title', 'slider'); ?></th>
            <th><?php echo __('Image', 'slider'); ?></th>
            <th><?php echo __('Order', 'slider'); ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item) { ?>
        <?php

            $item['link'] = Html::toText($item['link']);
            $item['title'] = Html::toText($item['title']);

            $pos = strpos($item['link'], 'http://');
            if ($pos === false) {
                $link = Option::get('siteurl').'/'.$item['link'];
            } else {
                $link = $item['link'];
            }
        ?>
        <tr>
            <td>
                <a target="_blank" href="<?php echo $link; ?>"><?php echo $item['title']; ?></a>
            </td>
            <td>
                <img src="<?php echo $item['image']; ?>" style="max-height:60px" />
            </td>
            <td>
                <?php echo $item['order']; ?>
            </td>
            <td>
                <div class="pull-right">
                <?php echo Html::anchor(__('Edit', 'slider'), 'index.php?id=slider&action=edit&item_id='.$item['id'], array('class' => 'btn btn-primary')); ?>
                <?php echo Html::anchor(__('Delete', 'slider'),
                           'index.php?id=slider&delete_item='.$item['id'],
                           array('class' => 'btn btn-danger', 'onclick' => "return confirmDelete('".__('Delete item :title', 'slider', array(':title' => $item['title']))."')"));
                 ?>
             </div>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php } ?>
<p><small>Edit the snippet <code>slider</code> to change the layout, alternatively
    create a custom template in <code>/public/themes/&lt;theme&gt;/slider/views/frontend/index.view.php</code>. <?php echo Html::anchor('Click here for usage info', 'index.php?id=slider&action=usage'); ?></small></p>
