<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "user".
*
    * @property integer $id
    * @property string $username
    * @property string $email
    * @property string $mobile
    * @property string $firstname
    * @property string $lastname
    * @property string $address
    * @property string $city_npa
    * @property integer $status
    * @property string $role
    * @property string $auth_key
    * @property string $password_hash
    * @property string $password_reset_token
    * @property string $access_token
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
*/
class UserBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
    return 'user';
}

/**
* @inheritdoc
*/
public function rules()
{
    return [
        [['username', 'email', 'auth_key', 'password_hash'], 'required'],
        [['status', 'created_by', 'updated_by'], 'integer'],
        [['created_at', 'updated_at'], 'safe'],
        [['username', 'email', 'mobile', 'firstname', 'lastname', 'address', 'city_npa', 'password_hash', 'password_reset_token', 'access_token'], 'string', 'max' => 255],
        [['role'], 'string', 'max' => 12],
        [['auth_key'], 'string', 'max' => 32],
        [['email'], 'unique'],
    ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'username' => Yii::t('app', 'Username'),
    'email' => Yii::t('app', 'Email'),
    'mobile' => Yii::t('app', 'Mobile'),
    'firstname' => Yii::t('app', 'Firstname'),
    'lastname' => Yii::t('app', 'Lastname'),
    'address' => Yii::t('app', 'Address'),
    'city_npa' => Yii::t('app', 'City Npa'),
    'status' => Yii::t('app', 'Status'),
    'role' => Yii::t('app', 'Role'),
    'auth_key' => Yii::t('app', 'Auth Key'),
    'password_hash' => Yii::t('app', 'Password Hash'),
    'password_reset_token' => Yii::t('app', 'Password Reset Token'),
    'access_token' => Yii::t('app', 'Access Token'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
     * @inheritdoc
     * @return \app\models\querys\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\UserQuery(get_called_class());
}
}