<?php

namespace app\modules\terminal\controllers;

use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;
use app\models\Users;

/**
 * Default controller for the `terminal` module
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
								 Yii::$app->user->identity->role == Users::ROLE_TERMINAL;
					   }
				   ],
                ],
            ],
        ];
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
