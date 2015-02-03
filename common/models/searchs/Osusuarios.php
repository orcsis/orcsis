<?php

namespace common\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Osusuarios as OsusuariosModel;

/**
 * Osusuarios represents the model behind the search form about `common\models\Osusuarios`.
 */
class Osusuarios extends OsusuariosModel
{
    public function rules()
    {
        return [
            [['usu_id', 'usu_activo'], 'integer'],
            [['usu_nomusu', 'usu_nombre', 'usu_clave', 'usu_feccre', 'usu_ulting', 'usu_token', 'usu_ultemp', 'usu_foto', 'usu_name', 'usu_type', 'usu_size'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = OsusuariosModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'usu_id' => $this->usu_id,
            'usu_feccre' => $this->usu_feccre,
            'usu_ulting' => $this->usu_ulting,
            'usu_activo' => $this->usu_activo,
        ]);

        $query->andFilterWhere(['like', 'usu_nomusu', $this->usu_nomusu])
            ->andFilterWhere(['like', 'usu_nombre', $this->usu_nombre])
            ->andFilterWhere(['like', 'usu_clave', $this->usu_clave])
            ->andFilterWhere(['like', 'usu_token', $this->usu_token])
            ->andFilterWhere(['like', 'usu_ultemp', $this->usu_ultemp])
            ->andFilterWhere(['like', 'usu_foto', $this->usu_foto])
            ->andFilterWhere(['like', 'usu_name', $this->usu_name])
            ->andFilterWhere(['like', 'usu_type', $this->usu_type])
            ->andFilterWhere(['like', 'usu_size', $this->usu_size]);

        return $dataProvider;
    }
}
