<?php

class UserIdentity extends CUserIdentity
{
    private $_id;

    public function authenticate()
    {
        $user = Users::model()->findByAttributes(['username' => $this->username]);

        if (!$user || !CPasswordHelper::verifyPassword($this->password, $user->password)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            $this->_id = $user->id;
            $this->username = $user->username;
            $this->errorCode = self::ERROR_NONE;
        }

        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}
