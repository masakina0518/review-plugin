
(function($, _){
    // TODO:実装みなおし
    $(function() {
        var $_wrapper           = $('#review_options_wrappar');
        var $_criterias_form    = $_wrapper.find('#_review_plugin_criterias_form');
        var $_criterias_add_btn = $_criterias_form.find('#_review_plugin_criterias_add');
        var criterias_template  = $_criterias_form.find('#_review_plugin_criterias_template').text();
        var $final_score_form   = $_wrapper.find('#_review_plugin_criteria_final_score_form');

        $_criterias_form.on('click', '._review_plugin_criterias_delete', function() {
            $(this).parent().remove();
        });

        $_criterias_add_btn.on('click', function() {
            var compiled = _.template(criterias_template);
            $final_score_form.before(compiled({}));
        });

        $_wrapper.tabs();
    });

    // TODO:実装みなおし
    $(function() {
        var $_wrapper           = $('#review_options_wrappar');
        var $_pois_point_form    = $_wrapper.find('#_review_plugin_posi_points_form');
        var $_pois_point_add_btn = $_pois_point_form.find('#_review_plugin_posi_points_add');
        var pois_point_template  = $_pois_point_form.find('#_review_plugin_posi_points_template').text();

        $_pois_point_form.on('click', '._review_plugin_posi_points_delete', function() {
            $(this).parent().remove();
        });

        $_pois_point_add_btn.on('click', function() {
            var compiled = _.template(pois_point_template);
            $_pois_point_add_btn.before(compiled({}));
        });
    });

    // TODO:実装みなおし
    $(function() {
        var $_wrapper           = $('#review_options_wrappar');
        var $_nega_point_form    = $_wrapper.find('#_review_plugin_nega_points_form');
        var $_nega_point_add_btn = $_nega_point_form.find('#_review_plugin_nega_points_add');
        var nega_point_template  = $_nega_point_form.find('#_review_plugin_nega_points_template').text();

        $_nega_point_form.on('click', '._review_plugin_nega_points_delete', function() {
            $(this).parent().remove();
        });

        $_nega_point_add_btn.on('click', function() {
            var compiled = _.template(nega_point_template);
            $_nega_point_add_btn.before(compiled({}));
        });
    });

})(jQuery, _);
