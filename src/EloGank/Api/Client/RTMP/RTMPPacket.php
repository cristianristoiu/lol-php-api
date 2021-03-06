<?php

/*
 * This file is part of the "EloGank League of Legends API" package.
 *
 * https://github.com/EloGank/lol-php-api
 *
 * For the full license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EloGank\Api\Client\RTMP;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class RTMPPacket
{
    /**
     * @var string
     */
    protected $destination;

    /**
     * @var string
     */
    protected $operation;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var array
     */
    protected $additionalHeaders;

    /**
     * @var \SabreAMF_TypedObject
     */
    protected $headers;

    /**
     * @var array
     */
    protected $additionalBody;

    /**
     * @var \SabreAMF_TypedObject
     */
    protected $data;

    /**
     * @var string
     */
    protected $class;


    /**
     * @param string $destination
     * @param string $operation
     * @param array  $parameters
     * @param string $packetClass
     * @param array  $headers
     * @param array  $body
     */
    public function __construct($destination, $operation, $parameters, $packetClass, array $headers = array(), array $body = array())
    {
        $this->destination        = $destination;
        $this->operation          = $operation;
        $this->parameters         = $parameters;
        $this->class              = $packetClass;
        $this->additionalHeaders = $headers;
        $this->additionalBody    = $body;
    }

    /**
     * Build the packet's header
     *
     * @param int $destinationId
     */
    public function buildHeader($destinationId)
    {
        $this->headers = new \SabreAMF_TypedObject(null, array_merge(array(
            'DSRequestTimeout' => 60,
            'DSId'             => $destinationId,
            'DSEndpoint'       => 'my-rtmps'
        ), $this->additionalHeaders));
    }

    /**
     * Build the packet's body
     */
    public function buildBody()
    {
        $remoteMessage = new \SabreAMF_AMF3_RemotingMessage();
        $this->data = new \SabreAMF_TypedObject($this->class, array_merge(array(
            'destination' => $this->destination,
            'operation'   => $this->operation,
            'source'      => null,
            'timestamp'   => 0,
            'messageId'   => $remoteMessage->generateRandomId(),
            'timeToLive'  => 0,
            'clientId'    => null,
            'headers'     => $this->headers,
            'body'        => $this->parameters
        ), $this->additionalBody));
    }

    /**
     * Build the whole packet
     *
     * @param int $destinationId
     */
    public function build($destinationId)
    {
        $this->buildHeader($destinationId);
        $this->buildBody();
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}