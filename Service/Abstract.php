<?php

abstract class InterspireEMApi_Service_Abstract
{
    /** @var InterspireEMApi  */
    protected $_client;
    protected $_requestMethodMap = array();

    public function __construct($client)
    {
        $this->_client = $client;
    }

    public function makeRequest($details = array())
    {
        $caller = $this->_getCaller();

        $xmlArray = array(
            'xmlrequest' => array(
                'username' => $this->_client->getUsername(),
                'usertoken' => $this->_client->getUsertoken(),
                'requesttype' => strtolower(substr($caller['class'], strrpos($caller['class'], '_')+1)),
                'requestmethod' => $this->_requestMethodMap[$caller['function']],
                'details' => $details,
            )
        );

        $xmlString = $this->_arrayToXmlString($xmlArray);
//var_dump($xmlString);
        $curlHandle = curl_init($this->_client->getApiPath());
        curl_setopt_array($curlHandle, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $xmlString,
        ));

        return new InterspireEMApi_Response($curlHandle);
    }

    private function _arrayToXmlString($array)
    {
        if (is_array($array)) {
            // one new line for array "indentation"
            $str = "\n";

            foreach ($array as $key => $value) {
                // handling of multiple elements with same key (key suffixed with Array)
                if (strrpos($key, 'Array') > 0 && strrpos($key, 'Array') == strlen($key) - 5) {
                    $itemKey = substr($key, 0, strrpos($key, 'Array'));
                    foreach ($value as $item) {
                        $str .= sprintf("<%1\$s>%2\$s</%1\$s>\n", $itemKey, $this->_arrayToXmlString($item));
                    }
                }
                // basic elements
                else {
                    // every element will be on new line
                    $str .= sprintf("<%1\$s>%2\$s</%1\$s>\n", $key, $this->_arrayToXmlString($value));
                }
            }

            return $str;
        }
        else {
            return (string)$array;
        }
    }

    private function _getCaller()
    {
        $backtrace = debug_backtrace(FALSE);
        return $backtrace[2];
    }
}