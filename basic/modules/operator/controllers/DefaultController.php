<?php

namespace app\modules\operator\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\models\Users;
use app\models\Workspace;
use app\models\WorkspaceAndOperator;

/**
 * Default controller for the `operator` module
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
					   'actions' => ['index'],
					   'allow' => true,
					   'roles' => ['@'],
					   'matchCallback' => function ($rule, $action) {
					      return Yii::$app->user->identity->role == Users::ROLE_ADMIN ||
								 Yii::$app->user->identity->role == Users::ROLE_OPERATOR;
					   }
				   ],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $userId = Yii::$app->user->identity->id;

        $lastDataUser = WorkspaceAndOperator::find()
        ->where(['operatorId' => $userId])
        ->orderBy(['dateArrival' => SORT_DESC])
        ->limit(1)
        ->one();

        $modelId = $lastDataUser->id;
        if($lastDataUser->dateDeparture != '')
        {
            $model = new WorkspaceAndOperator();
            
            $unavailableWorkspace = WorkspaceAndOperator::find()
                ->where(['dateDeparture' => null])
                ->all();
            $unavailableWorkspace = ArrayHelper::getColumn($unavailableWorkspace, 'workspaceId');

            $availableWorkspace = Workspace::find()
                ->where(['not in', 'id', $unavailableWorkspace])
                ->all();
            $availableWorkspace = ArrayHelper::map($availableWorkspace, 'id', 'name');

            $currentWorkspace = null;
        }
        else
        {
            $model = WorkspaceAndOperator::findOne($modelId);

            $availableWorkspace = null;

            $currentWorkspace = Workspace::find()
                ->where(['id' => $model->workspaceId])
                ->one();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            return $this->redirect(['index', 'model' => $model]);
        }

        return $this->render('index', ['model' => $model,
                                       'userId' => $userId,
                                       'availableWorkspace' => $availableWorkspace,
                                       'currentWorkspace' => $currentWorkspace]);
    }
}
