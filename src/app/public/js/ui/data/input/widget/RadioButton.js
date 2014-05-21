define( [
    "dojo/_base/declare",
    "dojo/dom-construct",
    "dijit/form/RadioButton",
    "../../../../model/meta/Model",
    "./_BinaryItemsControl"
],
function(
    declare,
    domConstruct,
    RadioButton,
    Model,
    _BinaryItemsControl
) {
    return declare([_BinaryItemsControl], {

        multiValued: false,

        buildItemWidget: function(item) {
            var itemId = this.store.getIdentity(item);
            var itemLabel = item.displayText;
            var typeClass = Model.getTypeFromOid(this.entity.oid);

            // create radio button
            var widget = new RadioButton({
                name: this.name,
                value: ""+itemId,
                checked: (this.value == itemId), // value may be string or number
                disabled: typeClass ? !typeClass.isEditable(this.attribute, this.entity) : false
            });
            widget.startup();
            this.addChild(widget);

            // create label
            domConstruct.create("span", {
                innerHTML: itemLabel,
                "class": "checkBoxLabel"
            }, widget.domNode, "after");

            return widget;
        }
    });
});