<?php

use \Bootstart\Bootstart;

/**
 * This class handles curl requests
 * @author Gustav Trenwith <gtrenwith@gmail.com>
 */
class Curl extends Bootstart
{
    /**
     * This function makes a request using the Curl library
     * @param string $url The url to send the request to
     * @param string $method The method to use i.e. POST or GET
     * @param array $input The values to send with the request
     * @param array $headers Custom headers
     * @param array $auth Authentication headers if required
     * @param string $agent THe user agent to use as definer for the request
     * @param string $encoding The encoding to use
     * @return array Returns the response from the request
     */
    function request($url, $method = "GET", $input = [], $headers = [],
                     $auth = [], $agent = "Bootstart", $encoding = "UTF-8")
    {
        try {
            # Initialize curl object
            $curl = curl_init();

            # Set URL
            curl_setopt($curl, CURLOPT_URL, $url);

            # Set standard options
            curl_setopt($curl, CURLOPT_HEADER, FALSE);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 20);
            curl_setopt($curl, CURLOPT_TIMEOUT, 60);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_FTP_USE_EPRT, FALSE);
            curl_setopt($curl, CURLOPT_FTP_USE_EPSV, FALSE);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

            # Set encoding
            curl_setopt($curl, CURLOPT_ENCODING, $encoding);

            # Set user agent string
            curl_setopt($curl, CURLOPT_USERAGENT, $agent);

            # Add POST data if required
            if (strtoupper($method) === 'POST') {
                curl_setopt($curl, CURLOPT_POST, TRUE);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $input);
            }

            # Add headers if they are present
            if (!empty($headers)) {
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            }

            # Add authentication headers if needed
            if (isset($auth['method']) && isset($auth['auth'])) {
                curl_setopt($curl, CURLOPT_HTTPAUTH, $auth['method']);
                curl_setopt($curl, CURLOPT_USERPWD, $auth['auth']);
            }

            # Execute the request and close the object
            $data = curl_exec($curl);
            $error = curl_errno($curl);
            curl_close($curl);

            # Handle any errors
            if ($error) {
                curl_close ($curl);
                return [
                    'success' => false,
                    'contents' => $error
                ];
            }
            return [
                'success' => true,
                'contents' => $data
            ];
        } catch (\Exception $exception) {
            return [
                'success' => false,
                'contents' => 'Exception: '.$exception->getMessage()
            ];
        }
    }
}