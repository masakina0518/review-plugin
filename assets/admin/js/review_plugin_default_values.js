
(function($, _){
    $(function() {
        var $_wrapper           = $('#review_plugin_default_values_wrappar');
        var $_criterias_form    = $_wrapper.find('#_review_plugin_def_criterias_form');
        var $_criterias_add_btn = $_criterias_form.find('#_review_plugin_def_criterias_add');
        var criterias_template  = $_criterias_form.find('#_review_plugin_def_criterias_template').text();

        $_criterias_form.on('click', '._review_plugin_def_criterias_delete', function() {
            $(this).parent().remove();
        });

        $_criterias_add_btn.on('click', function() {
            var compiled = _.template(criterias_template);
            $_criterias_add_btn.before(compiled({}));
        });


        $('#_review_plugin_def_color').wpColorPicker();
    });
})(jQuery, _);
