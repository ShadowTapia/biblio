<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchUsers represents the model behind the search form of `app\models\Users`.
 */
class SearchUsers extends Users
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idUser', 'UserName', 'UserLastName', 'UserPass', 'UserMail', 'authkey', 'accessToken', 'activate', 'verification_code'], 'safe'],
            [['Idroles', 'UserRut'], 'integer'],
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
        $query = Users::find();

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

        $dataProvider->sort->defaultOrder = ['UserLastName' => SORT_ASC];

        // grid filtering conditions
        $query->andFilterWhere([
            'Idroles' => $this->Idroles,
            'UserRut' => $this->UserRut,
        ]);

        $query->andFilterWhere(['like', 'idUser', $this->idUser])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'UserLastName', $this->UserLastName])
            ->andFilterWhere(['like', 'UserPass', $this->UserPass])
            ->andFilterWhere(['like', 'UserMail', $this->UserMail])
            ->andFilterWhere(['like', 'authkey', $this->authkey])
            ->andFilterWhere(['like', 'accessToken', $this->accessToken])
            ->andFilterWhere(['like', 'activate', $this->activate])
            ->andFilterWhere(['like', 'verification_code', $this->verification_code]);

        return $dataProvider;
    }
}
