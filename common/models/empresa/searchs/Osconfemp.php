<?php

namespace common\models\empresa\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\empresa\Osconfemp as OsconfempModel;

/**
 * Osconfemp represents the model behind the search form about `common\models\empresa\Osconfemp`.
 */
class Osconfemp extends OsconfempModel
{
    public function rules()
    {
        return [
            [['coe_id', 'coe_tipo'], 'integer'],
            [['coe_nombre', 'coe_descri', 'coe_data'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = OsconfempModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'coe_id' => $this->coe_id,
            'coe_tipo' => $this->coe_tipo,
        ]);

        $query->andFilterWhere(['like', 'coe_nombre', $this->coe_nombre])
            ->andFilterWhere(['like', 'coe_descri', $this->coe_descri])
            ->andFilterWhere(['like', 'coe_data', $this->coe_data]);

        return $dataProvider;
    }
}
