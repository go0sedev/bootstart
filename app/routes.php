<?php
# Route the app to the controller and method that will handle the request
switch ($request_uri) {
    default:
        return 'HomeController@home';
        break;
}