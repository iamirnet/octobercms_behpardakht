<?php
use Symfony\Component\HttpFoundation\Response as HttpResponse;

Route::get('/behpardakhtpay', function () {
    return HttpResponse::create(\iAmirNet\BehPardakht\BehPardakht::redirect(request()->all()));
})->name('behpardakhtpay');
