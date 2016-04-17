<?php

/* Copyright 2009 Mohd Khazee */

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
$PAGE = 'adminlog';
require_once 'includes/pageaccess.inc.php';

require_once 'includes/session.inc.php';
require_once 'includes/misc_functions.inc.php';

// TODO: Add "reset" option that archives old stuff? (Or deletes old stuff)
$templateEngine->assign("loglines", AdminLog::getInstance()->getLog());
$templateEngine->assign("lastcron", AdminLog::getInstance()->lastCron());
$templateEngine->displayPage('adminlog.tpl');
