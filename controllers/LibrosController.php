<?php

namespace app\controllers;

use Yii;
use app\models\libros\Libros;
use app\models\libros\LibrosSearch;
use app\models\libros\FormUpdateLibros;
use app\models\ejemplar\Ejemplar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use yii\base\Exception;

/**
 * LibrosController implements the CRUD actions for Libros model.
 */
class LibrosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Libros models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LibrosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     */
    public function actionConsulta()
    {
        $searchModel = new LibrosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('consulta',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Libros model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @return array|string
     * @throws Exception
     * @throws \Throwable
     */
    public function actionCreate()
    {
        $model = new Libros();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                $table = new Libros();
                $transaction = $table->getDb()->beginTransaction();
                try
                {
                    $table->isbn = $model->isbn;
                    $table->titulo = mb_strtoupper($model->titulo);
                    $table->subtitulo = $model->subtitulo;
                    $table->numpag = $model->numpag;
                    $table->ano = $model->ano;
                    $table->idioma = $model->idioma;
                    $table->formato = $model->formato;
                    $table->idcategoria = $model->idcategoria;
                    $table->ideditorial = $model->ideditorial;
                    $table->idautor = $model->idautor;
                    $table->idtemas = $model->idtemas;
                    $table->descripcion = $model->descripcion;
                    $librosId = $model->isbn;
                    $image = UploadedFile::getInstance($model,'imagen');
                    if (!is_null($image))
                    {
                        $imgName = $librosId . '.' . $image->getExtension();
                        $image->saveAs(Yii::getAlias('@libroImgPath') . '/' . $imgName);
                        $table->imagen = $imgName;
                    }
                    if($table->insert())
                    {
                        $transaction->commit();
                        \Yii::$app->session->setFlash('success','El Libro se ha ingresado exitosamente.-');

                    }else{
                        $transaction->rollBack();
                        \Yii::$app->session->setFlash('error','Error No se ha ingresado el Libro.-');
                    }
                    return $this->redirect(['libros/index']);
                }
                catch (Exception $e)
                {
                    $transaction->rollBack();
                    throw $e;
                }
                catch (\Throwable $e)
                {
                    $transaction->rollBack();
                    throw $e;
                }
            }else{
                $model->getErrors();
            }
        }

        return $this->render('create', ['model' => $model,]);

    }

    /**
     * @param $id
     * @return array|string
     * @throws Exception
     * @throws \Throwable
     */
    public function actionUpdate($id)
    {
        $model = new FormUpdateLibros();
        $table = new Libros();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                $transaction = $table->getDb()->beginTransaction();
                try
                {
                    $table = Libros::findOne(['idLibros' => $id]);
                    if ($table)
                    {
                        $table->isbn = $model->isbn;
                        $table->titulo = mb_strtoupper($model->titulo);
                        $table->subtitulo = $model->subtitulo;
                        $table->numpag = $model->numpag;
                        $table->ano = $model->ano;
                        $table->idioma = $model->idioma;
                        $table->formato = $model->formato;
                        $table->idcategoria = $model->idcategoria;
                        $table->ideditorial = $model->ideditorial;
                        $table->idtemas = $model->idtemas;
                        $table->idautor = $model->idautor;
                        $table->descripcion = $model->descripcion;
                        if($table->update())
                        {
                            $transaction->commit();
                            \Yii::$app->session->setFlash('success','El Libro se ha actualizado exitosamente.-');
                        }else{
                            $transaction->rollBack();
                            \Yii::$app->session->setFlash('error','No se ha actualizado el Libro.-');
                        }
                        return $this->redirect(['libros/index']);
                    }
                }
                catch (Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
                catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }else{
                $model->getErrors();
            }
        }else{
            $table = Libros::findOne(['idLibros' => $id]);
            if($table)
            {
                $model->isbn = $table->isbn;
                $model->titulo = $table->titulo;
                $model->subtitulo = $table->subtitulo;
                $model->numpag = $table->numpag;
                $model->ano = $table->ano;
                $model->idioma = $table->idioma;
                $model->formato = $table->formato;
                $model->idcategoria = $table->idcategoria;
                $model->ideditorial = $table->ideditorial;
                $model->idtemas = $table->idtemas;
                $model->idautor = $table->idautor;
                $model->descripcion = $table->descripcion;
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return Response
     * @throws Exception
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        //Se debe verificar la existencia de ejemplares asociados
        $tableEjemplar = Ejemplar::find()->where("idLibros=:idLibros",[":idLibros" => $id]);
        if ($tableEjemplar->count()>0)
        {
            \Yii::$app->session->setFlash('error', 'Ocurrió un error, existen ejemplares asociadas a este Libro.-');
            return $this->redirect(['index']);
        }else{
            $table = new Libros();
            $transaction = $table->getDb()->beginTransaction();
            try
            {
                if ($table->deleteAll("idLibros=:idLibros",[":idLibros" => $id]))
                {
                    $transaction->commit();
                    \Yii::$app->session->setFlash('success', 'Se ha borrado correctamente el Libro '. $table->titulo);
                }else{
                    $transaction->rollBack();
                    \Yii::$app->session->setFlash('error', 'Ocurrió un error, no se borro el Libro.-');
                }
            }
            catch (Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
            catch (\Throwable $e)
            {
                $transaction->rollBack();
                throw $e;
            }
            return $this->redirect(['index']);
        }

    }

    /**
     * Finds the Libros model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Libros the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Libros::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
