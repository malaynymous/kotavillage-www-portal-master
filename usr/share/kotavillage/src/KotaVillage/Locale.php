<?php
/* Copyright 2016 Mohd Khazee */

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
    along with GRASE Hotspot.  If not, see <http://www.gnu.org/licenses/>.
*/


namespace KotaVillage;

/* This Locale stuff doesn't need any DB, so we can call it from anywhere and
 * just apply the locale we want without DB calls!
 */

class Locale
{
    public static $locale = '';

    public static function applyLocale($newlocale)
    {
        self::$locale = $newlocale;
        //TODO Allow locale to be overriden by GET request?
        //if($_GET['lang']) $locale = $_GET['lang'];

        locale_set_default(self::$locale);
        //$language = locale_get_display_language(self::$locale, 'en');
        $lang = locale_get_primary_language(self::$locale);
        //$region = locale_get_display_region(self::$locale);

        T_setlocale(LC_MESSAGES, $lang);

        T_bindtextdomain("kotavillage", "/usr/share/kotavillage/locale");
        T_bind_textdomain_codeset("kotavillage", "UTF-8");
        T_textdomain("kotavillage");
    }

    public static function localeNumberFormat(
        $number,
        $isMoney = false,
        $lg = ''
    ) {
        if ($lg == '') {
            $lg = self::$locale;
        }

        if ($number == '') {
            return $number;
        }

        if ($isMoney) {
            $fmt = new \NumberFormatter($lg, \NumberFormatter::CURRENCY);
            return $fmt->format($number);
        } else {
            $fmt = new \NumberFormatter($lg, \NumberFormatter::DECIMAL);
            return $fmt->format($number);
        }
    }

    public static function localeMoneyFormat($number)
    {
        return self::localeNumberFormat($number, true);
    }

    public static function getAvailableLanguages()
    {
        $langs = array();
        //TODO make directory not absolute path?
        $lang_codes = glob('/usr/share/kotavillage/locale/??', GLOB_ONLYDIR);
        foreach ($lang_codes as $code) {
            $lang['display'] = \Locale::getDisplayLanguage(
                basename($code),
                'en'
            );
            $lang['code'] = basename($code);
            $langs[] = $lang;
        }

        return $langs;
    }
}
