<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('backend', 'dev', false);
sfContext::createInstance($configuration)->dispatch();
