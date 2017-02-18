<?php
Yii::import('application.vendor.*');
require_once('PHPExcel/PHPExcel.php');

class PeopleController extends Controller
{
    //php高版本中被finfo()函数替代
    function mime_content_type($filename) {
        $result = new finfo();

        if (is_resource($result) === true) {
            return $result->file($filename, FILEINFO_MIME_TYPE);
        }

        return false;
    }
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
//			'postOnly + delete', // we only allow deletion via POST request
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
            array('allow', // allow authenticated user to perform 'admin' and 'view' actions
                'actions'=>array('admin', 'view'),
                'expression'=>'isset($user->is_user) && $user->is_user'
            ),
            array('allow', // allow manager user to perform 'export', 'create', 'delete', 'downloadformat', 'upload' and 'update' actions
                'actions'=>array('admin', 'view', 'export', 'create', 'delete', 'downloadformat', 'upload', 'update'),
                'expression'=>'isset($user->is_manager) && $user->is_manager',
            ),
            array('allow', // allow admin user to perform 'clear' actions
                'actions'=>array('admin', 'export', 'view', 'create', 'delete', 'downloadformat', 'upload', 'update', 'clear'),
                'expression'=>'isset($user->is_admin) && $user->is_admin',
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
	}

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $dataProvider = new CActiveDataProvider(
            'People',
            array(
                'sort'=>array(
                    'defaultOrder' => 'position DESC,  CONVERT( `name` USING gbk )'
                ),
                'pagination' => false,
            )
        );
        $this->render('admin',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    public function actionDownloadformat() {
        $path = dirname(__FILE__)."/../xls_format/people_import_format.xlsx";

        header('Content-Transfer-Encoding: binary');
        header('Content-length: '.filesize($path));
        header('Content-Type: '.self::mime_content_type($path));
        header('Content-Disposition: attachment; filename='.'成员标准导入格式.xlsx');
        echo file_get_contents($path);
    }

    /**
     * export.
     */
    public function actionExport()
    {
        $formatPath = dirname(__FILE__)."/../xls_format/people_import_format.xlsx"; //载入标准格式
        $objPHPExcel = PHPExcel_IOFactory::load($formatPath);
//        $objPHPExcel->getDefaultStyle()->getNumberFormat()->setFormatCode('PHPExcel_Style_NumberFormat::FORMAT_TEXT');
//        $objPHPExcel->getProperties()->setTitle("导出的人员");
        $objPHPExcel->setActiveSheetIndex(0);
        $row=2;
        $activeSheet = $objPHPExcel->getActiveSheet();
//        $activeSheet->setTitle('peoples');
        $peoples = People::model()->findAllBySql('SELECT * FROM `tbl_people` ORDER BY `position` DESC, CONVERT( `name` USING gbk );'); //先以职位排序，在以汉字首字母顺序排序
        foreach($peoples as $p){
            $col=0;
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->name);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->name_en);
//            $activeSheet->setCellValueExplicitByColumnAndRow($col++,$row,$p->name, PHPExcel_Cell_DataType::TYPE_STRING);
//            $activeSheet->setCellValueExplicitByColumnAndRow($col++,$row,$p->name_en, PHPExcel_Cell_DataType::TYPE_STRING);
            switch($p->position) {
                case People::POSITION_TEACHER:
//                    $activeSheet->setCellValueExplicitByColumnAndRow($col++,$row,People::LABEL_TEACHER, PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueByColumnAndRow($col++,$row,People::LABEL_TEACHER);
                    break;
                case People::POSITION_STUDENT:
//                    $activeSheet->setCellValueExplicitByColumnAndRow($col++,$row,People::LABEL_STUDENT, PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueByColumnAndRow($col++,$row,People::LABEL_STUDENT);
                    break;
                case People::POSITION_PARTNER:
//                    $activeSheet->setCellValueExplicitByColumnAndRow($col++,$row,People::LABEL_PARTNER, PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueByColumnAndRow($col++,$row,People::LABEL_PARTNER);
                    break;
            }
            $activeSheet->setCellValueExplicitByColumnAndRow($col++,$row,$p->number, PHPExcel_Cell_DataType::TYPE_STRING);
//            $activeSheet->setCellValueExplicitByColumnAndRow($col++,$row,$p->email, PHPExcel_Cell_DataType::TYPE_STRING);
//            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->number);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->email);
            $row++;
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//        $objExcel = new PHPExcel;
//        $objWriter = new PHPExcel_Writer_Excel5($objExcel);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-excel");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        //$fileName = iconv('utf-8', "gb2312", $fileName);
        header('Content-Disposition:attachment;filename="'.'团队全部成员'.'.xlsx"'); //文件名
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output'); exit;
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
        $peoples = self::xlsToArray($xlsPath);
        return self::saveXlsArrayToDb($peoples);
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
     * 将@peoples数组中的数据逐个提取并存入数据库
     */
    public function saveXlsArrayToDb($peoples)
    {
//        $connection = Yii::app()->db;
        foreach($peoples as $k => $p) {
            //var_dump($k);
            //var_dump($p);
            for($i = 0; $i < 5; $i++) {
                $p[$i] = trim($p[$i]); //所有数据去空格
//                echo $p[$i].' ';
            }

            $name = $p[0];
            $name_en = $p[1];
            if (empty($name)) {
                if(empty($name_en)) continue; //name、name_en为空直接拜拜
                else $name = $name_en;
            }
            //以name、name_en做搜索，若数据库中有则修改该数据，没有则创建一条新数据
            $people = People::model()->findByAttributes(array('name' => $name));
            if($people == null)  $people = People::model()->findByAttributes(array('name_en' => $name_en));
            if ($people == null) {
                $people = new People;
            }
            $people->name = $name;
            $people->name_en = $name_en;

            //处理职位
            if($p[2] == People::LABEL_TEACHER)
                $people->position = People::POSITION_TEACHER;
            else if($p[2] == People::LABEL_STUDENT)
                $people->position = People::POSITION_STUDENT;
            else if($p[2] == People::LABEL_PARTNER)
                $people->position = People::POSITION_PARTNER;
            else
                $people->position = People::POSITION_STUDENT;
            $people->number = $p[3];
            $people->email = $p[4];

            if($people->save()) {
                ;
            } else {
                return false;
            }

        }
        return true;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new People;

        if (isset($_POST['People'])) {
            $model->attributes=$_POST['People'];

            if ($model->save()) {
                $this->redirect(array('view','id'=>$model->id)); //储存成功跳转到其view页面
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
        $model = $this->loadModel($id);

        if (isset($_POST['People'])) {
            $model->attributes = $_POST['People'];

            if ($model->save()) {
                $this->redirect(array('view','id'=>$model->id));
            }
        }

        $this->render('update',array(
            'model'=>$model,
        ));
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
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $this->loadModel($id)->delete();
            $this->redirect(array('admin'));
        } else {
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Delete all models.
     */
    public function actionClear() {
        //清空所有有关的关联表
        ProjectPeopleExecute::model()->deleteAll();
        ProjectPeopleLiability::model()->deleteAll();
        PaperPeople::model()->deleteAll();
        PatentPeople::model()->deleteAll();
        PublicationPeople::model()->deleteAll();
        SoftwarePeople::model()->deleteAll();

        //清空people数据表
        People::model()->deleteAll();

        $this->redirect(array('admin'));
    }

	/**
	 * Lists all models.

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('People');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
     */

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return People the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=People::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
