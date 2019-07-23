<?php


namespace Omnipay\FKWallet\Message;


use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class RefundResponse extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
    }

    public function isSuccessful()
    {
        return isset($this->data['status']) and $this->data['status'] != 'error';
    }

    public function isCancelled()
    {
        return isset($this->data['data']['status']) and $this->data['data']['status'] == 'Canceled';
    }

    public function isPending()
    {
        return parent::isPending(); // TODO: Change the autogenerated stub
    }

    public function getTransactionReference()
    {
        return isset($this->data['data']['payment_id']) ? $this->data['data']['payment_id'] : 0;
    }

    public function getMessage()
    {
        return isset($this->data['desc']) ? $this->data['desc'] : 'Unknown error';
    }

}
