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

class RelilabTermineBot
{

    /**
     * Plugin constructor.
     *
     * @since   0.1
     * @access  public
     * @uses    plugin_basename
     * @action  relilab_termine_bot
     */
    public function __construct()
    {
        add_action('acf_frontend/save_post', array('RelilabTermineBot', 'send_matrix_message'), 10, 2);
    }

    static public function send_matrix_message($form, $post_id)
    {

        $url = get_option('options_relilab_termine_bot_webhook', true);
        $post = get_post($post_id);
        $message = "Hallo, es wurde ein neuer Termin als Entwurf angelegt!</br>  <b>" . $post->post_title . "</b> </br> <a href='" . home_url() . "/wp-admin/post.php?post=" . $post_id . "&action=edit'>" . $post->post_title . " bearbeiten</a>";

        wp_remote_post($url, array(
            'headers' => array(
                "Content-Type" => "application/json"
            ),
            'timeout' => 60,
            'redirection' => 5,
            'blocking' => true,
            'httpversion' => '1.0',
            'sslverify' => false,
            'data_format' => 'body',
            'body' => json_encode([
                'text' => $message,
                'format' => 'html',
                'displayName' => 'Relilab Termine Bot',
                'avatarUrl' => plugin_dir_url( __FILE__).'assets/relilab-bot-avatar.png';
            ])));
    }

}

new RelilabTermineBot();
