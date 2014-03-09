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
// PROTECTED REGION ID(app/public/js/model/types/app/src/model/wcmf/LocktableClass.js/Define) ENABLED START
// PROTECTED REGION END
], function(
    declare,
    Node
// PROTECTED REGION ID(app/public/js/model/types/app/src/model/wcmf/LocktableClass.js/Params) ENABLED START
// PROTECTED REGION END
) {
    var Locktable = declare([Node
// PROTECTED REGION ID(app/public/js/model/types/app/src/model/wcmf/LocktableClass.js/Declare) ENABLED START
// PROTECTED REGION END
    ], {
        typeName: "app.src.model.wcmf.Locktable",
        description: "?",
        isSortable: false,
        displayValues: [
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
            name: "fk_user_id",
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
            name: "objectid",
            type: "String",
            description: "?",
            isEditable: false,
            inputType: 'text',
            displayType: 'text',
            validateType: '',
            validateDesc: '',
            tags: ['DATATYPE_ATTRIBUTE'],
            isReference: false
        }, {
            name: "sessionid",
            type: "String",
            description: "?",
            isEditable: false,
            inputType: 'text',
            displayType: 'text',
            validateType: '',
            validateDesc: '',
            tags: ['DATATYPE_ATTRIBUTE'],
            isReference: false
        }, {
            name: "since",
            type: "Date",
            description: "?",
            isEditable: false,
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
            maxMultiplicity: "1",
            thisEndName: "Locktable",
            relationType: "parent"
        }]

// PROTECTED REGION ID(app/public/js/model/types/app/src/model/wcmf/LocktableClass.js/Body) ENABLED START
        , listView: 'app/js/ui/data/widget/EntityListWidget'
        , detailView: 'app/js/ui/data/widget/EntityFormWidget'
// PROTECTED REGION END
    });
// PROTECTED REGION ID(app/public/js/model/types/app/src/model/wcmf/LocktableClass.js/Static) ENABLED START
// PROTECTED REGION END
    return Locktable;
});
  