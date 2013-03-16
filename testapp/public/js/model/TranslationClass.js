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
 * This file was generated by ChronosGenerator  from cwm-export.uml on Sat Mar 16 03:25:46 CET 2013.
 * Manual modifications should be placed inside the protected regions.
 */
define([
    "dojo/_base/declare",
    "./meta/Node"
// PROTECTED REGION ID(testapp/public/js/model/TranslationClass.js/Define) ENABLED START
// PROTECTED REGION END
], function(
    declare,
    Node
// PROTECTED REGION ID(testapp/public/js/model/TranslationClass.js/Params) ENABLED START
// PROTECTED REGION END
) {
    var Translation = declare([Node
// PROTECTED REGION ID(testapp/public/js/model/TranslationClass.js/Declare) ENABLED START
// PROTECTED REGION END
    ], {
// PROTECTED REGION ID(testapp/public/js/model/TranslationClass.js/Body) ENABLED START
// PROTECTED REGION END
    });
    Translation.typeName = 'Translation';
    Translation.sortable = false;

    Translation.attributes = [{
        name: "id",
        type: "",
        isEditable: false,
        inputType: 'text',
        regexp: '',
        regexpDesc: '',
        tags: ['DATATYPE_IGNORE'],
        isReference: false
    }, {
        name: "objectid",
        type: "String",
        isEditable: false,
        inputType: 'text',
        regexp: '',
        regexpDesc: '',
        tags: ['DATATYPE_ATTRIBUTE'],
        isReference: false
    }, {
        name: "attribute",
        type: "String",
        isEditable: false,
        inputType: 'text',
        regexp: '',
        regexpDesc: '',
        tags: ['DATATYPE_ATTRIBUTE'],
        isReference: false
    }, {
        name: "translation",
        type: "String",
        isEditable: false,
        inputType: 'textarea',
        regexp: '',
        regexpDesc: '',
        tags: ['DATATYPE_ATTRIBUTE'],
        isReference: false
    }, {
        name: "language",
        type: "String",
        isEditable: false,
        inputType: 'text',
        regexp: '',
        regexpDesc: '',
        tags: ['DATATYPE_ATTRIBUTE'],
        isReference: false
    }];

    Translation.relations = [];
// PROTECTED REGION ID(testapp/public/js/model/TranslationClass.js/Static) ENABLED START
// PROTECTED REGION END
    return Translation;
});
  