<?php

/**
 * newsearch actions.
 *
 * @package    wikipixel
 * @subpackage newsearch
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class newsearchActions extends sfActions
{
    /*________________________________________________________________________________________________________________*/
    public function preExecute()
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers("I18N");
    }

    public function executeShow()
    {
    }

    public function executeUser()
    {
        $userdata = $this->getSession()->getAll();
    }

}
