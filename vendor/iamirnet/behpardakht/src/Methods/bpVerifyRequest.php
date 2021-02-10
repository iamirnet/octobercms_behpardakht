<?php


namespace iAmirNet\BehPardakht\Methods;


trait bpVerifyRequest
{
    public function bpVerifyRequest($orderId, $verifySaleOrderId,  $verifySaleReferenceId) {
        $parameters = [
            'orderId' => $orderId,
            'saleOrderId' => $verifySaleOrderId,
            'saleReferenceId' => $verifySaleReferenceId
        ];
        $VerifyAnswer = $this->request('bpVerifyRequest', $parameters);
        if($VerifyAnswer['status'])
            $result = $this->bpSettleRequest(...func_get_args());
        if ($VerifyAnswer <> '0' AND $VerifyAnswer != '' ){
            $InquiryAnswer = $this->bpInquiryRequest(...func_get_args()) ;
            if ($InquiryAnswer['status'])
                $result = $this->bpSettleRequest(...func_get_args());
            else
                $result = $this->bpReversalRequest(...func_get_args());
        }
        if (!isset($result) || !is_array($result))
            $result = ['status' => $VerifyAnswer == '0', 'msg' => $this->getError($VerifyAnswer)];
        return array_merge($result, ["transId" => $verifySaleReferenceId]);
    }
}