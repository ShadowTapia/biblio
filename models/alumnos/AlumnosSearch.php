<?php

namespace app\models\alumnos;

use app\models\apoderados\Apoderados;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\alumnos\Alumnos;

/**
 * AlumnosSearch represents the model behind the search form of `app\models\alumnos\Alumnos`.
 */
class AlumnosSearch extends Alumnos
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rutalumno', 'codRegion', 'idProvincia', 'codComuna'], 'integer'],
            [['digrut', 'sexo', 'nombrealu', 'paternoalu', 'maternoalu', 'calle', 'nro', 'depto', 'block', 'villa', 'email', 'fono', 'fechanac', 'nacionalidad', 'fechaing', 'fecharet', 'idalumno'], 'safe'],
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
     * Este search se encarga de buscar los alumnos y los apoderados en relación
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function searchListApoderados($params)
    {
        $query = Alumnos::find()->joinWith(['pivots pi'])
            ->where(['pi.idCurso' => $params])
            ->andWhere(['pi.idano' => \Yii::$app->session->get('anoActivo')])
            ->orderBy('paternoalu')->addOrderBy('maternoalu');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,'pagination' => ['pagesize' => 50],
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'rutalumno' => $this->rutalumno,
            'codRegion' => $this->codRegion,
            'idProvincia' => $this->idProvincia,
            'codComuna' => $this->codComuna,
            'fechanac' => $this->fechanac,
            'fechaing' => $this->fechaing,
            'fecharet' => $this->fecharet,
        ]);

        $query->andFilterWhere(['like', 'digrut', $this->digrut])
            ->andFilterWhere(['like', 'sexo', $this->sexo])
            ->andFilterWhere(['like', 'nombrealu', $this->nombrealu])
            ->andFilterWhere(['like', 'paternoalu', $this->paternoalu])
            ->andFilterWhere(['like', 'maternoalu', $this->maternoalu])
            ->andFilterWhere(['like', 'calle', $this->calle])
            ->andFilterWhere(['like', 'nro', $this->nro])
            ->andFilterWhere(['like', 'depto', $this->depto])
            ->andFilterWhere(['like', 'block', $this->block])
            ->andFilterWhere(['like', 'villa', $this->villa])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'fono', $this->fono])
            ->andFilterWhere(['like', 'nacionalidad', $this->nacionalidad])
            ->andFilterWhere(['like', 'idalumno', $this->idalumno]);


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
        $query = Alumnos::find()->joinWith(['pivots pi'])
            ->where(['pi.idCurso' => $params])
            ->andWhere(['idano' => \Yii::$app->session->get('anoActivo')])
            ->orderBy('paternoalu')->addOrderBy('maternoalu');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pagesize' => 50],
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'rutalumno' => $this->rutalumno,
            'codRegion' => $this->codRegion,
            'idProvincia' => $this->idProvincia,
            'codComuna' => $this->codComuna,
            'fechanac' => $this->fechanac,
            'fechaing' => $this->fechaing,
            'fecharet' => $this->fecharet,
        ]);

        $query->andFilterWhere(['like', 'digrut', $this->digrut])
            ->andFilterWhere(['like', 'sexo', $this->sexo])
            ->andFilterWhere(['like', 'nombrealu', $this->nombrealu])
            ->andFilterWhere(['like', 'paternoalu', $this->paternoalu])
            ->andFilterWhere(['like', 'maternoalu', $this->maternoalu])
            ->andFilterWhere(['like', 'calle', $this->calle])
            ->andFilterWhere(['like', 'nro', $this->nro])
            ->andFilterWhere(['like', 'depto', $this->depto])
            ->andFilterWhere(['like', 'block', $this->block])
            ->andFilterWhere(['like', 'villa', $this->villa])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'fono', $this->fono])
            ->andFilterWhere(['like', 'nacionalidad', $this->nacionalidad])
            ->andFilterWhere(['like', 'idalumno', $this->idalumno]);


        return $dataProvider;
    }

    /**
     * Se obtiene a través de esta función el nombre del apoderado
     * @param $id
     * @return null|string
     */
    public static function getNombreTrigger($id)
    {
        $model = Apoderados::find()->joinWith(['pivots pi'])
            ->where(['apoderado' => '1'])
            ->andWhere(['pi.idalumno' => $id])
            ->andWhere(['idano' => \Yii::$app->session->get('anoActivo')])->one();
        if(!empty($model))
        {
            return strtoupper($model->nombreapo . " " . $model->apepat . " " . $model->apemat);
        }
        return null;
    }
}
