<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class SocialLinksIcons
 *
 * @since   1.0.0
 * @package SocialLinksIcons
 * @author  Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 */
class SocialLinksIcons
{

    /**
     * The single instance of the class
     *
     * @since 1.0.0
     *
     * @var null|SocialLinksIcons
     */
    private static $instance = null;

    /**
     * List of social networks once loaded
     *
     * @since 1.0.0
     *
     * @var SLI_Social_Abstract[]|null
     */
    private $networks = [];

    /**
     * Array of default social network
     *
     * @since 1.0.0
     *
     * @var array
     */
    private $defaultNetworks = [
        SLI_Social_Behance::class,
        SLI_Social_Blogger::class,
        SLI_Social_Discord::class,
        SLI_Social_Dribbble::class,
        SLI_Social_Facebook::class,
        SLI_Social_Flickr::class,
        SLI_Social_Github::class,
        SLI_Social_GooglePlay::class,
        SLI_Social_Instagram::class,
        SLI_Social_Linkedin::class,
        SLI_Social_Medium::class,
        SLI_Social_Pinterest::class,
        SLI_Social_Reddit::class,
        SLI_Social_Skype::class,
        SLI_Social_Slack::class,
        SLI_Social_Snapchat::class,
        SLI_Social_Soundcloud::class,
        SLI_Social_Stackoverflow::class,
        SLI_Social_Steam::class,
        SLI_Social_Telegram::class,
        SLI_Social_Tumblr::class,
        SLI_Social_Twitch::class,
        SLI_Social_Twitter::class,
        SLI_Social_Vimeo::class,
        SLI_Social_WhatsApp::class,
        SLI_Social_Youtube::class,
    ];

    /**
     * Function instance
     *
     * @since 1.0.0
     *
     * @return SocialLinksIcons
     * @throws ReflectionException
     * @throws SLI_Exception
     */
    public static function instance(): SocialLinksIcons {

        if(is_null(self::$instance)) {
            self::$instance = new self();
            self::$instance->loadNetworks();
        }

        return self::$instance;
    }

    /**
     * Function loadNetworks
     * Load the social networks
     *
     * @since 1.0.0
     *
     * @throws ReflectionException
     * @throws SLI_Exception
     */
    private function loadNetworks(): void {

        $networks = apply_filters('sn_networks', $this->defaultNetworks);

        foreach ($networks as $key => $networkClass) {

            $refClass = new \ReflectionClass($networkClass);
            $instance = $refClass->newInstanceWithoutConstructor();
            if (is_subclass_of($instance, SLI_Social_Abstract::class)) {
                if (!key_exists($instance->slug, $this->networks)) {
                    $this->networks[$instance->slug] = self::hydrateNetwork($instance);
                } else {
                    throw new SLI_Exception(sprintf(__('The slug %s of the social network %s is already used. Please modify the slug to make it unique.', SLI_DOMAIN), $instance->slug, $networkClass));
                }
            } else {
                throw new SLI_Exception(sprintf(__('Class %s must extend class %s', SLI_DOMAIN), $networkClass, SLI_Social_Abstract::class));
            }
        }

        uasort($this->networks, function ($a, $b) {
            return strcmp($a->name, $b->name);
        });
    }

    /**
     * Function hydrateNetwork
     *
     * @since 1.0.0
     *
     * @param SLI_Social_Abstract $network
     * @return SLI_Social_Abstract
     * @throws ReflectionException
     * @throws SLI_Exception
     */
    private static function hydrateNetwork(SLI_Social_Abstract $network): SLI_Social_Abstract {

        $network->title = get_option(SLI()->fieldName($network, 'title'));
        $network->url = get_option(SLI()->fieldName($network, 'url'));

        $color = get_option(SLI()->fieldName($network, 'color'));
        if(!empty($color)) {
            $network->color = $color;
        }

        $svg = get_option(SLI()->fieldName($network, 'svg'));
        if(!empty($svg)) {
            $network->svg = stripslashes_deep($svg);
        }

        return $network;
    }

    /**
     * Function networkExist
     * Checks if a social network exists
     *
     * @since 1.0.0
     *
     * @param string|null $networkSlug
     * @return bool
     */
    public function networkExist(?string $networkSlug): bool {

        if(is_null($networkSlug)) {
            return false;
        }

        return key_exists($networkSlug, $this->networks);
    }

    /**
     * Function all
     * Returns all social networks
     *
     * @since 1.0.0
     *
     * @param bool $onlyWithUrl
     * @return array
     */
    public function all(bool $onlyWithUrl = true): array {

        if($onlyWithUrl) {
            $networks = [];
            foreach ($this->networks as $network) {
                if($network->hasUrl()) {
                    $networks[$network->slug] = $network;
                }
            }

            return $networks;
        }

        return $this->networks;
    }

    /**
     * Function getOne
     * Return a social network from its slug
     *
     * @since 1.0.0
     *
     * @param string $networkSlug
     * @return SLI_Social_Abstract|null
     */
    public function getOne(string $networkSlug): ?SLI_Social_Abstract {

        if($this->networkExist($networkSlug)) {
            return $this->networks[$networkSlug];
        }

        return null;
    }

    /**
     * Function getOne
     * Checks if the url of a social network is defined
     *
     * @since 1.0.0
     *
     * @param string $networkSlug
     * @return bool
     */
    public function isDefine(string $networkSlug): bool {

        if($this->networkExist($networkSlug)) {
            return $this->networks[$networkSlug]->hasUrl();
        }

        return false;
    }

}