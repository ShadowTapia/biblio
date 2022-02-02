<?php

namespace app\models\apoderados;

use app\models\alumnos\Alumnos;
use yii\base\Model;
use yii\data\ActiveDataProvider;


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
            [['digrut', 'nombreapo', 'apepat', 'apemat', 'calle', 'nro', 'depto', 'block', 'villa','email', 'fono', 'celular', 'estudios', 'niveledu', 'profesion', 'trabajoplace', 'relacion'], 'safe'],
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
     * @param $id
     * @return null|string
     * Se encarga de devolver el nombre del alumno asociado a un apoderado
     */
    public static function getNameTrigger($id)
    {
        $model = Alumnos::find()->joinWith(['pivots pi'])
            ->where(['rutalumno' => $id])
            ->andWhere(['pi.idano' => \Yii::$app->session->get('anoActivo')])->one();
        if(!empty($model))
        {
            return strtoupper($model->nombrealu . " " . $model->paternoalu . " " . $model->maternoalu);
        }
        return null;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function searchListaApos($params)
    {
        $query = Apoderados::find()->joinWith(['pivots pi'])
            ->where(['pi.idCurso' => $params])
            ->andWhere(['pi.retirado' => '0'])
            ->andWhere(['pi.idano' => \Yii::$app->session->get('anoActivo')])
            ->orderBy('apepat')->addOrderBy('apemat');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,'pagination' => ['pagesize' => 50],
        ]);

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
