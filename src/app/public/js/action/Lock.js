define([
    "dojo/_base/declare",
    "dojo/_base/lang",
    "dojo/request",
    "./ActionBase"
], function (
    declare,
    lang,
    request,
    ActionBase
) {
    return declare([ActionBase], {

        name: 'lock',
        iconClass: 'icon-lock',
        action: "lock", // "lock|unlock"
        lockType: "optimistic", // "optimistic|pessimistic"

        /**
         * Create a pessimistic lock on the object
         * @param e The event that triggered execution, might be null
         * @param data Object to lock
         */
        execute: function(e, data) {
            if (this.init instanceof Function) {
                this.init(data);
            }
            request.post(appConfig.backendUrl, {
                data: {
                    action: this.action,
                    oid: data.oid,
                    type: this.lockType
                },
                headers: {
                    "Accept" : "application/json"
                },
                handleAs: 'json'

            }).then(lang.hitch(this, function(response) {
                // success
                this.callback(data, response);
            }), lang.hitch(this, function(error) {
                // error
                this.errback(data, error);
            }));
        }
    });
});
