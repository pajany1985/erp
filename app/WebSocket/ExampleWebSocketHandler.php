<?php
namespace App\WebSocket;

use BeyondCode\LaravelWebSockets\WebSockets\WebSocketHandler as BaseWebSocketHandler;

class ExampleWebSocketHandler extends BaseWebSocketHandler
{
    public function onOpen(Connection $connection)
    {
        // Handle WebSocket connection open event
    }

    public function onClose(Connection $connection)
    {
        // Handle WebSocket connection close event
    }

    public function onMessage(Connection $connection, Message $message)
    {
        // Handle WebSocket message received event
    }
}

