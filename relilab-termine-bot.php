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
        add_action('acf_frontend/save_post', array('RelilabTermineBot', 'send_matrix_message'), 10 ,2);
    }

    static public function send_matrix_message($form, $post_id)
    {

        $url = get_post_meta($post_id, 'relilab_termine_bot_webhook', true);
        $post = get_post($post_id);
        $message = "Hallo, es wurde ein neuer Termin angelegt! </br> <b>" . $post->post_title . "</b> </br> <a href='" . home_url() . "?p=" . $post_id . "'></a>";

       wp_remote_post($url, array(
            'headers' => array(
                "content-type" => "application/json"
            ),
            'body' => wp_json_encode(array(
                "text" => $message,
                "format" => "html",
                "displayName" => "Relilab Termin Bot",
                "avatarUrl" => "http://i.imgur.com/IDOBtEJ.png"
            ))));
    }

}
new RelilabTermineBot();
