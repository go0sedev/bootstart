<?php

use \Bootstart\Bootstart;

/**
 * This class handles flash messages
 * @author Gustav Trenwith <gtrenwith@gmail.com>
 */
class Flash extends Bootstart
{
    /**
     * @return bool True if user is authenticated, false if not
     */
    public function message()
    {
        $message = '';
        if (Bootstart::registry('session')->has('flash_type')) {
            $message = Bootstart::view('feedback/alert', [
                'type' => Bootstart::registry('session')->get('flash_type'),
                'message' => Bootstart::registry('session')->get('flash_message')
            ]);

            # Clear the session variable so that the message does not show again
            Bootstart::registry('session')->clear('flash_type');
            Bootstart::registry('session')->clear('flash_message');
        }
        return $message;
    }

    /**
     * Sets session variables for the flash message
     * @param string $status The message status
     * @param string $message The message body
     */
    public function set($status, $message)
    {
        Bootstart::registry('session')->set('flash_type', $status);
        Bootstart::registry('session')->set('flash_message', $message);
    }
}