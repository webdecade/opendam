<?php

class searchdateComponents extends sfComponents
{
	public function executeSidebar()
	{
		$this->licences = LicencePeer::getLicenceInArray();
		$this->uses = UsageUsePeer::getUses();
		$this->distributions = UsageDistributionPeer::getDistributions();
	}
}