<?php

namespace common\models\empresa;

use Yii;

/**
 * This is the model class for table "osconfemp".
 *
 * @property integer $coe_id
 * @property string $coe_nombre
 * @property string $coe_descri
 * @property integer $coe_tipo
 * @property string $coe_data
 */
class Osconfemp extends \common\models\empresa\BaseEmpresa
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'osconfemp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['coe_tipo'], 'integer'],
            [['coe_data'], 'string'],
            [['coe_nombre'], 'string', 'max' => 45],
            [['coe_descri'], 'string', 'max' => 60],
            [['coe_nombre'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'coe_id' => Yii::t('admin', 'Configuración'),
            'coe_nombre' => Yii::t('admin', 'Nombre/Variable'),
            'coe_descri' => Yii::t('admin', 'Descripción'),
            'coe_tipo' => Yii::t('admin', 'Tipo de Dato'),
            'coe_data' => Yii::t('admin', 'Coe Data'),
        ];
    }
}
