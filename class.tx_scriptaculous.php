<?php
/***************************************************************
 *  Copyright notice
 *  
 *  (c) 2006 Joerg Schoppet (joerg@schoppet.de)
 *  All rights reserved
 *
 *  This script is part of the Typo3 project. The Typo3 project is 
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 * 
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 * 
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/** 
 * Plugin 'script.aculo.us' for the 'scriptaculous' extension.
 *
 * @author	Joerg Schoppet <joerg@schoppet.de>
 */



class tx_scriptaculous {
	var $prefixId = 'tx_scriptaculous';		// Same as class name
	var $scriptRelPath = 'class.tx_scriptaculous.php';	// Path to this script relative to the extension dir.
	var $extKey = 'scriptaculous';	// The extension key.

	/**
	 * dummy
	 */
	function main($content,$conf)	{
	}

	/**
	 * include the library and other data for page rendering
	 * any configuration has to be done before with the set-functions
	 */
	function includeLib()	{

		// add prototype to page content
		if (!$GLOBALS['tx_scriptaculous']['tx_scriptaculous_prototype_inc']) {
			// add scriptaculous to page header
			$GLOBALS['TSFE']->additionalHeaderData['tx_scriptaculous_prototype_inc'] = '<script type="text/javascript" src="' . t3lib_extMgm::siteRelPath('scriptaculous') . 'lib/prototype.js"></script>';
			$GLOBALS['tx_scriptaculous']['tx_scriptaculous_prototype_inc'] = TRUE;
		}

		// the config is parsed the following way
		// 1. has the user set something within an application
		// 2. is something defined by TS
		// 3. use default values
		if (!isset($GLOBALS['tx_scriptaculous']['prototype_only']))	{

			if (isset($GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_scriptaculous.']['prototype_only']))	{

				if (strCaseCmp($GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_scriptaculous.']['prototype_only'], 'true') == 0)	{
					tx_scriptaculous::setPrototypeOnly(TRUE);
				} else {
					tx_scriptaculous::setPrototypeOnly(FALSE);
				}

			} else {
				tx_scriptaculous::setPrototypeOnly();
			}

		}

		if (!isset($GLOBALS['tx_scriptaculous']['functions']))	{

			if (isset($GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_scriptaculous.']['functions']))	{
				$aFunctions = explode(',', $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_scriptaculous.']['functions']);
			} else {
				tx_scriptaculous::setFunctionsOnly();
			}

		}

		// add scriptaculous to page content
		if ($GLOBALS['tx_scriptaculous']['prototype_only'] === FALSE)	{

			if (!$GLOBALS['tx_scriptaculous']['tx_scriptaculous_functions_inc']) {
				$sLoad = '';

				if (count($GLOBALS['tx_scriptaculous']['functions']) > 0)	{
					$sLoad = '?load=' . implode(',', $GLOBALS['tx_scriptaculous']['functions']);
				}

				$GLOBALS['TSFE']->additionalHeaderData['tx_scriptaculous_functions_inc'] = '<script type="text/javascript" src="' . t3lib_extMgm::siteRelPath('scriptaculous') . 'src/scriptaculous.js' . $sLoad . '"></script>';
				$GLOBALS['tx_scriptaculous']['tx_scriptaculous_functions_inc'] = TRUE;
			}

		}

	}

	/**
	 * set value if only prototype should be included
	 */
	function setPrototypeOnly($bVar=FALSE)	{
		$GLOBALS['tx_scriptaculous']['prototype_only'] = (bool)$bVar;
	}
	
	/**
	 * set value for special function load
	 */
	function setFunctionsOnly($aFunctions=array())	{

		if (is_array($aFunctions)) {
			$GLOBALS['tx_scriptaculous']['functions'] = $aFunctions;
		}

	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/scriptaculous/class.tx_scriptaculous.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/scriptaculous/class.tx_scriptaculous.php']);
}

?>
