<?php


namespace iAmirNet\BehPardakht\Methods;


trait Redirect
{
    public static function redirect($parameters, $method = "url")
    {
        $html = '<!DOCTYPE html>
            <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <title>Redirecting...</title>
            </head>
            <body>';
        if ($parameters['status']) {
            $html .= "<form id='behpardakht_go' action='$parameters[$method]' method='post'>";
            $html .= "<input type='hidden' name='RefId' value='{$parameters['RefId']}'>";
            $html .= "</form><script>document.getElementById('behpardakht_go').submit();</script>";
            $html .= "";
        } else {
            $html .= "<script>alert('امکان اتصال وجود ندارد ، لطفاً دوباره تلاش کنید.');</script>";
            $html .= "<script>window.location = {$parameters['callBackUrl']}</script>";
            $html .= "";
        }
        $html .= '</body>
            </html>';
        return $html;
    }
}