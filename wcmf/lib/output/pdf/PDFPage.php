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
 * $Id$
 */
require_once(WCMF_BASE."wcmf/lib/core/WCMFException.php");

/**
 * @class PDFPage
 * @ingroup Output
 * @brief PDFPage instances define the content of a pdf page by using a
 * set of FPDF/FPDI commands inside the PDFPage::render method.
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class PDFPage
{
  /**
   * Render data onto a pdf.
   * @param pdf A reference to the FPDF/FPDI instance to render onto
   * @param page The page number in the pdf document
   * @param data An optional data object to get data from.
   */
  function render(&$pdf, $page, $data=null)
  {
    WCMFException::throwEx("render() must be implemented by derived class: ".get_class($this), __FILE__, __LINE__);
  }
}
?>