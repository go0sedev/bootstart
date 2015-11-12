<?php

use \Bootstart\Bootstart;

/**
 * This class handles redirects
 * @author Gustav Trenwith <gtrenwith@gmail.com>
 */
class Redirect extends Bootstart
{
    /**
     * Redirects the user using the php header function
     * @param string $url Where to redirect to
     */
    function basic($url)
    {
        header('Location: '.$url);
    }

    /**
     * Redirects the user by passing a meta script back to the page
     * @param string $url Where to redirect to
     * @param int $wait How long to wait before redirecting to
     * @return string The meta string
     */
    function meta($url, $wait = 0)
    {
        # If the meta redirect snippet does not exist, redirect using basic
        # method
        if (!file_exists('snippets/redirect/meta')) {
            $this->basic($url);
        }
        
        return Bootstart::view('snippets/redirect/meta', [
            'wait' => $wait,
            'url' => $url
        ]);
    }
}