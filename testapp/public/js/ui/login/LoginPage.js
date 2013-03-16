define([
    "dojo/_base/declare",
    "dijit/_WidgetBase",
    "dijit/_TemplatedMixin",
    "dojomat/_AppAware",
    "dojomat/_StateAware",
    "../_include/_PageMixin",
    "../_include/_NotificationMixin",
    "../_include/NavigationWidget",
    "../_include/FooterWidget",
    "bootstrap/Button",
    "dojo/_base/lang",
    "dojo/dom-form",
    "dojo/query",
    "dojo/request",
    "dojo/text!./template/LoginPage.html",
], function (
    declare,
    _WidgetBase,
    _TemplatedMixin,
    _AppAware,
    _StateAware,
    _Page,
    _Notification,
    NavigationWidget,
    FooterWidget,
    button,
    lang,
    domForm,
    query,
    request,
    template
) {
    return declare([_WidgetBase, _TemplatedMixin, _AppAware, _StateAware, _Page, _Notification], {

        request: null,
        session: null,
        templateString: template,

        constructor: function(params) {
            this.request = params.request;
            this.session = params.session;
        },

        postCreate: function() {
            this.inherited(arguments);
            this.setTitle('Login');
            new NavigationWidget({titleOnly: true}, this.navigationNode);
            new FooterWidget({}, this.footerNode);

            this.setupRoutes();
        },

        startup: function() {
            this.inherited(arguments);
        },

        _login: function(e) {
            // prevent the page from navigating after submit
            e.stopPropagation();
            e.preventDefault();

            var data = domForm.toObject('loginForm');
            data.controller = 'wcmf\\application\\controller\\LoginController';
            data.action = 'dologin';
            data.responseFormat = 'json';

            query('.btn').button('loading');

            this.hideNotification();
            request.post('../main.php', {
                data: data,
                handleAs: 'json'

            }).then(lang.hitch(this, function(response){
                if (response.errorMessage) {
                    query('.btn').button('reset');
                    this.showNotification({
                      type: 'error',
                      message: response.errorMessage
                    });
                }
                else {
                    var route = this.router.getRoute('home');
                    var url = route.assemble();
                    this.push(url);
                }
            }));
        }
    });
});