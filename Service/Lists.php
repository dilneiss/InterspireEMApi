<?php
class InterspireEMApi_Service_Lists extends InterspireEMApi_Service_Abstract
{
    protected $_requestMethodMap = array(
        'getCustomFields' => 'GetCustomFields',
        'getLists'        => 'GetLists',
    );

    public function getCustomFields($listids = array())
    {
        $details = array(
            'listids' => $listids,
        );

        return $this->makeRequest($details);
    }

    public function getLists($listIds = array())
    {
        $details = array(
            'listsArray' => $listIds,
        );

        return $this->makeRequest($details);
    }
}