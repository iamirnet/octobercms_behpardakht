<?php

namespace iAmirNet\BehPardakht\Models;

use Azarinweb\Minimall\Classes\Payments\PaymentProvider;
use Azarinweb\Minimall\Classes\Payments\PaymentResult;
use Azarinweb\Minimall\Models\Order;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Request;
use Session;
use Throwable;
use function GuzzleHttp\Psr7\build_query;

class BehPardakht extends PaymentProvider
{
    public function name(): string
    {
        return 'به پرداخت ملت';
    }

    public function identifier(): string
    {
        return 'behpardakht';
    }

    public function validate(): bool
    {
        return true;
    }

    protected function getGateway()
    {
        $gateway = new \iAmirNet\BehPardakht\BehPardakht(
            BehPardakhtSettings::get('behpardakht_terminal_id'),
            BehPardakhtSettings::get('behpardakht_user_name'),
            BehPardakhtSettings::get('behpardakht_password')
        );
        $gateway->setOrder($this->order ? : Order::find(request('OrderId')));
        return $gateway;
    }

    public function settings(): array
    {
        return [];
    }

    public function process(PaymentResult $result): PaymentResult
    {
        $gateway = $this->getGateway();
        $response = null;
        try {
            $response = $gateway->bpPayRequest(
                $this->order->total_in_currency,
                $this->returnUrl()
            );
        } catch (Throwable $e) {
            return $result->fail([], $e);
        }

        if (!$response['status']) {
            return $result->fail($response['data'], $response['msg']);
        }
        Session::put('minimall.payment.callback', self::class);
        Session::put('minimall.behpardakht.transactionReference', $response['RefId']);
        return $result->redirect('/behpardakhtpay?' . http_build_query($response));
    }

    public function complete(PaymentResult $result): PaymentResult
    {
        $gateway = $this->getGateway();
        $response = null;
        try {
            $orderId = request('SaleOrderId');
            $verifySaleReferenceId = (float)request('SaleReferenceId');
            $response = $gateway->bpVerifyRequest($orderId, $orderId, $verifySaleReferenceId);
        } catch (Throwable $e) {
            return $result->fail(request()->all(), $e);
        }
        if ($response['status']) {
            return $result->success($response, 'پرداخت با موفقیت انجام گردید.');
        } else {
            return $result->fail($response, $response['msg']);
        }
    }
}
