<?php


/**
 * Skeleton subclass for performing query and update operations on the 'unit_group' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Tue Aug 30 10:30:18 2011
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class UnitGroupPeer extends BaseUnitGroupPeer
{
	/*________________________________________________________________________________________________________________*/
	public static function doCriteria(array $params = array(), array $orderBy = array(), $limit = null)
	{
		$keyword = isset($params["keyword"]) ? $params["keyword"] : "";
		$letter = isset($params["letter"]) ? $params["letter"] : "";
		$role = isset($params["role"]) ? (int)$params["role"] : 0;
		$albumId = isset($params["albumId"]) ? (int)$params["albumId"] : 0;
		$customerId = isset($params["customerId"]) ? (int)$params["customerId"] : 0;
		$groupId = isset($params["groupId"]) ? (int)$params["groupId"] : 0;

		$criteria = new Criteria();
		$criteria->addJoin(UnitPeer::ID, self::UNIT_ID);
		$criteria->addJoin(GroupePeer::ID, self::GROUPE_ID);

		if ($customerId) {
			$criteria->add(UnitPeer::CUSTOMER_ID, $customerId);
		}
	
		if ($letter) {
			$criteria->add(GroupePeer::NAME, $letter.'%', Criteria::LIKE);
		}
	
		if ($role) {
			$criteria->add(self::ROLE, $role);
		}

		if ($albumId) {
			$criteria->add(self::GROUPE_ID, $albumId);
		}

		if ($groupId) {
			$criteria->add(self::UNIT_ID, $groupId);
		}

		if ($keyword) {
			$c1 = $criteria->getNewCriterion(GroupePeer::NAME, "%".$keyword."%", Criteria::LIKE);
			$criteria->add($c1);
		}

		CriteriaUtils::buildOrderBy($criteria, $orderBy);

		if ($limit) {
			$criteria->setLimit($limit);
		}

		return $criteria;
	}
	
	/*________________________________________________________________________________________________________________*/
	public static function getPager($page, $itemPerPage, array $params = array(), array $orderBy = array())
	{
		Assert::ok($page > 0);
		Assert::ok($itemPerPage > 0);
	
		$pager = new sfPropelPager("UnitGroup", $itemPerPage);
		$pager->setCriteria(self::doCriteria($params, $orderBy));
		$pager->setPage($page);
		$pager->setPeerMethod("doSelect");
		$pager->init();
	
		return $pager;
	}

	/*________________________________________________________________________________________________________________*/
	public static function getLettersPager(array $params = array())
	{
		$criteria = self::doCriteria($params);

		$criteria->clearSelectColumns();
		$criteria->addSelectColumn("DISTINCT UPPER(substr(".GroupePeer::NAME.", 1, 1 )) AS letter");
		$criteria->addAscendingOrderByColumn("letter");

		$letters = GroupePeer::doSelectStmt($criteria);

		return $letters->fetchAll(PDO::FETCH_COLUMN, 0);
	}

	/*________________________________________________________________________________________________________________*/
	public static function retrieveByUnitIdAndGroupeId($unit_id, $groupe_id)
	{
		$c = new Criteria();
		
		$c->add(self::UNIT_ID, $unit_id);
		$c->add(self::GROUPE_ID, $groupe_id);

		return self::doSelectOne($c);
	}

	/*________________________________________________________________________________________________________________*/
	/**
	 * Renvoi les "UnitGroup" selon l'indentifiant d'un groupe.
	 * 
	 * @param integer $unit_id
	 * @return Array<UnitGroup>
	 */
	public static function retrieveByUnitId($unit_id)
	{
		$c = new Criteria();
		$c->add(self::UNIT_ID, $unit_id);

		return self::doSelect($c);
	}

	/*________________________________________________________________________________________________________________*/
	/**
	 * Renvoi les "UnitGroup" selon l'indentifiant d'un album.
	 *
	 * @param integer $album_id
	 * @return Array<UnitGroup>
	 */
	public static function retrieveByAlbumId($album_id)
	{
		$c = new Criteria();
		$c->add(self::GROUPE_ID, $album_id);
	
		return self::doSelect($c);
	}

	/*________________________________________________________________________________________________________________*/
	/**
	 * Renvoi les "UnitGroup" selon l'indentifiant d'un album et d'un utilisateur.
	 *
	 * @param integer $album_id
	 * @param integer $user_id
	 * @return Array<UnitGroup>
	 */
	public static function retrieveByAlbumIdAndUserId($album_id, $user_id)
	{
		$criteria = new Criteria();
		$criteria->addJoin(self::UNIT_ID, UserUnitPeer::UNIT_ID);
		$criteria->add(self::GROUPE_ID, $album_id);
		$criteria->add(UserUnitPeer::USER_ID, $user_id);

		return self::doSelect($criteria);
	}
	
	/*________________________________________________________________________________________________________________*/
	/**
	 * Renvoi les "UnitGroup" selon l'indentifiant d'un groupe.
	 *
	 * @param integer $unit_id
	 * @return Array<UnitGroup>
	 */
	public static function countByUnitId($unit_id)
	{
		$c = new Criteria();
		$c->add(self::UNIT_ID, $unit_id);
	
		return self::doCount($c);
	}

	/*________________________________________________________________________________________________________________*/
	/**
	 * @deprecated
	 * Renvoi les albums que l'on peux ajouter au groupe.
	 * 
	 * @param integer $unit_id L'id du groupe.
	 * @return Array<Groupe> Un tableau d'album.
	 */
	public static function getFreeGroups($unit_id)
	{
		$connection = Propel::getConnection();
		$groups = array();

		$query = "	SELECT groupe.*
					FROM groupe
					WHERE groupe.state = ".GroupePeer::__STATE_ACTIVE."
					AND groupe.customer_id = ".sfContext::getInstance()->getUser()->getCustomerId()."
					AND groupe.id NOT IN (	SELECT unit_group.groupe_id
											FROM unit_group, unit
											WHERE unit_group.unit_id = unit.id
											AND unit_group.unit_id = ".$unit_id."
											AND unit.customer_id = ".sfContext::getInstance()->getUser()->getCustomerId()."
										)
					ORDER BY groupe.name ASC";

		$statement = $connection->query($query);
		$statement->setFetchMode(PDO::FETCH_NUM);

		while ($rs = $statement->fetch()) {
			$group = new Groupe();
			$group->hydrate($rs);

			$groups[] = $group;
		}

		return $groups;
	}

	/*________________________________________________________________________________________________________________*/
	public static function retrieveMinRoleByGroupIdAndUserId($group_id, $user_id)
	{
		$connection = Propel::getConnection();
		$unitGroup = null;
		$role = null;

		$query = "	SELECT unit_group.*
					FROM unit_group, unit, user_unit
					WHERE unit_group.unit_id = unit.id
					AND unit.id = user_unit.unit_id
					AND unit_group.groupe_id = ".$group_id."
					AND user_unit.user_id = ".$user_id;

		$statement = $connection->query($query);
		$statement->setFetchMode(PDO::FETCH_NUM);

		while ($rs = $statement->fetch()) {
			if(empty($role) || (!empty($role) && $rs[3] < $role)) {
				$unitGroup = new UnitGroup();
				$unitGroup->hydrate($rs);
			}

			$role = $rs[3];
		}

		return $unitGroup;
	}

	/*________________________________________________________________________________________________________________*/
	public static function getEffectiveByGroupIdAndRole($group_id, $role_id)
	{
		$c = new Criteria();
		
		$c->addJoin(self::UNIT_ID, UnitPeer::ID);
		$c->addJoin(UnitPeer::ID, UserUnitPeer::UNIT_ID);
		$c->addJoin(UserUnitPeer::USER_ID, UserPeer::ID);
		$c->add(UserPeer::STATE, UserPeer::__STATE_ACTIVE);
		$c->add(self::GROUPE_ID, $group_id);
		$c->add(self::ROLE, $role_id);

		return UserUnitPeer::doSelect($c);
	}
}
