/*jslint browser:true */
(function ($) {
    "use strict";


    if ( window.vc && window.vc.events ) {
        window.vc.events.on( 'shortcodeView:ready', function ( view ) {
            var shortcode = view.get("shortcode");
            var model_id = view.get('id');

            if(shortcode === 'vc_row') {
                vc.frame_window.epic_iframe.additional_row_option(model_id);
            }
        });
    }


    if ( window.vc && window.vc.ShortcodesBuilder )
    {
        window.vc.ShortcodesBuilder.prototype.build = function(shortcodes, callback)
        {
            var model = vc.shortcodes.get(this.lastID());
            var parent = model.get("parent_id");
            var colwidth = vc.frame_window.vc_iframe.size_container(parent);

            this.ajax({
                action: "vc_load_shortcode",
                shortcodes: shortcodes,
                _vcnonce: window.vcAdminNonce,
                colwidth: colwidth
            }, vc.frame_window.location.href).done(function(html) {
                _.each($(html), function(block) {
                    this._renderBlockCallback(block)
                }, this),
                _.isFunction(callback) && callback(html),
                    vc.frame.setSortable(), vc.activity = !1, this.checkNoContent(), vc.frame_window.vc_iframe.loadScripts(), this.last() && vc.frame.scrollTo(this.first()), this.models = [], this.showResultMessage(), this.is_build_complete = !0
            })
        };

        window.vc.ShortcodesBuilder.prototype.update = function(model)
        {
            var parent = model.get("parent_id");
            var colwidth = vc.frame_window.vc_iframe.size_container(parent);

            var tag, shortcode;
            tag = model.get("shortcode"), shortcode = this.toString(model), vc.setDataChanged(), this.ajax({
                action: "vc_load_shortcode",
                shortcodes: [{
                    id: model.get("id"),
                    string: shortcode,
                    tag: tag
                }],
                _vcnonce: window.vcAdminNonce,
                colwidth: colwidth
            }, vc.frame_window.location.href).done(function(html) {
                var old_view;
                old_view = model.view, _.each($(html), function(block) {
                    this._renderBlockCallback(block)
                }, this), model.view && (model.view.$el.insertAfter(old_view.$el), vc.shortcodes.where({
                    parent_id: model.get("id")
                }).length && old_view.content().find("> *").appendTo(model.view.content()), old_view.remove(), vc.frame_window.vc_iframe.loadScripts(), model.view.changed(), vc.frame.setSortable(), model.view.updated())
            })
        };
    }

    function normalize_module_name(module)
    {
        module = module.toLowerCase();
        return module.replace('epic_module', 'epic');
    }

    function front_end_module()
    {
        for(var i = 0; i < modules.length; i++)
        {
            (function(){
                var module = modules[i];
                var module_name = "InlineShortcodeView_" + normalize_module_name(module.name);

                window[module_name] = window.InlineShortcodeView.extend({
                    render: function(){
                        var model_id = this.model.get("id");
                        window[module_name].__super__.render.call(this);
                        vc.frame_window.vc_iframe.addActivity(function()
                        {
                            if(module.type === 'block' && typeof this.epic_iframe.module_js === 'function') {
                                this.epic_iframe.module_js(model_id)
                            }
                            if(module.type === 'hero' && typeof this.epic_iframe.hero_js === 'function') {
                                this.epic_iframe.hero_js(model_id)
                            }
                            if(module.type === 'newsticker' && typeof this.epic_iframe.newsticker_js === 'function') {
                                this.epic_iframe.newsticker_js(model_id)
                            }
                            if(module.type === 'video_playlist' && typeof this.epic_iframe.video_playlist_js === 'function') {
                                this.epic_iframe.video_playlist_js(model_id)
                            }
                            if(module.type === 'block_link' && typeof this.epic_iframe.block_link_module === 'function') {
                                this.epic_iframe.block_link_module(model_id)
                            }
                            if(module.type === 'slider' && typeof this.epic_iframe.slider === 'function') {
                                this.epic_iframe.slider(model_id)
                            }
                            if(module.type === 'carousel' && typeof this.epic_iframe.carousel === 'function') {
                                this.epic_iframe.carousel(model_id)
                            }
                        });
                        return this
                    }
                });
            })();
        }

        window.InlineShortcodeView_vc_widget_sidebar = window.InlineShortcodeView.extend({
            render: function(){
                var model_id = this.model.get("id");
                window.InlineShortcodeView_vc_widget_sidebar.__super__.render.call(this);
                vc.frame_window.vc_iframe.addActivity(function(){
                    if(typeof this.epic_iframe.module_js === 'function') {
                        this.epic_iframe.widget(model_id)
                    }
                });
                return this;
            }
        });
    }

    function do_ready(){
        if( window.InlineShortcodeView ) {
            front_end_module();
        }
    }

    $(document).ready(do_ready);
})(jQuery);
