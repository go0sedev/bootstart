<?php

use \Bootstart\Bootstart;

/**
 * This class handles session data
 * @author Gustav Trenwith <gtrenwith@gmail.com>
 */
class Session extends Bootstart
{
    /**
     * Clears a specific session value
     * @param string $name The session name
     */
    function clear($name)
    {
        # Clear the given session variable
        $_SESSION[$name] = null;
    }

    /**
     * Destroys a session
     */
    function destroy()
    {
        # Destroy all session data
        session_destroy();
    }

    /**
     * Returns true if a session variable is not empty
     * @param string $name The variable name
     * @return Session value or null
     */
    function has($name)
    {
        # Return true if the session variable is not empty
        return (isset($_SESSION[$name]) && !empty($_SESSION[$name]));
    }

    /**
     * Returns a session variable's value
     * @param string $name The variable name
     * @return Session value or null
     */
    function get($name)
    {
        # Return the session value
        return (isset($_SESSION[$name])) ? $_SESSION[$name] : null;
    }

    /**
     * Sets a session value
     * @param string $name The session name
     * @param string $value THe value to set it to
     */
    function set($name, $value)
    {
        # Set the session to the value provided
        $_SESSION[$name] = $value;
    }
}