<?php


/**
 * Skeleton subclass for performing query and update operations on the 'module_visibility' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * ven. 23 mars 2012 10:06:49 CET
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class ModuleVisibilityPeer extends BaseModuleVisibilityPeer
{
	const __PRODUCT = 1;
	const __CUSTOMER = 2;
	const __UNIT = 3;
	const __ADMIN = 4;
	const __USER = 5;

	/*________________________________________________________________________________________________________________*/
	public static function getInArray()
	{
		return Array(
			self::__PRODUCT => __("Product"),
			self::__CUSTOMER => __("Customer"),
			self::__UNIT => __("Unit"),
			self::__ADMIN => __("Administrator"),
			self::__USER => __("User")
		);
	}
}
