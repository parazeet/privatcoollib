<?php

namespace App;

use GuzzleHttp\Client;

class ExchangedAmount
{
    private $from;
    private $to;
    private $amount;

    public function __construct($from, $to, $amount)
    {
        $this->from = $from;
        $this->to = $to;
        $this->amount = $amount;
    }

    public function toDecimal()
    {
        $url = 'https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5';
        $client = new Client();
        $res = $client->request('GET', $url);

        if ($res->getStatusCode() != 200) {
            return "Не смог получить данные API (code: {$res->getStatusCode()})";
        }

        $data =  json_decode($res->getBody());

        foreach ($data as $val) {
            if ($this->from == 'UAH') {
                if ($val->ccy == $this->to) {
                    return $this->amount / $val->sale;
                }
            } else {
                if ($val->ccy == $this->from) {
                    return $this->amount * $val->buy;
                }
            }
        }
    }
}
