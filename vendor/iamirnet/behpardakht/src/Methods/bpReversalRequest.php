<?php


namespace iAmirNet\BehPardakht\Methods;


trait bpReversalRequest
{
    public function bpReversalRequest($orderId, $verifySaleOrderId,  $verifySaleReferenceId) {
        $parameters = [
            'orderId' => $orderId,
            'saleOrderId' => $verifySaleOrderId,
            'saleReferenceId' => $verifySaleReferenceId
        ];
        $result = $this->request('bpReversalRequest', $parameters);
        return ['status' => $result == '0', 'msg' => $this->getError($result)];
    }
}