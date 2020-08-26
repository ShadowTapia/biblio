<?php

namespace app\models\autor;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\autor\Autor;

/**
 * AutorSearch represents the model behind the search form of `app\models\autor\Autor`.
 */
class AutorSearch extends Autor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idautor', 'nombre', 'nacionalidad'], 'safe'],
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
        $query = Autor::find()->orderBy('nombre');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pagesize' => 50],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'idautor', $this->idautor])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'nacionalidad', $this->nacionalidad]);

        return $dataProvider;
    }

    public static function getAutorTrigger($id)
    {
        $model = Autor::find()->where("idautor=:idautor",[":idautor" => $id])->one();
        if(!empty($model))
        {
            return $model->nombre;
        }
        return null;
    }
}
