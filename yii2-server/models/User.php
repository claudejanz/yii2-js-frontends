<?php

namespace app\models;

use app\models\base\UserBase;
use app\models\behaviors\RoleBehavior;
use claudejanz\toolbox\models\behaviors\WeightDefaultBehavior;
use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends UserBase implements IdentityInterface
{

    const STATUS_TO_VALIDATE = 5;
    const STATUS_ACTIVE = 10;
    const STATUS_DELETED = 20;
    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';
    const SCENARIO_CREATE = "create";

    public $password;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
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
            'autoRole' => [
                'class' => RoleBehavior::className()
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $roles = Yii::$app->authManager->getRoles();
//        var_dump($roles);
        return array_merge([
            ['password', 'required', 'on' => self::SCENARIO_CREATE],
            ['password', 'string', 'min' => 6, 'on' => self::SCENARIO_CREATE],
            ['password', 'setMyPassword', 'on' => self::SCENARIO_CREATE],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_TO_VALIDATE, self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['role', 'default', 'value' => self::ROLE_USER],
            ['role', 'in', 'range' => ArrayHelper::map($roles, 'name', 'name'),],
            [['email', 'mobile', 'firstname', 'lastname', 'username'], 'filter', 'filter' => 'trim'],
            [['email', 'mobile', 'firstname', 'lastname', 'username'], 'default', 'value' => null],
            ['email', 'email'],
            ['email', 'unique'],
            [['email', 'username'], 'required'],
            [['email', 'username'], 'unique'],
                ], parent::rules());
    }

    /**
     * Determines exposed fields
     *
     * @return void
     */
    public function fields()
    {
        $fields = parent::fields();
    
        // remove fields that contain sensitive information
        unset($fields['auth_key'], $fields['password_hash'], $fields['password_reset_token']);
        if (!(!Yii::$app->user->isGuest && Yii::$app->user->id == $this->id)) {
            unset($fields['access_token']);
            unset($fields['role']);
        }
        return $fields;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }


        $user = static::find()->where(['password_reset_token' => $token,])
        ->andWhere(['<=', 'status', self::STATUS_ACTIVE])
        ->one();
        return $user;
    }

    public static function findByEmailOrUsername($emailOrUsername)
    {
        return static::find()
        ->where(['email' => $emailOrUsername])
        ->orWhere(['username' => $emailOrUsername])
        ->andWhere(['<=', 'status', self::STATUS_ACTIVE])
        ->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
        $this->password_reset_token = '';
    }

    public function setMyPassword($password)
    {
        $this->setPassword($this->{$password});
        $this->generateAuthKey();
        return $this->{$password};
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->getSecurity()->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'password' => Yii::t('app', 'Password'),
        ]);
    }

    private static $roles;

    /**
     * Returns roles where user has access
     *
     * @return Roles[]
     */
    public static function getRoles()
    {
        if (!isset(self::$roles)) {
            $orig = Yii::$app->authManager->getRoles();
            $roles = [];
            foreach ($orig as $key => $role) {
                if (Yii::$app->user->can($role->name)) {
                    $roles[$role->name] = lcfirst($role->name);
                }
            };
            self::$roles = $roles;
        }
        return self::$roles;
    }

    /**
     * Return roles for validation
     *
     * @return array
     */
    public static function getRoleOptions()
    {
        $roles = [];
        if (Yii::$app->user->can(self::ROLE_USER)) {
            $roles[self::ROLE_USER] = Yii::t('app', 'ROLE_USER');
        }
        if (Yii::$app->user->can(self::ROLE_ADMIN)) {
            $roles[self::ROLE_ADMIN] = Yii::t('app', 'ROLE_ADMIN');
        }

        return $roles;
    }

    public function getRoleValue()
    {
        $options = self::getRoleOptions();
        return $options[$this->role];
    }
    /**
     * Generates "api" access token
     */
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString($length = 16);
    }

    // public function login()
    // {
    //     Yii::$app->user->login($this, 3600 * 24 * 30);
    // }
}
