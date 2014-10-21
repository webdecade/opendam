<?php


/**
 * Skeleton subclass for performing query and update operations on the 'usage_distribution' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * jeu. 26 janv. 2012 15:28:07 CET
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class UsageDistributionPeer extends BaseUsageDistributionPeer 
{
	const __AUTH = 1;
	const __LIMITED = 2;
	const __UNAUTH = 3;

	/*________________________________________________________________________________________________________________*/
	public static function getDistributions()
	{
		$c = new Criteria();
		
		$c->addJoin(UsageDistributionI18nPeer::ID, self::ID);
		$c->add(UsageDistributionI18nPeer::CULTURE, sfContext::getInstance()->getUser()->getCulture());
		$c->addAscendingOrderByColumn(UsageDistributionI18nPeer::TITLE);

		return self::doSelectWithI18n($c);
	}

	/*________________________________________________________________________________________________________________*/
	public static function getDistributionForFiles($file_ids)
	{
		$distributions = Array();

		foreach($file_ids as $file_id)
		{
			$file = FilePeer::retrieveByPk($file_id);

			if($file && $file->getUsageDistributionId())
			{
				$distribution = self::retrieveByPk($file->getUsageDistributionId());

				if(!in_array($distribution, $distributions))
					$distributions[$distribution->getId()] = $distribution;
			}
		}

		return $distributions;
	}

	/*________________________________________________________________________________________________________________*/
	public static function getDistributionForFolders($folder_ids)
	{
		$distributions = Array();

		foreach($folder_ids as $folder_id)
		{
			$folder = FolderPeer::retrieveByPk($folder_id);

			if($folder && $folder->getUsageDistributionId())
			{
				$distribution = self::retrieveByPk($folder->getUsageDistributionId());

				if(!in_array($distribution, $distributions))
					$distributions[$distribution->getId()] = $distribution;
			}
		}

		return $distributions;
	}
}
