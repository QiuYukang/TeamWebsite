<?php

class PaperTeachingController extends Controller
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

	private function setModelRelation($model) {
		if(isset($_POST['PaperTeaching']['peoples']))
			$model->peopleIds=$_POST['PaperTeaching']['peoples'];
		if(isset($_POST['PaperTeaching']['fund_projects']))
			$model->fundProjectIds=$_POST['PaperTeaching']['fund_projects'];
		if(isset($_POST['PaperTeaching']['reim_projects']))
			$model->reimProjectIds=$_POST['PaperTeaching']['reim_projects'];
		if(isset($_POST['PaperTeaching']['achievement_projects']))
			$model->achievementProjectIds=$_POST['PaperTeaching']['achievement_projects'];
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
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','download', 'admin'),
				'expression'=>'isset($user->is_manager) && $user->is_manager'
			),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('create','testExcelExport','testExcelExportByTable','query','testSearchByPeople','reset','upload','admin','delete','import','testXls','TestCsv','TestPhpExcelCsv'),
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
		$model=new PaperTeaching;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PaperTeaching']))
		{
			$model->attributes=$_POST['PaperTeaching'];
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

		if(isset($_POST['PaperTeaching']))
		{
			$model->attributes=$_POST['PaperTeaching'];
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
		$criteria = new CDbCriteria;
		$criteria->addCondition('is_high_level=1');
		$dataProvider=new CActiveDataProvider(
			'PaperTeaching',
            array('sort'=>array(
                'defaultOrder'=>array(
                ),

            ),
            'pagination'=>false,
            'criteria'=>$criteria,
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
		$model=new PaperTeaching('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PaperTeaching']))
			$model->attributes=$_GET['PaperTeaching'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return PaperTeaching the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=PaperTeaching::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param PaperTeaching $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='paper-teaching-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
