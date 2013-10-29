define([
    "dojo/_base/declare",
    "dojo/_base/lang",
    "dijit/registry",
    "dijit/_WidgetBase",
    "dijit/_TemplatedMixin",
    "dijit/_WidgetsInTemplateMixin",
    "dijit/MenuBar",
    "dijit/MenuBarItem",
    "dijit/PopupMenuBarItem",
    "dijit/DropDownMenu",
    "dijit/MenuSeparator",
    "dijit/MenuItem",
    "dojo/query",
    "dojo/NodeList-dom",
    "../../../Cookie",
    "../../../model/meta/Model",
    "../../../locale/Dictionary",
    "dojo/text!./template/NavigationWidget.html",
    "dojo/domReady!"
], function (
    declare,
    lang,
    registry,
    _WidgetBase,
    _TemplatedMixin,
    _WidgetsInTemplateMixin,
    MenuBar,
    MenuBarItem,
    PopupMenuBarItem,
    Menu,
    MenuSeparator,
    MenuItem,
    query,
    nodeListDom,
    Cookie,
    Model,
    Dict,
    template
) {
    return declare([_WidgetBase, _TemplatedMixin, _WidgetsInTemplateMixin], {

        titleOnly: false,
        templateString: lang.replace(template, Dict.tplTranslate),
        selected: null,

        constructor: function (params) {
            this.titleOnly = params.titleOnly;

            // template variables
            this.title = appConfig.title;
            this.userName = Cookie.get("user") || '';
            this.firstRootType = Model.getSimpleTypeName(appConfig.rootTypes[0]);
            this.userType = Model.getSimpleTypeName(appConfig.userType);
        },

        postCreate: function() {
            // set selected menu
            if (this.selected) {
                registry.byId(this.selected)._setSelected(true);
            }
        },

        startup: function() {
            this.inherited(arguments);

            // hide buttons, if titleOnly
            if (this.titleOnly) {
                query(".main-menu").style("display", "none");
            }
        },

        setContentRoute: function(type, id) {
            var contentNavNode = query("#navContent");
            contentNavNode.attr("data-dojorama-route", id !== undefined ? "entity" : "entityList");
            var routeParamStr = "type: '"+type+"'";
            if (id !== undefined) {
              routeParamStr += ", id: '"+id+"'";
            }
            contentNavNode.attr("data-dojorama-pathparams", routeParamStr);
        }
    });
});