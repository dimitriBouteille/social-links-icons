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
     * @see registerAdminMenu()
     * @var string
     */
    const PARENT_SLUG = 'options-general.php';

    /**
     * @since 1.0.0
     *
     * @see registerAdminMenu()
     * @var string
     */
    const PAGE_CAPABILITY = 'manage_options';

    /**
     * Name of the field containing the security nonce
     *
     * @since 1.0.0
     *
     * @var string
     */
    const ONCE_FIELD_NAME = 'sli_update_network_once';

    /**
     * Action name associated with the security nonce
     *
     * @since 1.0.0
     *
     * @var string
     */
    const ONCE_ACTION = 'sli-update-network-security';

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
            __('Social media management', 'social-links-icons'),
            __('Social media management', 'social-links-icons'),
            self::PAGE_CAPABILITY,
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

            $networks = $this->getAllNetworks();

            $slugNetwork = null;
            if(isset($_GET['network'])) {
                $slugNetwork = sanitize_key($_GET['network']);
            }

            if(!key_exists($slugNetwork, $networks)) {
                $this->defaultNetwork = reset($networks);
            } else {
                $this->defaultNetwork = $networks[$slugNetwork];
            }
        }

        return $this->defaultNetwork;
    }

    /**
     * Function getAllNetworks
     * Returns all social networks
     *
     * @since 1.0.0
     *
     * @return array
     * @throws ReflectionException
     * @throws SLI_Exception
     */
    private function getAllNetworks(): array {

        return SocialLinksIcons::instance()->all([
            'with-url' => false,
        ]);
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
            'networks' =>       $this->getAllNetworks(),
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
            'networks' =>       $this->getAllNetworks(),
            'defaultNetwork' => $this->getNetworkUrl(),
        ]);
    }

    /**
     * Function loadForm
     *
     * @since 1.0.0
     *
     * @throws ReflectionException
     * @throws SLI_Exception
     * @return void
     */
    public function loadForm(): void {

        $this->loadTemplate('/form.php', [
            'ajaxAction' =>     SLI_BackOffice::AJAX_ACTION,
            'onceFieldName' =>  SLI_BackOffice::ONCE_FIELD_NAME,
            'onceValue' =>      wp_create_nonce(SLI_BackOffice::ONCE_ACTION),
        ], false);
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

        if(isset($_POST[SLI_BackOffice::ONCE_FIELD_NAME])) {
            if(wp_verify_nonce($_POST[SLI_BackOffice::ONCE_FIELD_NAME], SLI_BackOffice::ONCE_ACTION)) {

                if(current_user_can(SLI_BackOffice::PAGE_CAPABILITY)) {

                    if (isset($_POST['sli-network'])) {
                        $slugNetwork = sanitize_key($_POST['sli-network']);

                        if (!empty($slugNetwork) && SocialLinksIcons::instance()->networkExist($slugNetwork)) {
                            $network = SocialLinksIcons::instance()->getOne($slugNetwork);

                            if ($this->checkNetwork($_POST, $network, $errors)) {

                                update_option(SLI()->fieldName($network, 'title'), $network->title);
                                update_option(SLI()->fieldName($network, 'url'), $network->url);
                                update_option(SLI()->fieldName($network, 'color'), $network->color);
                                update_option(SLI()->fieldName($network, 'svg'), $network->svg);

                                wp_send_json_success([
                                    'hasUrl' => $network->hasUrl(),
                                ]);
                            } else {
                                wp_send_json_error([
                                    'errors' => $errors,
                                ]);
                            }
                        } else {
                            wp_send_json_error([
                                'msg' => __('Unable to update this social network, the social network may not exist.', 'social-links-icons'),
                            ]);
                        }
                    } else {
                        wp_send_json_error([
                            'msg' => __('Couldn’t find the social network slug to update.', 'social-links-icons'),
                        ]);
                    }

                    die;
                }
            }
        }

        wp_send_json_error([
            'msg' => __('The form is invalid.', 'social-links-icons'),
        ]);

        die;
    }

    /**
     * Function checkNetwork
     * Validates the submission of the form
     *
     * @since 1.0.0
     *
     * @param array $data
     * @param SLI_Social_Abstract $networkUpdate
     * @param $errors
     * @return bool
     */
    private function checkNetwork(array $data, SLI_Social_Abstract &$networkUpdate, &$errors): bool {

        $errors = [];

        // Check url
        if(isset($data['url'])) {
            $url = $data['url'];

            if(empty($url) || (!empty($url) && filter_var($url, FILTER_VALIDATE_URL))) {
                $networkUpdate->url = $url;
            } else {
                $errors['url'] = __('The url is not correct.', 'social-links-icons');
            }
        }

        // Check title
        if(isset($data['title'])) {
            $title = trim($data['title']);

            if($title === wp_filter_nohtml_kses($title)) {
                $networkUpdate->title = wp_filter_nohtml_kses($title);
            } else {
                $errors['title'] = __('Html code is not allowed.', 'social-links-icons');
            }
        }

        // Check color
        if(isset($data['color'])) {
            $color = $data['color'];

            if($color === sanitize_hex_color($color)) {
                $networkUpdate->color = sanitize_hex_color($color);
            } else {
                $errors['color'] = __('The color does not respect the hexadecimal format.', 'social-links-icons');
            }
        }

        // Check svg
        if(isset($data['svg'])) {
            $svg = trim($data['svg']);

            if(empty($svg)) {
                $networkUpdate->svg = null;
            } else {
                try {
                    $xml = simplexml_load_string(stripslashes_deep($svg));

                    if ($xml->getName() === 'svg') {
                        $networkUpdate->svg = $svg;
                    } else {
                        $errors['svg'] = __('The svg should start with &lt;svg. Please delete the text in front of &lt;svg.', 'social-links-icons');
                    }
                } catch (\Exception $exception) {
                    $errors['svg'] = __('The svg is badly formatted, impossible to read.', 'social-links-icons');
                }
            }
        }

        return count($errors) === 0;
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