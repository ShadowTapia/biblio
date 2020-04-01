<?php

namespace app\controllers;

use app\models\anos\Anos;
use app\models\ContactForm;
use app\models\LoginForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
                    'access' => [
                        'class' => AccessControl::className(),
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
                        'class' => VerbFilter::className(),
                        'actions' => [
                            'logout' => ['post'],
                        ],
                    ],
                ];

        //return ['access' => ['class' => AccessControl::className(), 'only' => ['logout',
//            'biblio', 'admin'], 'rules' => [[ //El administrador tiene permisos sobre las siguientes acciones
//            'actions' => ['logout', 'admin'], //Esta propiedad establece que tiene permisos
//            'allow' => true, //Usuarios autenticados, el signo ? es para invitados
//            'roles' => ['@'], //Este m�todo nos permite crear un filtro sobre la identidad del usuario
//            //y as� establecer si tiene permisos o no
//        'matchCallback' => function ($rule, $action)
//        {
//            //Llamada al m�todo que comprueba si es un administrador
//            return User::isUserAdmin(Yii::$app->user->identity->id);
//        }
//        , ], [ //Los usuarios simples tienen permisos sobre las siguientes acciones
//           'actions' => ['logout', 'biblio'], //Esta propiedad establece que tiene permisos
//            'allow' => true, //Usuarios autenticados, el signo ? es para invitados
//            'roles' => ['@'], //Este m�todo nos permite crear un filtro sobre la identidad del usuario
//            //y as� establecer si tiene permisos o no
//       'matchCallback' => function ($rule, $action)
//        {
//           //Llamada al m�todo que comprueba si es un usuario simple
//            return User::isUserBiblio(Yii::$app->user->identity->id);
//        }
//        , ], ], ], //Controla el modo en que se accede a las acciones, en este ejemplo a la acci�n logout
//            //s�lo se puede acceder a trav�s del m�todo post
//        'verbs' => ['class' => VerbFilter::className(), 'actions' => ['logout' => ['post'], ], ], ]; 

    }    

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return ['error' => ['class' => 'yii\web\ErrorAction', ], 'captcha' => ['class' =>
            'yii\captcha\CaptchaAction', 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null, ], ];
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
                ->where(['activo'=>'1'])
                ->one();
                
        if (!\yii::$app->user->isGuest)
       {
            if (User::isUserAdmin(Yii::$app->user->identity->id))
            {
                Yii::$app->session['anoActivo'] = $year->idano;
                Yii::$app->session['nameAno'] = $year->nombreano;
                Yii::$app->session['adminUser'] = "admin";
            }elseif (User::isUserBiblio(Yii::$app->user->identity->id))
            {
                Yii::$app->session['anoActivo'] = $year->idano;
                Yii::$app->session['nameAno'] = $year->nombreano;               
                Yii::$app->session['biblioUser'] = "biblio";
            }
            return $this->goHome();
       }
       
       $model = new LoginForm();
       if ($model->load(Yii::$app->request->post()) && $model->login())
       {
            if (User::isUserAdmin(Yii::$app->user->identity->id))
            {
                Yii::$app->session['anoActivo'] = $year->idano;
                Yii::$app->session['nameAno'] = $year->nombreano;
                Yii::$app->session['adminUser'] = "admin";
            }elseif (User::isUserBiblio(Yii::$app->user->identity->id))
            {
                Yii::$app->session['anoActivo'] = $year->idano;
                Yii::$app->session['nameAno'] = $year->nombreano;
                Yii::$app->session['biblioUser'] = "biblio";
            }
            return $this->goBack();
       }
       else
       {
            return $this->render('login',['model' => $model, ]);
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
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->
            params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', ['model' => $model, ]);
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

}
