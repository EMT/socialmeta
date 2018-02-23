<?php
/**
 * SocialMeta plugin for Craft CMS 3.x
 *
 * Rule based social tags and meta data.
 *
 * @link      https://madebyfieldwork.com
 * @copyright Copyright (c) 2018 Fieldwork
 */

namespace fieldwork\socialmeta\variables;

use fieldwork\socialmeta\SocialMeta;
use Craft;

/**
 * @author    Fieldwork
 * @package   SocialMeta
 * @since     1.0.0
 */
class SocialMetaVariable
{
    private $_meta = null;

    // Public Methods
    // =========================================================================

    public function getMeta($entry)
    {
        if (!$this->_meta) {
            $settings = SocialMeta::getInstance()->settings;
            $this->_meta = $this->_generateMeta($entry, $settings);
        }

        return $this->_meta;
    }

    public function getTitle($entry)
    {
        return $this->getMeta($entry)['title'];
    }

    public function getDescription($entry)
    {
        return $this->getMeta($entry)['description'];
    }

    public function getSocialTags($entry) {
        $social = SocialMeta::getInstance()->settings['social'];
        $meta = $this->getMeta($entry);
        $tags = [];

        foreach ($social as $name => $fieldKey) {
            if (!empty($meta[$fieldKey])) {
                $tag = '<meta ';
                $tag .= strpos($name, 'og:') === 0 ? 'property' : 'name';
                $tag .= '="' . $name . '" ';
                $tag .= 'content="' . $meta[$fieldKey] . '" />';
                $tags[] = $tag;
            }
        }

        return implode("\n", $tags);
    }

    // Private Methods
    // =========================================================================

    /**
     * Given an entry-like object, use settings
     * to generate meta for social tags
     */
    private function _generateMeta($entry, $settings)
    {
        $fields = [];

        foreach ($settings['fields'] as $key => $value) {
            $fields[$key] = is_callable($value) ? $value($entry) : $value;
        }

        return $fields;
    }
}
