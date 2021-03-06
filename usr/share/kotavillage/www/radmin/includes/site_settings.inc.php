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

require_once __DIR__ . '/../../../vendor/autoload.php';

$Radmin = new \KotaVillage\Database\Database('/etc/kotavillage/radmin.conf');
$Settings = new \Kotavillage\Database\Radmin($Radmin);

/* PHP No longer correctly gets the timezone from the system. Try to set it */

$timezoneFile = trim(file_get_contents('/etc/timezone'));

if ($timezoneFile) {
    date_default_timezone_set($timezoneFile);
} else {
    date_default_timezone_set(@date_default_timezone_get());
}
