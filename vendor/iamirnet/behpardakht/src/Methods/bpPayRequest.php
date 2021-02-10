<?php

namespace iAmirNet\BehPardakht\Methods;

trait bpPayRequest
{
    public function bpPayRequest($amount, $callbackURL, $currency = "IRT", $data= '', $payload = 0)
    {
        if ($currency == "IRT")
            $amount = round($amount * 10);
        if (is_array($data))
            $data = json_encode($data);
        $InvoiceID = date("His") . '10000' . $this->order->id;
        $localDate = date('Ymd');
        $localTime = date('Gis');
        $parameters = array(
            'orderId' => $InvoiceID,
            'amount' => (int) $amount,
            'localDate' => $localDate,
            'localTime' => $localTime,
            'additionalData' => $data,
            'callBackUrl' => $callbackURL,
            'payerId' => $payload);
        $result = $this->request('bpPayRequest', $parameters);
        $res = explode(',', $result);
        $ResCode = $res[0];
        if ($ResCode == "0") {
            return array(
                "status" => true,
                "url" => "https://bpm.shaparak.ir/pgwchannel/startpay.mellat",
                "url_en" => "https://bpm.shaparak.ir/pgwchannel/enstartpay.mellat",
                "url_irani" => "https://bpm.shaparak.ir/pgwCreditchannel/startpay.mellat",
                "callBackUrl" => $callbackURL,
                "RefId" => $res[1]
            );
        } else {
            return array('status' => false, "msg" => $this->getError($result), "data" => $parameters,);
        }
    }
}