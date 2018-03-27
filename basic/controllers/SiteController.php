<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Users;
use yii\helpers\Url;

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
                'only' => ['logout', 'about'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
					   'actions' => ['about'],
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


    public function actionIndex()
    {
        if(Yii::$app->user->isGuest)
			return $this->redirect(Url::to(\Yii::$app->getUser()->loginUrl));
		else if(Yii::$app->user->identity->role == Users::ROLE_ADMIN)
			return $this->redirect(['/admin']);
		else if(Yii::$app->user->identity->role == Users::ROLE_OPERATOR)
			return $this->redirect(['/operator']);
		else if(Yii::$app->user->identity->role == Users::ROLE_TERMINAL)
			return $this->redirect(['/terminal']);
		else
			throw new \yii\web\NotFoundHttpException('Page not found.');
    }

    public function actionLogin()
    {
        if(!Yii::$app->user->isGuest)
        {
			return $this->goHome();
        }
        
        $model = new LoginForm();
        
        if(Yii::$app->request->post('LoginForm'))
        {
			$model->attributes = Yii::$app->request->post('LoginForm');
			
			if($model->validate())
			{
				Yii::$app->user->login($model->getUser());
				return $this->goHome();
			}
        }
        
        return $this->render('login', ['model' => $model]);
        
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
