<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use app\models\Ticket;
use yii\filters\auth\HttpBearerAuth;

use app\models\Workspace;

class TicketController extends Controller
{
    public function behaviors()
    {
    	$behaviors = parent::behaviors();
    	$behaviors['authenticate']['class'] = HttpBearerAuth::className();
    	$behaviors['authenticate']['only'] = ['create'];
    	return $behaviors;
    }

    public function actionIndex()
    {
    	
    }

    public function actionCreate()
    {
    	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    	
    	$ticket = new Ticket();
    	$ticket->name = rand() . '';
    	$ticket->dateCreated = date('Y-m-d H:i:s');
    	$ticket->save();

    	echo $ticket->id;

    }

}
