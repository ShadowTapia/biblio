<?php

namespace app\models\prestamos;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PrestamosSearch represents the model behind the search form of `app\models\prestamos\Prestamos`.
 */
class PrestamosSearch extends Prestamos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idPrestamo', 'idUser', 'idejemplar', 'norden', 'fechapres', 'fechadev', 'notas'], 'safe'],
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
        $query = Prestamos::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'fechapres' => $this->fechapres,
            'fechadev' => $this->fechadev,
        ]);

        $query->andFilterWhere(['like', 'idPrestamo', $this->idPrestamo])
            ->andFilterWhere(['like', 'idUser', $this->idUser])
            ->andFilterWhere(['like', 'idejemplar', $this->idejemplar])
            ->andFilterWhere(['like', 'norden', $this->norden])
            ->andFilterWhere(['like', 'notas', $this->notas]);

        return $dataProvider;
    }
}
