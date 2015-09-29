<?php
Yii::import('application.vendor.*');
require_once('PHPExcel/PHPExcel.php');
class ProjectController extends Controller
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
            array('allow',  // allow all users to perform 'index' actions
                'actions'=>array('index'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'admin' and 'view' actions
                'actions'=>array('index', 'admin', 'view'),
                'expression'=>'isset($user->is_user) && $user->is_user'
            ),
            array('allow', // allow manager user to perform 'create', 'delete', 'downloadformat', 'upload' and 'update' actions
                'actions'=>array('index', 'admin', 'view', 'create', 'delete', 'downloadformat', 'upload', 'update'),
                'expression'=>'isset($user->is_manager) && $user->is_manager',
            ),
            array('allow', // allow admin user to perform 'clear' actions
                'actions'=>array('index', 'admin', 'view', 'create', 'delete', 'downloadformat', 'upload', 'update', 'clear'),
                'expression'=>'isset($user->is_admin) && $user->is_admin',
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
	}

    /**
     * index
     */
    public function actionIndex($page = 1)
    {

        $dataProvider=new CActiveDataProvider(
            'Project',
            array('sort'=>array(
                'defaultOrder'=>array(
                    'latest_date' => CSort::SORT_DESC, //依最新时间排序
                ),

            ),
                'pagination' =>false, //所有数据都传给前台，前台实现分页
            )
        );
        //$dataProvider->pagination=false;
        $this->render('index',array(
            'dataProvider' => $dataProvider, //所有数据
            'page' => $page, //当前页，GET方式得到
        ));
    }

    /**
     * admin & export
     */
    public function actionAdmin()
    {
        $fileName = array(); //显示的搜索条件，导出的文件名

        $criteria = new CDbCriteria();
        $criteria->with = array('execute_peoples','liability_peoples');
        $criteria->together = true;
        $criteria->group = 't.id';
        $params = array();
        $order = '';

        $now_criteria = array(); //用于传递给_search显示当前的搜索条件

        // do not manually cat sql string, use methods like CDbCriteria::addCondition()!
        // or there will be sql injection vulnerability!
        // http://www.yiiframework.com/forum/index.php/topic/13119-sql-injection-question/
        if(isset($_GET['keyword']) && $_GET['keyword']){
            array_push($fileName,'关键词为'.$_GET['keyword']);
            $criteria->addCondition('lower(t.name) like :keyword'); //name和param全部转小写进行判断，达到忽略大小写的效果
            $params[':keyword']='%'.strtolower($_GET['keyword']).'%';
            $now_criteria['keyword'] = $_GET['keyword'];
        }
        if(isset($_GET['number']) && $_GET['number']) {
            array_push($fileName,'项目编号为'.$_GET['number']);
            $criteria->addCondition('lower(t.number) like :number'); //全部转小写进行判断，达到忽略大小写的效果
            $params[':number']='%'.strtolower($_GET['number']).'%';
            $now_criteria['number'] = $_GET['number'];
        }
        if(isset($_GET['fund_number']) && $_GET['fund_number']) {
            array_push($fileName,'经费本编号为'.$_GET['fund_number']);
            $criteria->addCondition('lower(t.fund_number) like :fund_number'); //全部转小写进行判断，达到忽略大小写的效果
            $params[':fund_number']='%'.strtolower($_GET['fund_number']).'%';
            $now_criteria['fund_number'] = $_GET['fund_number'];
        }
        if(isset($_GET['execute_people']) && $_GET['execute_people']) {
//            $isByPeople = true;
            $people = People::model()->find('id=:id',array(':id'=>$_GET['execute_people']));
            $peopleName = isset($people) ? $people->name : '';
            array_push($fileName, '执行人员含'.$peopleName);
            $criteria->addCondition('execute_.id=:execute_people_id');
            $params[':execute_people_id']=$_GET['execute_people'];
            $now_criteria['execute_people'] = $_GET['execute_people'];
        }
        if(isset($_GET['liability_people']) && $_GET['liability_people']) {
//            $isByPeople = true;
            $people = People::model()->find('id=:id',array(':id'=>$_GET['liability_people']));
            $peopleName = isset($people) ? $people->name : '';
            array_push($fileName, '合同书人员含'.$peopleName);
            $criteria->addCondition('liability_.id=:liability_people_id');
            $params[':liability_people_id']=$_GET['liability_people'];
            $now_criteria['liability_people'] = $_GET['liability_people'];
        }
        if(isset($_GET['maintainer']) && $_GET['maintainer']) {
//            $isByMaintainer = true;
//            $isByPeople = true;
            $people = People::model()->find('id=:id',array(':id'=>$_GET['maintainer']));
            $peopleName = isset($people) ? $people->name : '';
            array_push($fileName,$peopleName."维护");
            $criteria->addCondition('t.maintainer_id=:maintainer_id');
            $params[':maintainer_id']=$_GET['maintainer'];
            $now_criteria['maintainer'] = $_GET['maintainer'];
        }
        if(isset($_GET['level']) && $_GET['level'] ){
            array_push($fileName,'级别为'.$_GET['level']);
            $criteria->addCondition('t.level = :level');
            $params[':level']=$_GET['level'];
            $now_criteria['level'] = $_GET['level'];
        }
        if(isset($_GET['category']) && $_GET['category'] ){
            array_push($fileName,'类别为'.$_GET['category']);
            $criteria->addCondition('lower(t.category) like :category');
            $params[':category']='%'.strtolower($_GET['category']).'%';
            $now_criteria['category'] = $_GET['category'];
        }
        if(isset($_GET['unit']) && $_GET['unit'] ){
            array_push($fileName,'牵头/合作单位为'.$_GET['unit']);
            $criteria->addCondition('t.unit = :unit');
            $params[':unit']=$_GET['unit'];
            $now_criteria['unit'] = $_GET['unit'];
        }

        if(isset($_GET['start_date']) && $_GET['start_date'] && isset($_GET['end_date']) && $_GET['end_date']) {
            if ((($start_date = Project::processDateStatic($_GET['start_date'], 0)) != null) &&
                (($end_date = Project::processDateStatic($_GET['end_date'], 1)) != null) ) {
//                $isByDate = true;
                array_push($fileName,'时间在'.$start_date.'之后，在'.$end_date.'之前');
                //三个时间任意一个落在时间段中都ok
                $criteria->addCondition('((t.start_date >= :start_date AND t.start_date <= :end_date) OR
                (t.deadline_date >= :start_date AND t.deadline_date <= :end_date) OR
                (t.conclude_date >= :start_date AND t.conclude_date <= :end_date))');

                $params[':start_date'] = $start_date;
                $params[':end_date'] = $end_date;
                $now_criteria['start_date'] = $_GET['start_date'];
                $now_criteria['end_date'] = $_GET['end_date'];
            }
        }
        else if(isset($_GET['start_date']) && $_GET['start_date']){
            if(($start_date = Project::processDateStatic($_GET['start_date'], 0)) != null) {
//                $isByDate = true;
                array_push($fileName,'时间在'.$start_date.'之后');
                $criteria->addCondition('(t.start_date >= :start_date OR t.deadline_date >= :start_date OR t.conclude_date >= :start_date)');

                $params[':start_date']=$start_date;
                $now_criteria['start_date'] = $_GET['start_date'];
            }
        }
        else if(isset($_GET['end_date']) && $_GET['end_date']){
            if(($end_date = Project::processDateStatic($_GET['end_date'], 1)) != null) {
//                $isByDate = true;
                array_push($fileName, '时间在' . $end_date . '之前');
                $criteria->addCondition('(t.start_date <= :end_date OR t.deadline_date <= :end_date OR t.conclude_date <= :end_date)');

                $params[':end_date'] = $end_date;
                $now_criteria['end_date'] = $_GET['end_date'];
            }
        }

        if(isset($_GET['start_fund']) && $_GET['start_fund'] && isset($_GET['end_fund']) && $_GET['end_fund']) {
            if ((($start_fund = floatval($_GET['start_fund'])) != 0) &&
                (($end_fund = floatval($_GET['end_fund'])) != 0)) {

                array_push($fileName,'经费大于'.$start_fund.'，小于'.$end_fund);
                $criteria->addCondition('(t.fund >= :start_fund AND t.fund <= :end_fund)');

                $params[':start_fund'] = $start_fund;
                $params[':end_fund'] = $end_fund;
                $now_criteria['start_fund'] = $_GET['start_fund'];
                $now_criteria['end_fund'] = $_GET['end_fund'];
            }
        }
        else if(isset($_GET['start_fund']) && $_GET['start_fund']){
            if(($start_fund = floatval($_GET['start_fund'])) != 0) {

                array_push($fileName,'经费大于'.$start_fund);
                $criteria->addCondition('t.fund >= :start_fund');

                $params[':start_fund'] = $start_fund;
                $now_criteria['start_fund'] = $_GET['start_fund'];
            }
        }
        else if(isset($_GET['end_fund']) && $_GET['end_fund']){
            if(($end_fund = floatval($_GET['end_fund'])) != 0) {

                array_push($fileName, '经费小于' . $end_fund);
                $criteria->addCondition('t.fund <= :end_fund');

                $params[':end_fund'] = $end_fund;
                $now_criteria['end_fund'] = $_GET['end_fund'];
            }
        }

        if(isset($_GET['order']) && $_GET['order'] == 2) { //选择了按最新更新时间排序
            $order .= 't.last_update_date DESC ,'; //按最后更新时间排序
            array_push($fileName, '按最后更新时间排序');
            $now_criteria['order'] = 2;
        } else {
            array_push($fileName, '按时间排序');
            $now_criteria['order'] = 0;
        }

        $fileNameString = implode(', ',$fileName);

        //var_dump($params);
        $criteria->params = $params;
        $order .= 't.latest_date DESC';

        $dataProvider = new CActiveDataProvider(
            'Project',
            array(
                'sort'=>array(
                    'defaultOrder' => $order
                ),
                'criteria' => $criteria,
                'pagination' => false, //前台实现分页，无论显示还是导出都将数据全部传出
//                    array('pageSize' => '20')
                //array(
                //'pageSize' => Yii::app()->params['pageSize'],
                //)
            )
        );

        //筛选信息不完整的数据，筛选条件是数据的getIncompleteInfo()函数
        if(isset($_GET['incomplete']) && $_GET['incomplete'] ) {
            $data_arr = $dataProvider->getData();
            $incomplete_data_arr = array();
            foreach($data_arr as $data) {
                if($data->getIncompleteInfo() != null) { //信息不完整
                    $incomplete_data_arr[] = $data;
                }
            }
            $dataProvider->setData($incomplete_data_arr);
            $fileNameString .= '的信息不完整或有误的科研项目';
            $now_criteria['incomplete'] = 1;
        } else {
            $fileNameString .= '的全部科研项目';
        }

        //导出与否
        if(isset($_GET['export']) && $_GET['export']){
            self::exportProjectsToXlsByDefault($dataProvider->getData(), $fileNameString);
        } else {
            $this->render('admin',
                array(
                    'dataProvider' => $dataProvider,
                    'page' => isset($_GET['page']) ? $_GET['page'] : 1,
                    'search_info' => $fileNameString, //用于显示
                    'now_criteria' => $now_criteria, //用于让_search显示当前的搜索条件
                ));
        }
    }

    /**
     * 按默认方式导出文件，@projects传入导出的数据，生成的文件名为@fileName
     */
    private function exportProjectsToXlsByDefault($projects,$fileName){
        $formatPath = dirname(__FILE__)."/../xls_format/project_import_format.xlsx"; //载入标准格式
        $objPHPExcel = PHPExcel_IOFactory::load($formatPath);
//        $objPHPExcel->getProperties()->setTitle("导出的科研项目");
        $objPHPExcel->setActiveSheetIndex(0);
        $row=2;
        $activeSheet = $objPHPExcel->getActiveSheet();
//        $activeSheet->setTitle('projects');
        foreach($projects as $p){
            $col=0;
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->name, PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->number, PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->fund_number, PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->start_date, PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->deadline_date, PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->conclude_date, PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->fund, PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->unit, PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->level, PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->category, PHPExcel_Cell_DataType::TYPE_STRING);

            //这里不能使用$p->execute_peoples，该数组中只有一个作者，不明原因，下liability_peoples同
            foreach(Project::model()->findByPk($p->id)->execute_peoples as $people) {
                if($col>29){
                    break;
                }
                $activeSheet->setCellValueByColumnAndRow($col++,$row,$people->name);
            }
            $col=30;
            foreach(Project::model()->findByPk($p->id)->liability_peoples as $people) {
                if($col>49){
                    break;
                }
                $activeSheet->setCellValueByColumnAndRow($col++,$row,$people->name);
            }
            $col=50;
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->description);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,isset($p->maintainer)?$p->maintainer->name:'');
            $row++;
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-excel");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        //$fileName = iconv('utf-8', "gb2312", $fileName);
        header('Content-Disposition:attachment;filename="'.$fileName.'.xlsx"'); //文件名
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output'); exit;
    }

    /**
     * value to '是' or ''
     */
    private function convertIntToYesNo($int) {
        if($int == 1)
            return '是';
        else
            return '';
    }

    public function actionDownloadformat() {
        $path = dirname(__FILE__)."/../xls_format/project_import_format.xlsx";

        header('Content-Transfer-Encoding: binary');
        header('Content-length: '.filesize($path));
        header('Content-Type: '.mime_content_type($path));
        header('Content-Disposition: attachment; filename='.'科研项目标准导入格式.xlsx');
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
        $projects = self::xlsToArray($xlsPath);
        return self::saveXlsArrayToDb($projects);
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
     * 将@projects数组中的数据逐个提取并存入数据库
     */
    public function saveXlsArrayToDb($projects)
    {
//        $connection = Yii::app()->db;
        foreach($projects as $k => $p) {
            //var_dump($k);
            //var_dump($p);
            for($i = 0; $i < 51; $i++) {
                $p[$i] = trim($p[$i]); //所有数据去空格
//                echo $p[$i].' ';
            }

            if (empty($p[0])) continue; //name为空直接拜拜
            //以name、number、fund_number做搜索，若数据库中有则修改该数据，没有则创建一条新数据
            $project = Project::model()->findByAttributes(array('name' => $p[0]));
            if($project == null)  $project = Project::model()->findByAttributes(array('number' => $p[1]));
            if($project == null)  $project = Project::model()->findByAttributes(array('fund_number' => $p[2]));
            if ($project == null) {
                $project = new Project;
            }
            $project->name=$p[0];
            $project->number=$p[1];
            $project->fund_number=$p[2];
            //不合适的日期格式会在beforeSave()中处理
            $project->start_date=$p[3];
            $project->deadline_date=$p[4];
            $project->conclude_date=$p[5];
            $project->fund=$p[6];
            $project->unit=$p[7];
            $project->level=$p[8];
            $project->category=$p[9];

            for($i=0; $i<20; $i++) {
                $peopleName = $p[$i + 10];

                if($peopleName != null && $peopleName != '') { //没有填写就跳过余下的处理
                    $people = People::model()->findByAttributes(array('name'=>$peopleName));
                    if($people == null) $people = People::model()->findByAttributes(array('name_en'=>$peopleName));
                    if($people != null) {
                        $project->save_execute_peoples_id[] = $people->id;
                    }else {
                        $people = new People;
                        $people->name = $peopleName;
                        if($people->save()){
                            $project->save_execute_peoples_id[] = $people->id;
                        }
                    }
                }
            }

            for($i=0; $i<20; $i++) {
                $peopleName = $p[$i + 30];

                if($peopleName != null && $peopleName != '') { //没有填写就跳过余下的处理
                    $people = People::model()->findByAttributes(array('name'=>$peopleName));
                    if($people == null) $people = People::model()->findByAttributes(array('name_en'=>$peopleName));
                    if($people != null) {
                        $project->save_liability_peoples_id[] = $people->id;
                    }else {
                        $people = new People;
                        $people->name = $peopleName;
                        if($people->save()){
                            $project->save_liability_peoples_id[] = $people->id;
                        }
                    }
                }
            }

            $project->description=$p[50];

            $maintainerName = $p[51];
            if($maintainerName != null && $maintainerName != '') { //没有填写就跳过余下的处理
                $maintainer = People::model()->findByAttributes(array('name'=>$maintainerName));
                if($maintainer == null) $maintainer = People::model()->findByAttributes(array('name_en'=>$maintainerName));
                if($maintainer != null) {
                    $project->maintainer_id = $maintainer->id;
                }else {
                    $maintainer = new People;
                    $maintainer->name = $maintainerName;
                    if($maintainer->save()){
                        $project->maintainer_id = $maintainer->id;
                    }
                }
            }

            $project->re_relation = true; //打开重铸关联标记
            if($project->save()) {
                ;
            } else {
                return false;
            }

        }
        return true;
    }

    /**
     * 依规则@yesno to boolean
     */
    private function convertYesNoToInt($yesno) {
        if($yesno == '是') {
            return 1;
        } else if ($yesno == '否' || $yesno == "" || $yesno == null) {
            return 0;
        } else {
            return 1;
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Project;

        if (isset($_POST['Project'])) {
            //除category、两个peoples外其它的所有属性直接存储进model
            $model->attributes=$_POST['Project'];

            //category因为一些动态因素用前台代码写的，这里也需要手动添加
            $model->category = $_POST['category'];

            //_form中两个people通过POST传值给控制器
            //控制器把这些POST的值也存入对应的变量，调用save()时会根据变量进行关联表的处理
            $model->save_execute_peoples_id = $_POST['Project']['execute_peoples'];
            $model->save_liability_peoples_id = $_POST['Project']['liability_peoples'];

            $model->re_relation = true;
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

        if (isset($_POST['Project'])) {
//            var_dump($_FILES['uploaded_file']);
//            var_dump($model->uploaded_file);

            //除category、两个peoples外其它的所有属性直接存储进model
            $model->attributes = $_POST['Project'];

            //category因为一些动态因素用前台代码写的，这里也需要手动添加
            $model->category = $_POST['category'];

            //_form中两个people通过POST传值给控制器
            //控制器把这些POST的值也存入对应的变量，调用save()时会根据变量进行关联表的处理
            $model->save_execute_peoples_id = $_POST['Project']['execute_peoples'];
            $model->save_liability_peoples_id = $_POST['Project']['liability_peoples'];

            $model->re_relation = true;
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
        PaperProjectFund::model()->deleteAll();
        PaperProjectReim::model()->deleteAll();
        PaperProjectAchievement::model()->deleteAll();
        PatentProjectReim::model()->deleteAll();
        PatentProjectAchievement::model()->deleteAll();
        PublicationProjectFund::model()->deleteAll();
        PublicationProjectReim::model()->deleteAll();
        PublicationProjectAchievement::model()->deleteAll();
        SoftwareProjectFund::model()->deleteAll();
        SoftwareProjectReim::model()->deleteAll();
        SoftwareProjectAchievement::model()->deleteAll();

        //清空project数据表
        Project::model()->deleteAll();

        $this->redirect(array('admin'));
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
        $model = Project::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404,'The requested page does not exist.');
        }
        return $model;
    }

}
