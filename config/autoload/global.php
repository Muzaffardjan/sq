<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   09.03.2017
 */

return [
    'translator' => [
        'locale' => 'uz-oz',
        'locales' => [
            'uz-oz' => 'O\'zbekcha',
            'uz-uz' => 'Ўзбекча',
            'ru-ru' => 'Русский',
            'en-us' => 'English',
        ],
        'translation_file_patterns' => [
            [
                'type'     => 'phparray',
                'base_dir' => __DIR__ . '/../../data/language',
                'pattern'  => '%s.php',
            ],
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];