if (typeof $.monstra == 'undefined') $.monstra = {};

$.monstra.slider = {

    init: function() { },

    selectPage: function (slug, title) {
        $('input[name=slider_item_link]').val(slug);
        $('input[name=slider_item_title]').val(title);
        $('#selectPageModal').modal('hide');
    },

    selectCategory: function (name) {
        $('input[name=slider_item_category]').val(name);
        $('#selectCategoryModal').modal('hide');
    },

    selectImage: function (imageurl) {
        imageurl = "/public/uploads/"+imageurl;
        $('input[name=slider_item_image]').val(imageurl);
        $('#slider_item_image_preview').attr('src',imageurl).show();
        $('#selectImageModal').modal('hide');
    }

};


$(document).ready(function(){
    $.monstra.slider.init();
});