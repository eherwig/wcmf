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
 * This file was generated by ChronosGenerator  from cwm-export.uml on Sun Apr 28 21:58:27 CEST 2013.
 * Manual modifications should be placed inside the protected regions.
 */
define([
    "dojo/_base/declare",
    "app/model/meta/Node"
// PROTECTED REGION ID(testapp/public/js/model/types/testapp/application/model/wcmf/UserRDBClass.js/Define) ENABLED START
// PROTECTED REGION END
], function(
    declare,
    Node
// PROTECTED REGION ID(testapp/public/js/model/types/testapp/application/model/wcmf/UserRDBClass.js/Params) ENABLED START
// PROTECTED REGION END
) {
    var UserRDB = declare([Node
// PROTECTED REGION ID(testapp/public/js/model/types/testapp/application/model/wcmf/UserRDBClass.js/Declare) ENABLED START
// PROTECTED REGION END
    ], {
        typeName: 'testapp.application.model.wcmf.UserRDB',
        isSortable: false,
        displayValues: [
            "login"
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
            name: "login",
            type: "String",
            isEditable: true,
            inputType: 'text',
            regexp: '',
            regexpDesc: '',
            tags: ['DATATYPE_ATTRIBUTE'],
            isReference: false
        }, {
            name: "password",
            type: "String",
            isEditable: true,
            inputType: 'password',
            regexp: '',
            regexpDesc: '',
            tags: ['DATATYPE_ATTRIBUTE'],
            isReference: false
        }, {
            name: "name",
            type: "String",
            isEditable: true,
            inputType: 'text',
            regexp: '',
            regexpDesc: '',
            tags: ['DATATYPE_ATTRIBUTE'],
            isReference: false
        }, {
            name: "firstname",
            type: "String",
            isEditable: true,
            inputType: 'text',
            regexp: '',
            regexpDesc: '',
            tags: ['DATATYPE_ATTRIBUTE'],
            isReference: false
        }, {
            name: "config",
            type: "String",
            isEditable: true,
            inputType: 'text',
            regexp: '',
            regexpDesc: '',
            tags: ['DATATYPE_ATTRIBUTE'],
            isReference: false
        }],

        relations: [{
            name: "Locktable",
            type: "Locktable",
            aggregrationKind: "composite",
            maxMultiplicity: "unbounded",
            thisEndName: "UserRDB",
            relationType: "child"
        }, {
            name: "UserConfig",
            type: "UserConfig",
            aggregrationKind: "composite",
            maxMultiplicity: "unbounded",
            thisEndName: "UserRDB",
            relationType: "child"
        }, {
            name: "RoleRDB",
            type: "RoleRDB",
            aggregrationKind: "none",
            maxMultiplicity: "unbounded",
            thisEndName: "UserRDB",
            relationType: "child"
        }]

// PROTECTED REGION ID(testapp/public/js/model/types/testapp/application/model/wcmf/UserRDBClass.js/Body) ENABLED START
// PROTECTED REGION END
    });
// PROTECTED REGION ID(testapp/public/js/model/types/testapp/application/model/wcmf/UserRDBClass.js/Static) ENABLED START
// PROTECTED REGION END
    return UserRDB;
});
  