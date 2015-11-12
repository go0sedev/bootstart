<?php

# Get and prepare the request uri
$request_uri = trim(str_replace(PUBLIC_PATH, "", $_SERVER['REQUEST_URI']) ,"/");

# Strip away query parameters
if (strstr($request_uri, "?") !== false) {
    $request_uri = substr($request_uri, 0, strpos($request_uri, "?"));
};

# Handle SEO friendly URL's
if (strstr($request_uri, "/") !== false) {
    $count = 0;
    foreach (explode("/", $request_uri) as $param) {
        $count++;
        if ($count === 1) {
            $request_uri = $param;
        } else {
            $parameters[] = $param;
        }
    }
};

# Decide which route should handle the request
switch ($request_uri) {
    default:
        return 'HomeController@home';
        break;
}