<?php

namespace app\models\ejemplar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ejemplar\Ejemplar;

/**
 * EjemplarSearch represents the model behind the search form of `app\models\ejemplar\Ejemplar`.
 */
class EjemplarSearch extends Ejemplar
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idejemplar', 'norden', 'edicion', 'ubicacion', 'idLibros', 'fechain', 'fechaout'], 'safe'],
            [['disponible'], 'integer','message'=>'Debe ser un valor entre 0 y 1'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Ejemplar::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,'pagination' => ['pagesize' => 50],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'fechain' => $this->fechain,
            'fechaout' => $this->fechaout,
            'disponible' => $this->disponible,
        ]);

        $query->andFilterWhere(['like', 'idejemplar', $this->idejemplar])
            ->andFilterWhere(['like', 'norden', $this->norden])
            ->andFilterWhere(['like', 'edicion', $this->edicion])
            ->andFilterWhere(['like', 'ubicacion', $this->ubicacion])
            ->andFilterWhere(['like', 'idLibros', $this->idLibros]);

        return $dataProvider;
    }
}
