<?php

namespace app\models\temas;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TemasSearch represents the model behind the search form of `app\models\temas\Temas`.
 */
class TemasSearch extends Temas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idtemas'], 'integer'],
            [['nombre', 'codtemas'], 'safe'],
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
        $query = Temas::find();

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
            'idtemas' => $this->idtemas,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'codtemas', $this->codtemas]);

        return $dataProvider;
    }
}
