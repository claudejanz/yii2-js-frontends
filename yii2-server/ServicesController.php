<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\filters\Cors;
use yii\web\Controller;

/**
 * Services Controller
 */
class ServicesController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * {@inheritDoc}
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class'=>Cors::class,
                'cors' => [
                    // restrict access to
                    'Origin' => ['*'],
                    'Access-Control-Request-Headers' => ['*']
                    // 'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                ],
    
            ],
            'contentNegotiator'=>[
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    /**
     * Register action
     *
     * @return void
     */
    public function actionRegister()
    {
        return ['email'=>'claudejanz@gmail.com','name'=>'Claude Janz'];
    }
}
