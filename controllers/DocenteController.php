<?php

/**
 * @author Marcelo
 * @copyright 2019
 */

namespace app\controllers;

use app\models\Comunas;
use app\models\docente\Docente;
use app\models\docente\FormRegister;
use app\models\docente\FormUpdateDocente;
use app\models\Provincias;
use kartik\mpdf\Pdf;
use raoul2000\widget\pnotify\PNotify;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class DocenteController extends Controller
{
    public function actionIndexdocente()
    {
        $dataProvider = new ActiveDataProvider(['query' => Docente::find()]);
        $dataProvider->sort->defaultOrder = ['paterno' => SORT_ASC];
        return $this->render('indexdocente', ['dataProvider' => $dataProvider]);
    }

    /**
     * @return mixed
     * Generador de reporte en formato pdf
     */
    public function actionReporte()
    {
        $profes = array();
        $profe = Docente::find()->orderBy('paterno')->addOrderBy('materno')->all();
        if ($profe > 0) {
            foreach ($profe as $teachers) {
                $profes[] = $teachers;
            }
        }

        require_once Yii::$app->basePath . '\views\reporte\listadoprofe.php';
        $plantilla = getPlantilla($profes);
        $content = $plantilla;
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'format' => Pdf::FORMAT_FOLIO, 'destination' => Pdf::DEST_BROWSER, 'content' =>
            $content, 'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-docente.css',
            'options' => [ // any mpdf options you wish to set
            ], 'methods' => ['SetTitle' => 'Sistema Administración Bibliotecaria - Listado de Docentes',
            'SetSubject' => 'Generado por Sistema Administración Bibliotecaria - The Kingstown School',
            'SetHeader' => ['The Kingstown School - Sistema Administración Bibliotecaria: ' .
            date("r")], 'SetFooter' => ['|Page {PAGENO}|'], 'SetAuthor' =>
            'Marcelo Tapia D.', 'SetCreator' => 'Marcelo Tapia D.', ]]);
        return $pdf->render();
    }

    /**
     * 
     * Se encarga de resgistrar un docente
     * 
     */
    public function actionRegister()
    {
        $model = new FormRegister;
        //Validaci�n mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $table = new Docente;

                //Iniciamos la transacci�n
                $transaction = $table::getDb()->beginTransaction();
                try {
                    $table->rutdocente = $this->quitarStringless($model->rutdocente);
                    $table->digito = $this->devolverDigito($model->rutdocente);
                    $table->nombres = $model->nombres;
                    $table->paterno = $model->paterno;
                    $table->materno = $model->materno;
                    $table->calle = $model->calle;
                    $table->numero = $model->numero;
                    $table->depto = $model->depto;
                    $table->block = $model->block;
                    $table->villa = $model->villa;
                    $table->codRegion = $model->codRegion;
                    $table->idProvincia = $model->idProvincia;
                    $table->codComuna = $model->codComuna;
                    $table->telefono = $model->telefono;
                    $table->email = $model->email;
                    //Si el registro es guardado correctamente
                    if ($table->insert()) {
                        $transaction->commit();
                        $model->rutdocente = null;
                        $model->nombres = null;
                        $model->paterno = null;
                        $model->materno = null;
                        $model->calle = null;
                        $model->numero = null;
                        $model->depto = null;
                        $model->block = null;
                        $model->villa = null;
                        $model->telefono = null;
                        $model->email = null;

                        PNotify::widget(['pluginOptions' => ['title' =>
                            'Ingreso', 'text' => 'Se ha ingresado correctamente un nuevo <b>Docente</b>.',
                            'type' => 'info', ]]);
                        echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("docente/indexdocente") .
                            "'>";
                    } else {
                        $transaction->rollBack();
                        PNotify::widget(['pluginOptions' => ['title' =>
                            'Error', 'text' => 'Se ha producido un error al querer ingresar este <b>Docente</b>.',
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
            } else {
                $model->getErrors();
            }
        }
        return $this->render('register', ["model" => $model]);
    }

    /**
     * 
     * Se encarga de actualizar un docente
     * 
     */
    public function actionUpdateprofe($id)
    {
        $model = new FormUpdateDocente;

        $table = new Docente;

        //validación mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $transaction = $table::getDb()->beginTransaction();
                try {
                    $table = Docente::findOne(["rutdocente" => $id]);
                    if ($table) {
                        $table->nombres = $model->nombres;
                        $table->paterno = $model->paterno;
                        $table->materno = $model->materno;
                        $table->telefono = $model->telefono;
                        $table->calle = $model->calle;
                        $table->numero = $model->numero;
                        $table->depto = $model->depto;
                        $table->block = $model->block;
                        $table->villa = $model->villa;
                        $table->codRegion = $model->codRegion;
                        $table->idProvincia = $model->idProvincia;
                        $table->codComuna = $model->codComuna;
                        $table->email = $model->email;
                        if ($table->update()) {
                            $transaction->commit();
                            PNotify::widget(['pluginOptions' => ['title' =>
                                'Docente', 'text' => 'El docente se ha actualizado exitosamente.-', 'type' =>
                                'success', ]]);
                            echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("docente/indexdocente") .
                                "'>";
                        } else {
                            $transaction->rollBack();
                            PNotify::widget(['pluginOptions' => ['title' =>
                                'Docente', 'text' => 'No se ha actualizado el docente.-', 'type' => 'error', ]]);
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
            } else {
                $model->getErrors();
            }
        } else {
            $table = Docente::findOne(["rutdocente" => $id]);
            if ($table) {
                $model->nombres = $table->nombres;
                $model->paterno = $table->paterno;
                $model->materno = $table->materno;
                $model->telefono = $table->telefono;
                $model->calle = $table->calle;
                $model->numero = $table->numero;
                $model->depto = $table->depto;
                $model->block = $table->block;
                $model->villa = $table->villa;
                $model->codRegion = $table->codRegion;
                $model->idProvincia = $table->idProvincia;
                $model->codComuna = $table->codComuna;
                $model->email = $table->email;
            }
        }
        return $this->render('updateprofe', ["model" => $model]);
    }

    /**
     * 
     * Se encarga de devolver el Run sin puntos ejemplo:12.345.678-0 a 12345678
     */
    private function quitarStringless($run)
    {
        $runmenosptos = str_replace('.', "", $run);
        $data = explode('-', $runmenosptos);
        return $data[0];
    }

    /**
     * 
     * Se encarga de devolver el d�gito verificador del Run
     *  
     */
    private function devolverDigito($run)
    {
        $runmenosptos = str_replace('.', "", $run);
        $data = explode('-', $runmenosptos);
        $verificador = strtolower($data[1]);
        return $verificador;
    }

    /**
     * 
     * Se encarga de borrar un docente
     * 
     */
    public function actionDelete($id)
    {
        if ($id != null) {
            $table = new Docente;
            $transaction = $table->getDb()->beginTransaction();
            try {
                if ($table::deleteAll("rutdocente=:rutdocente", [":rutdocente" => $id])) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', utf8_encode('Se ha borrado correctamente el Docente.-'));
                    echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("docente/indexdocente") .
                        "'>";
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', utf8_encode('Ocurrio un error, no se borro el Docente.-'));
                    echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("docente/indexdocente") .
                        "'>";
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

    /**
     * 
     * Listado de provincias a partir de del id de region
     * 
     */
    public function actionListprovi($id)
    {
        $countProvincias = Provincias::find()->where(['codRegion' => $id])->count();

        $provincialists = Provincias::find()->where(['codRegion' => $id])->all();

        if ($countProvincias > 0) {

            foreach ($provincialists as $provi) {
                echo "<option value='" . $provi->idProvincia . "'>" . $provi->Provincia .
                    "</option>";
            }
        } else {
            echo "<option>--------</option>";
        }
    }

    /**
     * 
     * Listado de comunas por id de Provincia
     */
    public function actionListcomu($id)
    {
        $countComunas = Comunas::find()->where(['idProvincia' => $id])->count();

        $comunaslists = Comunas::find()->where(['idProvincia' => $id])->all();

        if ($countComunas > 0) {
            foreach ($comunaslists as $comu) {
                echo "<option value='" . $comu->codComuna . "'>" . $comu->comuna . "</option>";
            }
        } else {
            echo "<option>--------</option>";
        }
    }
}
