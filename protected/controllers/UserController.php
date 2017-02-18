<?php
Yii::import('application.vendor.*');
require_once('PHPExcel/PHPExcel.php');

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'setting' actions
                'actions'=>array('setting'),
                'expression'=>'isset($user->is_user) && $user->is_user'
            ),
            array('allow', // allow manager user to perform the same actions as authenticated user
                'actions'=>array('setting'),
                'expression'=>'isset($user->is_manager) && $user->is_manager',
            ),
            array('allow', // allow admin user to perform 'admin', 'create', 'update', 'delete' and 'clear' actions
                'actions'=>array('setting', 'admin', 'create', 'update', 'downloadformat', 'upload', 'delete', 'clear'),
                'expression'=>'isset($user->is_admin) && $user->is_admin',
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
	/*
	关于expression rules的使用：

	http://stackoverflow.com/a/9510215/3126855
		array('allow', 
            'actions'=>array('update'),
            'expression'=>"Yii::app()->controller->isPostOwner()",
        )
	http://www.cnblogs.com/mrcoke/articles/2360601.html
        array('allow',//允许普通管理员执行
            'actions'=>array('update'),
            'expression'=>array($this,'isNormalAdmin'),    //表示调用$this(即AdminController)中的isNormalAdmin方法。
        ),      

	*/

	/**
	 * set a user
	 */
	public function actionSetting()
	{
        $model = User::model()->findByPk(Yii::app()->user->id);
        $model->setScenario('setting');

        if(isset($_POST['User'])){
            $model->attributes = $_POST['User'];
            $valid = $model->validate(array('old_password', 'new_password', 'repeat_password'));

            if($valid){
                $model->password = $model->new_password;

                if($model->save()) {
                    $model->old_password = '';
                    $model->new_password = '';
                    $model->repeat_password = '';
                    $this->render('setting', array('model'=>$model, 'msg'=>'<font color="green">密码修改成功</font>'));
                    return;
                }
                else {
                    $this->render('setting', array('model' => $model, 'msg' => '<font color="red">密码修改失败</font>>'));
                    return;
                }
            }
        }

        $this->render('setting',array('model'=>$model));

//        if(isset($_POST['old_password']) && $_POST['old_password']) {
//            $old_password = $_POST['old_password'];
//
//            $user = User::model()->findByAttributes(array('id' => Yii::app()->user->id));
//
//            $identity=new UserIdentity($user->username,$old_password);
//
//            if(!$identity->authenticate()) {
//                $this->render('setting',
//                    array('errorMessage' => '密码错误'));
//            } else {
//                if(isset($_POST['password']) && $_POST['password']) $user->password = $_POST['password'];
//                if($user->save()) {
//                    ;
//                } else {
//
//                    $this->render('setting',
//                        array('errorMessage' => '失败失败'));
//                }
//            }
//        }
//        $this->render('setting',
//            array('errorMessage' => '请输入密码'));
	}

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $dataProvider = new CActiveDataProvider(
            'User',
            array(
                'sort'=>array(
                    'defaultOrder' => 'id'
                ),
                'pagination' => false,
            )
        );
        $this->render('admin',array(
            'dataProvider'=>$dataProvider,
        ));
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new User();
        $model->setScenario('create');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];

			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
        if($id == Yii::app()->user->id) {
            $this->redirect(array('admin'));
        }

		$model = $this->loadModel($id);
        $model->setScenario('update');
        $model->password = '';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];

			if($model->save())
                $this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        if($id == Yii::app()->user->id) {
            $this->redirect(array('admin'));
        }

        $this->loadModel($id)->delete();
        $this->redirect(array('admin'));
	}

	/**
	 * Clear all models.
	 */
	public function actionClear()
	{
        foreach(User::model()->findAll() as $user) {
            if($user->id == Yii::app()->user->id) continue;
            $user->delete();
        }
        $this->redirect(array('admin'));
	}

    public function actionDownloadformat() {
        $path = dirname(__FILE__)."/../xls_format/user_import_format.xlsx";

        header('Content-Transfer-Encoding: binary');
        header('Content-length: '.filesize($path));
        header('Content-Type: '.mime_content_type($path));
        header('Content-Disposition: attachment; filename='.'用户标准导入格式.xlsx');
        echo file_get_contents($path);
    }

    /**
     * upload
     */
    public function actionUpload() {
//        set_time_limit(50);
        if(isset($_FILES['fileField']) && !empty($_FILES['fileField'])
            && ( $_FILES['fileField']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $_FILES['fileField']['type'] == 'application/vnd.ms-excel')
        ) {
            $path = $_FILES['fileField']['tmp_name'];
//            echo $_FILES['fileField']['name']."<hr />";
//            echo $_FILES['fileField']['type']."<hr />";
//            echo $_FILES['fileField']['tmp_name']."<hr />";

            if(self::saveXlsToDb($path)){ //导入成功才进行页面跳转
//                echo 'function actionUpload() succeeded.<hr />';
                $this->redirect(array('admin'));
            }
        }

        $this->render('upload');
    }

    /**
     * 从@xlsPath路径下读取文件并将其数据存入数据库
     */
    protected function saveXlsToDb($xlsPath) {
        $users = self::xlsToArray($xlsPath);
        return self::saveXlsArrayToDb($users);
    }

    /**
     * @path下的xls to Array
     */
    public function xlsToArray($path)
    {
        Yii::trace("start of loading","actionTestXls()");
        //$reader = PHPExcel_IOFactory::createReader('Excel5');
        //$reader->setReadDataOnly(true);
        $objPHPExcel = PHPExcel_IOFactory::load($path);
        Yii::trace("end of loading","actionTestXls()");
        Yii::trace("start of reading","actionTestXls()");
        $dataArray = $objPHPExcel->getActiveSheet()->toArray(null,true,true);
        Yii::trace("end of reading","actionTestXls()");
//        for($i = 0; $i < 2; $i++) { //前两行是标准导入格式中的标题，不是数据，移除
        array_shift($dataArray); //一行是标题
//        }
        //var_dump($dataArray);
        return $dataArray;
    }

    /**
     * 将@users数组中的数据逐个提取并存入数据库
     */
    public function saveXlsArrayToDb($users)
    {
        $login_user = User::model()->findByPk(Yii::app()->user->id);

//        $connection = Yii::app()->db;
        foreach($users as $k => $p) {
            //var_dump($k);
            //var_dump($p);
            for($i = 0; $i < 3; $i++) {
                $p[$i] = trim($p[$i]); //所有数据去空格;
            }

            if (empty($p[0]) || empty($p[1])) continue; //用户名或密码为空直接拜拜
            if($p[0] == $login_user->username) continue; //登录用户不可被修改

            $user = User::model()->findByAttributes(array('username' => $p[0]));
            if ($user == null) {
                $user = new User;
            }
            $user->setScenario('upload');
            $user->username = $p[0];
            $user->password = $p[1];

            //处理职位，必须将其它两位置0
            if($p[2] == '超级管理员') {
                $user->is_admin = 1;
                $user->is_manager = 0;
                $user->is_user = 0;
            }
            else if($p[2] == '管理员') {
                $user->is_manager = 1;
                $user->is_admin = 0;
                $user->is_user = 0;
            }
            else if($p[2] == '用户') {
                $user->is_user = 1;
                $user->is_admin = 0;
                $user->is_manager = 0;
            }
            else {
                $user->is_user = 1;
                $user->is_admin = 0;
                $user->is_manager = 0;
            }

            if($user->save()) {
                ;
            } else {
                return false;
            }

        }
        return true;
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
