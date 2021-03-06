<?php

namespace app\models\base;

use Yii;
use app\models\AuthItem;

/**
 * This is the model class for table "auth_item_child".
*
    * @property string $parent
    * @property string $child
    *
            * @property AuthItem $parent0
            * @property AuthItem $child0
    */
class AuthItemChildBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'auth_item_child';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64],
            [['parent', 'child'], 'unique', 'targetAttribute' => ['parent', 'child']],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['parent' => 'name']],
            [['child'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['child' => 'name']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'parent' => Yii::t('app', 'Parent'),
    'child' => Yii::t('app', 'Child'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getParent0()
    {
    return $this->hasOne(AuthItem::className(), ['name' => 'parent'])->inverseOf('authItemChildren');
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getChild0()
    {
    return $this->hasOne(AuthItem::className(), ['name' => 'child'])->inverseOf('authItemChildren0');
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\AuthItemChildQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\AuthItemChildQuery(get_called_class());
}
}