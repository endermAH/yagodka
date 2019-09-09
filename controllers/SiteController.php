<?php

namespace app\controllers;

use app\models\Event;
use app\models\EventForm;
use app\models\EventToUser;
use app\models\JourneyForm;
use app\models\OrgForm;
use app\models\Rating;
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
use app\models\UploadForm;
use yii\web\UploadedFile;

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
                //'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['register', 'login'],
                        'allow' => false,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['register', 'login', 'index', 'rating', 'events', 'event', 'profile'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function () {
                    return Yii::$app->response->redirect(['/site/index']);
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
        $member_count = User::find()->where(['status' => 1])->count();
        $event_count = Event::find()->where(['status' => 1])->count();
        $total_coverage = Event::find()->where(['status' => 1])->sum('coverage');

        return $this->render('index', [
            'member_count' => $member_count,
            'event_count' => $event_count,
            'total_coverage' => $total_coverage
        ]);
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
        $phone = UserAttributes::find()->where(['user_id' => Yii::$app->user->identity->getId(), 'attribute_name' => 'phone'])->one();
        $model->phone = $phone ? $phone->attribute_value : '';
        $isu = UserAttributes::find()->where(['user_id' => Yii::$app->user->identity->getId(), 'attribute_name' => 'isu'])->one();
        $model->isu = $isu ? $isu->attribute_value : '';
        $vk = UserAttributes::find()->where(['user_id' => Yii::$app->user->identity->getId(), 'attribute_name' => 'vk'])->one();
        $model->vk = $vk ? $vk->attribute_value : '';
        $email = UserAttributes::find()->where(['user_id' => Yii::$app->user->identity->getId(), 'attribute_name' => 'email'])->one();
        $model->email = $email ? $email->attribute_value :'';

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->redirect([
                'site/profile',
                'uid' => Yii::$app->user->getId(),
            ]);
        }
        return $this->render('editcontact', [
            'model' => $model,
            'user' => Yii::$app->user->identity,
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
        $userattributes = $user->userAttributes;
        $ratingModel = new RatingForm;
        $events = $user->events;

        if ($ratingModel->load(Yii::$app->request->post()) && $ratingModel->changeRating($uid)){
            $user = User::findIdentity($uid);
            $ratingModel = new RatingForm;
        }
        return $this->render('userinfo',
            [
                'user' => $user,
                'userattributes' => $userattributes,
                'ratingModel' => $ratingModel,
                'events' => $events,
            ]);
    }

    public function actionRating()
    {
        $rating = User::find()->orderBy(['rating' => SORT_DESC])->all();
        foreach ($rating as $record) {
            $record->rating = $record->rating();
            $record->save();
            $rating = User::find()->orderBy(['rating' => SORT_DESC])->all();
        }
        return $this->render('rating',
            [
                'rating' => $rating,
            ]);
    }

    public function actionRegister() {
        $model = new RegistrationForm();
        $model->scenario = 'register';

        if ($model->load(Yii::$app->request->post()) && $model->register()){
            return $this->goBack();
        }
        $model->password = '';
        $model->password_repeat = '';

        return $this->render('register',[
            'model' => $model,
            'uid' => NULL,
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

    public function actionEvent($id) {
        $event = Event::findIdentity($id);
        return $this->render('event',
            [
                'event' => $event,
            ]);
    }

    public function actionMembers() {
        $users = User::find()->orderBy('status')->all();
        return $this->render('members',[
            'users' => $users
        ]);
    }

    public function actionConfirm($uid) {
        $user = User::findIdentity($uid);
        $user->status = !$user->status;
        $user->save();
        return $this->redirect(['site/members']);
    }

    public function actionUserrating($uid) {
        $rating = Rating::find()->where(['user_id' => $uid])->all();
        $user = User::findIdentity($uid);
        //var_dump($rating);
        //die;
        return $this->render('userrating', [
            'rating' => $rating,
            'user' => $user
        ]);
    }

    public function actionNewevent() {
        $model = new EventForm();

        $allusers = User::find()->where(['<>','id', Yii::$app->user->getId()])->andWhere(['status' => 1])->all();
        $users = [];
        foreach ($allusers as $user) {
            $users[$user->id] = $user->berry;
        }

        if ($model->load(Yii::$app->request->post()) && $model->register()){
            return $this->goBack();
        }

        return $this->render('newevent', [
            'model' => $model,
            'users' => $users
        ]);
    }

//    public function actionAddorg($eid) {
//        $orgModel = new OrgForm();
//        $allusers = User::find()->where(['<>','id', Yii::$app->user->getId()])->andWhere(['status' => 1])->all();
//        $model = Event::findIdentity($eid);
//        $users = [];
//        foreach ($allusers as $user) {
//            $users[$user->id] = $user->userInitials();
//        }
//
//        if ($model->load(Yii::$app->request->post()) && $model->register()){
//            //return $this->goBack();
//            echo '<pre>';
//            var_dump($this->orgs);
//            echo '</pre>';
//            die;
//        }
//
//        return $this->render('addorgs', [
//                'users' => $users,
//                'orgModel' => $orgModel,
//                'model' => $model
//            ]
//        );
//    }

    public function actionEvents(){
        $trueEvents = Event::find()->where(['status' => 1])->all();
        $ucEvents = Event::find()->where(['status' => 0])->all();

        return $this->render('events', [
            'trueEvents' => $trueEvents,
            'ucEvents' => $ucEvents
        ]);
    }

    public function actionEditevent($eid){
        $event = Event::findIdentity($eid);
        $model = new EventForm();
        $team = $event->users;

        $allusers = User::find()->where(['status' => 1])->all();
        $users = [];
        foreach ($allusers as $user) {
            $users[$user->id] = $user->berry;
        }

        if ($model->load(Yii::$app->request->post()) && $model->change($eid)){
            return $this->redirect(['site/events', 'eid'=>$eid]);
        }

        foreach ($model->attributes as $key => $value) {
            if ($key == 'orgs') continue;
            $model->$key = $event->$key;
        }

        foreach ($team as $member) {
            if (EventToUser::findOne(['user_id' => $member->id, 'event_id' => $eid])->role == 1) continue;
            $model->orgs[] = $member->id;
            }

        return $this->render('newevent', [
            'model' => $model,
            'users' => $users
        ]);
    }

    public function actionConfirmevent($eid) {
        $event = Event::findIdentity($eid);
        if ($event->status) {
            $records = Rating::findAll(['service' => $eid]);
            foreach ($records as $record) {
                $user = User::findOne(['id' => $record->user_id]);
                $user->cash -= $record->count;
                $user->save();
                $record->delete();
            }
        } else {
            $team = $event->users;
            foreach ($team as $member) {
                $role = EventToUser::findOne(['user_id' => $member->id, 'event_id' => $eid])->role;
                $record = new Rating();
                $record->user_id = $member->id;
                $record->comment = $event->name.' - '.Rating::$role_names[$role];;
                $record->count = Rating::$role_rating[$role];
                $record->service = $eid;
                $record->save();
                $member->cash += Rating::$role_rating[$role];
                $member->save();
            }
        }
        $event->status = !$event->status;
        $event->save();
        return $this->redirect(['site/events']);
    }

    public function actionEditUser($uid){
        $model = new RegistrationForm();
        $user = User::findOne(['id' => $uid]);

        foreach ($model->attributes as $key => $value) {
            if ($key == 'password_repeat') continue;
            $model->$key = $user->$key;
        }

        $model->scenario = 'update';

        if ($model->load(Yii::$app->request->post()) && $model->update($uid)){
            return $this->redirect(['site/profile', 'uid' => $uid]);
        }

        return $this->render('register',[
            'model' => $model,
            'uid' => $uid,
        ]);
    }

    public function actionUploadAvatar($uid){
        $model = new UploadForm();
        $user = User::findIdentity($uid);

        if (Yii::$app->request->isPost) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->upload($uid)) {
                return $this->redirect(['site/profile', 'uid' => $uid]);;
            }
        }

        return $this->render('upload',[
            'model' => $model,
            'user' => $user,
        ]);
    }

    public function actionJourney() {
        $model = new JourneyForm();
        $allusers = User::find()->where(['status' => 1])->all();
        $users = [];
        foreach ($allusers as $user) {
            $users[$user->id] = $user->berry;
        }

        if ($model->load(Yii::$app->request->post()) && $model->add()){
            return $this->redirect('site/rating');
        }

        return $this->render('journey',
            [
                'model' => $model,
                'users' => $users
            ]
        );
    }
}
