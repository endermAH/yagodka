<?php

namespace app\controllers;

use app\models\RatingForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\UserAttributes;
use app\models\RegistrationForm;

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
                        'actions' => ['register', 'login'],
                        'allow' => false,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['register', 'login', 'index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function () {
                    return Yii::$app->response->redirect('/');
                },
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

    /**
     * Login action.
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

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
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

    public function actionProfile($uid)
    {

        $user = User::findIdentity($uid);
        $userattributes = UserAttributes::getUserAttributes($uid);
        $ratingModel = new RatingForm;
        if ($ratingModel->load(Yii::$app->request->post()) && $ratingModel->changeRating($uid)){
            $user = User::findIdentity($uid);
            $ratingModel = new RatingForm;
        }
        return $this->render('userinfo',
            [
                'user' => $user,
                'userattributes' => $userattributes,
                'ratingModel' => $ratingModel
            ]);
    }

    public function actionRating()
    {
        $rating = User::find()->orderBy(['rating' => SORT_DESC])->all();
        return $this->render('rating',
            [
                'rating' => $rating,
            ]);
    }

    public function actionRegister() {
        $model = new RegistrationForm();

        if ($model->load(Yii::$app->request->post()) && $model->register()){
            return $this->goBack();
        }
        $model->password = '';
        $model->password_repeat = '';

        return $this->render('register',[
            'model' => $model
        ]);
    }

    public function actionAddRating($uid) {
        $ratingModel = new RatingForm;
        if ($ratingModel->load(Yii::$app->request->post()) && $ratingModel->changeRating($uid)) {
            echo 1;
            //return $this->refresh();
        }
        //return $this->refresh();
        echo 2;
        var_dump(Yii::$app->request->post());
    }

}
