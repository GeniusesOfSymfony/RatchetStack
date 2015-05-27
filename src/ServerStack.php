<?php

namespace Gos\Component\RatchetStack;

use Ratchet\Server\IoServer;

class ServerStack /* Implements IoServerInterface */
{
    /**
     * @var IoServer
     */
    private $server;

    /**
     * @param IoServer $server
     */
    public function __construct(IoServer $server)
    {
        $this->server = $server;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->server->run();
    }

    /**
     * {@inheritdoc}
     */
    public function handleConnect($conn)
    {
        $this->server->handleConnect($conn);
    }

    /**
     * {@inheritdoc}
     */
    public function handleData($data, $conn)
    {
        $this->server->handleData($data, $conn);
    }

    /**
     * {@inheritdoc}
     */
    public function handleEnd($conn)
    {
        $this->server->handleEnd($conn);
    }

    /**
     * {@inheritdoc}
     */
    public function handleError(\Exception $e, $conn)
    {
        $this->server->handleError($e, $conn);
    }
}
