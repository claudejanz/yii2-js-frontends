<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\filters\Cors;
use app\models\LoginForm;
use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\web\ServerErrorHttpException;

/**
 * Undocumented class
 */
class TopicsController extends ActiveController
{
    public $modelClass = 'app\models\Topic';
    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
        \Yii::$app->user->loginUrl = null;
    }
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // core filter has to be first
        $behaviors = \array_merge([
            'corsFilter'=>[
                'class'=>Cors::class,
                'cors' => [
                    // restrict access to
                    'Origin' => ['*'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                ],
            ]
        ], $behaviors);
        // authentificator add exception for login and register
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                // HttpBasicAuth::class,
                // HttpBearerAuth::class,
                QueryParamAuth::class,
            ],
            'optional' => [
                'index',
                'view',
                'create',
            ]
        ];
        return $behaviors;
    }
   
    public function checkAccess($action, $model = null, $params = [])
    {
        // check if the user can access $action and $model
        // throw ForbiddenHttpException if access should be denied
        if ($action === 'update' || $action === 'delete') {
            if ($model->id !== Yii::$app->user->id) {
                throw new \yii\web\ForbiddenHttpException(
                    sprintf('You can only %s articles that you\'ve created.', $action)
                );
            }
        }
    }
}
