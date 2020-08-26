<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;
use yii\helpers\Url;
use app\models\pivot\Pivot;

class PivotController extends Controller
{
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
        $grabo=false;
        $table = new Pivot;

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
                        $sql = $db->createCommand()->insert('pivot',[
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
                    $grabo=false;
                    throw $e;
                }catch (\Throwable $e) {
                    $transaction->rollBack();
                    $grabo=false;
                    throw $e;
                }
                if($grabo==true)
                {
                    Yii::$app->session->setFlash('success','Se ha producido la promoción del Curso.-');
                }else{
                    Yii::$app->session->setFlash('error','Ocurrió un error al realizar la promoción.-');
                }
        }
        else
        {
            throw new HttpException(400,'No existe una consulta');
        }
        echo "<meta http-equiv='refresh' content='1; " . Url::toRoute("alumnos/listapromocion") . "'>";
    }
}
