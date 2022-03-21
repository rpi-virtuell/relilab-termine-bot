<?php
/**
 * Plugin Name:      relilab termine bot
 * Plugin URI:       https://github.com/rpi-virtuell/relilab-termine-bot
 * Description:      Plugin to send a notification to a chat bot webhook
 * Author:           Daniel Reintanz
 * Version:          1.0.0
 * Licence:          GPLv3
 * GitHub Plugin URI: https://github.com/rpi-virtuell/relilab-termine-bot
 * GitHub Branch:     master
 */

class RelilabTermineBot {

	/**
	 * Plugin constructor.
	 *
	 * @since   0.1
	 * @access  public
	 * @uses    plugin_basename
	 * @action  relilab_termine_bot
	 */
	public function __construct() {
		add_action( 'init', array( 'RelilabTermineBot', 'register_termine_bot_options_page' ) );
		add_action( 'init', array( 'RelilabTermineBot', 'register_acf_fields' ) );
		add_action( 'acf_frontend/save_post', array( 'RelilabTermineBot', 'send_matrix_message' ), 10, 2 );
	}

	public function register_termine_bot_options_page() {

		if ( function_exists( 'acf_add_options_page' ) ) {

			$option_page = acf_add_options_page( array(
				'page_title' => 'relilab termine bot Einstellungen',
				'menu_title' => 'relilab Termine Bot',
				'menu_slug'  => 'relilab_termine_bot',
				'capability' => 'edit_posts',
				'redirect'   => true,
				'post_id'    => 'options'
			) );

		}
	}

	public function register_acf_fields() {
		if ( function_exists( 'acf_add_local_field_group' ) ):

			acf_add_local_field_group( array(
				'key'                   => 'group_62052b433f490',
				'title'                 => 'Termine Matrix Bot',
				'fields'                => array(
					array(
						'key'                         => 'field_62052b6308caf',
						'label'                       => 'Termine Martix Bot Webhook Link',
						'name'                        => 'relilab_termine_bot_webhook',
						'type'                        => 'password',
						'instructions'                => '',
						'required'                    => 1,
						'conditional_logic'           => 0,
						'wrapper'                     => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						"frontend_admin_display_mode" => "edit",
						"only_front"                  => 0,
						"placeholder"                 => "",
						"prepend"                     => "",
						"append"                      => ""
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'relilab_termine_bot',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => 1,
				'description'           => '',
			) );

		endif;
	}

	static public function send_matrix_message( $form, $post_id ) {

		$url     = get_option( 'options_relilab_termine_bot_webhook', true );
		$post    = get_post( $post_id );
		$message = "Hallo, es wurde ein neuer Termin angelegt! </br> <b>" . $post->post_title . "</b> </br> <a href='" . home_url() . "?p=" . $post_id . "'></a>";
		wp_remote_post( $url, array(
			'headers'     => array(
				"Content-Type" => "application/json"
			),
			'timeout'     => 60,
			'redirection' => 5,
			'blocking'    => true,
			'httpversion' => '1.0',
			'sslverify'   => false,
			'data_format' => 'body',
			'body'        => json_encode( [
				'text'        => $message,
				'format'      => 'html',
				'displayName' => 'Relilab Termine Bot',
				'avatarUrl'   => plugin_dir_url( __FILE__ ) . 'assets/relilab-bot-avatar.png'
			] )
		) );
	}

}

new RelilabTermineBot();
