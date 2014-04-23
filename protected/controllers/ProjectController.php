<?php
Yii::import('application.vendor.*');
require_once('password_compat/password_compat.php');
require_once('PHPExcel/PHPExcel.php');
class ProjectController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin'),
				'expression'=>'isset($user->is_project) && $user->is_project',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('upload','admin','delete','create','update','import','export','pwd'),
				'expression'=>'isset($user->is_admin) && $user->is_admin',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */

	public function actionPwd() {
		echo "actionPwd.<hr />";
		$hash1 = password_hash("admin", PASSWORD_DEFAULT);
		$hash2 = password_hash("123456a", PASSWORD_DEFAULT);
		var_dump($hash1);
		var_dump(Yii::app()->user->id);
		echo $hash1."<hr />";
		echo $hash2."<hr />";
		echo password_verify("123456a",$hash1);
		echo password_verify("123456a",$hash2);
	}

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Project;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Project']))
		{
			$model->attributes=$_POST['Project'];
			//$model->executePeoples=explode(',',$_POST['Project']['execute_peoples']);
			$model->executePeoples=$_POST['Project']['execute_peoples'];
			//var_dump($_POST['Project']['execute_peoples']);
			//var_dump($model->execute_peoples);
			//var_dump($_POST['Project']);
			if($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
				
				//var_dump($model->attributes);
			}

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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Project']))
		{
			$model->attributes=$_POST['Project'];
			$model->executePeoples=$_POST['Project']['execute_peoples'];
			$model->scenario='update';
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Project',
            array('sort'=>array(
                'defaultOrder'=>array(
                    'start_date' => true,
                ),

            ),
            'pagination'=>false,
        ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Project('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Project']))
			$model->attributes=$_GET['Project'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Project the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Project::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Project $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='project-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionUpload() {
        set_time_limit(50);
        if(isset($_FILES['spreedSheet']) && !empty($_FILES['spreedSheet'])) {
            $path = $_FILES['spreedSheet']['tmp_name'];
            echo $_FILES['spreedSheet']['name']."<hr />";
            echo $_FILES['spreedSheet']['type']."<hr />";
            echo $_FILES['spreedSheet']['tmp_name']."<hr />";
            if(self::saveXlsToDb($path)){
                echo 'function actionUpload() succeeded.<hr />';
                $this->redirect(array('index'));
            }
        }


        $this->render('upload');
    }

    public function actionReset() {
        Paper::model()->deleteAll();
    }




    protected function saveXlsToDb($xlsPath) {
        $projects = self::xlsToArray($xlsPath);
        return self::saveXlsArrayToDb($projects);
    }

    public function xlsToArray($path)
    {
        Yii::trace("start of loading","actionTestXls()");
        $reader = PHPExcel_IOFactory::createReader('Excel5');
        $reader->setReadDataOnly(true);
        $objPHPExcel = $reader->load($path);
        Yii::trace("end of loading","actionTestXls()");
        Yii::trace("start of reading","actionTestXls()");
        $dataArray = $objPHPExcel->getActiveSheet()->toArray(null,true,true);
        Yii::trace("end of reading","actionTestXls()");
        array_shift($dataArray);
        //var_dump($dataArray);
        return $dataArray;
    }

    private function convertYesNoToInt($yesno) {
        if($yesno=='是') {
            return 1;
        }else if($yesno=='否'){
            return 0;
        }
        return 0;
    }



    public function saveXlsArrayToDb($projects)
    {
        $connection=Yii::app()->db;
        //var_dump($projects);
        foreach($projects as $k => $p) {
            //var_dump($k);
            //var_dump($p);
            if($k<1) continue;
            $project = new Project;
            $project->name=$p[0];
            $project->number=$p[1];
            $project->fund_number=$p[2];
            $project->is_intl=self::convertYesNoToInt($p[3]);
            $project->is_national=self::convertYesNoToInt($p[4]);
            $project->is_provincial=self::convertYesNoToInt($p[5]);
            $project->is_city=self::convertYesNoToInt($p[6]);
            $project->is_school=self::convertYesNoToInt($p[7]);
            $project->is_enterprise=self::convertYesNoToInt($p[8]);
            $project->is_NSF=self::convertYesNoToInt($p[9]);
            $project->is_973=self::convertYesNoToInt($p[10]);
            $project->is_863=self::convertYesNoToInt($p[11]);
            $project->is_NKTRD=self::convertYesNoToInt($p[12]);
            $project->is_DFME=self::convertYesNoToInt($p[13]);
            $project->is_major=self::convertYesNoToInt($p[14]);
            $project->start_date=($p[16]);
            $project->deadline_date=($p[17]);
            $project->conclude_date=empty($p[18]) ? $project->deadline_date : $p[18];
            $project->pass_fund=$p[19];
            if($project->save()) {
                $peoplesId=array();
                for($i=0;$i<20;$i=$i+1){
                    $peopleName=$p[20+$i];
                    $peopleName=mysql_real_escape_string($peopleName);
                    $sql='select id from tbl_people where name="'.$peopleName.'";';
                    //


                    $testPeoples = People::model()->find('name="'.$peopleName.'"');
                    //var_dump($testPeoples);
                    $command=$connection->createCommand($sql);
                    $row=$command->queryRow();
                    if($row) {
                        //dump($row);
                        $peoplesId[]=$row['id'];

                    }else {
                        //dump($row);
                        $people = new People;
                        $people->name = $peopleName;
                        if($people->save())
                            //dump($people->id);
                        $peoplesId[] = $people->id;
                    }
                }
                if(!self::populatePeople($project,$peoplesId))
                    return false;

            } else {
                var_dump( $project->getErrors());
                //var_dump($project->info);
                return false;
            }
        }
        return true;
    }



}
