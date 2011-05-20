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
 * $Id: class.TextilePreviewController.php 1250 2010-12-05 23:02:43Z iherwig $
 */
require_once(WCMF_BASE."wcmf/lib/presentation/class.Controller.php");

/**
 * @class TextilePreviewController
 * @ingroup Controller
 * @brief TextilePreviewController is a controller that has no logic.
 * It is used to preview HTML output generated by textile
 * 
 * <b>Input actions:</b>
 * - unspecified: Present the preview
 *
 * <b>Output actions:</b>
 * - @em ok In any case
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class TextilePreviewController extends Controller
{
  /**
   * @see Controller::hasView()
   */
  public function hasView()
  {
    return true;
  }
  /**
   * @return False (Stop action processing chain).
   * @see Controller::executeKernel()
   */
  public function executeKernel()
  {
    $request = $this->getRequest();
    $response = $this->getResponse();
    $response->setValue('text', $request->getValue('text'));
    $response->setAction('ok');
    return false;
  }
}
?>
