<?php
/**
 * wCMF - wemove Content Management Framework
 * Copyright (C) 2005-2009 wemove digital solutions GmbH
 *
 * Licensed under the terms of any of the following licenses
 * at your choice:
 *
 * - GNU Lesser General Public License (LGPL)
 *   http://www.gnu.org/licenses/lgpl.html
 * - Eclipse Public License (EPL)
 *   http://www.eclipse.org/org/documents/epl-v10.php
 *
 * See the license.txt file distributed with this work for
 * additional information.
 *
 * $Id: function.input.php 1250 2010-12-05 23:02:43Z iherwig $
 */
namespace wcmf\lib\presentation\smarty_plugins;

use wcmf\lib\presentation\control\Control;

/*
* Smarty plugin
* -------------------------------------------------------------
* File:     function.input.php
* Type:     function
* Name:     input
* Purpose:  Renders a html control. Known parameters are:
*           name: The name of the control or the name of a node property
*           type: The input type (@see Control::render)
*           value: The value of the control
*           editable: True/False wether the control should be enabled or not
*           object: A PersistentObject instance (if this is given, the name parameter is interpreted
*                 as the name of a property of the object and inputType, value and editable are
*                 derived from that property)
*           language: The language if the control should be localization aware
* Usage:    {input name="login" inputType="text" value="" editable=true} or
*           {input object=$project name="name" language="de"}
* -------------------------------------------------------------
*/
function smarty_function_input($params, $smarty)
{
  $language = null;
  if (isset($params['language'])) {
    $language = $params['language'];
  }

  if (isset($params['object'])) {
    $object = $params['object'];
    $attrName = $params['name'];
    $value = $object->getValue($attrName);

    $inputType = "text";
    $editable = false;
    $attribute = null;
    $mapper = $object->getMapper();
    if ($mapper) {
      $attribute = $mapper->getAttribute($name);
      $inputType = $attribute->getInputType();
      $editable = $attribute->getIsEditable();
    }
    $name = ControlRenderer::getControlName($object, $attrName, $language);
    $control = ControlRenderer::getControl($inputType);
    $html = $control->render($name, $inputType, $value, $editable, $language, $smarty);
  }
  else {
    $name = $params['name'];
    $inputType = $params['type'];
    $value = $params['value'];
    $editable = $params['editable'];
    $control = Control::getControl($params['inputType']);
    $html = $control->render($name, $inputType, $value, $editable, $language, $smarty);
  }
  echo $html;
}
?>