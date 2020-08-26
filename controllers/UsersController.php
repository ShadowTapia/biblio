<?php

namespace app\controllers;

use app\models\FormChangeDatos;
use app\models\FormChangePass;
use app\models\FormRegister;
use app\models\FormUpdateUser;
use app\models\SearchUsers;
use app\models\Users;
use raoul2000\widget\pnotify\PNotify;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    /**
     * {@inheritdoc}
     */
//    public function behaviors()
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
//        ];
//    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchUsers();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
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
     *
     * Se encarga de registrar un nuevo usuario
     *
     **/
    public function actionRegister()
    {
        //Creamos la instancia con el model de validaciï¿½n
        $model = new FormRegister;

        //aqui comienza el codigo ya probado
        //Validaciï¿½n mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        //validación cuando el formulario es enviado vía post
        //Esto sucede cuando la validación ajax se ha llevado correctamente
        //También previene por si el usuario tiene desactivado el javascript y la
        //validación mediante ajax no puede ser llevada a cabo
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                //preparamos la consulta para guardar el usuario
                $table = new Users;

                $transaction = $table::getDb()->beginTransaction();
                try {
                    $table->UserRut = $this->removeStringless($model->UserRut);
                    $table->UserName = $model->UserName;
                    $table->UserLastName = $model->UserLastName;
                    $table->UserMail = $model->UserMail;
                    $table->activate = 1;
                    $table->Idroles = $model->idroles;
                    //Encriptamos la password
                    $table->UserPass = crypt($model->UserPass, Yii::$app->params["salt"]);
                    //Creamos una cookie para autenticar al usuario cuando decida recordar la sesiï¿½n
                    //Esta misma clave serï¿½ utilizada para activar el usuario
                    $table->authkey = $this->randKey("abcdef0123456789", 200);
                    //Creamos un token de acceso ï¿½nico para el usuario
                    $table->accessToken = $this->randKey("abcdef0123456789", 200);

                    //Si el registro es guardado correctamente
                    if ($table->insert()) {
                        //Nueva consulta para obtener el id del usuario
                        //para confirmar al usuario se requiere su id y su authkey
                        $users = $table->find()->where(["UserMail" => $model->UserMail])->one();
                        $id = urlencode($users->idUser);
                        $authkey = urlencode($users->authkey);

                        /**
                         * $subject = "Confirmar registro";
                         * $body = "<h1>Haga click en el siguiente enlace para finalizar tu registro</h1>";
                         * $body .= "<a href='http://http://localhost/php/biblio/web/index.php?r=site/confirm&id=".$id."&authKey=".$authKey."'>Confirmar</a>";

                         * //Enviamos el correo
                         * Yii::$app->mailer->compose()
                         * ->setTo($user->email)
                         * ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
                         * ->setSubject($subject)
                         * ->setHtmlBody($body)
                         * ->send();
                         **/
                        $transaction->commit();

                        $model->UserRut = null;
                        $model->UserName = null;
                        $model->UserLastName = null;
                        $model->UserMail = null;
                        $model->UserPass = null;
                        $model->UserPass_repeat = null;

                        PNotify::widget(['pluginOptions' => ['title' =>
                            'Ingreso', 'text' => 'Se ha ingresado correctamente un nuevo <b>Usuario</b>.',
                            'type' => 'info', ]]);
                        echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("usuarios/index") .
                            "'>";
                    } else {
                        $transaction->rollBack();
                        PNotify::widget(['pluginOptions' => ['title' =>
                            'Error', 'text' => 'Se ha producido un error al querer ingresar este <b>Usuario</b>.',
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
     * @param $run
     * @return mixed
     * Retorna el run en formato 12345678 en vez de 12.345.678-0
     */
    private function removeStringless($run)
    {
        $runmenosptos = str_replace('.', "", $run);
        $data = explode('-', $runmenosptos);
        return $data[0];
    }

    private function randKey($str = '', $long = 0)
    {
        $key = null;
        $str = str_split($str);
        $start = 0;
        $limit = count($str) - 1;
        for ($x = 0; $x < $long; $x++) {
            $key .= $str[rand($start, $limit)];
        }
        return $key;
    }


    /**
     * &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&6666
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Users();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->idUser]);
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->idUser]);
//        }
//
//        return $this->render('update', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&6
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Se encarga de actualizar el usuario
     */
    public function actionUpdateuser($id)
    {
        $model = new FormUpdateUser;

        $table = new Users;

        //validación mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $transaction = $table->getDb()->beginTransaction();
                try {
                    $table = Users::findOne(["idUser" => $id]);
                    if ($table) {
                        $table->UserName = $model->UserName;
                        $table->UserLastName = $model->UserLastName;
                        $table->UserMail = $model->UserMail;
                        $table->Idroles = $model->idroles;
                        $table->activate = $model->activate;

                        if ($table->update()) {
                            $transaction->commit();
                            Yii::$app->session->setFlash('success', 'El Usuario se ha actualizado exitosamente.-');
                            return $this->redirect(['index']);

                        } else {
                            $transaction->rollBack();
                            Yii::$app->session->setFlash('error', 'No se ha actualizado el Usuario.-');
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
            $table = Users::findOne(["idUser" => $id]);
            if ($table) {
                $model->UserName = $table->UserName;
                $model->UserLastName = $table->UserLastName;
                $model->UserMail = $table->UserMail;
                $model->idroles = $table->Idroles;
                $model->activate = $table->activate;
            }
        }

        return $this->render('updateuser', ["model" => $model]);
    }

    /**
     *
     * Se encarga de borrar un usuario
     *
     */
    public function actionDelete($id)
    {
        if ($id != null) {
            $table = new Users;
            $transaction = $table::getDb()->beginTransaction();
            try {
                if ($table::deleteAll("idUser=:idUser", [":idUser" => $id])) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', utf8_encode('Se ha borrado correctamente el Usuario.-'));
                    echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("users/index") .
                        "'>";
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', utf8_encode('Ocurrio un error, no se borro el Usuario.-'));
                    echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("users/index") .
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
     * Se encarga de cambiar la contraseña del usuario
     *
     *
     */
    public function actionChangepass()
    {
        //Creamos la instancia con el modelo de validaciï¿½n
        $model = new FormChangePass;

        //validación mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $table = new Users;

                $transaction = $table->getDb()->beginTransaction();
                try {
                    $table = Users::findOne(["idUser" => Yii::$app->user->identity->id]);

                    if ($table->UserPass == crypt($model->password, Yii::$app->params["salt"])) {
                        $table->UserPass = crypt($model->password_new, Yii::$app->params["salt"]);
                        if ($table->save()) {
                            $transaction->commit();

                            $model->password = null;
                            $model->password_new = null;
                            $model->password_repeat = null;
                            PNotify::widget([
                                'pluginOptions' => [
                                    'title' => 'Usuarios',
                                    'text' => utf8_encode('La contraseña fue actualizada correctamente.'),
                                    'type' => 'success',
                                ]]);
                        } else {
                            PNotify::widget([
                                'pluginOptions' => [
                                    'title' => 'Error',
                                    'text' => utf8_encode('La contraseña no pudo ser actualizada.'),
                                    'type' => 'error',
                                ]]);
                        }
                    } else //la contraseï¿½a original no coincide con la almecanda en la BBDD
                    {
                        PNotify::widget([
                            'pluginOptions' => [
                                'title' => 'Error',
                                'text' => utf8_encode('La contraseña anterior no coincide con nuestros registros.- '),
                                'type' => 'error',
                            ]]);
                    }
                }
                catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
                catch (\Throwable $e)
                {
                    $transaction->rollBack();
                    throw $e;
                }
            } else {
                $model->getErrors();
            }
        }

        return $this->render("changepass", ["model" => $model]);
    }


    /**
     *
     * Se encarga de cambiar el mail del usuario
     *
     */
    public function actionChangedatos()
    {
        $model = new FormChangeDatos;

        $table = new Users;

        //validación mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $table = Users::findOne(["idUser" => Yii::$app->user->identity->id]);
                if ($table) {
                    $table->UserMail = $model->UserMail;
                    if ($table->update()) {
                        PNotify::widget([
                            'pluginOptions' => [
                                'title' => 'Usuarios',
                                'text' => 'El correo fue cambiado exitosamente.-',
                                'type' => 'success',
                            ]]);

                        //Yii::$app->session->setFlash('success', utf8_encode('El correo fue cambiado exitosamente.-'));
                    } else {
                        PNotify::widget([
                            'pluginOptions' => [
                                'title' => 'Usuarios',
                                'text' => 'El correo no pudo ser actualizado.-',
                                'type' => 'error',
                            ]]);
                        //Yii::$app->session->setFlash('error', utf8_encode('El correo no fue cambiado.-'));
                    }
                }
            } else {
                $model->getErrors();
            }
        } else {
            $table = Users::findOne(["idUser" => Yii::$app->user->identity->id]);
            if ($table) {
                $model->UserMail = $table->UserMail;
            }
        }

        return $this->render("changedatos", ["model" => $model]);
    }

    /**
     *
     * Se encarga de actualizar la contraseña del usuario
     *
     */
    public function actionUppass($id)
    {
        if ($id != null)
        {
            $table = new Users;
            $table = Users::findOne(["idUser" => $id]);
            $run = $table->UserRut;
            if ($table)
            {
                //Iniciamos la transaction
                $transaction = $table->getDb()->beginTransaction();
                try
                {
                    $table->UserPass = crypt($run, Yii::$app->params["salt"]);
                    if ($table->update()) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Se ha actualizado correctamente la contraseña .-');
                        echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("users/index") .
                            "'>";
                    } else {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', 'Ocurrio un error, al actualizar la contraseña .-');
                        echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("users/index") .
                            "'>";
                    }

                }catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
                catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
        }
    }
}
