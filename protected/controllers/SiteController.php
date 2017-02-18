<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
        $criteria = new CDbCriteria;
        $user = Yii::app()->user;
        //index页面中展示5篇高水平论文
        $criteria->condition = "is_high_level=1";
        $criteria->select = array('id','info','latest_date');
        $dataProvider=new CActiveDataProvider(
            'Paper',
            array('sort'=>array(
                'defaultOrder'=>array(
                    'latest_date' => CSort::SORT_DESC, //依最新时间排序
                ),

            ),
                'criteria' => $criteria,
                'pagination' =>false, //所有数据都传给前台，前台实现分页
            )
        );
        //$dataProvider->pagination=false;
        $this->render('index',array(
            'dataProvider' => $dataProvider, //所有数据，前台取前5篇
        ));
	}

    public function actionIntroduction()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('introduction');
    }

    public function actionDirection()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('direction');
    }

    public function actionEnrollment() {
        $this->render('enrollment');
    }

    public function actionFun() {
        $this->render('fun');
    }
    public function actionFun1() {
        $this->render('fun1');
    }
    public function actionFun2() {
        $this->render('fun2');
    }
    public function actionFun3() {
        $this->render('fun3');
    }
    public function actionSub() {
        $this->render('sub');
    }

	public function actionAbout() {
		$this->render('about');
	}

	public function actionTeacher() {
		$this->render('teacher');
	}
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}