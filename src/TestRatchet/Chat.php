<?php
/**
 * INP All rights reserved.
 * User: Ivan
 * Date: 9/29/12
 * Time: 1:17 PM
 *
 */

namespace TestRatchet;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;


class Chat implements MessageComponentInterface
{

    /**
     * @var \SplObjectStorage ConnectionInterface[]
     */
    protected $clients;

    function __construct()
    {
        $this->clients = new \SplObjectStorage();
    }

    /**
     * When a new connection is opened it will be passed to this method
     * @param \Ratchet\ConnectionInterface $conn
     * @return void
     */
    function onOpen(ConnectionInterface $conn)
    {
        echo "New Connection \n";
        $this->clients->attach($conn);
        $conn->send("Hola!");
    }

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param \Ratchet\ConnectionInterface $conn
     * @return void
     */
    function onClose(ConnectionInterface $conn)
    {
        echo "Closed connection\n";
        $this->clients->detach($conn);
    }

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the
     * Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param Ratchet\Connection
     * @param \Exception
     * @throws Exception
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "ERROR!!!!";
        $conn->close();
    }

    /**
     * Triggered when a client sends data through the socket
     * @param \Ratchet\ConnectionInterface $from
     * @param $msg
     * @return void
     */
    function onMessage(ConnectionInterface $from, $msg)
    {
        echo "Message arrived $msg\n";
        foreach($this->clients as $client){
            if($client !== $from){
                $client->send($msg);
            }
        }
    }
}