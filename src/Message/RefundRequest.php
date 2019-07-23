<?php


namespace Omnipay\FKWallet\Message;


use Omnipay\Common\Exception\InvalidRequestException;

class RefundRequest extends AbstractRequest
{

    protected function cashout()
    {
        $this->validate('wallet_id', 'purse', 'amount', 'description', 'currency');
        return [
            'wallet_id' => $this->getParameter('wallet_id'),
            'purse' => $this->getPurse(),
            'amount' => $this->getAmount(),
            'desc' => $this->getDescription(),
            'currency' => $this->getCurrency(),
            'sign' => $this->getWalletSign(),
            'order_id' => $this->getTransactionId(),
            'check_duplicate' => 1,
            'action' => $this->getAction(),
        ];
    }

    protected function transfer()
    {
        $this->validate('wallet_id', 'purse', 'amount', 'desc', 'currency');
        return [
            'wallet_id' => $this->getParameter('wallet_id'),
            'sign' => $this->getWalletSign(),
            'order_id' => $this->getTransactionId(),
            'check_duplicate' => 1,
            'action' => $this->getAction(),
        ];
    }

    protected function online_payment()
    {
        $this->validate('wallet_id', 'purse', 'amount', 'desc', 'currency');
        return [
            'wallet_id' => $this->getParameter('wallet_id'),
            'sign' => $this->getWalletSign(),
            'order_id' => $this->getTransactionId(),
            'check_duplicate' => 1,
            'action' => 'online_payment',
        ];
    }

    protected function create_coin_address()
    {
        $this->validate('wallet_id', 'purse', 'amount', 'desc', 'currency');
        return [
            'wallet_id' => $this->getParameter('wallet_id'),
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
