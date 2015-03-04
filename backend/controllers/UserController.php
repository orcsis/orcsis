<?php

namespace backend\controllers;

use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use common\models\LoginForm;
use yii\filters\auth\HttpBasicAuth;

class UserController extends ActiveController
{
	/**
	 * Clase del modelo de datos
	 * @var yii\db\ActiveRecord
	 */
	public $modelClass = 'common\models\Osusuarios';
	
	public function behaviors()
	{
    	$behaviors = parent::behaviors();
    	$behaviors['authenticator'] = [
        	'class' => HttpBasicAuth::className(),
    	];
    	return $behaviors;
	}

	/**
	 * Realiza el login y retorna el token de autenticación
	 * Usuario y contraseña por POST requerido
	 * @return \yii\db\ActiveRecordInterface usuario que será utilizado
	 */
	public function actionLogin()
	{
		$data = \Yii::$app->getRequest()->getBodyParams();
		$model = new LoginForm();
		$mod = $model->load($data, '');
		//var_dump($model);
		if ($mod && $model->login())
		{
			$user = $model->getUser();
			/*if ($this->checkAccess) {
				call_user_func($this->checkAccess, $this->id, $user);
			}*/
			$user->usu_ulting = date('Y-m-d H:i:s');
			$user->generaToken();
			$update = $user->update();
			\Yii::trace('Actualizo: '.$update.' Token Generado: '.$user->usu_token);
			return $user;
		}
	}
}