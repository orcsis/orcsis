<?php

namespace common\models;

use Yii;
use \yii\helpers\ArrayHelper;

/**
 * This is the model class for table "osempresas".
 *
 * @property integer $emp_codigo
 * @property string $emp_nombre
 * @property string $emp_datos
 * @property integer $emp_estado
 */
class Osempresas extends \yii\db\ActiveRecord
{
	const ESTADO_ACTIVO = 1;
	const ESTADO_INACTIVO = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'osempresas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_nombre','emp_datos'], 'required'],
            [['emp_estado'], 'integer'],
            [['emp_nombre'], 'string', 'max' => 50],
            [['emp_datos'], 'string', 'max' => 20],
            [['emp_datos'], 'unique'],
            ['emp_estado','default', 'value' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'emp_codigo' => Yii::t('admin', 'Código de Empresa'),
            'emp_nombre' => Yii::t('admin', 'Nombre de Empresa'),
            'emp_datos' => Yii::t('admin', 'Base de Datos de la Empresa'),
            'emp_estado' => Yii::t('admin', 'Activo'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function selEmpresa()
    {
        if(!(!Yii::$app->user->isGuest && ( (Yii::$app->user->identity->usu_ultemp == null || Yii::$app->user->identity->usu_ultemp == 0) || (Yii::$app->session->hasFlash('SelEmpresa') && Yii::$app->session->getFlash('SelEmpresa')))))
        {
            return false;
        }

        $empresas = self::getEmpresas();

        if(count($empresas) < 1)
        {
            Yii::$app->session->setFlash('danger',Yii::t('app','No access to companies or not created'));
            return false;
        }

        if(count($empresas) == 1)
        {
            $user = Yii::$app->user->getidentity();
            $user->setEmpresa(key($empresas));
            $user->save();
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public static function getEmpresas()
    {
    	$empresas = self::find()->select(['emp_codigo','emp_nombre'])->where(['emp_estado' => self::ESTADO_ACTIVO])->asArray()->all();
    	$permitidas = [];
    	if (Yii::$app->user->can(self::tableName() . '_*')) 
    	{
    		$permitidas = $empresas;
    	}
    	else 
    	{
    		foreach ($empresas as $empresa) {
    			Yii::trace(self::className() . '_' . $empresa['emp_codigo']);
    			if (Yii::$app->user->can(self::tableName() . '_' . $empresa['emp_codigo']))
    			{
    				$permitidas[] = $empresa;
    			}
    		}
    	}
    	
        return ArrayHelper::map($permitidas,'emp_codigo', 'emp_nombre');
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
    	$auth = Yii::$app->authManager;
    	if ($insert)
    	{
    		$this->createPermission($auth);
    		$db = $this->getDb();

    		$transaction = $db->beginTransaction();
    		try {
    			$sql1 = 'CREATE DATABASE '. $this->emp_datos;
    			$db->createCommand($sql1)->execute();
    			$transaction->commit();
    		} catch(\Exception $e) {
    			$transaction->rollBack();
    			throw $e;
    		
    		}
    	}
    	else 
    	{
    		$rolEmpresa = $auth->getPermission(self::tableName() . '_' . (isset($changedAttributes['emp_codigo']) ? $changedAttributes['emp_codigo'] : $this->emp_codigo));
    		if (!$rolEmpresa)
    		{
    			$this->createPermission($auth);
    		}
    		else
    		{
    			$rolEmpresa->name = $this->permissionName;
    			$rolEmpresa->description = $this->emp_nombre;
    			$auth->update(self::tableName() . '_' . (isset($changedAttributes['emp_codigo']) ? $changedAttributes['emp_codigo'] : $this->emp_codigo), $rolEmpresa);
    		}
    	}

    	return parent::afterSave($insert, $changedAttributes);
    }

    /**
    * @inheritdoc
    */
    public function afterDelete()
    {
    	$auth = Yii::$app->authManager;
    	$rolEmpresa = $auth->getPermission($this->permissionName);
    	$auth->remove($rolEmpresa);
    	$db = $this->getDb();

    	$transaction = $db->beginTransaction();
    	try {
    		$sql1 = 'DROP DATABASE '. $this->emp_datos;
    		$db->createCommand($sql1)->execute();
    		$transaction->commit();
    	} catch(\Exception $e) {
    		$transaction->rollBack();
    		throw $e;
    		
    	}

    	return parent::afterDelete();
    }

    /**
    * @inheritdoc
    */
    private function createPermission($auth)
    {
    	$rolEmpresas = $auth->getPermission($this->tableName() . '_*');
    	if (!$rolEmpresas)
    	{
   			$rolEmpresas = $auth->createPermission($this->tableName() . '_*');
   			$rolEmpresas->description = Yii::t('app','All companies');
   			$auth->add($rolEmpresas);
   		}
    	$creaEmpresa = $auth->createPermission($this->permissionName);
    	$creaEmpresa->description = $this->emp_nombre;
    	$auth->add($creaEmpresa);
    	$auth->addChild($rolEmpresas,$creaEmpresa);
    }

    /**
    * @inheritdoc
    */
    public function getPermissionName()
    {
    	return $this->tableName() . '_' . $this->emp_codigo;
    }
}
