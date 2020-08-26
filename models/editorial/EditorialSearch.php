<?php

namespace app\models\editorial;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\editorial\Editorial;

/**
 * EditorialSearch represents the model behind the search form of `app\models\editorial\Editorial`.
 */
class EditorialSearch extends Editorial
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ideditorial'], 'integer'],
            [['nombre', 'direccion', 'telefono', 'mail'], 'safe'],
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
        $query = Editorial::find()->orderBy('nombre');

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
            'ideditorial' => $this->ideditorial,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'mail', $this->mail]);

        return $dataProvider;
    }
}
