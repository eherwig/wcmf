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
require_once(WCMF_BASE."wcmf/lib/util/Message.php");

/**
 * @interface IDataConverter
 * @ingroup Converter
 * @brief IDataConverter defines the interface for converting data between
 * storage and application.
 *
 * @author ingo herwig <ingo@wemove.com>
 */
interface IDataConverter
{
  /**
   * Convert data after reading from storage.
   * This method is called by PersistenceMapper classes after reading the data from the storage.
   * @param data The data from storage.
   * @param type The type of data.
   * @param name The name of the data item.
   * @return The converted data.
   */
  function convertStorageToApplication($data, $type, $name);
  /**
   * Convert data before writing to storage.
   * This method is called by PersistenceMapper classes before storing the data to the storage.
   * @param data The data from application.
   * @param type The type of data.
   * @param name The name of the data item.
   * @return The converted data.
   */
  function convertApplicationToStorage($data, $type, $name);
}
?>