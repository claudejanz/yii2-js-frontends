<?php

namespace app\models\base;

use Yii;
use app\models\Post;

/**
 * This is the model class for table "topic".
*
    * @property integer $id
    * @property string $title
    * @property integer $created_by
    * @property string $created_at
    * @property integer $updated_by
    * @property string $updated_at
    *
            * @property Post[] $posts
    */
class TopicBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
    return 'topic';
}

/**
* @inheritdoc
*/
public function rules()
{
    return [
        [['title'], 'required'],
        [['created_by', 'updated_by'], 'integer'],
        [['created_at', 'updated_at'], 'safe'],
        [['title'], 'string', 'max' => 255],
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
    'created_by' => Yii::t('app', 'Created By'),
    'created_at' => Yii::t('app', 'Created At'),
    'updated_by' => Yii::t('app', 'Updated By'),
    'updated_at' => Yii::t('app', 'Updated At'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPosts()
    {
    return $this->hasMany(Post::className(), ['topic_id' => 'id'])->inverseOf('topic');
    }

    /**
     * @inheritdoc
     * @return \app\models\querys\TopicQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\querys\TopicQuery(get_called_class());
}
}