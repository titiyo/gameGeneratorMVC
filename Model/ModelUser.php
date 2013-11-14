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
        $this->fileXml = simplexml_load_file("Content/xml/users.xml");
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
        $i=0;
        foreach($this->fileXml->user as $usr)
        {
             array_push($userList, $usr);
        }
        return $userList;
    }

}