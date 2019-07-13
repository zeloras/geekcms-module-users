var moduleUsersControlAdmin = {
    config: {
        'box_check_all': '.user-permissions__change-state-all',
        'box_permission_check': '.user-permissions__input',
        'checked_class': 'is_checked'
    },

    init: function () {
        let self = this;
        let config = self.config;

        $(config.box_check_all).unbind('click').on('click', function () {
            self.changePermissions(this);
        });
    },

    /**
     * Check/uncheck permissions boxes
     *
     * @param elem
     */
    changePermissions: function (elem) {
        let self = this;
        let config = self.config;
        let checkboxes = $(config.box_permission_check);
        let item = $(elem);
        let is_check = $(elem).hasClass(config.checked_class);

        item.toggleClass(config.checked_class);
        checkboxes.each(function () {
            this.checked = (!is_check);
        });
    }
};

$(document).on('mainComponentsAdminLoaded', function () {
    moduleUsersControlAdmin.init();
});
