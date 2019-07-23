<?php


namespace Omnipay\FKWallet\Message;


use Omnipay\Common\Exception\InvalidRequestException;

class RefundRequest extends AbstractRequest
{

    protected function cashout()
    {
        $this->validate('wallet_id', 'purse', 'amount', 'description', 'currency');
        return [
            'wallet_id' => $this->getWalletId(),
            'purse' => $this->getPurse(),
            'amount' => $this->getAmount(),
            'desc' => $this->getDescription(),
            'currency' => $this->getCurrency(),
            'sign' => md5($this->getWalletId().$this->getCurrency().$this->getAmount().$this->getPurse().$this->getWalletKey()),
            'order_id' => $this->getTransactionId(),
            'check_duplicate' => 1,
            'action' => $this->getAction(),
        ];
    }

    protected function transfer()
    {
        $this->validate('wallet_id', 'purse', 'amount', 'currency');
        return [
            'wallet_id' => $this->getWalletId(),
            'sign' => md5($this->getWalletId().$this->getAmount().$this->getPurse().$this->getWalletKey()),
            'order_id' => $this->getTransactionId(),
            'check_duplicate' => 1,
            'action' => $this->getAction(),
        ];
    }

    protected function online_payment()
    {
        $this->validate('wallet_id', 'service_id', 'account', 'amount', 'order_id');
        return [
            'wallet_id' => $this->getWalletId(),
            'sign' => md5($this->getWalletId().$this->getAmount().$this->getPurse().$this->getWalletKey()),
            'order_id' => $this->getTransactionId(),
            'check_duplicate' => 1,
            'action' => 'online_payment',
        ];
    }

    protected function create_coin_address()
    {
        $this->validate('wallet_id', 'purse', 'amount', 'desc', 'currency');
        return [
            'wallet_id' => $this->getWalletId(),
            'sign' => $this->getWalletSign(),
            'action' => $this->getAction(),
        ];
    }

    public function getData()
    {
        $this->validate('action');
        switch ($this->getAction()) {
            case 'cashout':
                return $this->cashout();
                break;
            case 'transfer':
                return $this->transfer();
                break;
            case 'online_payment':
                return $this->online_payment();
                break;
            default:
                if (strpos($this->getAction(), 'create') !== false) {
                    return $this->create_coin_address();
                } else {
                    throw new InvalidRequestException("The action parameter is not allowed");
                }

        }
    }

}
