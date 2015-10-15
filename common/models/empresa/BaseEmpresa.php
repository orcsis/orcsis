<?php

namespace common\models\empresa;

use Yii;

/**
 * This is the model class base for Company Data.
 *
 */
class BaseEmpresa extends \yii\db\ActiveRecord
{

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
    	if(Yii::$app->db2->isActive)
    	{
    		return Yii::$app->db2;
    	}
    	else 
    	{
    		$dsn = 'mysql:host=localhost;dbname='.Yii::$app->user->identity->osempresa->emp_datos;
    		Yii::$app->db2->dsn = $dsn;
    		Yii::$app->db2->open();
    	}
    	return Yii::$app->db2;
    }
}
