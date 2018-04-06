<?php

namespace app\commands;

use Yii;
use Faker\Factory;
use app\models\Post;
use app\models\User;
use app\models\Topic;
use yii\helpers\Html;
use app\models\Comment;
use yii\helpers\Console;
use yii\console\Controller;

/**
 * Provides content
 *
 * @author Claude
 */
class ContentController extends Controller
{

    /**
     * Provides content
     */
    public function actionIndex()
    {
        $assets = [
            'Exit',
            'Create Users',
            'Create Topics',
            'Create Posts',
            'Create Comments',
        ];
        $sep = '----------------------------------------------' . PHP_EOL;
        $message = $sep;
        $message .= 'What content do you want to create?' . PHP_EOL;
        $valids = [];
        foreach ($assets as $key => $value) {
            $message .= $this->ansiFormat($key, Console::FG_GREY)
                    . $this->ansiFormat(' => ', Console::FG_GREEN)
                    . $this->ansiFormat($value, Console::FG_YELLOW) . PHP_EOL;
            $valids[] = $key;
        }
        $message .= $this->ansiFormat('all', Console::FG_GREY)
                . $this->ansiFormat(' => ', Console::FG_GREEN)
                . $this->ansiFormat('all', Console::FG_YELLOW) . PHP_EOL;
        $message .= $sep;

        $error = $this->ansiFormat('Not valid input', Console::FG_RED);
        $pattern = '@^((' . implode('|', $valids) . '|all),?)+$@';
        $value = $this->prompt($message . 'Choices:', [
            'default' => 'all',
            'pattern' => $pattern,
            'error' => $error
        ]);

        $values = preg_split('@,@', $value, -1, PREG_SPLIT_NO_EMPTY);
        if (in_array('all', $values) || in_array('1', $values)) {
            $this->createUsers();
        }

        if (in_array('all', $values) || in_array('2', $values)) {
            $this->createTopics();
        }
       
        if (in_array('all', $values) || in_array('3', $values)) {
            $this->createPosts();
        }
       
        if (in_array('all', $values) || in_array('4', $values)) {
            $this->createComments();
        }
       
        if (in_array('0', $values)) {
            $this->exitit();
        }

        echo $sep;
    }

    public function createUsers()
    {
        Yii::$app->db->createCommand("SET foreign_key_checks = 0;")->execute();
        Yii::$app->db->createCommand()->truncateTable('user')->execute();
        Yii::$app->db->createCommand("SET foreign_key_checks = 1;")->execute();

        $total = 2;
        $count = 1;
        Console::startProgress(0, $total, 'Insert Admins: ', false);

        // les supers admin
        $admin = new User();
        $admin->scenario = User::SCENARIO_CREATE;
        $admin->attributes = [
            'username' => 'klod',
            'firstname' => 'Claude',
            'lastname' => 'Janz',
            'address' => '8a chemin de la chenalette',
            'city_npa' => 'Prangins, 1197',
            'mobile' => '+41 22 369 05 85',
            'email' => 'claudejanz@klod.ch',
            'password' => '12345678',
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ];
        if (!$admin->save()) {
            var_dump($admin->errors);
        }
        
        Console::updateProgress($count++, $total);
        // les supers admin
        $admin = new User();
        $admin->scenario = User::SCENARIO_CREATE;
        $admin->attributes = [
            'username' => 'claude',
            'firstname' => 'Claude',
            'lastname' => 'Janz',
            'address' => '8a chemin de la chenalette',
            'city_npa' => 'Prangins, 1197',
            'mobile' => '+41 22 369 05 85',
            'email' => 'claudejanz@gmail.com',
            'password' => '12345678',
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ];
        if (!$admin->save()) {
            var_dump($admin->errors);
        }
        
        Console::updateProgress($count++, $total);
        Console::endProgress("done." . PHP_EOL);
    }

    public function createTopics()
    {
        Yii::$app->db->createCommand("SET foreign_key_checks = 0;")->execute();
        Yii::$app->db->createCommand()->truncateTable('topic')->execute();
        Yii::$app->db->createCommand("SET foreign_key_checks = 1;")->execute();

        $topics=[
            ['title'=>'Front end'],
            ['title'=>'Back end'],
        ];

        $total = count($topics);
        $count = 1;
        Console::startProgress(0, $total, 'Insert Topics: ', false);
        
        // topics
        foreach ($topics as $data) {
            $topic = new Topic();
            $topic->attributes = $data;
            if (!$topic->save()) {
                var_dump($topic->errors);
            }
            Console::updateProgress($count++, $total);
        }
        Console::endProgress("done." . PHP_EOL);
    }

    public function createPosts()
    {
        Yii::$app->db->createCommand("SET foreign_key_checks = 0;")->execute();
        Yii::$app->db->createCommand()->truncateTable('post')->execute();
        Yii::$app->db->createCommand("SET foreign_key_checks = 1;")->execute();

        $topics = Topic::find()->indexBy('title')->all();
        $faker = Factory::create('fr-CH');
        $posts=[
            [
                'title'=>'Yii2',
                'topic_id'=> $topics['Back end']->id,
            ],
            [
                'title'=>'Angular',
                'topic_id'=> $topics['Front end']->id,
            ],
            [
                'title'=>'Reactjs',
                'topic_id'=> $topics['Front end']->id,
            ],
            [
                'title'=>'Vuejs',
                'topic_id'=> $topics['Front end']->id,
                'content'=> Html::tag('p', 'For vuejs front end I used:')
                .Html::beginTag('ul')
                .Html::tag('li', Html::a('vuex', 'https://vuex.vuejs.org/en/', ['target'=>'_blank']))
                .Html::tag('li', Html::a('vue-router', 'https://router.vuejs.org/en/', ['target'=>'_blank']))
                .Html::tag('li', Html::a('vue-mc', 'http://vuemc.io/', ['target'=>'_blank']))
                .Html::tag('li', Html::a('vuetifyjs', 'https://vuetifyjs.com/en/', ['target'=>'_blank']))
                .Html::endTag('ul'),
            ],
        ];

        $total = count($posts);
        $count = 1;
        Console::startProgress(0, $total, 'Insert Topics: ', false);
        
        // topics
        foreach ($posts as $data) {
            $post = new Post();
            $post->attributes = $data;
            if (!isset($data['content'])) {
                $post->content = Html::tag('p', join('</p><p>', $faker->sentences(rand(3, 5))));
            }
            if (!$post->save()) {
                var_dump($post->errors);
            }
            Console::updateProgress($count++, $total);
        }
        Console::endProgress("done." . PHP_EOL);
    }
    public function createComments()
    {
        Yii::$app->db->createCommand("SET foreign_key_checks = 0;")->execute();
        Yii::$app->db->createCommand()->truncateTable('comment')->execute();
        Yii::$app->db->createCommand("SET foreign_key_checks = 1;")->execute();

        $posts = Post::find()->select(['id'])->column();
        $faker = Factory::create('fr-CH');
        $total =50;
        $count = 1;
        Console::startProgress(0, $total, 'Insert Topics: ', false);
        
        // topics
        for ($i=0; $i < $total; $i++) {
            $comment = new Comment();
            $comment->content = Html::tag('p', join('</p><p>', $faker->sentences(rand(3, 5))));
            $comment->post_id = $posts[array_rand($posts)];
            if (!$comment->save()) {
                var_dump($comment->errors);
                var_dump($comment->attributes);
            }
            Console::updateProgress($count++, $total);
        }
        Console::endProgress("done." . PHP_EOL);
    }
}
