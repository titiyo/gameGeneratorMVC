<?php
/**
 * Created by IntelliJ IDEA.
 * User: ty
 * Date: 25/10/13
 * Time: 22:05
 * To change this template use File | Settings | File Templates.
 */

require_once 'Framework/Model.php';


class ModelUser extends Model {

    private $fileXml;

    public function __construct() {
        if(file_exists("Content/xml/users.xml"))
        {
            $this->fileXml = simplexml_load_file("Content/xml/users.xml");
        }
        else
        {
            $stringxml = <<<XML
<?xml version = "1.0" encoding="ISO-8859-1" standalone = "no" ?>
<users xmlns="http://users.org" xsi:schemaLocation="http://users.org /Content/xsd/users.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">

</users>
XML;

            $xml = simplexml_load_string($stringxml);
            $xml->asXml("Content/xml/users.xml");
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

    /**
     * @param $lname
     * @param $fname
     * @param $login
     * @param $email
     * @param $pwd
     */
    public function createUser($lname, $fname, $login, $email, $pwd)
    {
        $user = $this->fileXml->addChild('user');
        $user->addAttribute('group', 'member');
        $user->addChild('lname', $lname);
        $user->addChild('fname', $fname);
        $user->addChild('login', $login);
        $user->addChild('pwd', $pwd);
        $user->addChild('mail', $email);
        $this->fileXml->asXML("Content/xml/users.xml");

        $dom = dom_import_simplexml($this->fileXml)->ownerDocument;
        $dom->formatOutput = true;
        $dom->saveXML();
    }

    public function getUserList()
    {
        $userList = array();
        foreach($this->fileXml->user as $usr)
        {
             array_push($userList, $usr);
        }
        return $userList;
    }

    public function getUserDetails($login)
    {
        foreach($this->fileXml->user as $usr)
        {
            if($usr->login==$login)
                return array("lname"=> $usr->lname, "fname"=> $usr->fname,"login"=> $usr->login, "type" => $usr->attributes()->group,"mail"=> $usr->mail, "pwd"=>$usr->pwd);
        }
        return null;
    }

    public function modifUser($login, $type, $email, $pwd)
    {
        foreach($this->fileXml->user as $usr)
        {
            if($usr->login==$login)
            {
                $usr->attributes()->group = $type;
                $usr->mail = $email;
                $usr->pwd = $pwd;
            }
        }
        $this->fileXml->asXml("Content/xml/users.xml");
    }
    
    
}