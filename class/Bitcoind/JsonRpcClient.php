<?php
namespace Bitcoind;

class JsonRpcResponse
{
    var $httpCode;
    var $result;
    var $error;
    var $id;
}

/**
 * Client for the bitcoind JSON-RPC API
 */
class JsonRpcClient
{
    private $port = 8332;
    private $host = '127.0.0.1';
    private $username = 'bitcoinrpc';
    private $password;

    private $requestCounter = 0;

    public function setPort($n)
    {
        $this->port = $n;
    }

    public function setHost($s)
    {
        $this->host = $s;
    }

    public function setUsername($s)
    {
        $this->username = $s;
    }

    public function setPassword($s)
    {
        $this->password = $s;
    }

    /**
     * @param $data encoded POST data
     */
    private function postRequest($data)
    {
        if (!$this->username || !$this->password) {
            throw new \Exception();
        }

        $url = 'http://'.$this->username.':'.$this->password.'@'.$this->host.':'.$this->port.'/';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $output = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $tmp = json_decode($output);

        $res = new JsonRpcResponse();
        $res->httpCode = $httpCode;
        $res->result = $tmp->result;
        $res->error = $tmp->error;
        $res->id = $tmp->id;
        return $res;
    }

    public function __call($methodName, $params = array())
    {
        return $this->request(strtolower($methodName), $params);
    }

    public function request($methodName, $params = array())
    {
        $this->requestCounter++;

        $params = array(
            "method" => $methodName,
            "params" => $params,
            "id" => $this->requestCounter,
        );

        return $this->postRequest(json_encode($params));
    }
}
