<?php

use \Bootstart\Bootstart;

/**
 * This class handles authentication
 * @author Gustav Trenwith <gtrenwith@gmail.com>
 */
class Authentication extends Bootstart
{
    /**
     * @return bool True if user is authenticated, false if not
     */
    public function validated()
    {
        # Validate that the token is 40 characters long
        return (strlen(Bootstart::registry('session')->get('token')) == 40);
    }

    /**
     * Validates a user
     * @param string $code The authentication token
     * @return boolean
     */
    public function authenticate($code)
    {
        # Send an authentication request to GitHub with the given code, and
        # app ID and secret
        $data = Bootstart::registry('curl')->request(
            "https://github.com/login/oauth/access_token",
            "POST",
            http_build_query([
                'client_id' => GITHUB_ID,
                'client_secret' => GITHUB_SECRET,
                'code' => $code,
                'scope' => 'repo'
            ]), [
                'Accept: application/json'
            ]
        );

        # If the contents field is not in the response something went wrong
        if (!isset($data['contents'])) {

            # Provide some feedback
            Bootstart::registry('flash')->set(
                'danger',
                'Service Unavailable'
            );

            return false;
        }

        # Decode the content
        $response = json_decode($data['contents']);

        # Handle any errors returned
        if (isset($response->error)) {

            # Provide the error message
            Bootstart::registry('flash')->set(
                'danger',
                $response->error_description
            );

            # Redirect back to the home page
            return false;
        }

        # Provide some feedback
        Bootstart::registry('flash')->set(
            'success',
            'You have successfully singed in'
        );

        # Set the access token
        Bootstart::registry('session')->set('token', $response->access_token);

        # Redirect to the issues page
        return true;
    }

    /**
     * Signs a user out
     */
    public function signout()
    {
        Bootstart::registry('session')->clear('token');
    }
}