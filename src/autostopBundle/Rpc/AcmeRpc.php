<?php

namespace autostopBundle\Rpc;

use Ratchet\ConnectionInterface;
use Gos\Bundle\WebSocketBundle\RPC\RpcInterface;
use Gos\Bundle\WebSocketBundle\Router\WampRequest;
use Symfony\Component\HttpFoundation\Response;

class AcmeRpc implements RpcInterface
{
    /**
     * Adds the params together
     *
     * Note: $conn isnt used here, but contains the connection of the person making this request.
     *
     * @param ConnectionInterface $connection
     * @param WampRequest $request
     * @param array $params
     * @return int
     */
    public function posicion(ConnectionInterface $connection, WampRequest $request, $params)
    {
        //return new Response(var_dump($params));
        return array("result" => $params);
    }

    /**
     * Name of RPC, use for pubsub router (see step3)
     *
     * @return string
     */
    public function getName()
    {
        return 'acme.rpc';
    }
}