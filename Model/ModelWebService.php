<?php
/**
 * Created by IntelliJ IDEA.
 * User: ty
 * Date: 25/10/13
 * Time: 22:05
 * To change this template use File | Settings | File Templates.
 */

require_once '../Framework/Model.php';

class ModelWebService extends Model {

    private $fileXml;

    public function __construct() {
        if(file_exists("../Content/xml/users.xml"))
        {
            $this->fileXml = simplexml_load_file("../Content/xml/users.xml");
        }
        else
        {
            $stringxml = <<<XML
<?xml version = "1.0" encoding="ISO-8859-1" standalone = "no" ?>
<users xmlns="http://users.org" xsi:schemaLocation="http://users.org /Content/xsd/users.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">

</users>
XML;

            $xml = simplexml_load_string($stringxml);
            $xml->asXml("../Content/xml/users.xml");
        }
    }

    /**
     * @param $login
     * @param $pwd
     * @return array|null
     */
    public function getUser($login, $pwd) {
        foreach($this->fileXml->user as $usr)
        {
            if($usr->login == $login && $usr->pwd == $pwd)
            {
                return array('login' => $login, 'group' => (string)$usr->attributes()->group);
            }
        }
        return null;
    }