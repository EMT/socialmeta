<?php
/**
 * SocialMeta plugin for Craft CMS 3.x
 *
 * Rule based social tags and meta data.
 *
 * @link      https://madebyfieldwork.com
 * @copyright Copyright (c) 2018 Fieldwork
 */

namespace fieldwork\socialmeta;

use fieldwork\socialmeta\Settings;
use fieldwork\socialmeta\variables\SocialMetaVariable;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;

/**
 * Class SocialMeta
 *
 * @author    Fieldwork
 * @package   SocialMeta
 * @since     1.0.0
 *
 */
class SocialMeta extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var SocialMeta
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('socialMeta', SocialMetaVariable::class);
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {

                }
            }
        );

        Craft::info(
            Craft::t(
                'socialmeta',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    protected function createSettingsModel() {
        return new Settings();
    }
}
