<?php


/**
 * Skeleton subclass for representing a row from the 'preset' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * jeu. 12 juil. 2012 11:50:06 CEST
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Preset extends BasePreset
{
	/*________________________________________________________________________________________________________________*/
	public function getName()
	{
		sfContext::getInstance()->getConfiguration()->loadHelpers("I18N");
		return __($this->name);
	}
}
