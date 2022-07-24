<?php

namespace app\controllers;

use app\models\alumnos\Alumnos;
use app\models\apoderados\Apoderados;
use app\models\prestamos\FormUpdatePrestamos;
use app\models\docente\FormDocOnlyRut;
use app\models\Users;
use kartik\form\ActiveForm;
use Yii;
use app\models\prestamos\Prestamos;
use app\models\prestamos\PrestamosSearch;
use app\models\alumnos\FormAluOnlyRut;
use app\models\FormUserOnlyRut;
use app\models\apoderados\FormApoOnlyRut;
use app\models\ejemplar\Ejemplar;
use app\models\libros\LibrosSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\base\Exception;
use yii\db\StaleObjectException;

/**
 * PrestamosController implements the CRUD actions for Prestamos model.
 */
class PrestamosController extends Controller
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
     * Lists all Prestamos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PrestamosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     *
     * Renderiza la opción para prestar libros
     */
    public function actionPrestar()
    {
        $searchModel = new LibrosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('prestar', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $dateStart
     * @param $dateEnd
     * @return float
     */
    protected function calculofechas($dateStart,$dateEnd)
    {
        $dateStart = strtotime($dateStart);
        $dateEnd = strtotime($dateEnd);
        $datediff = $dateEnd - $dateStart;
        $date_dias = round($datediff / (60 * 60 * 24));

        return $date_dias;
    }

    /**
     * @param $id
     * @param $titulo
     * @return array|string
     * @throws Exception
     * @throws \Throwable
     */
    public function actionPrestarfuncionario($id,$titulo)
    {
        $model = new Prestamos();
        $modelUser = new FormUserOnlyRut();
        $modelEjemplar = new Ejemplar();
        $tablePrestamos = new Prestamos();
        $iUser='';

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load(Yii::$app->request->post()) && $modelUser->load(Yii::$app->request->post()))
        {
            if($model->validate() && $modelUser->validate())
            {
                if ($this->calculofechas($model->fechapres,$model->fechadev)<0)
                {
                    \Yii::$app->session->setFlash('error','Error la fecha de prestamo no puede ser mayor a la fecha de devolución.');
                    return $this->redirect(['prestamos/prestar']);
                }else{
                    $inorden = '';
                    $tableUser = Users::findOne(['UserRut'=> $modelUser->UserRut]);
                    if($tableUser)
                    {
                        $iUser = $tableUser->idUser;
                    }
                    $tableEjemplar = Ejemplar::findOne(['idejemplar' => $id]);
                    if($tableEjemplar)
                    {
                        $inorden = $tableEjemplar->norden;
                    }
                    //Procedimiento para obtner los datos del usuario
                    $transaction = $tablePrestamos::getDb()->beginTransaction();
                    try
                    {
                        $tablePrestamos->idUser = $iUser;
                        $tablePrestamos->idejemplar = $id;
                        $tablePrestamos->norden = $inorden;
                        $tablePrestamos->fechapres = Yii::$app->formatter->asDate($model->fechapres,"yyyy-MM-dd");
                        $tablePrestamos->fechadev = Yii::$app->formatter->asDate($model->fechadev,"yyyy-MM-dd");
                        $tablePrestamos->notas = $model->notas;
                        if($tablePrestamos->insert())
                        {
                            $transaction->commit();
                            \Yii::$app->session->setFlash('success','El prestamo se ha  ingresado exitosamente.-');

                        }else{
                            $transaction->rollBack();
                            \Yii::$app->session->setFlash('error','Se ha producido un error al querer ingresar este Prestamo.');

                        }
                        return $this->redirect(['prestamos/prestar']);
                    }
                    catch (Exception $e) {
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
                $modelUser->getErrors();
            }
        }else{
            $tableEjemplar = Ejemplar::findOne(['idejemplar' => $id]);
            if($tableEjemplar)
            {
                $modelEjemplar->norden = $tableEjemplar->norden;
                $modelEjemplar->edicion = $tableEjemplar->edicion;
                $modelEjemplar->ubicacion = $tableEjemplar->ubicacion;
            }
        }
        return $this->render('prestarfuncionario', compact('model','modelEjemplar','titulo','modelUser'));
    }

    /**
     * @param $id
     * @param $titulo
     * @return array|string
     * @throws Exception
     * @throws \Throwable
     */
    public function actionPrestarprofesor($id,$titulo)
    {
        $model = new Prestamos();
        $modelProfesor = new FormDocOnlyRut();
        $modelEjemplar = new Ejemplar();
        $tablePrestamos = new Prestamos();
        $iUser='';

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $modelProfesor->load(Yii::$app->request->post())) {
            if($model->validate() && $modelProfesor->validate())
            {
                if($this->calculofechas($model->fechapres,$model->fechadev)<0)
                {
                    \Yii::$app->session->setFlash('error','Error la fecha de prestamo no puede ser mayor a la fecha de devolución.');
                    return $this->redirect(['prestamos/prestar']);
                }else{
                    $inorden = '';
                    $tableUser = Users::findOne(['UserRut'=> $modelProfesor->rutdocente]);
                    if($tableUser)
                    {
                        $iUser = $tableUser->idUser;
                    }
                    $tableEjemplar = Ejemplar::findOne(['idejemplar' => $id]);
                    if($tableEjemplar)
                    {
                        $inorden = $tableEjemplar->norden;
                    }
                    //Procedimiento para obtner los datos del usuario
                    $transaction = $tablePrestamos::getDb()->beginTransaction();
                    try
                    {
                        $tablePrestamos->idUser = $iUser;
                        $tablePrestamos->idejemplar = $id;
                        $tablePrestamos->norden = $inorden;
                        $tablePrestamos->fechapres = Yii::$app->formatter->asDate($model->fechapres,"yyyy-MM-dd");
                        $tablePrestamos->fechadev = Yii::$app->formatter->asDate($model->fechadev,"yyyy-MM-dd");
                        $tablePrestamos->notas = $model->notas;
                        if($tablePrestamos->insert())
                        {
                            $transaction->commit();
                            \Yii::$app->session->setFlash('success','El prestamo se ha  ingresado exitosamente.-');

                        }else{
                            $transaction->rollBack();
                            \Yii::$app->session->setFlash('error','Se ha producido un error al querer ingresar este <b>Prestamo</b>.');

                        }
                        return $this->redirect(['prestamos/prestar']);
                    }
                    catch (Exception $e) {
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
                $modelProfesor->getErrors();
            }
        }else{
            $tableEjemplar = Ejemplar::findOne(['idejemplar' => $id]);
            if($tableEjemplar)
            {
                $modelEjemplar->norden = $tableEjemplar->norden;
                $modelEjemplar->edicion = $tableEjemplar->edicion;
                $modelEjemplar->ubicacion = $tableEjemplar->ubicacion;
            }
        }
        return $this->render('prestarprofesor', compact('model','modelEjemplar','titulo','modelProfesor'));
    }

    /**
     * @param $id
     * @param $titulo
     * @return array|string
     * @throws Exception
     * @throws \Throwable
     */
    public function actionPrestarapoderado($id,$titulo)
    {
        $model = new Prestamos();
        $modelApoderado = new FormApoOnlyRut();
        $modelEjemplar = new Ejemplar();
        $tablePrestamos = new Prestamos();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $modelApoderado->load(Yii::$app->request->post())) {
            if ($model->validate() && $modelApoderado->validate())
            {
                if($this->calculofechas($model->fechapres,$model->fechadev)<0)
                {
                    \Yii::$app->session->setFlash('error','Error la fecha de prestamo no puede ser mayor a la fecha de devolución.');
                    return $this->redirect(['prestamos/prestar']);
                }else{
                    $iUser = '';
                    $inorden = '';
                    //Si la diferencia de fechas son positivas
                    $tableUser = Users::findOne(['UserRut'=> $modelApoderado->rutapo]);
                    if($tableUser)
                    {
                        $iUser = $tableUser->idUser;
                    }
                    $tableEjemplar = Ejemplar::findOne(['idejemplar' => $id]);
                    if($tableEjemplar)
                    {
                        $inorden = $tableEjemplar->norden;
                    }
                    //Procedimiento para obtner los datos del usuario
                    $transaction = $tablePrestamos::getDb()->beginTransaction();
                    try
                    {
                        $tablePrestamos->idUser = $iUser;
                        $tablePrestamos->idejemplar = $id;
                        $tablePrestamos->norden = $inorden;
                        $tablePrestamos->fechapres = Yii::$app->formatter->asDate($model->fechapres,"yyyy-MM-dd");
                        $tablePrestamos->fechadev = Yii::$app->formatter->asDate($model->fechadev,"yyyy-MM-dd");
                        $tablePrestamos->notas = $model->notas;
                        if($tablePrestamos->insert())
                        {
                            $transaction->commit();
                            \Yii::$app->session->setFlash('success','El prestamo se ha  ingresado exitosamente.-');

                        }else{
                            $transaction->rollBack();
                            \Yii::$app->session->setFlash('error','Se ha producido un error al querer ingresar este <b>Prestamo</b>.');

                        }
                        return $this->redirect(['prestamos/prestar']);
                    }
                    catch (Exception $e) {
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
                $modelApoderado->getErrors();
            }
        }else{
            $tableEjemplar = Ejemplar::findOne(['idejemplar' => $id]);
            if($tableEjemplar)
            {
                $modelEjemplar->norden = $tableEjemplar->norden;
                $modelEjemplar->edicion = $tableEjemplar->edicion;
                $modelEjemplar->ubicacion = $tableEjemplar->ubicacion;
            }
        }
        return $this->render('prestarapoderado', compact('model','modelEjemplar','modelApoderado','titulo'));
    }

    /**
     * @param $id
     * @return Response
     * @throws Exception
     * @throws \Throwable
     */
    public function actionDevolver($id)
    {
        $table = new Prestamos();
        $transaction = $table::getDb()->beginTransaction();
        try
        {
               if($table->deleteAll("idPrestamo=:idPrestamo",[":idPrestamo" => $id]))
               {
                   $transaction->commit();
                   \Yii::$app->session->setFlash('success', '¡Se ha devuelto de forma exitosa el prestamo!');
                   return $this->redirect(['prestamos/index']);
               }else{
                    $transaction->rollBack();
                    \Yii::$app->session->setFlash('error','Se ha producido un error y no se ha devuelto nada');
                    return $this->redirect(['prestamos/index']);
               }
        }catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        catch (\Throwable $e)
        {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * @param $id
     * @param $titulo
     * @return array|string
     * @throws \Exception
     * @throws \Throwable
     *
     * Se encarga de realizar el prestamo para alumnoa
     */
    public function actionPrestarlibro($id,$titulo)
    {
        $model = new Prestamos();
        $modelAlumno = new FormAluOnlyRut();
        $modelEjemplar = new Ejemplar();
        $tablePrestamos = new Prestamos();
        //validación mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $modelAlumno->load(Yii::$app->request->post())) {

                if($model->validate() && $modelAlumno->validate())
                {
                    if($this->calculofechas($model->fechapres,$model->fechadev)<0)
                    {
                        \Yii::$app->session->setFlash('error','Error la fecha de prestamo no puede ser mayor a la fecha de devolución.');
                        return $this->redirect(['prestamos/prestar']);
                    }else{
                        $iUser = '';
                        $inorden = '';
                        //Si la diferencia de fechas son positivas
                        $tableUser = Users::findOne(['UserRut'=> $modelAlumno->rutalumno]);
                        if($tableUser)
                        {
                            $iUser = $tableUser->idUser;
                        }
                        $tableEjemplar = Ejemplar::findOne(['idejemplar' => $id]);
                        if($tableEjemplar)
                        {
                            $inorden = $tableEjemplar->norden;
                        }
                        //Procedimiento para obtner los datos del usuario
                        $transaction = $tablePrestamos::getDb()->beginTransaction();
                        try
                        {
                            $tablePrestamos->idUser = $iUser;
                            $tablePrestamos->idejemplar = $id;
                            $tablePrestamos->norden = $inorden;
                            $tablePrestamos->fechapres = Yii::$app->formatter->asDate($model->fechapres,"yyyy-MM-dd");
                            $tablePrestamos->fechadev = Yii::$app->formatter->asDate($model->fechadev,"yyyy-MM-dd");
                            $tablePrestamos->notas = $model->notas;
                            if($tablePrestamos->insert())
                            {
                                $transaction->commit();
                                \Yii::$app->session->setFlash('success','El prestamo se ha  ingresado exitosamente.-');

                            }else{
                                $transaction->rollBack();
                                \Yii::$app->session->setFlash('error','Se ha producido un error al querer ingresar este Prestamo.');

                            }
                            return $this->redirect(['prestamos/prestar']);
                        }
                        catch (Exception $e) {
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
                    $modelAlumno->getErrors();
                }
        }else{
            $tableEjemplar = Ejemplar::findOne(['idejemplar' => $id]);
            if($tableEjemplar)
            {
                $modelEjemplar->norden = $tableEjemplar->norden;
                $modelEjemplar->edicion = $tableEjemplar->edicion;
                $modelEjemplar->ubicacion = $tableEjemplar->ubicacion;
            }

        }
        return $this->render('prestarlibro', compact('model','modelAlumno','modelEjemplar','titulo'));
    }

    /**
     * @return string
     */
    public function actionLista_apoderados()
    {
        $out = [];
        if(isset($_POST['depdrop_parents']))
        {
            $id = end($_POST['depdrop_parents']);
            if(!empty($_POST['depdrop_params']))
            {
                $params = $_POST['depdrop_params'];
                $param1 = $params[0];
            }
            $list = Apoderados::find()
                ->joinWith(['pivots pi'])
                ->where(['pi.idCurso'=> $id])
                ->andWhere(['pi.retirado' => '0'])
                ->andWhere(['pi.idano'=>\Yii::$app->session->get('anoActivo')])
                ->asArray()
                ->all();
            $selected = null;
            if($id!=null && count($list)>0)
            {
                $selected=''; $cont = 0;
                foreach ($list as $i=>$apoderado)
                {
                    $cont++;
                    $out[] = ['id' => $apoderado['rutapo'],'name' => $cont . '.- ' . $apoderado['apepat'] . ' ' . $apoderado['apemat'] . ',' . $apoderado['nombreapo']];
                    if(!empty($param1))
                    {
                        $selected = $param1;
                    }
                }
                return Json::encode(['output'=>$out, 'selected'=>$selected]);
            }
        }
        return Json::encode(['output'=>'', 'selected'=>'']);
    }

    /**
     * @return string
     *  Se encarga de devolver los nombres de los alumnos pertenecientes a un curso
     */
    public function actionLista_alumnos()
    {
        $out = [];
        if(isset($_POST['depdrop_parents']))
        {
            $id = end($_POST['depdrop_parents']);
            if(!empty($_POST['depdrop_params']))
            {
                $params = $_POST['depdrop_params'];
                $param1 = $params[0];
            }
            $list = Alumnos::find()
                ->joinWith(['pivots pi'])
                ->where(['pi.idCurso'=> $id])
                ->andWhere(['pi.retirado' => '0'])
                ->andWhere(['pi.idano'=>\Yii::$app->session->get('anoActivo')])
                ->asArray()
                ->all();
            $selected = null;
            if($id!=null && count($list)>0)
            {
                $selected=''; $cont = 0;
                foreach ($list as $i => $alumno)
                {
                    $cont++;
                    $out[] = ['id' => $alumno['rutalumno'],'name' => $cont . '.- ' . $alumno['paternoalu'] . ' ' . $alumno['maternoalu'] . ',' . $alumno['nombrealu']];
                    if(!empty($param1))
                    {
                        $selected = $param1;
                    }
                }
                return Json::encode(['output'=>$out, 'selected'=>$selected]);
            }
        }
        return Json::encode(['output'=>'', 'selected'=>'']);
    }


    /**
     * Displays a single Prestamos model.
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
     * Creates a new Prestamos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Prestamos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idPrestamo]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return array|string
     * @throws Exception
     * @throws \Throwable
     */
    public function actionUpdate($id)
    {
        $model = new FormUpdatePrestamos();
        $table = new Prestamos();
        $user = '';
        $ejemplar = '';
        $name = '';
        $libro = '';

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if($model->validate())
            {
                $transaction = $table->getDb()->beginTransaction();
                try
                {
                    $table = Prestamos::findOne(['idPrestamo'=>$id]);
                    if($table)
                    {

                        $table->fechapres = Yii::$app->formatter->asDate($model->fechapres,"yyyy-MM-dd");
                        $table->fechadev = Yii::$app->formatter->asDate($model->fechadev,"yyyy-MM-dd");
                        $table->notas = $model->notas;
                        if($table->update())
                        {
                            $transaction->commit();
                            \Yii::$app->session->setFlash('success', 'Se ha actualizado correctamente este prestamo.-');
                        }else{
                            $transaction->rollBack();
                            \Yii::$app->session->setFlash('error', 'A ocurrido un error al intentar actualizar este prestamo.-');
                        }
                        return $this->redirect(['prestamos/index']);
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
            $table = Prestamos::findOne(['idPrestamo'=>$id]);
            if($table)
            {
                if (!empty($table->idejemplar))
                {
                    $ejemplar = $table->idejemplar;
                }
                if (!empty($table->idUser)) {
                    $user = $table->idUser;
                }
                if (!empty($table->fechapres)) {
                    $model->fechapres = $table->fechapres;
                }
                if (!empty($table->fechadev)) {
                    $model->fechadev = $table->fechadev;
                }
                if (!empty($table->notas)) {
                    $model->notas = $table->notas;
                }
            }
            //Busqueda del Usuario
            $tableUser = Users::findOne(['idUser'=>$user]);
            if($tableUser)
            {
                $name = $tableUser->UserName . ' ' . $tableUser->UserLastName;
            }
            //Busqueda del libro asociado al ejemplar
            $tableEjemplar = Ejemplar::findOne(['idejemplar'=>$ejemplar]);
            if($tableEjemplar)
            {
                $libro = $tableEjemplar->idLibros0->titulo;
            }
            //$model = $this->findModel($id);

        }
        return $this->render('update', ['model'=>$model,'name'=>$name,'libro'=>$libro]);
    }

    /**
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Prestamos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Prestamos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Prestamos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
