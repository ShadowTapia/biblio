<?php

namespace app\controllers;

use Yii;
use app\models\anos\Anos;
use app\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\Session;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\FormRecoverpass;
use app\models\FormResetPass;
use app\models\Users;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAdmin()
    {
        return $this->render("admin");
    }

    public function actionBiblio()
    {
        return $this->render("biblio");
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $year = Anos::find()
            ->where(['activo' => '1'])
            ->one();

        if (!\yii::$app->user->isGuest) {
            if (User::isUserAdmin(Yii::$app->user->identity->getId())) {
                Yii::$app->session->set('anoActivo', $year->idano);
                Yii::$app->session->set('nameAno', $year->nombreano);
                Yii::$app->session->set('adminUser', "admin");
            } elseif (User::isUserBiblio(Yii::$app->user->identity->getId())) {
                Yii::$app->session->set('anoActivo', $year->idano);
                Yii::$app->session->set('nameAno', $year->nombreano);
                Yii::$app->session->set('biblioUser', 'biblio');
            } elseif (User::isUserInspec(Yii::$app->user->identity->getId())) {
                Yii::$app->session->set('anoActivo', $year->idano);
                Yii::$app->session->set('nameAno', $year->nombreano);
                Yii::$app->session->set('InspecUser', 'Inspec');
            } elseif (User::isUserProfe(Yii::$app->user->identity->getId())) {
                Yii::$app->session->set('anoActivo', $year->idano);
                Yii::$app->session->set('nameAno', $year->nombreano);
                Yii::$app->session->set('profeUser', 'profe');
            } elseif (User::isUserFuncionario(Yii::$app->user->identity->getId())) {
                Yii::$app->session->set('anoActivo', $year->idano);
                Yii::$app->session->set('nameAno', $year->nombreano);
                Yii::$app->session->set('funcionarioUser', 'funcionario');
            } elseif (User::isUserAlumno(Yii::$app->user->identity->getId())) {
                Yii::$app->session->set('anoActivo', $year->idano);
                Yii::$app->session->set('nameAno', $year->nombreano);
                Yii::$app->session->set('alumnoUser', 'alumno');
            }
            Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params['sessionTimeoutSeconds']);
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (User::isUserAdmin(Yii::$app->user->identity->getId())) {
                Yii::$app->session->set('anoActivo', $year->idano);
                Yii::$app->session->set('nameAno', $year->nombreano);
                Yii::$app->session->set('adminUser', 'admin');
            } elseif (User::isUserBiblio(Yii::$app->user->identity->getId())) {
                Yii::$app->session->set('anoActivo', $year->idano);
                Yii::$app->session->set('nameAno', $year->nombreano);
                Yii::$app->session->set('biblioUser', 'biblio');
            } elseif (User::isUserInspec(Yii::$app->user->identity->getId())) {
                Yii::$app->session->set('anoActivo', $year->idano);
                Yii::$app->session->set('nameAno', $year->nombreano);
                Yii::$app->session->set('InspecUser', 'Inspec');
            } elseif (User::isUserProfe(Yii::$app->user->identity->getId())) {
                Yii::$app->session->set('anoActivo', $year->idano);
                Yii::$app->session->set('nameAno', $year->nombreano);
                Yii::$app->session->set('profeUser', 'profe');
            } elseif (User::isUserFuncionario(Yii::$app->user->identity->getId())) {
                Yii::$app->session->set('anoActivo', $year->idano);
                Yii::$app->session->set('nameAno', $year->nombreano);
                Yii::$app->session->set('funcionarioUser', 'funcionario');
            } elseif (User::isUserAlumno(Yii::$app->user->identity->getId())) {
                Yii::$app->session->set('anoActivo', $year->idano);
                Yii::$app->session->set('nameAno', $year->nombreano);
                Yii::$app->session->set('alumnoUser', 'alumno');
            }
            Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params['sessionTimeoutSeconds']);
            return $this->goBack();
        } else {
            return $this->render('login', ['model' => $model,]);
        }
        // if (!\Yii::$app->user->isGuest) {
        //            if (User::isUserAdmin(Yii::$app->user->identity->id)) {
        //                //Yii::$app->session['adminUser'] = "admin";
        //                return $this->redirect(["site/admin"]);
        //            } elseif (User::isUserBiblio(Yii::$app->user->identity->id)) {
        //                //Yii::$app->session['biblioUser'] = "biblio";
        //                return $this->redirect(["site/biblio"]);
        //            }
        //            //return $this->goHome();
        //        }
        //
        //        $model = new LoginForm();
        //        if ($model->load(Yii::$app->request->post()) && $model->login()) {
        //            if (User::isUserAdmin(Yii::$app->user->identity->id)) {
        //                //Yii::$app->session['adminUser'] = "admin";
        //                return $this->redirect(["site/admin"]);
        //            } elseif (User::isUserBiblio(Yii::$app->user->identity->id)) {
        //                //Yii::$app->session['biblioUser'] = "biblio";
        //                return $this->redirect(["site/biblio"]);
        //            }
        //        } else {
        //            return $this->render('login', ['model' => $model, ]);
        //        }


    }
    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->session['userSessionTimeout'] < time()) {
                Yii::$app->user->logout();
            } else {
                Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params['sessionTimeoutSeconds']);
                return true;
            }
        }
        return true;
    }


    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        if (isset(Yii::$app->session['adminUser'])) {
            unset(Yii::$app->session['adminUser']);
            unset(Yii::$app->session['anoActivo']);
            unset(Yii::$app->session['nameAno']);
        }
        if (isset(Yii::$app->session['biblioUser'])) {
            unset(Yii::$app->session['biblioUser']);
            unset(Yii::$app->session['anoActivo']);
            unset(Yii::$app->session['nameAno']);
        }
        if (isset(Yii::$app->session['InspecUser'])) {
            unset(Yii::$app->session['InspecUser']);
            unset(Yii::$app->session['anoActivo']);
            unset(Yii::$app->session['nameAno']);
        }
        if (isset(Yii::$app->session['profeUser'])) {
            unset(Yii::$app->session['profeUser']);
            unset(Yii::$app->session['anoActivo']);
            unset(Yii::$app->session['nameAno']);
        }
        if (isset(Yii::$app->session['funcionarioUser'])) {
            unset(Yii::$app->session['funcionarioUser']);
            unset(Yii::$app->session['anoActivo']);
            unset(Yii::$app->session['nameAno']);
        }
        if (isset(Yii::$app->session['alumnoUser'])) {
            unset(Yii::$app->session['alumnoUser']);
            unset(Yii::$app->session['anoActivo']);
            unset(Yii::$app->session['nameAno']);
        }
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {

            //Se crea la variable que leera la página contact
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    private function randkey($str = '', $long = 0)
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
     * @return string
     * Manejador de errores
     */
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception instanceof NotFoundHttpException) {
            //Al no existir controles mas acciones finaliza aqui
            return $this->render('pnf');
        } else {
            return $this->render('error', compact('exception'));
        }
    }

    /**
     * Acción de recuperar contraseña del usuario
     * 
     */
    public function actionRecoverpass()
    {
        //Instancia para validar el formulario
        $model = new FormRecoverpass();

        //Mensaje que será mostrado al usuario en la vista
        $msg = null;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                //Buscar al usuario a traves del mail
                $table = Users::find()->where("UserMail=:UserMail", [":UserMail" => $model->UserMail]);

                //Si el usuario existe
                if ($table->count() == 1) {
                    //Crear variables de sesión para limitar el tiempo de restablecimiento de la contraseña
                    //Hasta que el navegador cierre
                    $session = new Session();
                    $session->open();

                    //Esta clave aleatoria se cargará en un campo oculto del formulario reseteado
                    $session["recover"] = $this->randkey("abcdef0123456789", 200);
                    $recover = $session["recover"];

                    //También almacenamos el id del usuario en una variable de sesión
                    //El id del usuario es necesario para generar la consulta a la tabla users
                    //y restablecer la contraseña
                    $table = Users::find()->where("UserMail=:UserMail", [":UserMail" => $model->UserMail])->one();
                    $session["id_recover"] = $table->idUser;

                    //Esta variable contiene un número hexadecimal que será enviado en el correo al usuario
                    //para que lo introduzca en un campo del formulario de reseteado
                    //Es guardada en el registro correspondiente de la tabla users
                    $verification_code = $this->randkey("abcdef0123456789", 8);
                    //Columna verification_code
                    $table->verification_code = $verification_code;
                    //Guardamos los cambios en la tabla Users
                    $table->save();

                    //Creamos el msg que será enviado al correo del usuario
                    $subject = "Recuperar contraseña";
                    $body = "<p>Copie el siguiente código de verificación para restablecer su contraseña ... ";
                    $body .= "<strong>" . $verification_code . "</strong></p>";
                    $body .= "<p><a href='https://biblio.kingstownschool.cl/site/resetpass'>Recuperar password</a></p>";
                    $headers = "From: " . Yii::$app->params["adminEmail"] . "\r\n" .

                        "Reply-To: " . Yii::$app->params["adminEmail"] . "\r\n";


                    //Enviamos el correo
                    @mail($model->UserMail, $subject, $body, $headers);

                    //Vaciar el campo del formulario
                    $model->UserMail = null;

                    //Mostrar el mensaje al usuario
                    $msg = "Le hemos enviado un mensaje a su cuenta de correo para que pueda cambiar su contraseña.";
                    Yii::$app->session->setFlash('success', $msg);
                } else {
                    //El usuario no existe
                    $msg = "Ha ocurrido un error, favor contactarse con el Administrador de la plataforma";
                    Yii::$app->session->setFlash('danger', $msg);
                }
            } else {
                $model->getErrors();
            }
        }
        return $this->render("recoverpass", ["model" => $model]);
    }

    /**
     * Acción de reseto de password
     */
    public function actionResetpass()
    {
        //Instancia para validar el formulario
        $model = new FormResetPass();

        //Abrimos la sesión
        $session = new Session();
        $session->open();

        //Si no existen las variables de sesión requeridas lo expulsamos a la página de inicio
        if (empty($session["recover"]) || empty($session["id_recover"])) {
            return $this->redirect("index");
        } else {
            $recover = $session["recover"];
            //El valor de esta variable de sesión la cargamos en el campo recover del formulario
            $model->recover = $recover;

            //Esta variable contiene el id del usuario que solicitó restablecer la contraseña
            //Será utilizada para realizar la consulta a la tabla Users
            $id_recover = $session["id_recover"];
        }

        //Si el formulario es enviado para resetear el password
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                //Si el valor de la variable de sesión recover es correcta
                if ($recover == $model->recover) {
                    //Preparamos la consulta para resetear el password, necesitamos el email y el id
                    //del usuario que fue guardado en un variable de sesión y el código de verificación
                    //que fue enviado en el correo al usuario y que fue guardado en el registro
                    $table = Users::findOne(["UserMail" => $model->UserMail, "idUser" => $id_recover, "verification_code" => $model->verification_code]);

                    //Encriptamos la password
                    $table->UserPass = crypt($model->UserPass, Yii::$app->params["salt"]);

                    //Si la actualización se lleva a cabo correctamente
                    if ($table->save()) {
                        //Destruir las variables de sesión
                        $session->destroy();

                        //Vaciar los campos del formulario
                        $model->UserMail = null;
                        $model->UserPass = null;
                        $model->password_repeat = null;
                        $model->recover = null;
                        $model->verification_code = null;

                        $msg = "Enhorabuena, contraseña modificada correctamente, redireccionando a la página de login ...";
                        $msg .= "<meta http-equiv='refresh' content='5; " . Url::toRoute("site/login") . "'>";
                        Yii::$app->session->setFlash('success', $msg);
                    } else {
                        $msg = "Ha ocurrido un error, favor de contactar al administrador de la plataforma.";
                        Yii::$app->session->setFlash('danger', $msg);
                    }
                }
            } else {
                $model->getErrors();
            }
        }
        return $this->render("resetpass", ["model" => $model]);
    }
}
