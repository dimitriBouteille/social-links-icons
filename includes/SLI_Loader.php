<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class SLI_Loader
 *
 * @since   1.0.0
 * @package SocialLinksIcons
 * @author  Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 */
class SLI_Loader
{

    /**
     * The single instance of the class
     *
     * @since 1.0.0
     *
     * @var null|SLI_Loader
     */
    private static $instance = null;

    /**
     * Function instance
     *
     * @since 1.0.0
     *
     * @return SLI_Loader|null
     * @throws ReflectionException
     * @throws SLI_Exception
     */
    public static function instance() {

        if(is_null(self::$instance)) {
            self::$instance = new self();
            self::$instance->init();
        }

        return self::$instance;
     }

    /**
     * Function init
     * Initialize the plugin (constants, hooks, ...)
     *
     * @since 1.0.0
     *
     * @throws ReflectionException
     * @throws SLI_Exception
     */
     private function init(): void {

        $this->initConstants();
        $this->loadClass();
        $this->initHooks();
        $this->initFunctions();
        $this->initGlobalVars();

        SLI_ShortCode::init();
     }

    /**
     * Function initConstants
     * Define SL constants
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function initConstants(): void {

        $this->define('SLI_ABSPATH', __DIR__);
        $this->define('SLI_TEMPLATES_PATH', SLI_DIR.DIRECTORY_SEPARATOR.'templates');
    }

    /**
     * Function loadClass
     * Include required core files used in admin
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function loadClass(): void {

        $this->include('/SLI_Exception.php');
        $this->include('/Social/SLI_Social_Abstract.php');
        $this->include('/Social/SLI_Social_Behance.php');
        $this->include('/Social/SLI_Social_Blogger.php');
        $this->include('/Social/SLI_Social_Discord.php');
        $this->include('/Social/SLI_Social_Dribbble.php');
        $this->include('/Social/SLI_Social_Facebook.php');
        $this->include('/Social/SLI_Social_Flickr.php');
        $this->include('/Social/SLI_Social_Github.php');
        $this->include('/Social/SLI_Social_GooglePlay.php');
        $this->include('/Social/SLI_Social_Instagram.php');
        $this->include('/Social/SLI_Social_Linkedin.php');
        $this->include('/Social/SLI_Social_Medium.php');
        $this->include('/Social/SLI_Social_Pinterest.php');
        $this->include('/Social/SLI_Social_Reddit.php');
        $this->include('/Social/SLI_Social_Skype.php');
        $this->include('/Social/SLI_Social_Slack.php');
        $this->include('/Social/SLI_Social_Snapchat.php');
        $this->include('/Social/SLI_Social_Soundcloud.php');
        $this->include('/Social/SLI_Social_Stackoverflow.php');
        $this->include('/Social/SLI_Social_Steam.php');
        $this->include('/Social/SLI_Social_Telegram.php');
        $this->include('/Social/SLI_Social_Tumblr.php');
        $this->include('/Social/SLI_Social_Twitch.php');
        $this->include('/Social/SLI_Social_Twitter.php');
        $this->include('/Social/SLI_Social_Vimeo.php');
        $this->include('/Social/SLI_Social_WhatsApp.php');
        $this->include('/Social/SLI_Social_Youtube.php');
        $this->include('/SocialLinksIcons.php');
        $this->include('/SLI_BackOffice.php');
        $this->include('/SLI_ShortCode.php');
    }

    /**
     * Function define
     * Define constant if not already set
     *
     * @since 1.0.0
     *
     * @param string $name
     * @param string|bool $value
     * @return bool
     */
    private function define(string $name, $value): bool {

        if(!defined($name)) {
            define($name, $value);
            return true;
        }

        return false;
    }

    /**
     * Function initHooks
     * Hook into actions
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function initHooks(): void {

        add_action('plugins_loaded', [$this, 'initTranslation']);
        add_action('admin_menu', [SLI_BackOffice::instance(), 'registerAdminMenu']);
        add_action('admin_print_styles', [SLI_BackOffice::instance(), 'initCss']);
        add_action('admin_enqueue_scripts', [SLI_BackOffice::instance(), 'initJs']);
        add_action('wp_ajax_'.SLI_BackOffice::AJAX_ACTION, [SLI_BackOffice::instance(), 'ajaxSave']);
        add_action('sli_admin_tabs', [SLI_BackOffice::instance(), 'loadTabs']);
        add_action('sli_admin_body', [SLI_BackOffice::instance(), 'loadBody']);
        add_action('sli_admin_form', [SLI_BackOffice::instance(), 'loadForm']);
        add_action('sli_admin_title', [SLI_BackOffice::instance(), 'loadTitle']);
        add_action('sli_admin_find_icons', [SLI_BackOffice::instance(), 'loadFindIcons']);

    }

    /**
     * Function initGlobalVars
     *
     * @since 1.0.0
     *
     * @throws ReflectionException
     * @throws SLI_Exception
     */
    private function initGlobalVars(): void {

        $GLOBALS['socialLinksIcons'] = SocialLinksIcons::instance();
    }

    /**
     * Function initFunctions
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function initFunctions(): void {

        if(!function_exists('sli_adminUrlNetwork')) {

            /**
             * Function sli_adminUrlNetwork
             * Returns the url of a social network in admin
             *
             * @since 1.0.0
             *
             * @param SLI_Social_Abstract $network
             * @return string
             */
            function sli_adminUrlNetwork(SLI_Social_Abstract $network): string {

                return admin_url(sprintf('%s?page=%s&network=%s',
                    SLI_BackOffice::PARENT_SLUG,
                    SLI_BackOffice::PAGE_SLUG,
                    $network->slug));
            }
        }

        if(!function_exists('sli_isNetwork')) {

            /**
             * Function sli_isNetwork
             *
             * @since 1.0.0
             *
             * @param SLI_Social_Abstract $firstNetwork
             * @param SLI_Social_Abstract $secondNetwork
             * @return bool
             */
            function sli_isNetwork(SLI_Social_Abstract $firstNetwork, SLI_Social_Abstract $secondNetwork): bool {

                return $firstNetwork->slug === $secondNetwork->slug;
            }
        }

        if(!function_exists('sli_load_form')) {

            /**
             * Function sli_load_form
             *
             * @since 1.0.0
             *
             * @param SLI_Social_Abstract $network
             * @return void
             */
            function sli_load_form(SLI_Social_Abstract $network): void {

                $GLOBALS['network'] = $network;
                do_action('sli_admin_form');
            }
        }
    }

    /**
     * Function initTranslation
     *
     * @since 1.1.0
     *
     * @return void
     */
    public function initTranslation(): void {

        $locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
        $dir = SLI_DIR . '/languages/';

        load_textdomain( 'social-links-icons', $dir . 'social-links-icons-' . $locale . '.mo' );
        load_plugin_textdomain( 'social-links-icons', false, $dir);
    }

    /**
     * Function include
     * Load a file
     *
     * @since 1.0.0
     *
     * @param string $file
     * @return void
     */
    private function include(string $file): void {

        include_once SLI_ABSPATH.$file;
    }

    /**
     * Function pluginUrl
     * Get the plugin url
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function pluginUrl(): string {

        return untrailingslashit(plugins_url('/', __DIR__));
    }

    /**
     * Function assetsUrl
     * Get the assets url
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function assetsUrl(): string {

        return $this->pluginUrl().'/dist';
    }

    /**
     * Function fieldName
     * Returns the name of an option
     *
     * @since 1.0.0
     *
     * @param SLI_Social_Abstract $network
     * @param string $field
     * @return string
     */
    public function fieldName(SLI_Social_Abstract $network, string $field): string {

        return sprintf('sli-%s-%s', $network->slug, $field);
    }

    /**
     * Function templatesPath
     * Get the path to the templates folder
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function templatesPath(): string {

        return SLI_DIR.DIRECTORY_SEPARATOR.'templates';
    }

}