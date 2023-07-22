<?php

namespace app\controllers;

use Yii;
use app\models\anos\Anos;
use app\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\NotFoundHttpException;

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
}
