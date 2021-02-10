<?php


namespace iAmirNet\BehPardakht\Methods;

use SoapClient;

trait Request
{
    public function request($method, $parameters) {
        $namespace = 'http://interfaces.core.sw.bps.com/';
        $client = new SoapClient('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
        $result = $client->$method(array_merge(['terminalId' => $this->getTerminalId(),
            'userName' => $this->getUserName(),
            'userPassword' => $this->getPassword()
        ],$parameters), $namespace);
        return is_array($result) || is_object($result) ? $result->return : "-1";
    }
}