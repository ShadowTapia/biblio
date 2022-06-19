<?php

namespace app\controllers;

use app\models\apoderados\FormApoRegister;
use app\models\cursos\Cursos;
use app\models\pivot\FormSelectPivot;
use app\models\Comunas;
use app\models\Provincias;
use app\models\apoderados\FormApoConsultaRut;
use Yii;
use app\models\apoderados\Apoderados;
use app\models\apoderados\ApoderadosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
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
     * @return string
     * Se encarga de suministrar una lista de apoderados
     */
    public function actionListapoderados()
    {
        $model = new FormSelectPivot();

        if($model->load(Yii::$app->request->post()))
        {
            Yii::$app->session->set('icurso',$model->idCurso);
        }

        $searchModel = new ApoderadosSearch();
        $dataProvider = $searchModel->searchListaApos(Yii::$app->session->get('icurso'));
        $name = Cursos::find()->where(['idCurso' => Yii::$app->session->get('icurso')])->one();
        if($name)
        {
            $nomcurso = $name->Nombre;
            $count = $dataProvider->getTotalCount();
        }else{
            $nomcurso = '';
            $count = 0;
        }
        return $this->render('listapoderados',compact('model','searchModel','dataProvider','nomcurso','count'));
    }

    /**
     * @param $id
     * @param $run
     * @return array|string|Response
     */
    public function actionConsultarutapo($id, $run)
    {
        $model = new FormApoConsultaRut();

        //validación mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                $runcompleto = $model->rutapo;
                return $this->redirect(['apoderados/ingresaapo', 'id' => $id, 'run' => $run, 'runapo' => $runcompleto]);
            }else{
                $model->getErrors();
            }
        }

        return $this->render('consultarutapo',["model" => $model]);

    }

    /**
     * @param $id
     * @param $run
     * @param $runapo
     * @return array|string
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionIngresaapo($id,$run,$runapo)
    {
        $model = new FormApoRegister();
        $encontro = false;

        $db = Yii::$app->db;

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
                    $tableApoderados = Apoderados::findOne(["rutapo" => $this->quitarStringless($runapo)]);
                    if ($tableApoderados)
                    {
                        $encontro = true;
                    }
                    if ($encontro == true)
                    {
                        $db->createCommand()->update('apoderados',
                            [
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
                            ],
                            [
                                'rutapo' => $this->quitarStringless($model->rutapo)
                            ])->execute();
                    }else{
                        $db->createCommand()->insert('apoderados',[
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
                    }
                    $transaction->commit();
                    \Yii::$app->session->setFlash('success', 'Se ha ingresado correctamente el Apoderado.-.');
                    $apoinsert = true;
                }
                catch (\Exception $e) {
                    $transaction->rollBack();
                    \Yii::$app->session->setFlash('error', 'Ocurrio un error, al ingresar un Apoderado.-');
                    throw $e;
                }
                catch (\Throwable $e) {
                    $transaction->rollBack();
                    \Yii::$app->session->setFlash('error', 'Ocurrio un error, al ingresar un Apoderado.-');
                    throw $e;
                }
                //Esta parte es para registrar el apoderado en la tabla Pivot
                if($apoinsert==true && $apoasign==true)
                {
                    $tableApoderados = Apoderados::findOne(["rutalumno" => $run]);
                    $idapoderado = $tableApoderados->idApo;
                    $transaction = $db->beginTransaction();
                    try{
                        $db->createCommand()->update('pivot',['idApo' => $idapoderado],['idalumno' => $id])->execute();
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
        }else{
            $rutsinptos = $this->quitarStringless($runapo);
            $tableApoderados = Apoderados::findOne(["rutapo" => $rutsinptos]);
            if ($tableApoderados)
            {
                $model->rutapo = $runapo;
                $model->nombreapo = $tableApoderados->nombreapo;
                $model->apepat = $tableApoderados->apepat;
                $model->apemat = $tableApoderados->apemat;
                $model->calle = $tableApoderados->calle;
                $model->nro = $tableApoderados->nro;
                $model->depto = $tableApoderados->depto;
                $model->block = $tableApoderados->block;
                $model->villa = $tableApoderados->villa;
                $model->codRegion = $tableApoderados->codRegion;
                $model->idProvincia = $tableApoderados->idProvincia;
                $model->codComuna = $tableApoderados->codComuna;
                $model->fono = $tableApoderados->fono;
                $model->celular = $tableApoderados->celular;
                $model->email = mb_strtolower($tableApoderados->email);
                $model->niveledu = $tableApoderados->niveledu;
                $model->estudios = $tableApoderados->estudios;
                $model->profesion = $tableApoderados->profesion;
                $model->trabajoplace = $tableApoderados->trabajoplace;
                $model->relacion = $tableApoderados->relacion;
                $model->apoderado = $tableApoderados->apoderado;
            }else{
                $model->rutapo = $runapo;
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
       if(Yii::$app->request->isPost){
            $parents = Yii::$app->request->post('depdrop_parents');
            if($parents != null)
            {
                $codRegion = empty($parents[0]) ? null : $parents[0];
                $param1 = null;
                if(!empty($_POST['depdrop_params']))
                {
                    $params = $_POST['depdrop_params'];
                    $param1 = $params[0];
                }
                $out = Provincias::getProvinciaList($codRegion);

                $selected = Provincias::findOne($param1);
                return Json::encode(['output'=> $out, 'selected'=> $selected]);
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
        if(Yii::$app->request->isPost){
            $ids = Yii::$app->request->post('depdrop_parents');
            if($ids != null)
            {
                $idProvincia = empty($ids[0]) ? null : $ids[0];
                $param2 = null;
                if(!empty($_POST['depdrop_params']))
                {
                    $params = $_POST['depdrop_params'];
                    $param2 = $params[0];
                }

                $data = Comunas::getComunalist($idProvincia);
                $selected = Comunas::findOne($param2);

                return Json::encode(['output'=>$data, 'selected'=>$selected]);
            }
        }
        return Json::encode(['output'=>'', 'selected'=>'']);
    }
}
