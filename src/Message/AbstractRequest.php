<?php

namespace Omnipay\FKWallet\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

/**
 * Abstract Request
 *
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    protected $liveEndpoint = 'https://2ip.ru';


    public function sendData($data)
    {
        $url = $this->getEndpoint();
        $response = $this->httpClient->post($this->getEndpoint(), [], $data);
        $data = json_decode($response->getBody(), true);

        return $this->createResponse($data);
    }


    protected function getEndpoint()
    {
        return $this->liveEndpoint;
    }

    protected function createResponse($data)
    {
        return $this->response = new RefundResponse($this, $data);
    }

    public function getWalletSign()
    {
        return md5($this->getWalletId() . $this->getWalletKey());
    }

    public function getAction()
    {
        return $this->getParameter('action');
    }

    public function setAction($value)
    {
        return $this->setParameter('action', $value);
    }

    public function getWalletId()
    {
        return $this->getParameter('wallet_id');
    }

    public function getWalletKey()
    {
        return $this->getParameter('wallet_key');
    }

    public function setWalletId($value)
    {
        return $this->setParameter('wallet_id', $value);
    }

    public function setWalletKey($value)
    {
        return $this->setParameter('wallet_key', $value);
    }

    public function setPurse($value)
    {
        return $this->setParameter('purse', $value);
    }

    public function getPurse()
    {
        return $this->getParameter('purse');
    }

    public function getCurrency()
    {
        return $this->getParameter('currency');
    }

}
