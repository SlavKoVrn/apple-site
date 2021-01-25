<?php

use backend\models\Admin;
use yii\db\Migration;

/**
 * Class m210125_101522_add_admin_user
 */
class m210125_101522_add_admin_user extends Migration
{
    /** @var Admin */
    private $admin;

    /**
     * Fetch an existing admin user from DB
     * @return Admin|null
     */
    private function fetchAdmin()
    {
        return Admin::findOne(['username' => $this->admin->username]);
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->admin = new Admin();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if (!$this->fetchAdmin()) {
            $this->admin->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($admin = $this->fetchAdmin()) {
            $admin->delete();
        }
    }
}
