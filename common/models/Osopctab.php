<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "osopctab".
 *
 * @property integer $opt_id
 * @property string $opt_tabla
 * @property string $opt_campo
 * @property integer $opt_opcion
 * @property string $opt_descri
 */
class Osopctab extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'osopctab';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['opt_opcion'], 'integer'],
            [['opt_tabla', 'opt_campo'], 'string', 'max' => 45],
            [['opt_descri'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'opt_id' => Yii::t('admin', 'Opt ID'),
            'opt_tabla' => Yii::t('admin', 'Tabla'),
            'opt_campo' => Yii::t('admin', 'Campo'),
            'opt_opcion' => Yii::t('admin', 'Opción'),
            'opt_descri' => Yii::t('admin', 'Descripción'),
        ];
    }
}
