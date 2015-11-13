<?php

use \Bootstart\Bootstart;

/**
 * This class handles Slack Integrations
 * @author Gustav Trenwith <gtrenwith@gmail.com>
 */
class Slack extends Bootstart
{
    /**
     * Sends a notification to Slack
     * @param string $message The message
     * @param string $channel The Slack channel
     * @param string $webhook The Slack web hook
     */
    function notification($message, $channel = null, $webhook = "")
    {
        Bootstart::registry('curl')->request(
            $webhook,
            "POST",
            "payload=".json_encode([
                "channel" => $channel,
                "text" => $message
            ])
        );
    }
}