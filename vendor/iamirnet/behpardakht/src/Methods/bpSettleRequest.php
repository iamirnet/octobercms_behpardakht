<?php


namespace iAmirNet\BehPardakht\Methods;


trait bpSettleRequest
{
    public function bpSettleRequest($orderId, $verifySaleOrderId,  $verifySaleReferenceId) {
        $parameters = [
            'orderId' => $orderId,
            'saleOrderId' => $verifySaleOrderId,
            'saleReferenceId' => $verifySaleReferenceId
        ];
        $result = $this->request('bpSettleRequest', $parameters);
        return ['status' => $result == '0', 'msg' => $this->getError($result)];
    }
}