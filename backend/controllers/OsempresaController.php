<?php

namespace backend\controllers;

use yii\rest\ActiveController;
use common\models\Osempresas;

class OsempresaController extends ActiveController
{
	/**
	 * Clase del modelo de datos
	 * @var yii\db\ActiveRecord
	 */
	public $modelClass = 'common\models\Osempresas';
	
	public function behaviors()
	{
    	$behaviors = parent::behaviors();
    	/*$behaviors['authenticator'] = [
        	'class' => HttpBasicAuth::className(),
    	];*/
    	return $behaviors;
	}

	/*public function actionEmpresas()
    {
        $model = new Osempresas();
        $model = 

    }*/
}