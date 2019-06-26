<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class SLI_ShortCode
 *
 * @since   1.0.0
 * @package SocialLinksIcons
 * @author  Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 */
class SLI_ShortCode
{

    /**
     * The single instance of the class
     *
     * @since 1.0.0
     *
     * @see instance()
     * @var null|SLI_ShortCode
     */
    private static $instance = null;

    /**
     * Function init
     *
     * @since 1.0.0
     *
     * @return SLI_ShortCode
     */
    public static function init(): SLI_ShortCode {

        if(is_null(self::$instance)) {
            self::$instance = new self();
            self::$instance->registerShortCode();
        }

        return self::$instance;
    }

    /**
     * Function registerShortCode
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function registerShortCode(): void {

        add_shortcode('sli-list', [$this, 'basicShortCode']);
    }

    /**
     * Function basicShortCode
     * Loads the contents of the sli-list shortCode
     *
     * @param $attrs
     *      content => If true, display the icon in svg. By default, the social network name is displayed
     *      networks => Social network slug to be displayed. Ex : facebook, twitter, instagram
     * @return string
     * @throws ReflectionException
     * @throws SLI_Exception
     */
    public function basicShortCode($attrs): string {

        $networks = SocialLinksIcons::instance()->all([
            'with-url' => true,
            'networks' => $this->explodeListNetworks($attrs['networks'] ?? null),
        ]);

        // List
        $listAttrs = $this->buildAttr(apply_filters('sli-list-attr', [
            'class' => 'sli-list',
        ]));
        $html[] = sprintf('<ul %s>', $listAttrs);

        foreach ($networks as $network) {

            // Item
            $itemAttrs = $this->buildAttr(apply_filters('sli-list-item-attr', [
                'class' => 'sli-list-item',
            ], $network));
            $html[] = sprintf('<li %s>', $itemAttrs);

            // Link
            $linkAttrs = $this->buildAttr(apply_filters('sli-list-link-attr', [
                'href' =>   $network->url,
                'target' => '_blank',
                'rel' =>    'noreferrer noopener',
                'class' =>  'sli-list-link',
                'title' =>  $network->title,
            ],  $network));

            $defaultContent = $network->name;
            if(isset($attrs['content']) && $attrs['content'] === 'svg') {
                $defaultContent = $network->svg;
            }

            $linkContent = apply_filters('sli-list-link-content', $defaultContent, $network);
            $html[] = sprintf('<a %s>%s</a>', $linkAttrs, $linkContent);

            // End item
            $html[] = '</li>';
        }

        // End list
        $html[] = '</ul>';

        return implode('', $html);
    }

    /**
     * Function buildAttr
     * Transforms an array into an attributes string
     *
     * @since 1.0.0
     *
     * @param array $attrs
     * @return string
     */
    private function buildAttr(array $attrs): string {

        $strAttrs = [];
        foreach ($attrs as $attrName => $attrValue) {
            if(!empty($attrValue)) {
                $strAttrs[] = $attrName . '="' . $attrValue . '"';
            }
        }

        return implode(' ', $strAttrs);
    }

    /**
     * Function explodeListNetworks
     *
     * @since 1.0.0
     *
     * @param string|null $networks
     * @return array|null
     */
    private function explodeListNetworks($networks) {

        if(is_null($networks)) {
            return null;
        }

        $networks = explode(',', $networks);
        $networks = array_map('trim', $networks);

        return $networks;
    }

}