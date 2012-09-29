<?php
/**
 * INP All rights reserved.
 * User: Ivan
 * Date: 9/29/12
 * Time: 1:15 PM
 *
 */
require __DIR__.'/vendor/autoload.php';

use Ratchet\Server\IoServer;
use TestRatchet\Chat;

$server = IoServer::factory(
    new Chat(),
    8000
);

$server->run();
