<?php

namespace app\models\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
class RoleBehavior extends Behavior
{

    public $valueAttribute = 'role';

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'after',
            ActiveRecord::EVENT_AFTER_UPDATE => 'after',
        ];
    }

    public function after($event)
    {
        $owner = $this->owner;
        $value = $owner->{$this->valueAttribute};
        if ($value) {
            $id = $owner->id;
            $authManager = Yii::$app->authManager;
            $authManager->revokeAll($id);
            $role = $authManager->getRole($value);
            $authManager->assign($role, $id);
        }
    }
}
