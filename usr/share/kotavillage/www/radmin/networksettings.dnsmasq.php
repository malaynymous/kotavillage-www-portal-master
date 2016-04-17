<?php

/* Copyright 2011 Mohd khazee */

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

// As this can be called from anywhere we need to chdir
chdir(__DIR__);

require_once 'includes/site_settings.inc.php';

$NONINTERACTIVE_SCRIPT = true;

$networkOptions = unserialize($Settings->getSetting('networkoptions'));
$lastChangedTimestamp = $Settings->getSetting('lastnetworkconf');

$lanIP = $networkOptions['lanipaddress'];
$netmask = $networkOptions['networkmask'];

$lanIF = $networkOptions['lanif'];
$wanIF = $networkOptions['wanif'];

$networkIP = long2ip(ip2long($lanIP) & ip2long($netmask));

echo "#### This file is auto generated                              ####\n";
echo "#### Please do not edit it.                                   ####\n";
echo "#### Changes can be made in the Grase Hotspot Admin interface ####\n";

echo "#chilli_lanip $lanIP\n";
echo "#chilli_wanif $wanIF\n";
echo "#chilli_lanif $lanIF\n";
echo "#chilli_network $networkIP\n";
echo "#chilli_netmask $netmask\n";
echo "\n";
//echo "address=/hotspot.lan/$lanIP\n";
echo "address=/kotavillagehotspot.lan/$lanIP\n";
echo "address=/logout/1.0.0.0\n";
echo "address=/logoff/1.0.0.0\n";
echo "\n";
echo "no-resolv\n";
echo "strict-order\n";
echo "\n";
echo "expand-hosts\n";
echo "domain=hotspot.lan\n";

// No dns servers set so default to OpenDNS Famiyl Shield
if (sizeof($networkOptions['dnsservers']) == 0) {
    echo "#default dns servers and OpenDNS Family Shield\n";
    echo "server=208.67.222.123\n";
    echo "server=208.67.220.123\n";
} else {
    foreach ($networkOptions['dnsservers'] as $dnsserver) {
        echo "server=$dnsserver\n";
    }
}

if ($networkOptions['opendnsbogusnxdomain']) {
   /* From http://johnewart.net/posts/2010/04/26/
    "67.215.65.130" => "hit-adult.opendns.com",
    "67.215.65.131" => "hit-block.opendns.com",
    "67.215.65.132" => "hit-nxdomain.opendns.com",
    "67.215.65.133" => "hit-phish.opendns.com",
    "67.215.65.134" => "hit-servfail.opendns.com",
    "67.215.65.135" => "block.opendns.com",
    "67.215.65.136" => "guide.opendns.com",
    "67.215.65.137" => "phish.opendns.com",
    "67.215.65.138" => "block.opendns.com",
    "67.215.65.139" => "guide.opendns.com",
    */

    // Due to Bug #79 (http://trac.grasehotspot.org/ticket/79) we can't lookup the bogus nxdomain ips, as we block them!
    // Unless another solution is found for lookups we'll just have to update this if the ips ever change.
    echo "bogus-nxdomain=67.215.65.132\n";
    /*$bogusnxdomains = array('hit-nxdomain.opendns.com');
    // TODO: plugin hook here?
    foreach($bogusnxdomains as $domainname){
	$ips = gethostbynamel($domainname);
	if($ips) foreach($ips as $ip)
        {
            echo "bogus-nxdomain=$ip\n";
        }
    }*/
}

if (is_array($networkOptions['bogusnx'])) {
    foreach ($networkOptions['bogusnx'] as $ip) {
        echo "bogus-nxdomain=$ip\n";
    }
}

echo "# last updated $lastChangedTimestamp";
