<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Topic extends \app\models\base\TopicBase
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

    public function extraFields()
    {
        return ['posts'];
    }
    
    public function fields() {
        $fields = parent::fields();
        $fields['can_update'] = function ($model) {
            return (Yii::$app->user->can('topic update', ['model'=>$model]))?true:false;
        };
        return $fields;
    }
}
