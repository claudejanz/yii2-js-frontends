<?php

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

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
            'Import Users',
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
            'default' => '1',
            'pattern' => $pattern,
            'error' => $error
        ]);

        $values = preg_split('@,@', $value, -1, PREG_SPLIT_NO_EMPTY);
        if (in_array('all', $values) || in_array('1', $values)) {
            $this->importUsers();
        }
       
        if (in_array('0', $values)) {
            $this->exitit();
        }

        echo $sep;
    }

    public function importUsers()
    {
        Yii::$app->db->createCommand("SET foreign_key_checks = 0;")->execute();
        Yii::$app->db->createCommand()->truncateTable('user')->execute();
        Yii::$app->db->createCommand("SET foreign_key_checks = 1;")->execute();

        $total = 2;
        $count = 1;
        Console::startProgress(0, $total, 'Insert Admins: ', false);
        $print = true;

        // les supers admin
        $admin = new User();
        $admin->scenario = User::SCENARIO_CREATE;
        $admin->attributes = [
            'username' => 'claudejanz',
            'firstname' => 'Claude',
            'lastname' => 'Janz',
            'address' => '8a chemin de la chenalette',
            'city_npa' => 'Prangins, 1197',
            'mobile' => '+41 22 369 05 85',
            'email' => 'claudejanz@bluewin.ch',
            'password' => '12345678',
            'role' => User::ROLE_SUPERADMIN,
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
            'role' => User::ROLE_SUPERADMIN,
            'status' => User::STATUS_ACTIVE,
        ];
        if (!$admin->save()) {
            var_dump($admin->errors);
        }
        
        Console::updateProgress($count++, $total);
        Console::endProgress("done." . PHP_EOL);
    }
}
