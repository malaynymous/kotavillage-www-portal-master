<?php

/* Copyright 2008 Mohd Khazee */

/*  This file is part of KOTAVILLAGE Hotspot.

    http://kotavillagehotspot.tk/

    KOTAVILLAGE Hotspot is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    KOTAVILLAGE Hotspot is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with KOTAVILLAGE Hotspot.  If not, see <http://www.gnu.org/licenses/>.
*/

//error_reporting(E_ALL|E_STRICT); // REMOVE FOR RELEASE (NOT IN USE DUE TO PEAR MODULES BRING UP LOTS OF ERROS
require_once "Auth.php";
require_once "MDB2.php";

/**
 * Include Auth_Container base class
 */
require_once 'Auth/Container.php';
require_once 'Auth/Container/MDB2.php';

require_once __DIR__ . '/../../../vendor/autoload.php';

require_once('accesscheck.inc.php');
require_once('site_settings.inc.php');
require_once 'page_functions.inc.php';


$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$pagestarttime = $mtime;

function loginForm($username = null, $status = null, &$auth = null)
{
    global $templateEngine;
    $templateEngine->clearAssign('MenuItems');
    $templateEngine->clearAssign("LoggedInUsername");
    $templateEngine->assign('username', $username);

    switch ($status) {
        case 0:
            break;
        case -1:
        case -2:
            $error = T_("Your session has expired. Please login again");
            AdminLog::getInstance()->log("Expired Session");
            break;
        case -3:
            $error = T_("Incorrect Login");
            AdminLog::getInstance()->log("Invalid Login");
            break;
        case -5:
            $errro = T_("Security Issue. Please login again");
            AdminLog::getInstance()->log("Security Issue With Login");
            break;
        default:
            $error = T_("Authentication Issue. Please report to Admin");
            AdminLog::getInstance()->log("Auth Issues: $status");
    }
    if (isset($error)) {
        $templateEngine->assign("error", $error);
    }
    $templateEngine->displayPage('loginform.tpl');
    exit();
}

$DatabaseConnections = new DatabaseConnections();

$options = array(
    'dsn' => $DatabaseConnections->getRadminDSN(),
    'cryptType' => 'sha1salt',
    'sessionName' => 'KOTAVILLAGE Radius Admin For Internet',
    // accesslevel contains the users access levels as a bitmask
    'db_fields' => array('accesslevel')
);

$Auth = new Auth("MDB2_Salt", $options, "loginForm");

$Auth->setAdvancedSecurity(
    array(
        AUTH_ADV_USERAGENT => true,
        AUTH_ADV_IPCHECK => true,
        AUTH_ADV_CHALLENGE => false
    )
);
$Auth->setIdle(600);

$AdminLog =& AdminLog::getInstance($DatabaseConnections->getRadminDB(), $Auth);

if ($Auth->listUsers() == array()) {
    $templateEngine->assign("error", array(T_("No users defined in database. Please check your install")));
    $templateEngine->displayPage('loginform.tpl');
    exit();
}
$Auth->start();

if (!$Auth->checkAuth()) {
    echo "Should never get here"; // THIS CODE SHOULD NEVER RUN
    exit();
} elseif (isset($_GET['logoff'])) {
    AdminLog::getInstance()->log("Log out");
    $Auth->logout();
    $Auth->start();
} else {
    $templateEngine->assign("LoggedInUsername", $Auth->getUsername());
}

check_page_access();
