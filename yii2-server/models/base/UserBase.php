<?php

namespace app\models\base;

use Yii;
use app\models\Departement;

/**
 * This is the model class for table "user".
*
    * @property integer $id
    * @property string $username
    * @property integer $departement_id
    * @property string $email
    * @property string $image
    * @property string $fonction
    * @property string $mobile
    * @property string $societe
    * @property string $firstname
    * @property string $lastname
    * @property string $address
    * @property string $postal_code
    * @property string $locality
    * @property integer $conseiller
    * @property integer $status
    * @property string $role
    * @property string $auth_key
    * @property string $password_hash
    * @property string $password_reset_token
    * @property integer $weight
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Departement $departement
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
            [['departement_id', 'conseiller', 'status', 'weight', 'created_by', 'updated_by'], 'integer'],
            [['firstname', 'lastname', 'auth_key', 'password_hash'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'email', 'image', 'fonction', 'mobile', 'societe', 'firstname', 'lastname', 'address', 'postal_code', 'locality', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['role'], 'string', 'max' => 12],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['departement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departement::className(), 'targetAttribute' => ['departement_id' => 'id']],
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
    'departement_id' => Yii::t('app', 'Departement ID'),
    'email' => Yii::t('app', 'Email'),
    'image' => Yii::t('app', 'Image'),
    'fonction' => Yii::t('app', 'Fonction'),
    'mobile' => Yii::t('app', 'Mobile'),
    'societe' => Yii::t('app', 'Societe'),
    'firstname' => Yii::t('app', 'Firstname'),
    'lastname' => Yii::t('app', 'Lastname'),
    'address' => Yii::t('app', 'Address'),
    'postal_code' => Yii::t('app', 'Postal Code'),
    'locality' => Yii::t('app', 'Locality'),
    'conseiller' => Yii::t('app', 'Conseiller'),
    'status' => Yii::t('app', 'Status'),
    'role' => Yii::t('app', 'Role'),
    'auth_key' => Yii::t('app', 'Auth Key'),
    'password_hash' => Yii::t('app', 'Password Hash'),
    'password_reset_token' => Yii::t('app', 'Password Reset Token'),
    'weight' => Yii::t('app', 'Weight'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getDepartement()
    {
    return $this->hasOne(Departement::className(), ['id' => 'departement_id'])->inverseOf('users');
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