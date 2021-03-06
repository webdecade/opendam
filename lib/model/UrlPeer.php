<?php


/**
 * Skeleton subclass for performing query and update operations on the 'url' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Wed Sep  7 11:46:39 2011
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class UrlPeer extends BaseUrlPeer
{
	/*________________________________________________________________________________________________________________*/
	public static function retrieveByType($type)
	{
		$c = new Criteria();
		$c->add(self::TYPE, $type);
		$url = self::doSelect($c);

		return !empty($url) > 0 ? $url[0] : null;
	}
}
