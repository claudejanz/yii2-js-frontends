<?php

namespace app\models\base;

use Yii;
use app\models\Comment;
use app\models\Topic;

/**
 * This is the model class for table "post".
*
    * @property integer $id
    * @property string $title
    * @property string $content
    * @property integer $topic_id
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Comment[] $comments
            * @property Topic $topic
    */
class PostBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'post';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['title', 'content', 'topic_id'], 'required'],
            [['content'], 'string'],
            [['topic_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['topic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Topic::className(), 'targetAttribute' => ['topic_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'title' => Yii::t('app', 'Title'),
    'content' => Yii::t('app', 'Content'),
    'topic_id' => Yii::t('app', 'Topic ID'),
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getComments()
    {
    return $this->hasMany(Comment::className(), ['post_id' => 'id'])->inverseOf('post');
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTopic()
    {
    return $this->hasOne(Topic::className(), ['id' => 'topic_id'])->inverseOf('posts');
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\PostQuery(get_called_class());
}
}