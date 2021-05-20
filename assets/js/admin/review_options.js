(function($, _){

    // TODO:実装みなおし
    $(function() {
        var $_wrapper           = $('#review_options_wrappar');
        var $_input_field       = $_wrapper.find('#review_options_input_field');
        var $_on_off_radio      = $_wrapper.find('input[name="_review_plugin_enable_review"]:radio');

        $_on_off_radio.each(function() {
            var $this = $(this);
            if($this.prop('checked') === true) {
                switch_field_show($this.val());
            }
        });

        $_on_off_radio.change(function() {
            switch_field_show($(this).val());
        });

        function switch_field_show(is_on) {
            if(is_on == 0) {
                $_input_field.hide();
                return;
            }
            $_input_field.show();
        }
    });

    // TODO:実装みなおし
    $(function() {
        var $_wrapper           = $('#review_options_wrappar');
        var $_use_post_title    = $_wrapper.find('#_review_plugin_use_post_title');
        var $_post_title        = $_wrapper.find('#_review_plugin_post_title');

        switch_post_title_readonly($_use_post_title.prop('checked'));

        $_use_post_title.change(function() {
            switch_post_title_readonly($(this).prop('checked'));
        });

        function switch_post_title_readonly(is_checked) {
            if(is_checked === true) {
                $_post_title.prop('readonly', true);
                return;
            }
            $_post_title.prop('readonly', false);
        }
    });

    // TODO:実装みなおし
    $(function() {
        var $_wrapper           = $('#review_options_wrappar');
        var $_criterias_form    = $_wrapper.find('#_review_plugin_criterias_form');
        var $_sliders           = $_criterias_form.find('.slider');
        var $_criterias_add_btn = $_criterias_form.find('#_review_plugin_criterias_add');
        var criterias_template  = $_criterias_form.find('#_review_plugin_criterias_template').text();
        var $final_score_form   = $_wrapper.find('#_review_plugin_criteria_final_score_form');

        $_sliders.slider();

        $_criterias_form.on('click', '._review_plugin_criterias_delete', function() {
            $(this).parent().remove();
        });

        $_criterias_add_btn.on('click', function() {
            var compiled = _.template(criterias_template);
            $final_score_form.before(compiled({}));
        });
        $_wrapper.tabs(
            {
                'activate': function(event, ui) {
                    $_wrapper.find('a.nav-tab-active').removeClass('nav-tab-active');
                    $(ui.newTab[0]).find('a').addClass('nav-tab-active');
                }
            }
        );
        $('#_review_plugin_color').wpColorPicker();
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

    // TODO:実装みなおし
    $(function() {
        var $_wrapper           = $('#review_options_wrappar');
        var $_affili_title_form    = $_wrapper.find('#_review_plugin_affili_title_form');
        var $_affili_title_add_btn = $_affili_title_form.find('#_review_plugin_affili_title_add');
        var affili_title_template  = $_affili_title_form.find('#_review_plugin_affili_title_template').text();

        $_affili_title_form.on('click', '._review_plugin_affili_title_delete', function() {
            $(this).parent().remove();
        });

        $_affili_title_add_btn.on('click', function() {
            var compiled = _.template(affili_title_template);
            $_affili_title_add_btn.before(compiled({}));
        });
    });

    // TODO:実装みなおし
    $(function() {
        var $_schema_type_select  = $('#_review_plugin_schema_type');
        var $_schema_properties_2 = $('#_review_plugin_schema_type_2');
        var $_schema_properties_4 = $('#_review_plugin_schema_type_4');

        switch_properties_box($_schema_type_select.val());

        $_schema_type_select.change(function() {
            switch_properties_box($(this).val());
        });

        function switch_properties_box(select_val) {
            $_schema_properties_2.hide();
            $_schema_properties_4.hide();
            switch(select_val) {
                case '2':
                    $_schema_properties_2.show();
                    break;
                case '4':
                    $_schema_properties_4.show();
                    break;
            }
        }
    });
})(jQuery, _);
