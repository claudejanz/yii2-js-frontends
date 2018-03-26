<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Provides content
 *
 * @author Claude
 */
class DropTablesController extends Controller
{

    /**
     * Provides content
     */
    public function actionIndex()
    {
        $assets = [
            'Exit',
            'DropTable',
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
            'default' => '0',
            'pattern' => $pattern,
            'error' => $error
        ]);

        $values = preg_split('@,@', $value, -1, PREG_SPLIT_NO_EMPTY);
        if (in_array('all', $values) || in_array('1', $values)) {
            $this->dropTables();
        }

        if (in_array('0', $values)) {
            $this->exitit();
        }

        echo $sep;
    }

    public function dropTables()
    {
        Yii::$app->db->createCommand("SET foreign_key_checks = 0;")->execute();
        $tables = Yii::$app->db->schema->getTableNames();
        foreach ($tables as $table) {
            Yii::$app->db->createCommand()->dropTable($table)->execute();
        }
        Yii::$app->db->createCommand("SET foreign_key_checks = 1;")->execute();
    }
    public function exitit()
    {
        echo $this->ansiFormat('See you again' . PHP_EOL, Console::FG_YELLOW);
    }
}
