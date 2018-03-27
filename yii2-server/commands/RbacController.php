<?php

namespace app\commands;

use app\models\User;
use app\rbac\AuthorRule;
use app\rbac\OwnRule;
use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\Console;

/**
 * Description of RbacController
 *
 * @author claude janz <claude.janz@gmail.com>
 */
class RbacController extends Controller
{

    public function actionIndex()
    {
        $assets = [
            'Exit',
            'Init RBAC',
            'Assign RBAC',
        ];
        $sep = '----------------------------------------------' . PHP_EOL;
        $message = $sep;
        $message .= 'What do you want to do?' . PHP_EOL;
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
            $this->actionInit();
        }
        if (in_array('all', $values) || in_array('2', $values)) {
            $this->actionAssign();
        }
        if (in_array('0', $values)) {
            $this->exitit();
        }

        echo $sep;
    }

    /**
     * Initialises RBAC strucutes
     * @throws Exception
     */
    public function actionInit()
    {
        $authManager = Yii::$app->authManager;

        $total = 48;
        $i = 1;
        Console::startProgress(0, $total, 'Init RBAC: ', false);
        try {
            $authManager->removeAll();



            /**
             * Create Permissions
             */
            
            // add own rule for users
            $ownRule = new OwnRule;
            $authManager->add($ownRule);
            Console::updateProgress($i++, $total);

            // add author rule for posts and comments
            $authorRule = new AuthorRule;
            $authManager->add($authorRule);
            Console::updateProgress($i++, $total);
            
            // create and add "user" permissions
            $userIndex = $authManager->createPermission('user index');
            $authManager->add($userIndex);
            Console::updateProgress($i++, $total);
            $userCreate = $authManager->createPermission('user create');
            $authManager->add($userCreate);
            Console::updateProgress($i++, $total);
            $userView = $authManager->createPermission('user view');
            $authManager->add($userView);
            Console::updateProgress($i++, $total);
            $userUpdate = $authManager->createPermission('user update');
            $authManager->add($userUpdate);
            Console::updateProgress($i++, $total);
            $userDelete = $authManager->createPermission('user delete');
            $authManager->add($userDelete);
            Console::updateProgress($i++, $total);


            // create, add the "user own update" permission and associate the parent rule.
            $userOwnUpdate = $authManager->createPermission('user own update');
            $userOwnUpdate->ruleName = $ownRule->name;
            $authManager->add($userOwnUpdate);
            $authManager->addChild($userOwnUpdate, $userUpdate);
            Console::updateProgress($i++, $total);

            // create and add "topic" permissions
            $topicIndex = $authManager->createPermission('topic index');
            $authManager->add($topicIndex);
            Console::updateProgress($i++, $total);
            $topicCreate = $authManager->createPermission('topic create');
            $authManager->add($topicCreate);
            Console::updateProgress($i++, $total);
            $topicUpdate = $authManager->createPermission('topic update');
            $authManager->add($topicUpdate);
            Console::updateProgress($i++, $total);
            $topicDelete = $authManager->createPermission('topic delete');
            $authManager->add($topicDelete);
            Console::updateProgress($i++, $total);

            // create and add "post" permissions
            $postIndex = $authManager->createPermission('post index');
            $authManager->add($postIndex);
            Console::updateProgress($i++, $total);
            $postCreate = $authManager->createPermission('post create');
            $authManager->add($postCreate);
            Console::updateProgress($i++, $total);
            $postUpdate = $authManager->createPermission('post update');
            $authManager->add($postUpdate);
            Console::updateProgress($i++, $total);
            $postDelete = $authManager->createPermission('post delete');
            $authManager->add($postDelete);
            Console::updateProgress($i++, $total);

            // create, add the "post own update" permission and associate the parent rule.
            $postOwnUpdate = $authManager->createPermission('post own update');
            $postOwnUpdate->ruleName = $authorRule->name;
            $authManager->add($postOwnUpdate);
            $authManager->addChild($postOwnUpdate, $postUpdate);
            Console::updateProgress($i++, $total);
            
            // create, add the "post own delete" permission and associate the parent rule.
            $postOwnDelete = $authManager->createPermission('post own delete');
            $postOwnDelete->ruleName = $authorRule->name;
            $authManager->add($postOwnDelete);
            $authManager->addChild($postOwnDelete, $postDelete);
            Console::updateProgress($i++, $total);

            // create and add "comment" permissions
            $commentIndex = $authManager->createPermission('comment index');
            $authManager->add($commentIndex);
            Console::updateProgress($i++, $total);
            $commentCreate = $authManager->createPermission('comment create');
            $authManager->add($commentCreate);
            Console::updateProgress($i++, $total);
            $commentUpdate = $authManager->createPermission('comment update');
            $authManager->add($commentUpdate);
            Console::updateProgress($i++, $total);
            $commentDelete = $authManager->createPermission('comment delete');
            $authManager->add($commentDelete);
            Console::updateProgress($i++, $total);
            
            // create, add the "comment own update" permission and associate the parent rule.
            $commentOwnUpdate = $authManager->createPermission('comment own update');
            $commentOwnUpdate->ruleName = $authorRule->name;
            $authManager->add($commentOwnUpdate);
            $authManager->addChild($commentOwnUpdate, $commentUpdate);
            Console::updateProgress($i++, $total);

            // create, add the "comment own delete" permission and associate the parent rule.
            $commentOwnDelete = $authManager->createPermission('comment own delete');
            $commentOwnDelete->ruleName = $authorRule->name;
            $authManager->add($commentOwnDelete);
            $authManager->addChild($commentOwnDelete, $commentDelete);
            Console::updateProgress($i++, $total);


            /**
             * Create roles and relations
             */
            // Create and add roles
            $user = $authManager->createRole(User::ROLE_USER);
            $authManager->add($user);
            Console::updateProgress($i++, $total);
            $admin = $authManager->createRole(User::ROLE_ADMIN);
            $authManager->add($admin);
            Console::updateProgress($i++, $total);

            // add permissions to user role
            $parent = $user;
            
            // add own user
            $authManager->addChild($parent, $userOwnUpdate);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $postOwnUpdate);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $postOwnDelete);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $commentOwnUpdate);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $commentOwnDelete);
            Console::updateProgress($i++, $total);

            // add permissions to admin role
            $parent = $admin;

            // heritate user role
            $authManager->addChild($parent, $user);
            Console::updateProgress($i++, $total);
            
            // add full access to users
            $authManager->addChild($parent, $userCreate);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $userIndex);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $userUpdate);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $userDelete);
            Console::updateProgress($i++, $total);

            // add full access to topic
            $authManager->addChild($parent, $topicCreate);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $topicIndex);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $topicUpdate);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $topicDelete);
            Console::updateProgress($i++, $total);
            
            // add full access to post
            $authManager->addChild($parent, $postCreate);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $postIndex);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $postUpdate);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $postDelete);
            Console::updateProgress($i++, $total);
            
            // add full access to comment
            $authManager->addChild($parent, $commentCreate);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $commentIndex);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $commentUpdate);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $commentDelete);
            Console::updateProgress($i++, $total);

            Console::endProgress("done." . PHP_EOL);

            // allow "author" to update their own dispos
        } catch (Exception $e) {
            throw new $e;
        }
    }

    /**
     * Assigns user to roles
     *
     * @throws Exception
     */
    public function actionAssign()
    {
        $authManager = Yii::$app->authManager;


        $total = 5;
        $i = 1;
        try {
            Console::startProgress(0, $total, 'Assign RBAC: ', false);

            $users = User::find()->select('id')->where(['role' => User::ROLE_ADMIN])->column();
            if ($users) {
                $role = $authManager->getRole(User::ROLE_ADMIN);
                foreach ($users as $value) {
                    $authManager->assign($role, $value);
                }
            }
            Console::updateProgress($i++, $total);

            $users = User::find()->select('id')->where(['role' => User::ROLE_USER])->column();
            if ($users) {
                $role = $authManager->getRole(User::ROLE_USER);
                foreach ($users as $value) {
                    $authManager->assign($role, $value);
                }
            }
            Console::updateProgress($i++, $total);

            Console::endProgress("done." . PHP_EOL);

            echo $this->ansiFormat('Structure recreated' . PHP_EOL, Console::FG_YELLOW);
        } catch (Exception $ex) {
            throw new $ex;
        }
    }
}
