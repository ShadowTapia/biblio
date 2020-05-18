<?php

namespace app\controllers;

use app\models\alumnos\Alumnos;
use app\models\cursos\Cursos;
use app\models\pivot\FormSelectPivot;
use app\models\alumnos\FormAluRegister;
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
                ], 'methods' => ['SetTitle' => utf8_encode('Sistema Administración Bibliotecaria - Listado por Curso'),
                    'SetSubject' => 'Generado por Sistema Administración Bibliotecaria - The Kingstown School',
                    'SetHeader' => [utf8_encode('The Kingstown School - Sistema Administración Bibliotecaria: ') .
                        date("r")], 'SetFooter' => ['|Page {PAGENO}|'], 'SetAuthor' =>
                        'Marcelo Tapia D.', 'SetCreator' => 'Marcelo Tapia D.', ]]);
            return $pdf->render();
        }
        Yii::$app->session->setFlash('error', utf8_encode('No existen alumnos asociados a este Curso.-'));
        echo "<meta http-equiv='refresh' content='2; " . Url::toRoute("alumnos/cursoalumnos") . "'>";

    }

    public function actionIngresaalu()
    {
        $model = new FormAluRegister();

        if($model->load(Yii::$app->request->post())&&Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {

            }
            else
            {
                $model->getErrors();
            }
        }
        return $this->render('ingresaalu',compact('model'));
    }

    /**
     * @return array|string
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionCambiocurso()
    {
        $model = new FormSelectPivot;
        $model2= new FormSelectPivot;

        $table = new Pivot;

        if($model->load(Yii::$app->request->post())&&Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if($model->load(Yii::$app->request->post()) && $model2->load(Yii::$app->request->post()))
        {
            if($model->validate() && $model2->validate())
            {
                $transaction = $table::getDb()->beginTransaction();
                try
                {
                    $table = Pivot::find()->where(['idalumno' => $model->idalumno])->andWhere(['idano' => Yii::$app->session->get('anoActivo')])->one();
                    if($table)
                    {
                        $table->idCurso = $model2->idCurso;
                        $table->motivo = $model2->motivo;
                        if($table->update())
                        {
                            $transaction->commit();
                            PNotify::widget(['pluginOptions' => ['title' =>
                                'Alumnos', 'text' => 'El Alumno(a) ha cambiado de curso exitosamente.-', 'type' =>
                                'success', ]]);
                        }
                        else
                        {
                            $transaction->rollBack();
                            PNotify::widget(['pluginOptions' => ['title' =>
                                'Alumno', 'text' => 'No se ha actualizado el Alumno(a).-', 'type' => 'error', ]]);
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
            else
            {
                $model->getErrors();
            }
            return $this->render('cambiocurso', compact('model','model2'));
        }
        return $this->render('cambiocurso',compact('model','model2'));

    }

    /**
     * @return string
     */
    public function actionCursoalumnos()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Alumnos::find()->joinWith(['pivots pi'])->where(['idCurso' => Yii::$app->session->get('icurso')])->andWhere(['idano' => Yii::$app->session->get('anoActivo')])->orderBy('paternoalu')->addOrderBy('maternoalu'),'pagination' => ['pagesize' => 50,],]);
        $count = $dataProvider->getCount();
        if($count < 1)
        {
            Yii::$app->session->setFlash('error', utf8_encode('No existen alumnos asociados a este Curso.-'));
            echo "<meta http-equiv='refresh' content='2; " . Url::toRoute("alumnos/aluxcurso") . "'>";
        }
        return $this->render('cursoalumnos',compact('dataProvider'));

    }

    /**
     * @param $id
     * Se encarga de poblar el combo con la lista de alumnos del curso seleccionado
     */
    public function actionListalumnos($id)
    {
        $countfila=0;
        //Creamos el contador
        $countAlumnos = Alumnos::find()->joinWith(['pivots pi'])->where(['idCurso' => $id])->andWhere(['idano' => Yii::$app->session->get('anoActivo')])->count();
        //Asignamos la query y obtenemos la lista de alumnos que cumplen
        $pupilslists = Alumnos::find()->joinWith(['pivots pi'])->where(['idCurso' => $id])->andWhere(['idano' => Yii::$app->session->get('anoActivo')])->orderBy('paternoalu')->addOrderBy('maternoalu')->all();

        if($countAlumnos > 0)
        {
            foreach ($pupilslists as $alu)
            {
                $countfila++;
                echo "<option value='" .$alu->idalumno . "'>" .$countfila . '.- ' .$alu->paternoalu . ' '. $alu->maternoalu . ',' . $alu->nombrealu . "</option>";
            }

        }
        else
        {
            echo "<option>--------</option>";
        }
     }
}
