<?php

/* Copyright 2008 Mohd khazee */

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

require_once 'includes/page_functions.inc.php';

function usermin_createmenuitems()
{
    //	$menubar['id'] = array("href" => , "label" => );
    $menubar['user'] = array("href" => "?user", "label" => "My Details");
    $menubar['history'] = array("href" => "?history", "label" => "My History");
    $menubar['logout'] = array("href" => "?logoff", "label" => "Logoff");
    return $menubar;
}

function usermin_assign_vars()
{
    global $templateEngine, $Settings;
    $templateEngine->assign("Application", T_("My Account"));

    $templateEngine->assign("Title", $Settings->getSetting('locationName') . " - " . T_("My Account"));

    // Setup Menus
    $templateEngine->assign("MenuItems", usermin_createmenuitems());
    isset($_SESSION['username']) && $templateEngine->assign("LoggedInUsername", $_SESSION['username']);

}
