<?php namespace Bootstart;

use Exception;

# Include the config
include __DIR__.'/config.php';

/**
 * Magic autoload function used to include the appropriate class files when they are needed
 * @param string $class_name The name of the class
 * @throws Exception File not found exception
 */
function __autoload($class_name)
{
    $path = APP_PATH.'classes/'.ucfirst(strtolower($class_name)).'.php';
    if (!file_exists($path)) {
        throw new Exception("Class '$class_name' not found.");
    }
    include_once $path;
}
/**
 * The main entry point for the application. It makes use of the Singleton
 * Design Pattern.
 * Class Swordfish
 * @author:  Gustav Trenwith <gtrenwith@gmail.com>
 */
class Bootstart
{
    # Stores the instance of the app
    private static $instance;

    # Registry of objects (Registry Design Pattern)
    private $objects;

    /**
     * Declaring the magic constructor as private prevents an object from being
     * declared using the new keyword.
     */
    private function __construct() {}

    /**
     * The destructor for the app
     */
    public function __destruct() {}

    /**
     * The only way of creating an object is by calling the public Singleton
     * method. Checking if the $instance static variable is set,
     * prevents duplicate instances of the app from being declared.
     */
    static function singleton()
    {
        # If an instance does not exist
        if(!isset(self::$instance)) {

            # Create an instance of this class
            $application = new Bootstart;

            # Set the instance variable to the instance just created
            self::$instance = $application;
        }

        # Return the instance of this class
        return self::$instance;
    }

    /**
     * This is a simple registry of objects created by the application. This
     * method makes use of the registry design pattern to create objects
     * @param string $name The class name
     * @return object Will return an object of the class
     */
    public function registry($name)
    {
        # Check if the object has already been created
        if (!isset($this->objects[$name])) {

            # Load the class
            __autoload($name);

            # Create an object of the class
            $this->objects[$name] = new $name;
        }

        # Return the object of the class
        return $this->objects[$name];
    }

    /**
     * This function takes the request input, and returns the appropriate view
     * @return string Containing the HTML code that will be sent to the browser
     * @throws \Exception When the view is not found
     */
    public function handle()
    {
        # Include the routes file
        $parameters = [];
        $handler = require 'routes.php';

        # Extract the controller and method names from the route
        $controller = substr($handler, 0, strpos($handler, '@'));
        $method = substr($handler, strpos($handler, '@') + 1);

        # Check that the controller exists
        $path = dirname(__FILE__).'/controllers/'.$controller.'.php';
        self::validate($path);

        # Include and instantiate the controller, and call the view
        require_once $path;
        $class = new $controller;
        return $class->$method($parameters);
    }

    /**
     * This function renders the html views, based on the view name
     * @param string $name The name of the view
     * @param array $data Additional variables to be replaced in the content
     * @param string $template The name of the template to use
     * @return string The Html code generated from rendering the view
     * @throws \Exception When the view is not found
     */
    static public function render($name, $data = [],
                                  $template = 'templates/visitor')
    {
        # In order to match naming convention, lowercase the name
        $body = dirname(__DIR__).'/app/views/'.strtolower($name).'.php';
        $template = dirname(__DIR__).'/app/views/'.strtolower($template).'.php';

        # Check if the template and view exist, else throw an exception
        self::validate($template);
        self::validate($body);

        # Get the template contents
        $html = file_get_contents($template);

        # Put the view contents in the template and return to the browser
        $html = str_replace("{{content}}", file_get_contents($body), $html);
        foreach ($data as $key => $value) {
            $html = str_replace("{{{$key}}}", $value, $html);
        }
        $html = str_replace("{{url}}", URL, $html);
        return $html;
    }

    /**
     * This function returns the html viewwithout a template
     * @param string $name The name of the view
     * @param array $data Additional variables to be replaced in the content
     * @return string The Html code from the view
     * @throws \Exception When the view is not found
     */
    static public function view($name, $data = [])
    {
        # In order to match naming convention, lowercase the name
        $body = dirname(__DIR__).'/app/views/'.strtolower($name).'.php';

        # Check if the view exist, else throw an exception
        self::validate($body);

        # Get the template contents
        $html = file_get_contents($body);

        # Replace placeholders in the contents
        foreach ($data as $key => $value) {
            $html = str_replace("{{{$key}}}", $value, $html);
        }
        return $html;
    }

    static public function validate($name)
    {
        if (!file_exists($name)) {
            throw new \Exception("File '".ucfirst(strtolower($name))
                ."'' not found");
        }
    }
}