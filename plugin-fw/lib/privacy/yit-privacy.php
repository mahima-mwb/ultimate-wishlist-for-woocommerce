<?php
!defined( 'ABSPATH' ) && exit; // Exit if accessed directly

if ( !class_exists( 'mwb_Privacy' ) ) {
    /**
     * Class mwb_Privacy
     * Privacy Class
     *
     * @author Leanza Francesco <leanzafrancesco@gmail.com>
     */
    class mwb_Privacy {
        private static $_instance;

        private $_title;

        public static function get_instance() {
            return !is_null( self::$_instance ) ? self::$_instance : self::$_instance = new self();
        }

        /**
         * mwb_Privacy constructor.
         */
        private function __construct() {
            $this->_title = apply_filters( 'mwb_plugin_fw_privacy_policy_guide_title', _x( 'mwb Plugins', 'Privacy Policy Guide Title', 'mwb-plugin-fw' ) );
            add_action( 'admin_init', array( $this, 'add_privacy_message' ) );
        }

        /**
         * Adds the privacy message on mwb privacy page.
         */
        public function add_privacy_message() {
            if ( function_exists( 'wp_add_privacy_policy_content' ) ) {
                $content = $this->get_privacy_message();

                if ( $content ) {
                    wp_add_privacy_policy_content( $this->_title, $this->get_privacy_message() );
                }
            }
        }

        /**
         * get the privacy message
         *
         * @return string
         */
        public function get_privacy_message() {
            $privacy_content_path = mwb_CORE_PLUGIN_TEMPLATE_PATH . '/privacy/html-policy-content.php';
            ob_start();
            $sections = $this->get_sections();
            if ( file_exists( $privacy_content_path ) )
                include $privacy_content_path;

            return apply_filters( 'mwb_plugin_fw_privacy_policy_content', ob_get_clean() );
        }

        public function get_sections() {
            return apply_filters( 'mwb_plugin_fw_privacy_policy_content_sections', array(
                'general'           => array(
                    'tutorial'    => _x( 'This sample language includes the basics around what personal data your store may be collecting, storing and sharing, as well as who may have access to that data. Depending on what settings are enabled and which additional plugins are used, the specific information shared by your store will vary. We recommend consulting with a lawyer when deciding what information to disclose on your privacy policy.', 'Privacy Policy Content', 'mwb-plugin-fw' ),
                    'description' => '',
                ),
                'collect_and_store' => array(
                    'title' => _x( 'What we collect and store', 'Privacy Policy Content', 'mwb-plugin-fw' )
                ),
                'has_access'        => array(
                    'title' => _x( 'Who on our team has access', 'Privacy Policy Content', 'mwb-plugin-fw' )
                ),
                'share'             => array(
                    'title' => _x( 'What we share with others', 'Privacy Policy Content', 'mwb-plugin-fw' ),
                ),
                'payments'          => array(
                    'title' => _x( 'Payments', 'Privacy Policy Content', 'mwb-plugin-fw' )
                ),
            ) );
        }
    }
}

mwb_Privacy::get_instance();