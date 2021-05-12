<?php

namespace app\controllers;

use app\models\User;
use app\models\databases\Users;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

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
     * Домашняя страница
     *
     * @return string
     */
    public function actionIndex()
    {
        $session = Yii::$app->session;

        if (!isset($session["user"])) return $this->render('index');

        $this->redirect('/chat');

        return null;
    }

    public function actionPage($id){
        $page_owner = null;

        $UserFromDB = Users::findOne($id);

        if (isset($UserFromDB)){
            $page_owner = [
                'id' => $UserFromDB->attributes["id"],
                'username' => $UserFromDB->attributes["name"],
                'link' => $UserFromDB->attributes["link"],
                'password' => $UserFromDB->attributes["password"],
                'status' => $UserFromDB->attributes["status"]
            ];
        }

        return $this->render('page', [
            'page_owner' => $page_owner
        ]);
    }

    /**
     * Страница авторизации
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionApi(){
        return $this->render("api");
    }

    /**
     * Страница выхода
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Страница "о нас"
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
