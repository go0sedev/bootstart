<?php

use Bootstart\Bootstart;

/**
 * The default controller
 * @author Gustav Trenwith <gtrenwith@gmail.com>
 */
class HomeController extends Bootstart
{
    /**
     * Renders the default view
     * @return string
     */
    public function home()
    {
        # Render the response body
        return Bootstart::render('home');
    }
}