<?php

/**
 * citisearch actions.
 *
 * @package    wikipixel
 * @subpackage citisearch
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class citisearchActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function preExecute() {
        sfContext::getInstance()->getConfiguration()->loadHelpers("I18N");
    }

    public function executeIndex(sfWebRequest $request) {
        $db_host = "localhost";
        $db_username = "root";
        $db_password = "Mithon@8";
        $db_name = "opendam";
        mysql_connect($db_host, $db_username, $db_password) or die("not connected");
        mysql_select_db($db_name);
        $album_tag = "";
        $ret_tag = "";
        $dev_tag = "";
        $msg_tag = "";
        $pg_tag = "";
        $type_tag = "";
        $qrystr = "";
        if ($request->getParameter("album_tag", "") != "") {
            $album_tag = $request->getParameter("album_tag", "");
            $qrystr = $qrystr . " AND album_tag in ('" . $album_tag . "')";
        }
        if ($request->getParameter("ret_tag", "") != "") {
            $ret_tag = $request->getParameter("ret_tag", "");
            $qrystr = $qrystr . " AND retailer_tag in ('" . $ret_tag . "')";
        }
        if ($request->getParameter("dev_tag", "") != "") {
            $dev_tag = $request->getParameter("dev_tag", "");
            $qrystr = $qrystr . " AND device_tag in ('" . $dev_tag . "')";
        }
        if ($request->getParameter("msg_tag", "") != "") {
            $msg_tag = $request->getParameter("msg_tag", "");
            $qrystr = $qrystr . " AND payment_estimator in ('" . $msg_tag . "')";
        }
        if ($request->getParameter("page_tag", "") != "") {
            $pg_tag = $request->getParameter("page_tag", "");
            $qrystr = $qrystr . " AND page_tag in ('" . $pg_tag . "')";
        }
        if ($request->getParameter("type_tag", "") != "") {
            $type_tag = $request->getParameter("type_tag", "");
            $qrystr = $qrystr . " AND type_tag in ('" . $type_tag . "')";
        }
        if ($request->getParameter("ajaxrqt", "") == "1") {
            $qry = " Select * from userstudy";
            $qry = $qry . " Where album !='' ";
            $qry = $qry . $qrystr;
            $qry = $qry . " Order By date_tag desc";
            $qrydata = mysql_query($qry);
            $partnername = "";
            $usrstdname = "";
            $busidevname = "";
            $presentationname = "";
            while ($fetchdata = mysql_fetch_array($qrydata)) {
                if ($fetchdata['album'] == "Partner") {
                    $partnername = $partnername . '<li>' . $fetchdata['asset_name'] . '</li>';
                }
                if ($fetchdata['album'] == "User Study") {
                    $usrstdname = $usrstdname . '<li>' . $fetchdata['asset_name'] . '</li>';
                }
                if ($fetchdata['album'] == "Business Development") {
                    $busidevname = $busidevname . '<li>' . $fetchdata['asset_name'] . '</li>';
                }
                if ($fetchdata['album'] == "Presentation") {
                    $presentationname = $presentationname . '<li>' . $fetchdata['asset_name'] . '</li>';
                }
            }
            if ($partnername == "") {
                $partnername = '<li>No album found.</li>';
            }
            if ($usrstdname == "") {
                $usrstdname = '<li>No album found.</li>';
            }
            if ($busidevname == "") {
                $busidevname = '<li>No album found.</li>';
            }
            if ($presentationname == "") {
                $presentationname = '<li>No album found.</li>';
            }
            echo $partnername . "||" . $busidevname . "||" . $usrstdname . "||" . $presentationname;
            exit;
        }
        $keyword = $request->getParameter("keyword", "");
        $page = (int) $request->getParameter("page", 1);
        $orderBy = $request->getParameter("orderBy", array("name_asc"));
        $itemPerPage = 15;
        $this->albums = GroupePeer::getPager($page, $itemPerPage, array(
                    "customerId" => $this->getUser()->getCustomerId(),
                    "keyword" => $keyword,
                        ), $orderBy);
        $this->tagc = TagCatPeer::doSelect(new Criteria());
        $this->orderBy = $orderBy;
        $this->keyword = $keyword;
        $this->csrfToken = $this->getUser()->getCsrfToken();

        $albumtag = array();
        $retailer_tag = array();
        $device_tag = array();
        $message_offer = array();
        $page_tag = array();
        $messagetype = array();
        
        $qry = " Select * from userstudy";
        $qry = $qry . " order by date_tag desc";
        $qrydata = mysql_query($qry);
        while ($fetchdata = mysql_fetch_array($qrydata))
        {
            $dtflg = 0;
            if ($request->getParameter("txtfrmdate", "") != "")
            {
                if( strtotime($fetchdata['date_tag']) >= strtotime($request->getParameter("type_tag", "")) )
                {
                    $dtflg = 0;
                }
                else
                {
                    $dtflg = 1;
                }
            }
            if ($request->getParameter("txttodate", "") != "")
            {
            }
            if($dtflg == 0)
            {
                $albumtag[] = $fetchdata['album_tag'];
                //$albumtag[] = date('Y-m-d', strtotime($fetchdata['date_tag']));
                $retailer_tag[] = $fetchdata['retailer_tag'];
                $device_tag[] = $fetchdata['device_tag'];
                $message_offer[] = $fetchdata['payment_estimator'];
                $page_tag[] = $fetchdata['page_tag'];
                $messagetype[] = $fetchdata['type_tag'];
            }
        }
        $this->album_tag = array_unique($albumtag);
        $this->retailer_tag = array_unique($retailer_tag);
        $this->device_tag = array_unique($device_tag);
        $this->message_offer = array_unique($message_offer);
        $this->page_tag = array_unique($page_tag);
        $this->messagetype = array_unique($messagetype);
    }

    public function executeShow(sfWebRequest $request) {
        
    }

    public static function getListParams() {
        $sf_user = sfContext::getInstance()->getUser();
        return array(
            "userId" => $sf_user->getId(),
            "customerId" => $sf_user->getCustomerId()
        );
    }

}