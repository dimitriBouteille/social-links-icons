<?php

/**
 * Class SLI_Social_Abstract
 *
 * @since   1.0.0
 * @package SocialLinksIcons
 * @author  Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 */
abstract class SLI_Social_Abstract
{

    /**
     * Slug of the social network
     * This slug must be unique for each social network
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $slug;

    /**
     * Name of the social network
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $name;

    /**
     * Title
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $title;

    /**
     * Url of the social network
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $url;

    /**
     * Social network icon in svg format
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $svg;

    /**
     * Color representing the social network
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $color;

    /**
     * Function hasUrl
     * Check if the url is defined
     *
     * @return bool
     */
    public function hasUrl(): bool {

        return !empty($this->url);
    }

}