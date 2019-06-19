<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class SLI_BackOffice
 *
 * @since   1.0.0
 * @package SocialLinksIcons
 * @author  Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 */
class SLI_BackOffice
{

    /**
     * The single instance of the class
     *
     * @since 1.0.0
     *
     * @see instance()
     * @var null|SLI_BackOffice
     */
    private static $instance = null;

    /**
     * Name of the action Ajax
     *
     * @since 1.0.0
     *
     * @see registerAdminMenu()
     * @var string
     */
    const AJAX_ACTION = 'sli_admin_save_network';

    /**
     * Page Slug in admin
     *
     * @since 1.0.0
     *
     * @see registerAdminMenu()
     * @var string
     */
    const PAGE_SLUG = 'social-networks';

    /**
     * The slug name for the parent menu
     *
     * @since 1.0.0
     *
     * @var string
     */
    const PARENT_SLUG = 'options-general.php';

    /**
     * Social network displayed by default in admin
     *
     * @since 1.0.0
     *
     * @see getNetworkUrl()
     * @var null|SLI_Social_Abstract
     */
    private $defaultNetwork = null;

    /**
     * Function instance
     *
     * @since 1.0.0
     *
     * @return SLI_BackOffice
     */
    public static function instance(): SLI_BackOffice {

        if(is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Function registerAdminMenu
     * Initializes menu in admin
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function registerAdminMenu(): void {

        add_submenu_page(
            self::PARENT_SLUG,
            __('Gestion des réseaux sociaux', SLI_DOMAIN),
            __('Gestion des réseaux sociaux', SLI_DOMAIN),
            'manage_options',
            self::PAGE_SLUG,
            [$this, 'renderPage']
        );
    }

    /**
     * Function initCss
     * Initializes the Css used in admin
     *
     * @since 1.0.0
     *
     * @throws ReflectionException
     * @throws SLI_Exception
     */
    public function initCss(): void {

        wp_enqueue_style('admin_sli_style', SLI()->assetsUrl().'/css/style.css');
    }

    /**
     * Function loadTemplate
     *
     * @param string $templateName
     * @param array $datas
     * @param bool $requiredOnce
     * @throws ReflectionException
     * @throws SLI_Exception
     * @return void
     */
    private function loadTemplate(string $templateName, array $datas = [], bool $requiredOnce = true): void {

        $path = SLI()->templatesPath().$templateName;
        if(file_exists($path)) {

            foreach ($datas as $dataKey => $data) {
                set_query_var($dataKey, $data);
            }

            load_template($path, $requiredOnce);
        }
    }

    /**
     * Function getNetworkUrl
     *
     * @return SLI_Social_Abstract
     * @throws ReflectionException
     * @throws SLI_Exception
     */
    private function getNetworkUrl(): SLI_Social_Abstract {

        if(is_null($this->defaultNetwork)) {

            $networks = SocialLinksIcons::instance()->all(false);
            $slugNetwork = $_GET['network'] ?? null;

            if(!key_exists($slugNetwork, $networks)) {
                $this->defaultNetwork = reset($networks);
            } else {
                $this->defaultNetwork = $networks[$slugNetwork];
            }
        }

        return $this->defaultNetwork;
    }

    /**
     * Function loadTabs
     *
     * @since 1.0.0
     *
     * @throws ReflectionException
     * @throws SLI_Exception
     * @return void
     */
    public function loadTabs(): void {

        $this->loadTemplate('/tab/menu.php', [
            'networks' =>       SocialLinksIcons::instance()->all(false),
            'defaultNetwork' => $this->getNetworkUrl(),
        ], true);
    }

    /**
     * Function loadBody
     *
     * @since 1.0.0
     *
     * @throws ReflectionException
     * @throws SLI_Exception
     * @return void
     */
    public function loadBody(): void {

        $this->loadTemplate('/tab/body.php', [
            'networks' =>       SocialLinksIcons::instance()->all(false),
            'defaultNetwork' => $this->getNetworkUrl(),
            'ajaxAction' =>     SLI_BackOffice::AJAX_ACTION,
        ], true);
    }

    /**
     * Function loadFindIcons
     *
     * @since 1.0.0
     *
     * @throws ReflectionException
     * @throws SLI_Exception
     * @return void
     */
    public function loadFindIcons(): void {

        $svgSites = ['https://iconmonstr.com/', 'https://www.flaticon.com/', 'https://icones8.fr/icons', 'https://icomoon.io/app/#/select',];

        $this->loadTemplate('/texts/find-icons.php', [
            'sitesSvg' => $svgSites,
        ]);

    }

    /**
     * Function loadTitle
     *
     * @since 1.0.0
     *
     * @throws ReflectionException
     * @throws SLI_Exception
     * @return void
     */
    public function loadTitle(): void {

        $this->loadTemplate('/texts/title.php');
    }

    /**
     * Function initJs
     * Initializes the Js used in admin
     *
     * @since 1.0.0
     *
     * @throws ReflectionException
     * @throws SLI_Exception
     */
    public function initJs(): void {

        wp_enqueue_script('admin_sli_js', SLI()->assetsUrl(). '/js/app.js');
    }

    /**
     * Function ajaxSave
     * Action that is called when saving a social network
     *
     * @since 1.0.0
     *
     * @throws ReflectionException
     * @throws SLI_Exception
     */
    public function ajaxSave() {

        $networkSlug = $_POST['sn-network'] ?? null;
        $network = SocialLinksIcons::instance()->getOne($networkSlug);

        if(!is_null($network)) {

            $network->svg = trim($_POST['svg'] ?? null);
            $network->title = trim($_POST['title'] ?? null);
            $network->url = trim($_POST['url'] ?? null);
            $network->color = trim($_POST['color'] ?? null);

            update_option(SLI()->fieldName($network, 'title'), $network->title);
            update_option(SLI()->fieldName($network, 'url'), $network->url);
            update_option(SLI()->fieldName($network, 'svg'), $network->svg);
            update_option(SLI()->fieldName($network, 'color'), $network->color);

            wp_send_json_success([
                'hasUrl' => $network->hasUrl(),
            ]);
        } else {
            wp_send_json_error([
                'msg' => __('Impossible de mettre à jour ce réseau social, le réseau social n\'existe peut-être pas.', SLI_DOMAIN),
            ]);
        }

        die;
    }

    /**
     * Function renderPage
     *
     * @throws ReflectionException
     * @throws SLI_Exception
     * @return void
     */
    public function renderPage(): void {

        $this->loadTemplate('/index.php', [], true);
    }

}