<?php

namespace app\controllers;

use app\models\Apoderados\FormApoRegister;
use app\models\Comunas;
use app\models\pivot\Pivot;
use app\models\Provincias;
use Yii;
use app\models\apoderados\Apoderados;
use app\models\apoderados\ApoderadosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\helpers\Json;

/**
 * ApoderadosController implements the CRUD actions for Apoderados model.
 */
class ApoderadosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Apoderados models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApoderadosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Apoderados model.
     * @param integer $id
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
     * Creates a new Apoderados model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Apoderados();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idApo]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @param $run
     * @return array|string|Response
     * @throws \Exception
     * @throws \Throwable
     * Se encarga de ingresar un apoderado
     */
    public function actionIngresaapo($id,$run)
    {
        $model = new FormApoRegister();

        $db = Yii::$app->db;
        $tableApoderados = new Apoderados();
        $tablePivot = new Pivot();

        //validación mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()))        {

            if ($model->validate())
            {
                $transaction = $db->beginTransaction();
                try
                {
                    if($model->apoderado=='1')
                    {
                        $apoasign = true;
                    }
                    else
                    {
                        $apoasign = false;
                    }
                    $sql = $db->createCommand()->insert('apoderados',[
                       'rutapo' => $this->quitarStringless($model->rutapo),
                       'digrut' => $this->devolverVerificador($model->rutapo),
                       'nombreapo' => $model->nombreapo,
                       'apepat' => $model->apepat,
                       'apemat' => $model->apemat,
                       'calle' => $model->calle,
                       'nro' => $model->nro,
                       'depto' => $model->depto,
                       'block' => $model->block,
                       'villa' => $model->villa,
                       'codRegion' => $model->codRegion,
                       'idProvincia' => $model->idProvincia,
                       'codComuna' => $model->codComuna,
                       'fono' => $model->fono,
                       'email' => $model->email,
                       'celular' => $model->celular,
                       'estudios' => $model->estudios,
                       'niveledu' => $model->niveledu,
                       'profesion' => $model->profesion,
                       'trabajoplace' => $model->trabajoplace,
                       'apoderado' => $model->apoderado,
                       'relacion' => $model->relacion,
                       'rutalumno' => $run,
                    ])->execute();
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Se ha ingresado correctamente el <b>Apoderado</b>.-.');
                    $apoinsert = true;
                }
                catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Ocurrio un error, al ingresar un <b>Apoderado</b>.-');
                    $apoinsert = false;
                    throw $e;
                }
                catch (\Throwable $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Ocurrio un error, al ingresar un <b>Apoderado</b>.-');
                    $apoinsert = false;
                    throw $e;
                }
                //Esta parte es para registrar el apoderado en la tabla Pivot
                if($apoinsert==true && $apoasign==true)
                {
                    $tableApoderados = Apoderados::findOne(["rutalumno" => $run]);
                    $idapoderado = $tableApoderados->idApo;
                    $transaction = $db->beginTransaction();
                    try{
                        $sql = $db->createCommand()->update('pivot',
                            [
                            'idApo' => $idapoderado,
                            ],
                            [
                                'idalumno' => $id
                            ])->execute();
                        $transaction->commit();
                    }
                    catch (\Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                    }
                    catch (\Throwable $e) {
                        $transaction->rollBack();
                        throw $e;
                    }
                }
                $model->rutapo = null;
                $model->digrut = null;
                $model->nombreapo = null;
                $model->apepat = null;
                $model->apemat = null;
                $model->calle = null;
                $model->nro = null;
                $model->depto = null;
                $model->block = null;
                $model->villa = null;
                $model->fono = null;
                $model->email = null;
                $model->celular = null;
                $model->estudios = null;
                $model->niveledu = null;
                $model->profesion = null;
                $model->trabajoplace = null;
                return $this->redirect(['alumnos/relacionapos']);
            }else{
                $model->getErrors();
            }
        }
        return $this->render('ingresaapo', ["model" => $model]);
    }

    /**
     * Updates an existing Apoderados model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idApo]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Apoderados model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Apoderados model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Apoderados the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apoderados::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param $run
     * @return mixed
     * Devuelve rut 12.345.678-9 a 12345678
     */
    private function quitarStringless($run)
    {
        $runmenosptos = str_replace('.', "", $run);
        $data = explode('-', $runmenosptos);
        return $data[0];
    }

    /**
     * @param $run
     * @return string
     * Se encarga de devolver el verificador del Run ingresado
     */
    private function devolverVerificador($run)
    {
        $runmenosptos = str_replace('.', "", $run);
        $data = explode('-', $runmenosptos);
        $verificador = strtolower($data[1]);
        return $verificador;
    }

    /**
     * @return string
     * Se encarga de retornar la lista de Provincias
     */
    public function actionLista_provincia()
    {
       $out = [];
        if(Yii::$app->request->isPost){
            $parents = Yii::$app->request->post('depdrop_parents');
            if($parents != null)
            {
                $codRegion = $parents[0];
                $out = Provincias::getProvinciaList($codRegion);

                return Json::encode(['output'=>$out, 'selected'=>'']);
            }
        }
        return Json::encode(['output'=>'', 'selected'=>'']);
    }

    /**
     * @return string
     * Retorna listado de comunas
     */
    public function actionListcomu()
    {
        $out = [];
        if(Yii::$app->request->isPost){
            $ids = Yii::$app->request->post('depdrop_parents');
            if($ids != null)
            {
                $idProvincia = $ids[0];
                $data = Comunas::getComunalist($idProvincia);

                return Json::encode(['output'=>$data, 'selected'=>'']);
            }
        }
        return Json::encode(['output'=>'', 'selected'=>'']);
    }
}
