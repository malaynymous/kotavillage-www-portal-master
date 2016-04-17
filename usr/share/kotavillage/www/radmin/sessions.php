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
$PAGE = 'sessions';
require_once 'includes/pageaccess.inc.php';
require_once 'includes/session.inc.php';
require_once 'includes/misc_functions.inc.php';

if (isset($_POST['logout_mac'])) {
    // Logout a specific MAC address
    if (\KotaVillage\Util::logoutChilliSession($_POST['logout_mac'])) {
        $templateEngine->successMessage(T_("Logged out: ") . Grase\Clean::text($_POST['logout_mac']));
    } else {
        $templateEngine->errorMessage(
            T_("Unable to find active session for: ") . KotaVillage\Clean::text($_POST['logout_mac'])
        );
    }
}

if (isset($_GET['username'])) {
    $templateEngine->assign(
        "sessions",
        DatabaseFunctions::getInstance()->getRadiusUserSessionsDetails($_GET['username'])
    );
    $templateEngine->assign("username", $_GET['username']);
} elseif (isset($_GET['allsessions'])) {
    $sessions = DatabaseFunctions::getInstance()->getRadiusUserSessionsDetails();
    $totalRows = sizeof($sessions);
    $numPerPage = $_GET['items'] ? abs($_GET['items']) : 25; // TODO check this is safe
    $page = $_GET['page'] ? abs($_GET['page']) : 0; //TODO check this is safe

    $pages = floor($totalRows / $numPerPage);
    if ($page > $pages) {
        $page = $pages;
    }
    $currentStartItem = $page * $numPerPage;

    $displaySessions = array_slice($sessions, $currentStartItem, $numPerPage, true);
    $templateEngine->assign("sessions", $displaySessions);
    $templateEngine->assign("pages", $pages);
    $templateEngine->assign("perpage", $numPerPage);
    $templateEngine->assign("currentpage", $page);
} else {
    $templateEngine->assign("activesessions", DatabaseFunctions::getInstance()->getActiveRadiusSessionsDetails());
    if ($_GET['refresh']) {
        $refresh = clean_int($_GET['refresh']) * 60;
        if ($refresh < 60) {
            $refresh = 60;
        }
        $templateEngine->assign("autorefresh", $refresh);
    }
}

$templateEngine->assign('usercomments', DatabaseFunctions::getInstance()->getAllUsersComments());
$templateEngine->displayPage('sessions.tpl');

// TODO: Data usage over "forever"
