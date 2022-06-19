<?php

namespace app\models\libros;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\autor\Autor;

/**
 * LibrosSearch represents the model behind the search form of `app\models\libros\Libros`.
 */
class LibrosSearch extends Libros
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idLibros', 'titulo', 'subtitulo', 'descripcion', 'idioma', 'formato', 'idautor', 'imagen'], 'safe'],
            [['isbn', 'numpag', 'ano', 'idcategoria', 'ideditorial', 'idtemas'], 'integer'],
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
        $query = Libros::find()->orderBy('titulo');

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
            'isbn' => $this->isbn,
            'numpag' => $this->numpag,
            'ano' => $this->ano,
            'idcategoria' => $this->idcategoria,
            'ideditorial' => $this->ideditorial,
            'idtemas' => $this->idtemas,
        ]);

        $query->andFilterWhere(['like', 'idLibros', $this->idLibros])
            ->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'subtitulo', $this->subtitulo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'idioma', $this->idioma])
            ->andFilterWhere(['like', 'formato', $this->formato])
            ->andFilterWhere(['like', 'idautor', $this->idautor])
            ->andFilterWhere(['like', 'imagen', $this->imagen]);

        return $dataProvider;
    }

    public static function getNombreAutor($id)
    {
        $model = Autor::findOne(['idautor'=>$id]);
        if(!empty($model))
        {
            return strtoupper($model->nombre);
        }
        return null;
    }
}
