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

$PAGE = 'main';
require_once 'includes/pageaccess.inc.php';
require_once 'includes/session.inc.php';

$Sysinfo = new KotaVillage\SystemInformation();
$templateEngine->assign('Sysinfo', $Sysinfo);
$templateEngine->displayPage('main.tpl');
