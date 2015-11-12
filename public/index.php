<?php
# Start the session
session_start();

# Start up the application
require __DIR__.'/../app/bootstart.php';

# Create an instance of the app
$app = Bootstart\Bootstart::singleton();

# Handle the request
echo $app->handle();