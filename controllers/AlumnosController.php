<?php

namespace app\controllers;

use app\models\alumnos\Alumnos;
use app\models\alumnos\AlumnosSearch;
use app\models\alumnos\FormAluRegister;
use app\models\alumnos\FormAluUpdate;
use app\models\cursos\Cursos;
use app\models\pivot\FormSelectPivot;
use app\models\pivot\FormUpdatePivot;
use app\models\pivot\Pivot;
use kartik\mpdf\Pdf;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
/**
 * Class AlumnosController
 * @package app\controllers
 */
class AlumnosController extends Controller
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

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionFulllistaalumnos()
    {
        $model = new FormSelectPivot();
        if($model->load(Yii::$app->request->post()))
        {
            Yii::$app->session->set('icurso',$model->idCurso);
        }
        $searchModel = new AlumnosSearch();
        $dataProvider = $searchModel->searchListApoderados(Yii::$app->session->get('icurso'));
        $name = Cursos::find()->where(['idCurso' => Yii::$app->session->get('icurso')])->one();
        if($name)
        {
            $nomcurso = $name->Nombre;
            $count = $dataProvider->getTotalCount();
        }else{
            $nomcurso = '';
            $count = 0;
        }

        return $this->render('fulllistaalumnos',compact('searchModel','dataProvider','model','nomcurso','count'));
    }

    /**
     * @return string
     */
    public function actionListadoalumnosapos()
    {
        $model = new FormSelectPivot();

        if($model->load(Yii::$app->request->post()))
        {
            Yii::$app->session->set('icurso',$model->idCurso);
        }

        $searchModel = new AlumnosSearch();
        $dataProvider = $searchModel->searchListApoderados(Yii::$app->session->get('icurso'));
        $name = Cursos::find()->where(['idCurso' => Yii::$app->session->get('icurso')])->one();
        if($name)
        {
            $nomcurso = $name->Nombre;
            $count = $dataProvider->getTotalCount();
        }else{
            $nomcurso = '';
            $count = 0;
        }

        return $this->render('listadoalumnosapos',[
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
                    'nomcurso' => $nomcurso,
                    'count' => $count
        ]);

    }

    /**
     * @return string
     */
    public function actionRelacionapos()
    {
        $model = new FormSelectPivot();

        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                Yii::$app->session->set('icurso',$model->idCurso);
            }
        }

        $searchModel = new AlumnosSearch();
        $dataProvider = $searchModel->search(Yii::$app->session->get('icurso'));
        $name = Cursos::find()->where(['idCurso' => Yii::$app->session->get('icurso')])->one();
        if($name){
            $nomcurso = $name->Nombre;
            $count = $dataProvider->getTotalCount();
        }else{
            $nomcurso = '';
            $count = 0;
        }

        return $this->render('relacionapos', [
                'searchModel'=>$searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
                'nomcurso' => $nomcurso,
                'count' => $count
            ]);

    }

    /**
     * @return array|string
     * @throws \Exception
     * @throws \Throwable
     * Mostramos el curso al que deseamos que se desplazen los alumnos
     */
    public function actionAsignar()
    {
        $model = new FormSelectPivot();
        if($model->load(Yii::$app->request->post())&&Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                $name = Cursos::find()->where(['idCurso' => $model->idCurso])->one();
                Yii::$app->session->set('icurso',$model->idCurso);

                echo "<meta http-equiv='refresh' content='2; " . Url::toRoute(['alumnos/elegirpupils', 'nomcurso' => $name->Nombre]) ."'>";
            }else{
                $model->getErrors();
            }
        }
        return $this->render('asignar',["model" => $model]);

    }

    /**
     * Consulta la lista de alumnos para actualizar
     * @return string
     */
    public function actionUpgeneral()
    {
        $searchModel = new AlumnosSearch();
        $dataProvider = $searchModel->searchGeneral(Yii::$app->request->queryParams);
        return $this->render('upgeneral',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     *
     * Consulta de alumnos retirados, Ojo aquí la consulta se hace al reves preguntando primero por la tabla PIvot
     */
    public function actionConretirados()
    {
        $searchModel = new AlumnosSearch();
        $dataProvider = $searchModel->searchRetirados(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['pivot.retirado' => '1'])
                            ->andWhere(['pivot.idano' => \Yii::$app->session->get('anoActivo')])
                            ->addOrderBy('alumnos.fecharet');
        return $this->render('conretirados',compact('dataProvider'));
    }

    /**
     * Se encarga de consultar los datos de los alumnos a través de un Grid
     * @return string
     */
    public function  actionCongeneral()
    {
        $searchModel = new AlumnosSearch();
        $dataProvider = $searchModel->searchGeneral(Yii::$app->request->queryParams);

        return $this->render('congeneral', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     */
    public function actionDelalumno()
    {
        $model = new FormSelectPivot();
        if($model->load(Yii::$app->request->post()))
        {
            Yii::$app->session->set('icurso',$model->idCurso);
        }
        $searchModel = new AlumnosSearch();
        $dataProvider = $searchModel->search(Yii::$app->session->get('icurso'));
        $name = Cursos::find()->where(['idCurso'=>Yii::$app->session->get('icurso')])->one();
        if($name)
        {
            $nomcurso = $name->Nombre;
            $count = $dataProvider->getTotalCount();
        }
        else{
            $nomcurso ='';
            $count = 0;
        }
        return $this->render('delalumno',compact('searchModel','dataProvider','model','nomcurso','count'));
    }

    /**
     * @return string
     *
     * Realiza la modificación del alumno, desde un curso en especifico
     */
    public function actionUpconcurso()
    {
        $model = new FormSelectPivot();

        if ($model->load(Yii::$app->request->post()))
        {
            Yii::$app->session->set('icurso',$model->idCurso);
        }
        $searchModel = new AlumnosSearch();
        $dataProvider = $searchModel->search(Yii::$app->session->get('icurso'));
        $name = Cursos::find()->where(['idCurso' => Yii::$app->session->get('icurso')])->one();
        if($name){
            $nomcurso = $name->Nombre;
            $count = $dataProvider->getTotalCount();
        }else{
            $nomcurso = '';
            $count = 0;
        }
        return $this->render('upconcurso',[
            'searchModel'=>$searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'nomcurso' => $nomcurso,
            'count' => $count]);
    }

    /**
     * @return array|string
     * Se encarga de presentar el listado de alumnos por curso
     */
    public function actionAluxcurso()
    {
        $model = new FormSelectPivot();

        if($model->load(Yii::$app->request->post())&&Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                $name = Cursos::find()->where(['idCurso' => $model->idCurso])->one();
                Yii::$app->session->set('icurso',$model->idCurso);
                echo "<meta http-equiv='refresh' content='2; " . Url::toRoute(['alumnos/cursoalumnos', 'nomcurso' => $name->Nombre]) ."'>";
            }else{
                $model->getErrors();
            }
        }
        return $this->render('aluxcurso',['model' => $model]);

    }

    /**
     * @throws \Exception
     * @throws \Throwable
     * Se encarga de actualizar los cursos para los alumnos de la grilla
     */
    public function actionIngresacurso()
    {
        $table = new Pivot;

        $select = (array)Yii::$app->request->post('selection');
        if(!empty($select))
        {
            foreach ($select as $id)
            {
                $transaction = $table->getDb()->beginTransaction();
                try
                {
                    $table = Pivot::findOne(["idalumno" => $id]);
                    if($table)
                    {
                        $table->idCurso = Yii::$app->session->get('icurso');
                        if($table->update())
                        {
                            $transaction->commit();
                        }
                        else
                        {
                            $transaction->rollBack();
                        }

                    }
                }catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
        }else{
            throw new HttpException(400,'No existe una consulta');
        }
        $curso = Cursos::find()->where(['idcurso' => Yii::$app->session->get('icurso')])->one();
        \Yii::$app->session->setFlash('success', 'Se asociaron alumnos a este Curso ' . $curso->Nombre);
        return $this->redirect(['alumnos/asignar']);
        //echo "<meta http-equiv='refresh' content='2; " . Url::toRoute("alumnos/asignar") . "'>";

    }

    /**
     * @return string
     * Carga la planilla con los datos de alumnos
     */
    public function actionElegirpupils()
    {
            $dataProvider = new ActiveDataProvider([
                'query' => Alumnos::find()->joinWith(['pivots pi'])->where(['idCurso' => 29])->andWhere(['idano' => Yii::$app->session->get('anoActivo')])->orderBy('paternoalu')->addOrderBy('maternoalu'),'pagination' => ['pagesize' => 50,],]);
            return $this->render('elegirpupils',['dataProvider' => $dataProvider]);

    }

    /**
     * @return mixed
     * Genera reporte con la lista de alumnos retirados
     */
    public function actionReportretirado()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Pivot::find()->joinWith('idalumno0')
                    ->where(['pivot.retirado' => '1'])->andWhere(['pivot.idano' => \Yii::$app->session->get('anoActivo')])
                    ->orderBy('alumnos.fecharet')]);
        $totalitems = $dataProvider->getTotalCount();
        $content = $this->renderPartial('/reporte/listaretirados', compact('dataProvider'));
        if ($totalitems > 0)
        {
            Yii::$app->response->format = Response::FORMAT_RAW;
            $pdf = new Pdf(['mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                'format' => Pdf::FORMAT_FOLIO, 'destination' => Pdf::DEST_BROWSER, 'content' =>
                    $content, 'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-alumno.css',
                'options' => [ // any mpdf options you wish to set
                ], 'methods' => ['SetTitle' => 'Sistema Administración Bibliotecaria - Listado Retirados',
                    'SetSubject' => 'Generado por Sistema Administración Bibliotecaria - The Kingstown School',
                    'SetHeader' => ['The Kingstown School - Sistema Administración Bibliotecaria: ' .
                        date("r")], 'SetFooter' => ['|Page {PAGENO}|'], 'SetAuthor' =>
                        'Marcelo Tapia D.', 'SetCreator' => 'Marcelo Tapia D.', ]]);
            return $pdf->render();
        }

        Yii::$app->session->setFlash('error', 'No existen alumnos retirados este año.-');
        return $this->redirect(['alumnos/conretirados']);
        //echo "<meta http-equiv='refresh' content='2; " . Url::toRoute("alumnos/conretirados") . "'>";
    }

    /**
     * @property string $nameAno
     * @return mixed
     * Crea reporte x curso de alumnos
     */
    public function actionReporte()
    {
        $alumnos = array();
        $alumno = Alumnos::find()->joinWith(['pivots pi'])
                    ->where(['idCurso' => Yii::$app->session->get('icurso')])
                    ->andWhere(['pi.retirado' => '0'])
                    ->andWhere(['idano' => Yii::$app->session->get('anoActivo')])
                    ->orderBy('paternoalu')->addOrderBy('maternoalu')->all();
        if($alumno > 0)
        {
            foreach ($alumno as $pupils)
            {
                $alumnos[] = $pupils;
            }
            $curso = Cursos::find()->where(['idcurso' => Yii::$app->session->get('icurso')])->one();
            $cursoname = $curso->Nombre . ' ' . Yii::$app->session->get('nameAno');
            require_once  ('/home/kingstownschoolc/biblio.kingstownschool.cl/biblio/views/reporte/listadocurso.php');
            //require_once Yii::$app->basePath . '\views\reporte\listadocurso.php';
            $plantilla = getPlantilla($alumnos,$cursoname);
            $content = $plantilla;
            Yii::$app->response->format = Response::FORMAT_RAW;
            $pdf = new Pdf(['mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                'format' => Pdf::FORMAT_FOLIO, 'destination' => Pdf::DEST_BROWSER, 'content' =>
                    $content, 'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-alumno.css',
                'options' => [ // any mpdf options you wish to set
                ], 'methods' => ['SetTitle' => 'Sistema Administración Bibliotecaria - Listado por Curso',
                    'SetSubject' => 'Generado por Sistema Administración Bibliotecaria - The Kingstown School',
                    'SetHeader' => ['The Kingstown School - Sistema Administración Bibliotecaria: ' .
                        date("r")], 'SetFooter' => ['|Page {PAGENO}|'], 'SetAuthor' =>
                        'Marcelo Tapia D.', 'SetCreator' => 'Marcelo Tapia D.', ]]);
            return $pdf->render();
        }
        Yii::$app->session->setFlash('error', 'No existen alumnos asociados a este Curso.-');
        return $this->redirect(['alumnos/cursoalumnos']);
        //echo "<meta http-equiv='refresh' content='2; " . Url::toRoute("alumnos/cursoalumnos") . "'>";

    }

    /**
     * @param $id
     * @param $fuente
     * @return array|string
     * @throws \Exception
     * @throws \Throwable
     *
     * Se encarga de actualizar el alumno
     */
    public function actionUpdate($id,$fuente)
    {
        $model = new FormAluUpdate();
        $modelPivot = new FormUpdatePivot();

        $tableAlumnos = new Alumnos();
        $tablePivot = new Pivot();


        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $modelPivot->load(Yii::$app->request->post()))
        {
            if ($model->validate() && $modelPivot->validate())
            {
                $aluUpdate = '';
                $transaction = $tableAlumnos->getDb()->beginTransaction();
                try
                {
                    $tableAlumnos = Alumnos::findOne(['idalumno' => $id]);
                    if ($tableAlumnos)
                    {
                        $tableAlumnos->rutalumno = $this->quitarStringless($model->rutalumno);
                        $tableAlumnos->digrut = $this->devolverDigito($model->rutalumno);
                        $tableAlumnos->nombrealu = mb_strtoupper($model->nombrealu);
                        $tableAlumnos->paternoalu = mb_strtoupper($model->paternoalu);
                        $tableAlumnos->maternoalu = mb_strtoupper($model->maternoalu);
                        $tableAlumnos->fechanac = Yii::$app->formatter->asDate($model->fechanac,"yyyy-MM-dd");
                        $tableAlumnos->calle = $model->calle;
                        $tableAlumnos->nro = $model->nro;
                        $tableAlumnos->depto = $model->depto;
                        $tableAlumnos->block = $model->block;
                        $tableAlumnos->villa = $model->villa;
                        $tableAlumnos->codRegion = $model->codRegion;
                        $tableAlumnos->idProvincia = $model->idProvincia;
                        $tableAlumnos->codComuna = $model->codComuna;
//                        if($model->sexo=="F")
//                        {
//                            $tableAlumnos->sexo = "F";
//                        }
//                        if($model->sexo=="M")
//                        {
//                            $tableAlumnos->sexo = "M";
//                        }
                        $tableAlumnos->sexo = $model->sexo;
                        $tableAlumnos->email = $model->email;
                        $tableAlumnos->fono = $model->fono;
                        $tableAlumnos->nacionalidad = $model->nacionalidad;
                        $tableAlumnos->fechaing = Yii::$app->formatter->asDate($model->fechaing,"yyyy-MM-dd");
                        $tableAlumnos->sangre = $model->sangre;
                        $tableAlumnos->enfermedades = $model->enfermedades;
                        $tableAlumnos->alergias = $model->alergias;
                        $tableAlumnos->medicamentos = $model->medicamentos;
                        $tableAlumnos->fecharet = Yii::$app->formatter->asDate($model->fecharet,"yyyy-MM-dd");
                        if ($tableAlumnos->update())
                        {
                            $transaction->commit();
                            $aluUpdate = true;

                        }else{
                            $transaction->rollBack();
                            $aluUpdate = false;
                            \Yii::$app->session->setFlash('error', 'A ocurrido un error al intentar actualizar el Alumno.-');
                            if($fuente==1)
                            {
                                return $this->redirect(['alumnos/upgeneral']);
                            }else if($fuente==2)
                            {
                                return $this->redirect(['alumnos/upconcurso']);
                            }

                        }
                    }
                }
                catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
                catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
                //Aqui definimos la actualización de la tabla pivot
                if($aluUpdate==true)
                {
                    $transaction = $tablePivot->getDb()->beginTransaction();
                    try
                    {
                        $tablePivot = Pivot::findOne(['idalumno'=>$id,'idano'=>Yii::$app->session->get('anoActivo')]);
                        if ($tablePivot)
                        {
                            $tablePivot->retirado = $modelPivot->retirado;
                            if ($tablePivot->update())
                            {
                                $transaction->commit();
                            }
                            else
                            {
                                $transaction->rollBack();
                            }
                            \Yii::$app->session->setFlash('success', 'Se ha actualizado correctamente el Alumno.-');
                            if($fuente==1)
                            {
                                return $this->redirect(['alumnos/upgeneral']);
                            }else if($fuente==2) //Redirige según el formulario que hizo la llamada
                            {
                                return $this->redirect(['alumnos/upconcurso']);
                            }
                        }
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
            }else{
                $model->getErrors();
                $modelPivot->getErrors();
            }

        }else{
            $tableAlumnos = Alumnos::findOne(['idalumno' => $id]);
            if ($tableAlumnos)
            {
                $model->rutalumno = $tableAlumnos->rutalumno . '-' . $tableAlumnos->digrut;
                $model->nombrealu = $tableAlumnos->nombrealu;
                $model->paternoalu = $tableAlumnos->paternoalu;
                $model->maternoalu = $tableAlumnos->maternoalu;
                $model->fechanac = $tableAlumnos->fechanac;
                $model->calle = $tableAlumnos->calle;
                $model->nro = $tableAlumnos->nro;
                $model->depto = $tableAlumnos->depto;
                $model->block = $tableAlumnos->block;
                $model->villa = $tableAlumnos->villa;
                $model->codRegion = $tableAlumnos->codRegion;
                $model->idProvincia = $tableAlumnos->idProvincia;
                $model->codComuna = $tableAlumnos->codComuna;
                $model->sexo = $tableAlumnos->sexo;
                $model->email = $tableAlumnos->email;
                $model->fono = $tableAlumnos->fono;
                $model->nacionalidad = $tableAlumnos->nacionalidad;
                $model->fechaing = $tableAlumnos->fechaing;
                $model->fecharet = $tableAlumnos->fecharet;
                $model->sangre = $tableAlumnos->sangre;
                $model->enfermedades = $tableAlumnos->enfermedades;
                $model->alergias = $tableAlumnos->alergias;
                $model->medicamentos = $tableAlumnos->medicamentos;
            }
            $tablePivot = Pivot::findOne(['idalumno' => $id,'idano'=>Yii::$app->session->get('anoActivo')]);
            if ($tablePivot)
            {
                $modelPivot->retirado = $tablePivot->retirado;
            }
        }
        return $this->render('update', compact('model','modelPivot'));

    }

    /**
     * @property string rutalumno
     * @property string nombrealu
     * @property string paternoalu
     * @property string maternoalu
     * @property string calle
     * @property string nro
     * @property string depto
     * @property string block
     * @property string villa
     * @return array|string
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionIngresaalu()
    {
        $model = new FormAluRegister();
        $modelPivot = new FormSelectPivot();

        $tableAlumnos = new Alumnos();
        $tablePivot = new Pivot();

        if($model->load(Yii::$app->request->post())&&Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if($model->load(Yii::$app->request->post()) && $modelPivot->load(Yii::$app->request->post()))
        {
            if($model->validate() && $modelPivot->validate())
            {
                $transaction = $tableAlumnos::getDb()->beginTransaction();
                try
                {
                    $tableAlumnos->rutalumno = $this->quitarStringless($model->rutalumno);
                    $tableAlumnos->digrut = $this->devolverDigito($model->rutalumno);
                    $tableAlumnos->nombrealu = mb_strtoupper($model->nombrealu);
                    $tableAlumnos->paternoalu = mb_strtoupper($model->paternoalu);
                    $tableAlumnos->maternoalu = mb_strtoupper($model->maternoalu);
                    $tableAlumnos->fechanac = Yii::$app->formatter->asDate($model->fechanac,"yyyy-MM-dd");
                    $tableAlumnos->calle = $model->calle;
                    $tableAlumnos->nro = $model->nro;
                    $tableAlumnos->depto = $model->depto;
                    $tableAlumnos->block = $model->block;
                    $tableAlumnos->villa = $model->villa;
                    $tableAlumnos->codRegion = $model->codRegion;
                    $tableAlumnos->idProvincia = $model->idProvincia;
                    $tableAlumnos->codComuna = $model->codComuna;
                    $tableAlumnos->sexo = $model->sexo;
                    $tableAlumnos->email = $model->email;
                    $tableAlumnos->fono = $model->fono;
                    $tableAlumnos->nacionalidad = $model->nacionalidad;
                    $tableAlumnos->fechaing = Yii::$app->formatter->asDate($model->fechaing,"yyyy-MM-dd");
                    if($tableAlumnos->save(false))
                    {
                        $transaction->commit();
                        $aluinsert = true;
                    }
                    else
                    {
                        $transaction->rollBack();
                        $aluinsert = false;
                        \Yii::$app->session->setFlash('error','Se ha producido un error al querer ingresar este Alumno(a).');
                    }
                }
                catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
                catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
                if($aluinsert==true)
                {
                    $tableAlumnos = Alumnos::findOne(["rutalumno" => $this->quitarStringless($model->rutalumno)]);
                    $transaction = $tablePivot::getDb()->beginTransaction();
                    try{
                        $tablePivot = Pivot::findOne(["idalumno" => $tableAlumnos->idalumno]);
                        if($tablePivot)
                        {
                            $tablePivot->idCurso = $modelPivot->idCurso;
                            $tablePivot->idano = Yii::$app->session->get('anoActivo');
                            if($tablePivot->update())
                            {
                                $transaction->commit();
                                $model->rutalumno = null;
                                $model->nombrealu = null;
                                $model->paternoalu = null;
                                $model->maternoalu = null;
                                $model->fechanac = null;
                                $model->calle = null;
                                $model->nro = null;
                                $model->depto = null;
                                $model->block = null;
                                $model->villa = null;
                                $model->email = null;
                                $model->fono = null;
                                $model->fechaing = null;
                                \Yii::$app->session->setFlash('success','El Alumno(a) se ha ingresado exitosamente.-');
                            }
                            else
                            {
                                $transaction->rollBack();
                                \Yii::$app->session->setFlash('error','Se ha producido un error al querer ingresar este Alumno(a).-');
                            }
                        }
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
            }
            else
            {
                $model->getErrors();
            }
        }
        return $this->render('ingresaalu',compact('model','modelPivot'));
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
    private function devolverDigito($run)
    {
        $runmenosptos = str_replace('.', "", $run);
        $data = explode('-', $runmenosptos);
        $verificador = strtolower($data[1]);
        return $verificador;
    }

    /**
     * @return string
     *
     * Se encarga de realizar la promoción de un curso
     */
    public function actionListapromocion()
    {
        $model = new FormSelectPivot();

        if($model->load(Yii::$app->request->post()))
        {
            Yii::$app->session->set('icurso',$model->idCurso);
        }
        $searchModel = new AlumnosSearch();
        $dataProvider = $searchModel->searchListApoderados(Yii::$app->session->get('icurso'));
        $name = Cursos::find()->where(['idCurso' => Yii::$app->session->get('icurso')])->one();
        if($name)
        {
            $nomcurso = $name->Nombre;
            $count = $dataProvider->getTotalCount();
        }else{
            $nomcurso = '';
            $count = 0;
        }

        return $this->render('listapromocion', compact('searchModel','dataProvider','model','nomcurso','count'));
    }

    /**
     * @return string
     */
    public function actionListacambiocurso()
    {
        $model = new FormSelectPivot();

        if($model->load(Yii::$app->request->post()))
        {
            Yii::$app->session->set('icurso',$model->idCurso);
        }

        $searchModel = new AlumnosSearch();
        $dataProvider = $searchModel->searchListApoderados(Yii::$app->session->get('icurso'));
        $name = Cursos::find()->where(['idCurso' => Yii::$app->session->get('icurso')])->one();
        if($name)
        {
            $nomcurso = $name->Nombre;
            $count = $dataProvider->getTotalCount();
        }else{
            $nomcurso = '';
            $count = 0;
        }

        return $this->render('listacambiocurso',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'nomcurso' => $nomcurso,
            'count' => $count
        ]);
    }

    /**
     * @param $id
     * @param $name
     * @return array|string|Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionCambiocurso($id,$name)
    {
        $model = new FormSelectPivot;

        $table = new Pivot;

        if($model->load(Yii::$app->request->post())&&Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                $transaction = $table::getDb()->beginTransaction();
                try
                {
                    $table = Pivot::find()->where(['idalumno' => $id])->andWhere(['idano' => Yii::$app->session->get('anoActivo')])->one();
                    if($table)
                    {
                        $table->idCurso = $model->idCurso;
                        $table->motivo = $model->motivo;
                        if($table->update())
                        {
                            $transaction->commit();
                            \Yii::$app->session->setFlash('success', 'Ha cambiado correctamente de curso el Alumno.-');

                        }
                        else
                        {
                            $transaction->rollBack();
                            \Yii::$app->session->setFlash('error', 'Ocurrio un error, al cambiar de curso para el Alumno.-');
                        }
                    }
                }
                catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
                catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
                return $this->redirect(['alumnos/listacambiocurso']);
            }
            else
            {
                $model->getErrors();
            }

        }

        return $this->render('cambiocurso',compact('model','name'));

    }

    public function actionDelete($id)
    {
        if($id != null)
        {
            $table = new Alumnos();
            $transaction = $table->getDb()->beginTransaction();
            try
            {
                if($table::deleteAll("idalumno=:idalumno",["idalumno"=>$id]))
                {
                    $transaction->commit();
                    \Yii::$app->session->setFlash('success', 'Se ha borrado correctamente este Alumno.-');
                }else{
                    $transaction->rollBack();
                    \Yii::$app->session->setFlash('error', 'Ocurrio un error, no se borro el Alumno.-');
                }
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
        return $this->redirect(['alumnos/delalumno']);
    }

    /**
     * @return string
     */
    public function actionCursoalumnos()
    {
        $model= new FormSelectPivot();

        if($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                Yii::$app->session->set('icurso',$model->idCurso);
            }
        }

        $searchModel=new AlumnosSearch();
        $dataProvider = $searchModel->searchListApoderados(Yii::$app->session->get('icurso'));
        $name = Cursos::find()->where(['idCurso'=>Yii::$app->session->get('icurso')])->one();
        if($name)
        {
            $nomcurso=$name->Nombre;
            $count = $dataProvider->getTotalCount(); //Obtenemos el total de registros del data Provider
        }else{
            $nomcurso='';
            $count = 0; //Si no hay registros
        }

        return $this->render('cursoalumnos',[
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider,
            'model'=>$model,
            'nomcurso'=>$nomcurso,
            'count'=>$count
        ]);
    }
}
