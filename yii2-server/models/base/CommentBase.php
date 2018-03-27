<?php

namespace app\models\base;

use Yii;
use app\models\Post;

/**
 * This is the model class for table "comment".
*
    * @property integer $id
    * @property string $content
    * @property integer $post_id
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Post $post
    */
class CommentBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'comment';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['content', 'post_id'], 'required'],
            [['content'], 'string'],
            [['post_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'content' => Yii::t('app', 'Content'),
    'post_id' => Yii::t('app', 'Post ID'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPost()
    {
    return $this->hasOne(Post::className(), ['id' => 'post_id'])->inverseOf('comments');
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\CommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\CommentQuery(get_called_class());
}
}