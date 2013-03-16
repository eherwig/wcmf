/*jshint strict:false */

define([
    "dojo/_base/declare",
    "dijit/_WidgetBase",
    "dijit/_TemplatedMixin",
    "dojo/text!./template/FooterWidget.html"
], function (
    declare,
    _WidgetBase,
    _TemplatedMixin,
    template
) {
    return declare([_WidgetBase, _TemplatedMixin], {

        templateString: template
    });
});