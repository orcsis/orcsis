<?php
use kartik\datecontrol\Module;
use kartik\widgets\DynaGrid;
use kartik\grid\GridView;

$config = [];

    // Modulo yii2-admin (RBAC)
    $config['bootstrap'][] = 'admin';
    $config['modules']['admin'] = [ 'class' => 'orcsis\admin\Module',
    								'controllerMap' => [
    									'assigment' => [
											'class' => 'orcsis\admin\controllers\AssignmentController',
    										'idField' => 'usu_id',
    										'usernameField'=>'usu_nomusu',
    									]
    								]
								  ];
    $config['modules']['datecontrol'] = [ 'class' => 'kartik\datecontrol\Module',
    									  'displaySettings' => [
    									  	Module::FORMAT_DATE => 'd-M-Y',
    									  	Module::FORMAT_TIME => 'H:i:s A',
    									  	Module::FORMAT_DATETIME => 'd-M-Y H:i:s A',
    									  ],
    									  'autoWidget' => true,
    									  'widgetSettings' => [
											Module::FORMAT_DATE => [
												'class' => 'yii\jui\DatePicker',
												'options' => ['class' =>'form-control'],
												'clientOptions' => ['dateFormat' => 'dd-mm-yy'],
											]
    									  ]
										];
    $config['modules']['dynagrid'] = [ 'class' => '\kartik\dynagrid\Module',
    								   
									 ];
    $config['modules']['gridview'] = [ 'class' => '\kartik\grid\Module',
    								   
									 ];
    $config['modules']['utility'] = ['class' => 'c006\utility\migration\Module'];

return $config;
