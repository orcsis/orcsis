<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\rbac\DbManager;

/**
 * This is the model class for table "osusuarios".
 *
 * @property integer $usu_id
 * @property string $usu_nomusu
 * @property string $usu_nombre
 * @property string $usu_clave
 * @property string $usu_feccre
 * @property string $usu_ulting
 * @property integer $usu_activo
 * @property string $usu_token
 * @property string $usu_ultemp
 * @property string $usu_foto
 * @property string $usu_name
 * @property string $usu_type
 * @property string $usu_size
 * @property string $uploadedFile
 */
class Osusuarios extends ActiveRecord implements IdentityInterface
{
	const ESTADO_ACTIVO = 1;
	const ESTADO_INACTIVO = 0;
	const ESTADO_SUSPENDIDO = 2;
	public $uploadedFile;
	public $roles;
	
    /**
     * @return string Nombre de La Tabla
     */
    public static function tableName()
    {
        return 'osusuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usu_nomusu'], 'required'],
            [['usu_feccre', 'usu_ulting'], 'safe'],
            ['usu_activo','default', 'value' => self::ESTADO_ACTIVO],
            ['usu_activo','in', 'range' => [self::ESTADO_ACTIVO, self::ESTADO_INACTIVO,self::ESTADO_SUSPENDIDO]],
            [['usu_foto'], 'safe'],
            ['uploadedFile', 'file', 'types' => 'jpg, gif, png'],
            [['usu_nomusu', 'usu_nombre', 'usu_clave', 'usu_name', 'usu_type', 'usu_size'], 'string', 'max' => 64],
            [['usu_token', 'usu_ultemp'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        	'usu_id' => \Yii::t('app', 'Id de Usuario'),
            'usu_nomusu' => \Yii::t('app', 'Nombre de Usuario (id)'),
            'usu_nombre' => \Yii::t('app', 'Nombre Completo del Usuario'),
            'usu_clave' => \Yii::t('app', 'Contraseña'),
            'usu_feccre' => \Yii::t('app', 'Fecha de Creación'),
            'usu_ulting' => \Yii::t('app', 'Último Ingreso'),
            'usu_activo' => \Yii::t('app', 'Estado del Usuario'),
            'usu_token' => \Yii::t('app', 'Token de autenticación API'),
            'usu_ultemp' => \Yii::t('app', 'Última Empresa ingresada'),
            'usu_foto' => \Yii::t('app', 'Fotografía del Usuario'),
            'usu_name' => \Yii::t('app', 'Nombre de la Fotografía'),
            'usu_type' => \Yii::t('app', 'Tipo de Archivo'),
            'usu_size' => \Yii::t('app', 'Tamaño del Archivo'),
        ];
    }
    
    /**
     * Crear nuevo usuario
     * @param array $atributos Atributos del usuario en arreglo asociativo
     * @return static|null el modelo del usuario creado
     */
    public static function create($atributos)
    {
    	$user = new static();
    	$user->setAttributes($atributos);
    	$user->setPassword($atributos['usu_clave']);
    	$user->removeToken();
    	if ($user->save()) {
    		return $user;
    	} else {
    		return null;
    	}
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
    	return [
    	'timestamp' => [
    	'class' => 'yii\behaviors\TimestampBehavior',
    	'attributes' => [
    	ActiveRecord::EVENT_BEFORE_INSERT => ['usu_feccre'],
    	],
    	],
    	];
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
    	return static::findOne(['usu_id' => $id, 'usu_activo' => self::ESTADO_ACTIVO]);
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token,$type = null)
    {
    	return static::findOne(['usu_token' => $token, 'usu_activo' => self::ESTADO_ACTIVO]);
    }
    
    /**
     * Finds user by username
     *
     * @param  string      $usu_nomusu
     * @return static|null
     */
    public static function findByUsername($username)
    {
    	return static::findOne(['usu_nomusu' => $username, 'usu_activo' => self::ESTADO_ACTIVO]);
    }
    
    /**
     * @inheritdoc
     */
    public function getId()
    {
    	return $this->usu_id;
    }
    
    /**
     * Valida la contraseña
     *
     * @param  string  $password Contraseña a validar
     * @return boolean si la contraseña es valida para el usuario actual
     */
    public function validatePassword($password)
    {
    	//\Yii::trace($this->usu_clave);
    	return Yii::$app->getSecurity()->validatePassword($password, $this->usu_clave);
    }
    
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
    	return $this->usu_token;
    }
    
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
    	return $this->getAuthKey() === $authKey;
    }
    
    /**
     * Genera un hash para la contraseña
     *
     * @param string $password Contraseña no cifrada
     */
    public function setPassword($password)
    {
    	$this->usu_clave = Yii::$app->getSecurity()->generatePasswordHash($password);
    }
    
    /**
     * Genera nuevo token de autenticación
     */
    public function generaToken()
    {
    	$this->usu_token = Yii::$app->getSecurity()->generateRandomKey() . '_' . time();
    }
    
    /**
     * Elimina el token de autenticación
     */
    public function removeToken()
    {
    	$this->usu_token = null;
    }
    
    /**
     * Verifica si se ha subido la fotografía del usuario
     */
    public function beforeSave($insert)
    {
    	if($file=UploadedFile::getInstance($this, 'uploadedFile'))
    	{
    		$this->usu_name = $file->name;
    		$this->usu_type = $file->type;
    		$this->usu_size = $file->size;
    		$this->usu_foto = file_get_contents($file->tempName);
    	}
    	
    	return parent::beforeSave($insert);
    }
    
    /**
     * Devuelve los campos que pasarán a JSON
     * @return $fields array
     */
    public function fields()
    {
    	$fields = parent::fields();
    	unset($fields['usu_clave']);
    	$fields['roles'] = function(){ return $this->roles;};
    	return $fields;
    }
    
    /**
     * Asigna la última empresa seleccionada
     */
    public function setEmpresa($empresa)
    {
    	$this->usu_ultemp = $empresa;
    }
    
    /**
     * Devuelve los roles del usuario
     * @return array
     */
    public function getRoles()
    {
    	$this->roles = DbManager::getRolesByUser($this->usu_id);
    	return $this->roles;
    }
    
}
