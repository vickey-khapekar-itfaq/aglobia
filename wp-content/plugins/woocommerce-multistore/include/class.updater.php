<?php

    class WOO_MSTORE_CodeAutoUpdate
         {
             # URL to check for updates, this is where the index.php script goes
             public $api_url;

             private $slug;
             public $plugin;


             public function __construct($api_url, $slug, $plugin)
                 {
                     $this->api_url = $api_url;

                     $this->slug    = $slug;
                     $this->plugin  = $plugin;

                 }


             public function check_for_plugin_update($checked_data)
                 {
                     if (empty($checked_data->checked) || !isset($checked_data->checked[$this->plugin]))
                        return $checked_data;

                     $request_string = $this->prepare_request('plugin_update');
                     if($request_string === FALSE)
                        return $checked_data;

                     // Start checking for an update
                     $request_uri = $this->api_url . '?' . http_build_query( $request_string , '', '&');
                     $data = wp_remote_get( $request_uri );

                     if(is_wp_error( $data ) || $data['response']['code'] != 200)
                        return $checked_data;

                     $response_block = json_decode($data['body']);

                     if(!is_array($response_block) || count($response_block) < 1)
                          {
                              $no_update      = true;
                              $response_block = array(
                                  (object) array(
                                      'message' => new stdClass()
                                  ),
                              );
                          }

                     //retrieve the last message within the $response_block
                     $response_block = $response_block[count($response_block) - 1];
                     $response = isset($response_block->message) ? $response_block->message : '';

                     if (is_object($response) && !empty($response)) // Feed the update data into WP updater
                         {
                             //include slug and plugin data
                             $response->slug = $this->slug;
                             $response->plugin = $this->plugin;
                             $response->banners = array(
                                '1x' => WOO_MSTORE_ASSET_URL . '/assets/images/banner-772x250.jpg',
                                '2x' => WOO_MSTORE_ASSET_URL . '/assets/images/banner-1544x500.jpg',
                             );
                             $response->icons = array(
                                '1x' => WOO_MSTORE_ASSET_URL . '/assets/images/icon-128x128.jpg',
                                '2x' => WOO_MSTORE_ASSET_URL . '/assets/images/icon-256x256.jpg',
                             );

                             if ( isset( $no_update ) ) {
                                 $checked_data->no_update[ $this->plugin ] = $response;
                             } else {
                                 $checked_data->response[ $this->plugin ] = $response;
                             }
                         }

                     return $checked_data;
                 }


             public function plugins_api_call($def, $action, $args)
                 {
                     if (!is_object($args) || !isset($args->slug) || $args->slug != $this->slug)
                        return false;


                     //$args->package_type = $this->package_type;

                     $request_string = $this->prepare_request($action, $args);
                     if($request_string === FALSE)
                        return new WP_Error('plugins_api_failed', __('An error occour when try to identify the pluguin.' , 'woonet') . '&lt;/p> &lt;p>&lt;a href=&quot;?&quot; onclick=&quot;document.location.reload(); return false;&quot;>'. __( 'Try again', 'woonet' ) .'&lt;/a>');;

                     $request_uri = $this->api_url . '?' . http_build_query( $request_string , '', '&');
                     $data = wp_remote_get( $request_uri );

                     if(is_wp_error( $data ) || $data['response']['code'] != 200)
                        return new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.' , 'woonet') . '&lt;/p> &lt;p>&lt;a href=&quot;?&quot; onclick=&quot;document.location.reload(); return false;&quot;>'. __( 'Try again', 'woonet' ) .'&lt;/a>', $data->get_error_message());

                     $response_block = json_decode($data['body']);
                     //retrieve the last message within the $response_block
                     $response_block = $response_block[count($response_block) - 1];
                     $response = $response_block->message;

                     if (is_object($response) && !empty($response)) // Feed the update data into WP updater
                         {
                             //include slug and plugin data
                             $response->slug = $this->slug;
                             $response->plugin = $this->plugin;

                             $response->sections = (array)$response->sections;
                             $response->banners = array(
                                 'low' => WOO_MSTORE_ASSET_URL . '/assets/images/banner-772x250.jpg',
                                 'high' => WOO_MSTORE_ASSET_URL . '/assets/images/banner-1544x500.jpg',
                             );

                             return $response;
                         }
                 }

             public function prepare_request($action, $args = array())
                 {
                     global $wp_version;

                     $license_data = get_site_option('mstore_license');

                     return array(
                                     'woo_sl_action'        => $action,
                                     'version'              => WOO_MSTORE_VERSION,
                                     'product_unique_id'    => WOO_MSTORE_PRODUCT_ID,
                                     'licence_key'          => $license_data['key'],
                                     'domain'               => WOO_MSTORE_INSTANCE,

                                     'wp-version'           => $wp_version,

                     );
                 }
         }


         function WOO_MSTORE_run_updater()
             {

                 $wp_plugin_auto_update = new WOO_MSTORE_CodeAutoUpdate(WOO_MSTORE_APP_API_URL, 'woocommerce-multistore', 'woocommerce-multistore/woocommerce-multistore.php');

                 // Take over the update check
                 add_filter('pre_set_site_transient_update_plugins', array($wp_plugin_auto_update, 'check_for_plugin_update'));

                 // Take over the Plugin info screen
                 add_filter('plugins_api', array($wp_plugin_auto_update, 'plugins_api_call'), 10, 3);

             }
         add_action( 'after_setup_theme', 'WOO_MSTORE_run_updater' );



?>