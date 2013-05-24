/*
 * Copyright (c) 2013 The Olympos Development Team.
 * 
 * http://sourceforge.net/projects/olympos/
 * 
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.eclipse.org/legal/epl-v10.html. If redistributing this code,
 * this entire header must remain intact.
 */

/**
 * This file was generated by ChronosGenerator  from cwm-export.uml on Fri May 24 18:54:44 CEST 2013.
 * Manual modifications should be placed inside the protected regions.
 */
define([
    "dojo/_base/declare",
    "app/model/meta/Node"
// PROTECTED REGION ID(testapp/public/js/model/types/testapp/application/model/wcmf/UserConfigClass.js/Define) ENABLED START
// PROTECTED REGION END
], function(
    declare,
    Node
// PROTECTED REGION ID(testapp/public/js/model/types/testapp/application/model/wcmf/UserConfigClass.js/Params) ENABLED START
// PROTECTED REGION END
) {
    var UserConfig = declare([Node
// PROTECTED REGION ID(testapp/public/js/model/types/testapp/application/model/wcmf/UserConfigClass.js/Declare) ENABLED START
// PROTECTED REGION END
    ], {
        typeName: 'testapp.application.model.wcmf.UserConfig',
        isSortable: false,
        displayValues: [
            "key"
        ],
        pkNames: [
            "id"
        ],

        attributes: [{
            name: "id",
            type: "",
            isEditable: false,
            inputType: 'text',
            regexp: '',
            regexpDesc: '',
            tags: ['DATATYPE_IGNORE'],
            isReference: false
        }, {
            name: "fk_user_id",
            type: "",
            isEditable: false,
            inputType: 'text',
            regexp: '',
            regexpDesc: '',
            tags: ['DATATYPE_IGNORE'],
            isReference: false
        }, {
            name: "key",
            type: "String",
            isEditable: false,
            inputType: 'text',
            regexp: '',
            regexpDesc: '',
            tags: ['DATATYPE_ATTRIBUTE'],
            isReference: false
        }, {
            name: "val",
            type: "String",
            isEditable: true,
            inputType: 'text',
            regexp: '',
            regexpDesc: '',
            tags: ['DATATYPE_ATTRIBUTE'],
            isReference: false
        }],

        relations: [{
            name: "UserRDB",
            type: "UserRDB",
            aggregrationKind: "none",
            maxMultiplicity: "1",
            thisEndName: "UserConfig",
            relationType: "parent"
        }]

// PROTECTED REGION ID(testapp/public/js/model/types/testapp/application/model/wcmf/UserConfigClass.js/Body) ENABLED START
        , listView: 'js/ui/data/widget/EntityListWidget'
        , detailView: 'js/ui/data/widget/EntityFormWidget'
// PROTECTED REGION END
    });
// PROTECTED REGION ID(testapp/public/js/model/types/testapp/application/model/wcmf/UserConfigClass.js/Static) ENABLED START
// PROTECTED REGION END
    return UserConfig;
});
  