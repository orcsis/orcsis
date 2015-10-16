<?php

namespace common\models\empresa;

use Yii;
use yii\base\DynamicModel;

/**
 * This is the model class base for Company Data.
 *
 */
class Confemp extends DynamicModel
{

    /**
     * Constructors.
     * @param array $attributes the dynamic attributes (name-value pairs, or names) being defined
     * @param array $config the configuration array to be applied to this object.
     */
    public function __construct(array $attributes = [], $config = [])
    {
        $osconfemp = Osconfemp::find()->asArray()->all();
        foreach ($osconfemp as $object) {
            $attributes[$object['coe_nombre']] = Yii::$app->orcsis->getEmpVar($object['coe_nombre']);
        }
        parent::__construct($attributes, $config);
    }

    /**
     * @inheritdoc
     */
    public function getAttributeLabel($attribute)
    {
        $labels = $this->attributeLabels();
        return isset($labels[$attribute]) ? $labels[$attribute] : (Yii::$app->orcsis->getEmpVarLabel() != null ?
            Yii::$app->orcsis->getEmpVarLabel($attribute) : $this->generateAttributeLabel($attribute));
    }
}
