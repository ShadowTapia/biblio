<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\historico\Historico;

/**
 * HistoricoSearch represents the model behind the search form of `app\models\historico\Historico`.
 */
class HistoricoSearch extends Historico
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idhistorico', 'idUser', 'idejemplar', 'fechapres', 'fechadev', 'fechadevReal', 'observacion', 'User', 'UserMail'], 'safe'],
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
        $query = Historico::find();

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
            'fechadevReal' => $this->fechadevReal,
        ]);

        $query->andFilterWhere(['like', 'idhistorico', $this->idhistorico])
            ->andFilterWhere(['like', 'idUser', $this->idUser])
            ->andFilterWhere(['like', 'idejemplar', $this->idejemplar])
            ->andFilterWhere(['like', 'observacion', $this->observacion])
            ->andFilterWhere(['like', 'User', $this->User])
            ->andFilterWhere(['like', 'UserMail', $this->UserMail]);

        return $dataProvider;
    }
}
