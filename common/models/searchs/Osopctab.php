<?php

namespace common\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Osopctab as OsopctabModel;

/**
 * Osopctab represents the model behind the search form about `common\models\Osopctab`.
 */
class Osopctab extends OsopctabModel
{
    public function rules()
    {
        return [
            [['opt_id', 'opt_opcion'], 'integer'],
            [['opt_tabla', 'opt_campo', 'opt_descri'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = OsopctabModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'opt_id' => $this->opt_id,
            'opt_opcion' => $this->opt_opcion,
        ]);

        $query->andFilterWhere(['like', 'opt_tabla', $this->opt_tabla])
            ->andFilterWhere(['like', 'opt_campo', $this->opt_campo])
            ->andFilterWhere(['like', 'opt_descri', $this->opt_descri]);

        return $dataProvider;
    }
}
