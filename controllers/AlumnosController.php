<?php

namespace app\controllers;

use app\models\alumnos\Alumnos;
use app\models\alumnos\AlumnosSearch;
use app\models\alumnos\FormAluRegister;
use app\models\cursos\Cursos;
use app\models\pivot\FormSelectPivot;
use app\models\pivot\Pivot;
use kartik\mpdf\Pdf;
use raoul2000\widget\pnotify\PNotify;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;


class AlumnosController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionListadoalumnosapos()
    {
        $nomcurso = '';
        $model = new FormSelectPivot();

        if($model->load(Yii::$app->request->post()))
        {
            $name = Cursos::find()->where(['idCurso' => $model->idCurso])->one();
            Yii::$app->session['icurso'] = $model->idCurso;
            $nomcurso = $name->Nombre;
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
        $nomcurso = '';
        $model = new FormSelectPivot();

        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                $name = Cursos::find()->where(['idCurso' => $model->idCurso])->one();
                Yii::$app->session['icurso'] = $model->idCurso;
                $nomcurso = $name->Nombre;
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
                Yii::$app->session['icurso'] = $model->idCurso;

                echo "<meta http-equiv='refresh' content='2; " . Url::toRoute(['alumnos/elegirpupils', 'nomcurso' => $name->Nombre]) ."'>";
            }else{
                $model->getErrors();
            }
        }
        return $this->render('asignar',["model" => $model]);

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
                Yii::$app->session['icurso'] = $model->idCurso;
                echo "<meta http-equiv='refresh' content='2; " . Url::toRoute(['alumnos/cursoalumnos', 'nomcurso' => $name->Nombre]) ."'>";
            }else{
                $model->getErrors();
            }
        }
        return $this->render('aluxcurso',["model" => $model]);

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
        Yii::$app->session->setFlash('success', 'Se asociaron alumnos a este Curso ' . $curso->Nombre);
        echo "<meta http-equiv='refresh' content='2; " . Url::toRoute("alumnos/asignar") . "'>";

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
     * @property string $nameAno
     * @return mixed
     * Crea reporte x curso de alumnos
     */
    public function actionReporte()
    {
        $alumnos = array();
        $alumno = Alumnos::find()->joinWith(['pivots pi'])->where(['idCurso' => Yii::$app->session->get('icurso')])->andWhere(['idano' => Yii::$app->session->get('anoActivo')])->orderBy('paternoalu')->addOrderBy('maternoalu')->all();
        if($alumno > 0)
        {
            foreach ($alumno as $pupils)
            {
                $alumnos[] = $pupils;
            }
            $curso = Cursos::find()->where(['idcurso' => Yii::$app->session->get('icurso')])->one();
            $cursoname = $curso->Nombre . ' ' . Yii::$app->session->get('nameAno');
            require_once Yii::$app->basePath . '\views\reporte\listadocurso.php';
            $plantilla = getPlantilla($alumnos,$cursoname);
            $content = $plantilla;
            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
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
        echo "<meta http-equiv='refresh' content='2; " . Url::toRoute("alumnos/cursoalumnos") . "'>";

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
                        PNotify::widget(['pluginOptions' => ['title' =>
                            'Error', 'text' => 'Se ha producido un error al querer ingresar este <b>Alumno(a)1</b>.',
                            'type' => 'error', ]]);
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
                                PNotify::widget(['pluginOptions' => ['title' =>
                                    'Alumno', 'text' => 'El Alumno(a) se ha ingresado exitosamente.-', 'type' =>
                                    'success', ]]);
                            }
                            else
                            {
                                $transaction->rollBack();
                                PNotify::widget(['pluginOptions' => ['title' =>
                                   'Error', 'text' => 'Se ha producido un error al querer ingresar este <b>Alumno(a)</b>.',
                                    'type' => 'error', ]]);
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

    public function actionListapromocion()
    {
        $nomcurso = '';
        $model = new FormSelectPivot();

        if($model->load(Yii::$app->request->post()))
        {
            $name = Cursos::find()->where(['idCurso' => $model->idCurso])->one();
            Yii::$app->session['icurso'] = $model->idCurso;
            $nomcurso = $name->Nombre;
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

        return $this->render('listapromocion',[
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
    public function actionListacambiocurso()
    {
        $nomcurso = '';
        $model = new FormSelectPivot();

        if($model->load(Yii::$app->request->post()))
        {
            $name = Cursos::find()->where(['idCurso' => $model->idCurso])->one();
            Yii::$app->session['icurso'] = $model->idCurso;
            $nomcurso = $name->Nombre;
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
     * @return array|string
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionCambiocurso($id)
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
                            Yii::$app->session->setFlash('success', 'Ha cambiado correctamente de curso el <b>Alumno</b>.-.');

                        }
                        else
                        {
                            $transaction->rollBack();
                            Yii::$app->session->setFlash('error', 'Ocurrio un error, al cambiar de curso para el <b>Alumno</b>.-');
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
        return $this->render('cambiocurso',compact('model'));

    }

    /**
     * @return string
     */
    public function actionCursoalumnos()
    {
        $nomcurso = '';
        $model= new FormSelectPivot();

        if($model->load(Yii::$app->request->post()))
        {
            $name = Cursos::find()->where(['idCurso'=>$model->idCurso])->one();
            Yii::$app->session['icurso']=$model->idCurso;
            $nomcurso = $name->Nombre;
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
