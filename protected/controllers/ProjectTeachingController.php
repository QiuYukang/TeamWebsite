<?php
Yii::import('application.vendor.*');
require_once('password_compat/password_compat.php');
require_once('PHPExcel/PHPExcel.php');
class ProjectTeachingController extends Controller
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
			'postOnly + delete', // we only allow deletion via POST request
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
            array('allow',  // allow all users to perform 'index' actions
                'actions'=>array('index'),
                'users'=>array('*'),
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
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	private function setModelRelation($model) {
		if(isset($_POST['ProjectTeaching']['peoples_value']))
			$model->peopleIds=explode(',', $_POST['ProjectTeaching']['peoples_value']);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ProjectTeaching;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ProjectTeaching']))
		{
			$model->attributes=$_POST['ProjectTeaching'];
			self::setModelRelation($model);
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['ProjectTeaching']))
		{
			// var_dump($_POST['ProjectTeaching']['peoples_value']);
			// Yii::app()->end();
			$model->attributes=$_POST['ProjectTeaching'];
			self::setModelRelation($model);
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
		$dataProvider=new CActiveDataProvider('ProjectTeaching');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ProjectTeaching('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ProjectTeaching']))
			$model->attributes=$_GET['ProjectTeaching'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ProjectTeaching the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ProjectTeaching::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ProjectTeaching $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='project-teaching-form')
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
        Project::model()->deleteAll();
    }




    protected function saveXlsToDb($xlsPath) {
        $projects = self::xlsToArray($xlsPath);
        return self::saveXlsArrayToDb($projects);
    }

    public function xlsToArray($path)
    {
        Yii::trace("start of loading","actionTestXls()");
        $objPHPExcel = PHPExcel_IOFactory::load($path);
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
            if($k<1 || empty($p[0])) continue;
            if(($project=ProjectTeaching::model()->findByAttributes(array('name'=>$p[0],'number'=>$p[1])))==null) {
            	$project = new ProjectTeaching;
            }
            $project->scenario='update';
            $project->name=$p[0];
            $project->number=$p[1];
            $project->fund_number=$p[2];
            $project->is_intl=self::convertYesNoToInt($p[3]);
            $project->is_provincial=self::convertYesNoToInt($p[4]);
            $project->is_city=self::convertYesNoToInt($p[5]);
            $project->is_school=self::convertYesNoToInt($p[6]);
            $project->is_quality=self::convertYesNoToInt($p[7]);
            $project->is_reform=self::convertYesNoToInt($p[8]);
            $project->is_lab=self::convertYesNoToInt($p[9]);
            $project->is_new_lab=self::convertYesNoToInt($p[10]);
            $project->start_date=$p[11];
            $project->deadline_date=$p[12];
            $project->conclude_date=$p[13];
            $project->fund=$p[14];
            $peoplesId=array();
            for($i=0;$i<20;$i=$i+1){
				$peopleName=$p[15+$i];
				if($peopleName=="") {
					continue;
				}
				$people = People::model()->findByAttributes(array('name'=>$peopleName));
                if($people!=null) {
                    $peoplesId[]=$people->id;
                }else {
                    $people = new People;
                    $people->name = $peopleName;
                    if(!$people->save()){
                    	print_r($people->getErrors());
                    	return false;
                    }
                    $peoplesId[] = $people->id;
                }

            }
            $project->peopleIds = $peoplesId;
    //         $peoplesId=array();
    //         for($i=0;$i<20;$i=$i+1){
				// $peopleName=$p[35+$i];
				// $people = People::model()->findByAttributes(array('name'=>$peopleName));
    //             if($people!=null) {
    //                 $peoplesId[]=$people->id;

    //             }else {
    //                 $people = new People;
    //                 $people->name = $peopleName;
    //                 if($people->save())
    //                 $peoplesId[] = $people->id;
    //             }

    //         }
    //         $project->liabilityPeoples = $peoplesId;
            $project->save();
        }
        return true;
    }

}
