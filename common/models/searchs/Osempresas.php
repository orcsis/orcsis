<?php

namespace common\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Osempresas as OsempresasModel;

/**
 * Osempresas represents the model behind the search form about `common\models\Osempresas`.
 */
class Osempresas extends OsempresasModel
{
    public function rules()
    {
        return [
            [['emp_codigo', 'emp_estado'], 'integer'],
            [['emp_nombre', 'emp_datos'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = OsempresasModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'emp_codigo' => $this->emp_codigo,
            'emp_estado' => $this->emp_estado,
        ]);

        $query->andFilterWhere(['like', 'emp_nombre', $this->emp_nombre])
            ->andFilterWhere(['like', 'emp_datos', $this->emp_datos]);

        return $dataProvider;
    }
}
