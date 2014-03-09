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
 * This file was generated by ChronosGenerator  from cwm-export.uml.
 * Manual modifications should be placed inside the protected regions.
 */
define([
    "dojo/_base/declare",
    "app/js/model/meta/Node"
// PROTECTED REGION ID(app/public/js/model/types/app/src/model/wcmf/RoleClass.js/Define) ENABLED START
// PROTECTED REGION END
], function(
    declare,
    Node
// PROTECTED REGION ID(app/public/js/model/types/app/src/model/wcmf/RoleClass.js/Params) ENABLED START
// PROTECTED REGION END
) {
    var Role = declare([Node
// PROTECTED REGION ID(app/public/js/model/types/app/src/model/wcmf/RoleClass.js/Declare) ENABLED START
// PROTECTED REGION END
    ], {
        typeName: "app.src.model.wcmf.Role",
        description: "?",
        isSortable: false,
        displayValues: [
            "name"
        ],
        pkNames: [
            "id"
        ],

        attributes: [{
            name: "id",
            type: "",
            description: "",
            isEditable: false,
            inputType: 'text',
            displayType: 'text',
            validateType: '',
            validateDesc: '',
            tags: ['DATATYPE_IGNORE'],
            isReference: false
        }, {
            name: "name",
            type: "String",
            description: "?",
            isEditable: true,
            inputType: 'text',
            displayType: 'text',
            validateType: '',
            validateDesc: '',
            tags: ['DATATYPE_ATTRIBUTE'],
            isReference: false
        }],

        relations: [{
            name: "User",
            type: "User",
            aggregationKind: "none",
            maxMultiplicity: "unbounded",
            thisEndName: "Role",
            relationType: "child"
        }]

// PROTECTED REGION ID(app/public/js/model/types/app/src/model/wcmf/RoleClass.js/Body) ENABLED START
        , listView: 'app/js/ui/data/widget/EntityListWidget'
        , detailView: 'app/js/ui/admin/widget/RoleFormWidget'
// PROTECTED REGION END
    });
// PROTECTED REGION ID(app/public/js/model/types/app/src/model/wcmf/RoleClass.js/Static) ENABLED START
// PROTECTED REGION END
    return Role;
});
  