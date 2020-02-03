'use strict';

define(
    [
        'underscore',
        'oro/translator',
        'pim/form',
        'swapi/template/import/file-path'
    ],
    function (
        _,
        __,
        BaseForm,
        template
    ) {
        return BaseForm.extend({
            //className: 'AknCenteredBox',
            template: _.template(template),

            initialize: function (config) {
                this.config = config.config;

                BaseForm.prototype.initialize.apply(this, arguments);
            },

            render: function () {
                this.$el.html(this.template({
                    path: this.getFormData().configuration.filePath,
                    label: __(this.config.label)
                }));

                this.delegateEvents();

                return BaseForm.prototype.render.apply(this, arguments);
            }
        });
    }
);
