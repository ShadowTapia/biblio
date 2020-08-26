<?php

namespace app\models\apoderados;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\apoderados\Apoderados;

/**
 * ApoderadosSearch represents the model behind the search form of `app\models\apoderados\Apoderados`.
 */
class ApoderadosSearch extends Apoderados
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rutapo', 'codRegion', 'idProvincia', 'codComuna', 'rutalumno', 'idApo'], 'integer'],
            [['digrut', 'nombreapo', 'apepat', 'apemat', 'calle', 'nro', 'depto', 'block', 'villa', 'fono', 'email', 'celular', 'estudios', 'niveledu', 'profesion', 'trabajoplace', 'relacion'], 'safe'],
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
        $query = Apoderados::find();

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
            'rutapo' => $this->rutapo,
            'codRegion' => $this->codRegion,
            'idProvincia' => $this->idProvincia,
            'codComuna' => $this->codComuna,
            'rutalumno' => $this->rutalumno,
            'idApo' => $this->idApo,
        ]);

        $query->andFilterWhere(['like', 'digrut', $this->digrut])
            ->andFilterWhere(['like', 'nombreapo', $this->nombreapo])
            ->andFilterWhere(['like', 'apepat', $this->apepat])
            ->andFilterWhere(['like', 'apemat', $this->apemat])
            ->andFilterWhere(['like', 'calle', $this->calle])
            ->andFilterWhere(['like', 'nro', $this->nro])
            ->andFilterWhere(['like', 'depto', $this->depto])
            ->andFilterWhere(['like', 'block', $this->block])
            ->andFilterWhere(['like', 'villa', $this->villa])
            ->andFilterWhere(['like', 'fono', $this->fono])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'celular', $this->celular])
            ->andFilterWhere(['like', 'estudios', $this->estudios])
            ->andFilterWhere(['like', 'niveledu', $this->niveledu])
            ->andFilterWhere(['like', 'profesion', $this->profesion])
            ->andFilterWhere(['like', 'trabajoplace', $this->trabajoplace])
            ->andFilterWhere(['like', 'relacion', $this->relacion]);

        return $dataProvider;
    }
}
