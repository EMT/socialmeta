<?php

namespace fieldwork\socialmeta;
use craft\base\Model;

/**
 * Social Meta plugin.
 *
 * @author Fieldwork
 * @since  3.0.0-RC11
 */
class Settings extends Model
{
    /**
     * @var array The default fields
     */
    public $fields = [];

    /**
     * @var array The default social tags
     */
    public $social = [
        'twitter:card' => 'twitter:card',
        'og:url' => 'url',
        'og:title' => 'title',
        'og:description' => 'description',
        'og:image' => 'image',
    ];

    function __construct() {
        $this->fields = [
            'url' => function($entry) {
                return $entry->getUrl();
            },
            'title' => function($entry) {
                return $entry->title;
            },
            'description' => function($entry) {
                return '';
            },
            'image' => function($entry) {
                return null;
            },
            'twitter:card' => 'summary',
        ];
    }
}
