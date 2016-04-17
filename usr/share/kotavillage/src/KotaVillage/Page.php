<?php

namespace KotaVillage;

    /* Copyright 2016-2018 Mohd Khazee */

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

class Page
{
    private $te;
    private $errorMessages = array();
    private $successMessages = array();
    private $warningMessages = array();

    public function __construct($template_engine = null)
    {
        if ($template_engine == null) {
            $this->te = new \SmartyBC();
            $this->setupSmarty();
        } else {
            $this->te = $template_engine;
        }
    }

    private function setupSmarty()
    {
        //$this->te->error_reporting = E_ALL & ~E_NOTICE;
        $this->te->compile_check = true;
        //$this->te->register_outputfilter('smarty_outputfilter_strip');
        //$this->te->registerPlugin('modifier', 'bytes', array("\KotaVillage\Util", "formatBytes"));
        $this->te->register_modifier('bytes', array("\KotaVillage\Util", "formatBytes"));
        $this->te->register_modifier('seconds', array("\KotaVillage\Util", "formatSec"));
        $this->te->register_modifier('displayLocales', array('\KotaVillage\Locale', 'localeNumberFormat'));
        $this->te->register_modifier('displayMoneyLocales', array('\KotaVillage\Locale', 'localeMoneyFormat'));
        $this->te->register_function('inputtype', array('\KotaVillage\Page', 'smartyInputType'));
        $this->te->register_modifier("sortby", "smarty_modifier_sortby");

        // i18n
        //$locale = (!isset($_GET["l"]))?"en_GB":$_GET["l"];
        $this->te->register_block('t', 'smarty_block_t');

    }

    public function smartyInputType($params, &$smarty)
    {
        $val = $params['value'];
        $checked = " ";
        switch ($params['type']) {
            case "ip":
                return 'type="text" pattern="\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}" title="IP Address" value="'
                    . $val . '"';
                break;
            case "bool":
                if ($val) {
                    $checked = "checked";
                }
                return 'type="checkbox" ' . $checked;
            default:
                return 'type="text" value="' . $val . '"';
        }
    }

    public function errorMessage($message)
    {
        $this->errorMessages[] = $message;
    }

    public function successMessage($message)
    {
        $this->successMessages[] = $message;
    }

    public function warningMessage($message)
    {
        $this->warningMessages[] = $message;
    }

    public function clearAssign($template_var)
    {
        return $this->te->clearAssign($template_var);
    }

    public function displayPage($template)
    {
        \assign_vars($this->te);
        $this->setupTemplateVariables();
        return $this->te->display($template);
    }

    public function setupTemplateVariables()
    {
        if (sizeof($this->warningMessages) != 0) {
            $this->assign("warningmessages", $this->warningMessages);
        }
        if (sizeof($this->errorMessages) != 0) {
            $this->assign("error", $this->errorMessages);
        }
        if (sizeof($this->successMessages) != 0) {
            $this->assign("success", $this->successMessages);
        }

        // Real hostname
        $this->assign("RealHostname", trim(file_get_contents('/etc/hostname')));
    }

    public function assign($template_var, $value)
    {
        return $this->te->assign($template_var, $value);
    }
}
