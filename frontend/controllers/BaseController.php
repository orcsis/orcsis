<?php

namespace frontend\controllers;

class BaseController extends \yii\web\Controller
{
	/**
	 * 
	 * */
	public function behaviors()
	{
		return [
			'empresa' => [
				'class' => 'orcsis\components\EmpresaControl',
			],
		];
	}

	public function actionIndex()
	{
		return $this->goHome();
	}
}
