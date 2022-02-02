<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;
use app\models\pivot\Pivot;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Class PivotController
 * @package app\controllers
 */
class PivotController extends Controller
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

    /**
     * @return array|Response
     * @throws HttpException
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionPromocion()
    {
        $db = Yii::$app->db;

        $select = (array)Yii::$app->request->post('selection');//typecasting
        $cursoid = Yii::$app->request->post('idCurso');
        $anonew = (int)Yii::$app->session->get("anoActivo") + 1;
        if(!empty($select))
        {
                $transaction = $db->beginTransaction();
                try
                {
                    foreach ($select as $id)
                    {
                        $table = Pivot::find()->where(['idalumno'=>$id])->andWhere(['idano'=>Yii::$app->session->get('anoActivo')])->one();
                        $db->createCommand()->insert('pivot',[
                            'idalumno' => $id,
                            'idCurso' => $cursoid,
                            'idano' => $anonew,
                            'idApo' => $table->idApo,
                        ])->execute();
                    }
                    $transaction->commit();
                    $grabo=true;

                }catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
                if($grabo==true)
                {
                    \Yii::$app->session->setFlash('success','Se ha producido la promoción del Curso.-');
                }else{
                    \Yii::$app->session->setFlash('error','Ocurrió un error al realizar la promoción.-');
                }
        }
        else
        {
            throw new HttpException(400,'No existe una consulta');
        }
        //cuando se trata de retornar a una vista q esta fuera de la vista del controller
        //coloque una barra antes del directorio
        return $this->redirect('/alumnos/listapromocion');
    }
}
