<?php

namespace backend\models;

use common\models\User;

/**
 * Class Admin
 * @package backend\models
 *
 * Admin user for backend authentication
 */
class Admin extends User
{
    /**
     * Hardcode admin credentials
     */
    private function hardcode()
    {
        $this->username = 'admin';
        $this->generateAuthKey();
        $this->setPassword('Qwer1234');
        $this->email = 'admin@example.com';
        $this->status = self::STATUS_ACTIVE;
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->hardcode();
    }
}
