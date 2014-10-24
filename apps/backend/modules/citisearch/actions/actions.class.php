<?php

/**
 * citisearch actions.
 *
 * @package    wikipixel
 * @subpackage citisearch
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class citisearchActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */

  public function executeIndex(sfWebRequest $request)
  {
   $keyword = $request->getParameter("keyword", "");
    $page = (int)$request->getParameter("page", 1);
    $orderBy = $request->getParameter("orderBy", array("name_asc"));

    $itemPerPage = 15;
    
    $this->albums = GroupePeer::getPager($page, $itemPerPage,
        array(
            "customerId" => $this->getUser()->getCustomerId(),
            "keyword"    => $keyword,
        ), $orderBy);
    
    $this->orderBy = $orderBy;
    $this->keyword = $keyword;
    
    $this->csrfToken = $this->getUser()->getCsrfToken();
  }

  public function executeShow(sfWebRequest $request)
  {

  }

  public static function getListParams()
  {
    $sf_user = sfContext::getInstance()->getUser();
    
    return array(
        "userId" => $sf_user->getId(),
        "customerId" => $sf_user->getCustomerId()
    );
  }

}
