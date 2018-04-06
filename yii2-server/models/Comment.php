<?php

namespace app\models;

use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Comment extends \app\models\base\CommentBase
{
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
        ];
    }
    public function fields()
    {
        $fields = parent::fields();

        $fields['username'] = function ($model) {
            $user = $model->getUser()->select('username')->one();
            return $user->username;
        };
        
        return $fields;
    }
     /**
    * @return \yii\db\ActiveQuery
    */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
