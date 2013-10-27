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

    /** Renvoie vrai si l'utilisateur exit, sinon renvoie false
     * @param $login
     * @param $pwd
     * @return boolean
     */
    public function isExit($login, $pwd) {
        foreach($this->fileXml->user as $usr)
        {
            if($usr->login == $login && $usr->pwd == $pwd)
            {
                return true;
            }
        }
        return false;
    }
}