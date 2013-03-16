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
// PROTECTED REGION ID(testapp/public/js/model/DBSequenceClass.js/Define) ENABLED START
// PROTECTED REGION END
], function(
    declare,
    Node
// PROTECTED REGION ID(testapp/public/js/model/DBSequenceClass.js/Params) ENABLED START
// PROTECTED REGION END
) {
    var DBSequence = declare([Node
// PROTECTED REGION ID(testapp/public/js/model/DBSequenceClass.js/Declare) ENABLED START
// PROTECTED REGION END
    ], {
// PROTECTED REGION ID(testapp/public/js/model/DBSequenceClass.js/Body) ENABLED START
// PROTECTED REGION END
    });
    DBSequence.typeName = 'DBSequence';
    DBSequence.sortable = false;

    DBSequence.attributes = [{
        name: "id",
        type: "",
        isEditable: false,
        inputType: 'text',
        regexp: '',
        regexpDesc: '',
        tags: ['DATATYPE_IGNORE'],
        isReference: false
    }];

    DBSequence.relations = [];
// PROTECTED REGION ID(testapp/public/js/model/DBSequenceClass.js/Static) ENABLED START
// PROTECTED REGION END
    return DBSequence;
});
  