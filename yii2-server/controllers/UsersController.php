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

class UsersController extends ActiveController
{
    public $modelClass = 'app\models\User';
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
                'login',
                'create'
            ]
        ];
        return $behaviors;
    }
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
       
        $model = new LoginForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->login()) {
            $model->user->generateAccessToken();
            $model->user->save();
            // $response = Yii::$app->getResponse();
            // $response->setStatusCode(201);
            // $id = implode(',', array_values($model->getPrimaryKey(true)));
            // $response->getHeaders()->set('Location', Url::toRoute([''], true));
            return $model->user;
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }
    public function checkAccess($action, $model = null, $params = [])
    {
        // check if the user can access $action and $model
        // throw ForbiddenHttpException if access should be denied
        if ($action === 'update' || $action === 'delete') {
            if ($model->id !== Yii::$app->user->id){
                throw new \yii\web\ForbiddenHttpException(
                    sprintf('You can only %s articles that you\'ve created.', $action)
                );
            }
        }
    }
}
