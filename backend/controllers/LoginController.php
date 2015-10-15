<?php

namespace backend\controllers;

use yii\rest\ActiveController;
use common\models\LoginForm;
//use yii\filters\auth\HttpBasicAuth;

class LoginController extends ActiveController
{
	/**
	 * Clase del modelo de datos
	 * @var yii\db\ActiveRecord
	 */
	public $modelClass = 'common\models\Osusuarios';
	
	public function behaviors()
	{
    	$behaviors = parent::behaviors();
    	/*$behaviors['authenticator'] = [
        	'class' => HttpBasicAuth::className(),
    	];*/
    	return $behaviors;
	}

	public function actionLogin()
    {
        $model = new LoginForm();
        $data = \Yii::$app->getRequest()->getBodyParams();
        $mod = $model->load($data, '');
        //var_dump($model);
        if ($mod && $model->login())
        {
            $user = $model->getUser();
            \Yii::trace('Actualizo. Token Generado: '.$user->usu_token);
            return $user;
            //echo $user->usu_token;
        }
        else {
            return $model;
        }

    }
}