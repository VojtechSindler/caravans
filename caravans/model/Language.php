<?php

namespace Caravans\Model;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class Language {

    const CS = 21;
    const DE = 22;
    const EN = 23;

    /**
     * Převede jazyk z url na číselnou reprezentaci ILanguage
     * @param string $lang
     * @return int
     */
    public static function convertToInt($lang) {
        if($lang == "cs")
            return self::CS;
        if($lang == "en")
            return self::EN;
        if($lang == "de")
            return self::DE;
    }

    public static function convertToString($int){
        if($int == self::CS)
            return "cs";
        if($int == self::EN)
            return "en";
        if($int == self::DE)
            return "de";
    }
}
