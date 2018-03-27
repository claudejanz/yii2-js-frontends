<?php

use app\models\User;
use yii\db\Migration;

/**
 * Class m180321_101623_user
 */
class m180321_101623_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'email' => $this->string()->unique()->notNull(),
            'mobile' => $this->string(),
            'firstname' => $this->string(),
            'lastname' => $this->string(),
            'address' => $this->string(),
            'city_npa' => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(User::STATUS_TO_VALIDATE),
            'role' => $this->string('12')->notNull()->defaultValue(User::ROLE_USER),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'access_token' => $this->string(),
            'created_by' => $this->integer()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_by' => $this->integer()->null(),
            'updated_at' => $this->dateTime()->null(),
        ], $tableOptions);

        $this->createTable('topic', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'created_by' => $this->integer()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_by' => $this->integer()->null(),
            'updated_at' => $this->dateTime()->null(),
        ], $tableOptions);
        
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'topic_id'=>$this->integer()->notNull(),
            'created_by' => $this->integer()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_by' => $this->integer()->null(),
            'updated_at' => $this->dateTime()->null(),
        ], $tableOptions);
        $this->addForeignKey('fk-post-topic_id-topic-id','post','topic_id','topic','id');

        $this->createTable('comment', [
            'id' => $this->primaryKey(),
            'content' => $this->text()->notNull(),
            'post_id'=>$this->integer()->notNull(),
            'created_by' => $this->integer()->null(),
            'created_at' => $this->dateTime()->null(),
            'updated_by' => $this->integer()->null(),
            'updated_at' => $this->dateTime()->null(),
        ], $tableOptions);
        $this->addForeignKey('fk-comment-post_id-post-id','comment','post_id','post','id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180321_101623_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180321_101623_user cannot be reverted.\n";

        return false;
    }
    */
}
