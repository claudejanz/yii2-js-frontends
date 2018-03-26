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

        $total = 76;
        $i = 1;
        Console::startProgress(0, $total, 'Init RBAC: ', false);
        try {
            $authManager->removeAll();





            // relational init
            // add the rule
            $authorRule = new AuthorRule;
            $authManager->add($authorRule);
            Console::updateProgress($i++, $total);
            
            $ownRule = new OwnRule;
            $authManager->add($ownRule);
            Console::updateProgress($i++, $total);
            
           









            /**
             * Rules for user
             */
            // create "user" permissions
            $userIndex = $authManager->createPermission('user index');
            Console::updateProgress($i++, $total);
            $userCreate = $authManager->createPermission('user create');
            Console::updateProgress($i++, $total);
            $userView = $authManager->createPermission('user view');
            Console::updateProgress($i++, $total);
            $userUpdate = $authManager->createPermission('user update');
            Console::updateProgress($i++, $total);
            $userDelete = $authManager->createPermission('user delete');
            Console::updateProgress($i++, $total);

            // add "user" permistions
            $authManager->add($userIndex);
            Console::updateProgress($i++, $total);
            $authManager->add($userCreate);
            Console::updateProgress($i++, $total);
            $authManager->add($userView);
            Console::updateProgress($i++, $total);
            $authManager->add($userUpdate);
            Console::updateProgress($i++, $total);
            $authManager->add($userDelete);
            Console::updateProgress($i++, $total);

            // add the "userOwnView" permission and associate the rule with it.
            $userOwnView = $authManager->createPermission('user own view');
            Console::updateProgress($i++, $total);
            $userOwnView->ruleName = $ownRule->name;
            $authManager->add($userOwnView);
            Console::updateProgress($i++, $total);
            $authManager->addChild($userOwnView, $userView);
            Console::updateProgress($i++, $total);

            // add the "userOwnUpdate" permission and associate the rule with it.
            $userOwnUpdate = $authManager->createPermission('user own update');
            Console::updateProgress($i++, $total);
            $userOwnUpdate->ruleName = $ownRule->name;
            $authManager->add($userOwnUpdate);
            Console::updateProgress($i++, $total);
            $authManager->addChild($userOwnUpdate, $userUpdate);
            Console::updateProgress($i++, $total);

            


            /**
             * Create roles and relations
             */
            // Create roles
            $client = $authManager->createRole(User::ROLE_CLIENT);
            Console::updateProgress($i++, $total);
            $admin = $authManager->createRole(User::ROLE_ADMIN);
            Console::updateProgress($i++, $total);
            $superadmin = $authManager->createRole(User::ROLE_SUPERADMIN);
            Console::updateProgress($i++, $total);

            // Add roles in Yii::$app->authManager
            $authManager->add($client);
            Console::updateProgress($i++, $total);
            $authManager->add($admin);
            Console::updateProgress($i++, $total);
            $authManager->add($superadmin);
            Console::updateProgress($i++, $total);


            // Client
            $parent = $client;
            
            $authManager->addChild($parent, $userOwnView);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $userOwnUpdate);
            Console::updateProgress($i++, $total);

            // Administrateur
            $parent = $admin;
            $authManager->addChild($parent, $client);
            Console::updateProgress($i++, $total);
            
            $authManager->addChild($parent, $userCreate);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $userView);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $userIndex);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $userUpdate);
            Console::updateProgress($i++, $total);
            $authManager->addChild($parent, $userDelete);
            Console::updateProgress($i++, $total);

            // Super Administrateur
            $parent = $superadmin;
            $authManager->addChild($parent, $admin);

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

            $users = User::find()->select('id')->where(['role' => User::ROLE_SUPERADMIN])->column();
            if ($users) {
                $role = $authManager->getRole(User::ROLE_SUPERADMIN);
                foreach ($users as $value) {
                    $authManager->assign($role, $value);
                }
            }
            Console::updateProgress($i++, $total);

            $users = User::find()->select('id')->where(['role' => User::ROLE_ADMIN])->column();
            if ($users) {
                $role = $authManager->getRole(User::ROLE_ADMIN);
                foreach ($users as $value) {
                    $authManager->assign($role, $value);
                }
            }
            Console::updateProgress($i++, $total);

            $users = User::find()->select('id')->where(['role' => User::ROLE_CLIENT])->column();
            if ($users) {
                $role = $authManager->getRole(User::ROLE_CLIENT);
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
