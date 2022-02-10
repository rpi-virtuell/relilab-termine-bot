<?php
/**
 * Plugin Name:      relilab termine bot
 * Plugin URI:       https://github.com/rpi-virtuell/rw-sso-rest-auth-service
 * Description:      Authentication tool to compare Wordpress login Data with a Remote Login Server
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
        add_action('acf_frontend/save_post', array('SsoRestAuthClient', 'send_matrix_message'));
    }

    public function send_matrix_message($form, $post_id)
    {

        $url = "https://webhooks.t2bot.io/api/v1/matrix/hook/GUd4CALaOyFjPF2v1XazNAzJ3GrJZE4EmZNSX5xKUuk5OflEYxFvfoqu0ErKF996";
        $post = get_post($post_id);
        $message = "Hallo, es wurde ein neuer Termin angelegt! </br> <b>". $post->post_title ."</b> </br> <a href='". home_url()."?p=". $post_id ."'></a>" ;
        wp_remote_post($url, array(
            "text" => $message,
            "format" => "html",
            "displayName" => "Relilab Termin Bot",
            "avatarUrl" => "http://i.imgur.com/IDOBtEJ.png"
        ));
    }
}

