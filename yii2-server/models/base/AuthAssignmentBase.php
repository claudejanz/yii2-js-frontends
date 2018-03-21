<?php

namespace app\models\base;

use Yii;
use app\models\AuthItem;

/**
 * This is the model class for table "auth_assignment".
*
    * @property string $item_name
    * @property string $user_id
    * @property integer $created_at
    *
            * @property AuthItem $itemName
    */
class AuthAssignmentBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'auth_assignment';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['item_name', 'user_id'], 'required'],
            [['created_at'], 'integer'],
            [['item_name', 'user_id'], 'string', 'max' => 64],
            [['item_name', 'user_id'], 'unique', 'targetAttribute' => ['item_name', 'user_id']],
            [['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['item_name' => 'name']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'item_name' => Yii::t('app', 'Item Name'),
    'user_id' => Yii::t('app', 'User ID'),
    'created_at' => Yii::t('app', 'Created At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getItemName()
    {
    return $this->hasOne(AuthItem::className(), ['name' => 'item_name'])->inverseOf('authAssignments');
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\AuthAssignmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\AuthAssignmentQuery(get_called_class());
}
}