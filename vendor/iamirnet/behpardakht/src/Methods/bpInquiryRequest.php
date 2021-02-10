<?php


namespace iAmirNet\BehPardakht\Methods;


trait bpInquiryRequest
{
    public function bpInquiryRequest($orderId, $verifySaleOrderId,  $verifySaleReferenceId) {
        $parameters = [
            'orderId' => $orderId,
            'saleOrderId' => $verifySaleOrderId,
            'saleReferenceId' => $verifySaleReferenceId
        ];
        $result = $this->request('bpInquiryRequest', $parameters);
        return ['status' => $result == '0', 'msg' => $this->getError($result)];
    }
}