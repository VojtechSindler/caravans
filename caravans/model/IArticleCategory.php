<?php

namespace Caravans\Model;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
interface IArticleCategory {

    const ARTICLE = 10;
    const NEWS = 11;
    const EXHIBITON = 12;

}

/**
 * Přetypování IArticleCategory na název kategorie.
 */
class CategoryTranslator {
    
    /**
     * @param int $type
     * @return string
     */
    public static function translate($type) {
        switch ($type) {
            case IArticleCategory::ARTICLE:
                return "aktualita";
                break;
            case IArticleCategory::EXHIBITON:
                return "výstava";
                break;
            case IArticleCategory::NEWS:
                return "novinka";
            default:
                break;
        }
    }

}
