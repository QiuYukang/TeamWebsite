<?php
Yii::import('application.vendor.*');
require_once('PHPExcel/PHPExcel.php');

//上传大文件需要设置php的upload_max_filesize和post_max_size以及max_file_uploads，不然表单不会被提交过来！
//相应的还要修改mysql的max_allowed_packed参数
class PatentController extends Controller
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
            array('allow', // allow authenticated user to perform 'admin', 'view' and 'download' actions
                'actions'=>array('index', 'admin', 'view', 'download'),
                'expression'=>'isset($user->is_user) && $user->is_user'
            ),
            array('allow', // allow manager user to perform 'create', 'delete', 'downloadformat', 'upload', 'uploadfile' and 'update' actions
                'actions'=>array('index', 'admin', 'view', 'download', 'create', 'delete', 'downloadformat', 'upload', 'uploadfile', 'update'),
                'expression'=>'isset($user->is_manager) && $user->is_manager',
            ),
            array('allow', // allow admin user to perform 'clear' actions
                'actions'=>array('index', 'admin', 'view', 'download', 'create', 'delete', 'downloadformat', 'upload', 'uploadfile', 'update', 'clear'),
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
        $criteria = new CDbCriteria;
        //搜索出了的行只读出以下列来显示
//        $criteria->select = array('name','number','status','app_date','auth_date','latest_date','level','category','file_name','abstract','maintainer_id','last_update_date');
        $criteria->select = array('name', 'number', 'abstract');
//        $criteria->with = array('peoples','reim_projects','achievement_projects');
        $criteria->with = array('peoples');

        $dataProvider=new CActiveDataProvider(
            'Patent',
            array('sort'=>array(
                'defaultOrder'=>array(
                    'latest_date' => CSort::SORT_DESC, //依最新时间排序
                ),

            ),
                'criteria' => $criteria,
                'pagination' =>false, //所有数据都传给前台，前台实现分页
            )
        );
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
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
        if(isset($_GET['incomplete']) && $_GET['incomplete'] ||
            (isset($_GET['export']) && $_GET['export'])) $criteria->select = array('name', 'number', 'status', 'app_date', 'auth_date', 'latest_date', 'level', 'category', 'file_name', 'file_size', 'abstract', 'maintainer_id', 'last_update_date');
        else $criteria->select = array('name', 'number', 'level', 'category');
        $criteria->with = array('peoples', 'reim_projects','achievement_projects');
        $criteria->together = true;
        $criteria->group = 't.id';
        $params = array();
        $order = '';

        $now_criteria = array(); //用于传递给form显示当前的搜索条件

        // do not manually cat sql string, use methods like CDbCriteria::addCondition()!
        // or there will be sql injection vulnerability!
        // http://www.yiiframework.com/forum/index.php/topic/13119-sql-injection-question/
        if(isset($_GET['keyword']) && $_GET['keyword']){
            array_push($fileName,'关键词为'.$_GET['keyword']);
            $criteria->addCondition('lower(t.name) like :keyword'); //name和param全部转小写进行判断，达到忽略大小写的效果
            $params[':keyword']='%'.strtolower($_GET['keyword']).'%';
            $now_criteria['keyword'] = $_GET['keyword'];
        }
        if(isset($_GET['number']) && $_GET['number']){
            array_push($fileName,'专利号为'.$_GET['number']);
            $criteria->addCondition('lower(t.number) like :number'); //number和param全部转小写进行判断，达到忽略大小写的效果
            $params[':number']='%'.strtolower($_GET['number']).'%';
            $now_criteria['number'] = $_GET['number'];
        }
        if(isset($_GET['author']) && $_GET['author']) {
            $people = People::model()->find('id=:id',array(':id'=>$_GET['author']));
            $peopleName = isset($people) ? $people->name : '';
            array_push($fileName, $peopleName."发明");
            $criteria->addCondition('peoples_.id=:people_id');
            $params[':people_id']=$_GET['author'];
            $now_criteria['author'] = $_GET['author'];
        } else {
            //array_push($fileName, "以团队发明");
        }
        if(isset($_GET['maintainer']) && $_GET['maintainer']){
            $people = People::model()->find('id=:id',array(':id'=>$_GET['maintainer']));
            $peopleName = isset($people) ? $people->name : '';
            array_push($fileName,$peopleName."维护");
            $criteria->addCondition('t.maintainer_id=:maintainer_id');
            $params[':maintainer_id']=$_GET['maintainer'];
            $now_criteria['maintainer'] = $_GET['maintainer'];
        }
        $status = null;
        if(isset($_GET['status']) && $_GET['status'] != null) {
            $status = $_GET['status'];
            if($status == 0) {
                array_push($fileName, "状态为".Patent::LABEL_APPLIED);
            } else if($status == 1) {
                array_push($fileName, "状态为".Patent::LABEL_AUTHORISED);
            } else;
            $criteria->addCondition('t.status = :status');
            $params[':status'] = $status;
            $now_criteria['status'] = $_GET['status'];
        };
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
        //当选择了status时搜索的时间段就是基于status的
        if(isset($_GET['start_date']) && $_GET['start_date'] && isset($_GET['end_date']) && $_GET['end_date']) {
            if ((($start_date = Patent::processDateStatic($_GET['start_date'], 0)) != null) &&
                (($end_date = Patent::processDateStatic($_GET['end_date'], 1)) != null) ) {
                if($status == null) {
                    array_push($fileName,'时间在'.$start_date.'之后，在'.$end_date.'之前');
                    //两个时间任意一个落在时间段中都ok
                    $criteria->addCondition('((t.app_date >= :start_date AND t.app_date <= :end_date) OR
                    (t.auth_date >= :start_date AND t.auth_date <= :end_date))');
                } else if($status == 0) {
                    array_push($fileName,'申请时间在'.$start_date.'之后，在'.$end_date.'之前');
                    $criteria->addCondition('t.app_date >= :start_date AND t.app_date <= :end_date');
                } else if($status == 1) {
                    array_push($fileName,'授权时间在'.$start_date.'之后，在'.$end_date.'之前');
                    $criteria->addCondition('t.auth_date >= :start_date AND t.auth_date <= :end_date');
                } else;
                $params[':start_date'] = $start_date;
                $params[':end_date'] = $end_date;
                $now_criteria['start_date'] = $_GET['start_date'];
                $now_criteria['end_date'] = $_GET['end_date'];
            }
        }
        else if(isset($_GET['start_date']) && $_GET['start_date']){
            if(($start_date = Patent::processDateStatic($_GET['start_date'], 0)) != null) {
                if($status == null) {
                    array_push($fileName,'时间在'.$start_date.'之后');
                    $criteria->addCondition('(t.app_date >= :start_date OR t.auth_date >= :start_date)');
                } else if($status == 0) {
                    array_push($fileName,'申请时间在'.$start_date.'之后');
                    $criteria->addCondition('t.app_date >= :start_date');
                } else if($status == 1) {
                    array_push($fileName,'授权时间在'.$start_date.'之后');
                    $criteria->addCondition('t.auth_date >= :start_date');
                } else;
                $params[':start_date']=$start_date;
                $now_criteria['start_date'] = $_GET['start_date'];
            }
        }
        else if(isset($_GET['end_date']) && $_GET['end_date']){
            if(($end_date = Patent::processDateStatic($_GET['end_date'], 1)) != null) {
                if($status == null) {
                    array_push($fileName, '时间在' . $end_date . '之前');
                    $criteria->addCondition('(t.app_date <= :end_date OR t.auth_date <= :end_date)');
                } else if ($status == 0) {
                    array_push($fileName, '申请时间在' . $end_date . '之前');
                    $criteria->addCondition('t.app_date <= :end_date');
                } else if ($status == 1) {
                    array_push($fileName, '授权时间在' . $end_date . '之前');
                    $criteria->addCondition('t.auth_date <= :end_date');
                } else;
                $params[':end_date'] = $end_date;
                $now_criteria['end_date'] = $_GET['end_date'];
            }
        }
        if(isset($_GET['reim_project']) && $_GET['reim_project']){
            $project=Project::model()->find('id=:id',array(':id'=>$_GET['reim_project']));
            array_push($fileName,'报账项目为'.$project->name);
            $criteria->addCondition('reim_.id=:reim_id');
            $params[':reim_id']=$_GET['reim_project'];
            $now_criteria['reim_project'] = $_GET['reim_project'];
        }
        if(isset($_GET['achievement_project']) && $_GET['achievement_project']){
            $project=Project::model()->find('id=:id',array(':id'=>$_GET['achievement_project']));
            array_push($fileName,'成果项目为'.$project->name);
            $criteria->addCondition('achievement_.id=:achievement_id');
            $params[':achievement_id']=$_GET['achievement_project'];
            $now_criteria['achievement_project'] = $_GET['achievement_project'];
        }
        if(isset($_GET['order']) && $_GET['order'] == 2) { //选择了按最新更新时间排序
            $order .= 't.last_update_date DESC ,'; //按最后更新时间排序
            $now_criteria['order'] = 2;
        } else if(isset($_GET['order']) && $_GET['order'] == 1) { //选择了按作者顺序排序
            if(isset($_GET['author']) && $_GET['author']) { //且选择了作者
                $order .= 'peoples_peoples_.seq ,'; //首先按作者顺序排序
                $now_criteria['order'] = 1;
            } else { //没选择作者就按时间排序
                $now_criteria['order'] = 0;
            }
        } else {
            $now_criteria['order'] = 0;
        }

        $fileNameString = implode('，',$fileName);

        //var_dump($params);
        $criteria->params = $params;
        $order .= 't.latest_date DESC';

        $dataProvider = new CActiveDataProvider(
            'Patent',
            array(
                'sort'=>array(
                    'defaultOrder' => $order
                ),
                'criteria' => $criteria,
                'pagination' => false, //前台实现分页，无论显示还是导出都将数据全部传出
            )
        );

        if(isset($_GET['incomplete']) && $_GET['incomplete'] ) {
            $data_arr = $dataProvider->getData();
            $incomplete_data_arr = array();
            foreach($data_arr as $data) { //筛选出信息不完整的数据
                if($data->getIncompleteInfo() != null) {
                    $incomplete_data_arr[] = $data;
                }
            }
            $dataProvider->setData($incomplete_data_arr);
            if(strlen($fileNameString) == 0) $fileNameString = '信息不完整或有误的专利';
            else $fileNameString .= '的信息不完整或有误的专利';
            $now_criteria['incomplete'] = 1;
        } else {
            if(strlen($fileNameString) == 0) $fileNameString = '专利';
            else $fileNameString .= '的专利';
        }
        if(isset($_GET['order']) && $_GET['order'] == 2) { //选择了按最新更新时间排序
            $fileNameString .= '（按最后更新时间排序）';
        } else if(isset($_GET['order']) && $_GET['order'] == 1) { //选择了按作者顺序排序
            if(isset($_GET['author']) && $_GET['author']) { //且选择了作者
                $fileNameString .= '（按作者顺序排序）';
            } else { //没选择作者就按时间排序
                $fileNameString .= '（按时间排序）';
            }
        } else {
            $fileNameString .= '（按时间排序）';
        }

        //导出与否
        if(isset($_GET['export']) && $_GET['export']){
            self::exportPatentsToXlsByDefault($dataProvider->getData(), $fileNameString);
        } else {
            $this->render('admin',
                array(
                    'dataProvider' => $dataProvider,
                    'page' => isset($_GET['page']) ? $_GET['page'] : 1,
                    'search_info' => $fileNameString, //用于显示
                    'now_criteria' => $now_criteria, //用于让form显示当前的搜索条件
                ));
        }
    }

    /**
     * 按默认方式导出文件，@patents传入导出的数据，生成的文件名为@fileName
     */
    private function exportPatentsToXlsByDefault($patents,$fileName){
        $formatPath = dirname(__FILE__)."/../xls_format/patent_import_format.xlsx"; //载入标准格式
        $objPHPExcel = PHPExcel_IOFactory::load($formatPath);
//        $objPHPExcel->getDefaultStyle()->getNumberFormat()->setFormatCode('PHPExcel_Style_NumberFormat::FORMAT_TEXT');
//        $objPHPExcel->getProperties()->setTitle("导出的专利");
        $objPHPExcel->setActiveSheetIndex(0);
        $row=2;
        $activeSheet = $objPHPExcel->getActiveSheet();
//        $activeSheet->setTitle('patents');
        foreach($patents as $p){
            $col=0;
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->name, PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->number, PHPExcel_Cell_DataType::TYPE_STRING);
            //这里不能使用$p->peoples，该数组中只有一个作者，不明原因，下projects同
            foreach(Patent::model()->findByPk($p->id)->peoples as $people) {
                if($col>17){
                    break;
                }
                $activeSheet->setCellValueByColumnAndRow($col++,$row,$people->name);
                $activeSheet->setCellValueByColumnAndRow($col++,$row,$people->name_en);
//                $col++;//no output for english name.
            }
            $col=18;
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->app_date);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->auth_date);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->level, PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->category, PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->file_name);
            foreach (Patent::model()->findByPk($p->id)->reim_projects as $pp) {
                if($col>28) {
                    break;
                }
                $activeSheet->setCellValueByColumnAndRow($col++,$row,$pp->name);
                $activeSheet->setCellValueExplicitByColumnAndRow($col++,$row,$pp->number, PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicitByColumnAndRow($col++,$row,$pp->fund_number, PHPExcel_Cell_DataType::TYPE_STRING);
            }
            $col=29;
            foreach (Patent::model()->findByPk($p->id)->achievement_projects as $pp) {
                if($col>38) {
                    break;
                }
                $activeSheet->setCellValueByColumnAndRow($col++,$row,$pp->name);
                $activeSheet->setCellValueExplicitByColumnAndRow($col++,$row,$pp->number, PHPExcel_Cell_DataType::TYPE_STRING);
            }
            $col=39;
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->abstract);
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
        $path = dirname(__FILE__)."/../xls_format/patent_import_format.xlsx";

        header('Content-Transfer-Encoding: binary');
        header('Content-length: '.filesize($path));
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.'专利标准导入格式.xlsx');
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

            if(self::saveXlsToDb($path)){ //导入成功才进行页面跳转
                $this->redirect(array('admin'));
            }
        }

        $this->render('upload');
    }

    /**
     * 从@xlsPath路径下读取文件并将其数据存入数据库
     */
    protected function saveXlsToDb($xlsPath) {
        $patents = self::xlsToArray($xlsPath);
        return self::saveXlsArrayToDb($patents);
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
        array_shift($dataArray);
        return $dataArray;
    }

    /**
     * 将@patents数组中的数据逐个提取并存入数据库
     */
    public function saveXlsArrayToDb($patents)
    {
        foreach ($patents as $k => $p) {
            for ($i = 0; $i < 41; $i++) {
                $p[$i] = trim($p[$i]); //所有数据去空格
//                echo $p[$i].' ';
            }

            if (empty($p[0])) continue;
            //以name、number做搜索，若数据库中有则修改该数据，没有则创建一条新数据
            $patent = Patent::model()->findByAttributes(array('name' => $p[0]));
            if($patent == null)  $patent = Patent::model()->findByAttributes(array('number' => $p[1]));
            if ($patent == null) {
                $patent = new Patent;
            }
            $patent->name = $p[0];
            $patent->number = $p[1];

            for($i=0; $i<8; $i++) {
                $peopleName = $p[2 * $i + 2];
                $peopleNameEN = $p[2 * $i + 3];

                if(($peopleName == '' || $peopleName == null) &&
                    ($peopleNameEN == '' || $peopleNameEN == null) ) { //中英文名都没有直接continue
                    continue;
                }

                //处理英文名的逻辑：中文名英文名都有的分别存在name和name_en上，没有中文名的把英文名存到name和name_en中
                if($peopleName == null || $peopleName == '') { //如果没有中文名
                    if($peopleNameEN != null && $peopleNameEN != '') { //有英文名就把英文名放name中，name_en保持
                        $peopleName = $peopleNameEN;
                        //$peopleNameEN = '';
                    }
                    else continue; //中英文名都没有就continue
                }

                //people以name，name_en做搜索，但以name做区分（新建必须存在）
                $people = People::model()->findByAttributes(array('name'=>$peopleName));
                if($people == null) $people = People::model()->findByAttributes(array('name_en'=>$peopleNameEN)); //如果没找到就再用英文名找一次

                if($people != null) { //若存在该people
                    //若该people的name_en在数据库中没有但表格中有，则存下该name_en；若数据库中有则不更新
                    if(($people->name_en == null || $people->name_en == '') &&
                        ($peopleNameEN != null && $peopleNameEN != '')) {
                        $people->name_en = $peopleNameEN;
                        $people->save();
                    }
                    if(!in_array($people->id, $patent->save_peoples_id)) { //不应放入重复的值进去，beforeSave()中也做了检查
                        $patent->save_peoples_id[] = $people->id;
                    }

                }else { //若不存在创建新People
                    if($peopleName == null || $peopleName == '') continue; //新建必须存在name

                    $people = new People;
                    $people->name = $peopleName;
                    $people->name_en = empty($peopleNameEN) ? null : $peopleNameEN; //为空就赋null
                    if($people->save()){
                        $patent->save_peoples_id[] = $people->id; //新建的不可能重复，不做重复检查
                    }
                }
            }

            //不合适的日期格式会在beforeSave()中处理
            $patent->app_date = $p[18];
            $patent->auth_date = $p[19];

            if ($patent->app_date != null)
                $patent->status = Patent::STATUS_APPLIED;
            if ($patent->auth_date != null)
                $patent->status = Patent::STATUS_AUTHORISED;

            $patent->level = $p[20];
            $patent->category = $p[21];
            $patent->file_name = $p[22];


            for($i=0; $i<2; $i++){
                $name = $p[3 * $i + 23];
                $number = $p[3 * $i + 24];
                $fund_number = $p[3 * $i + 25];

                if(($name == '' || $name == null) &&
                    ($number == '' || $number == null) &&
                    ($fund_number == '' || $fund_number == null)) { //name、number、fund_number都没有直接continue
                    continue;
                }

                $reim_project = Project::model()->findByAttributes(array('name'=>$name));
                if($reim_project == null) $reim_project = Project::model()->findByAttributes(array('number'=>$number));
                if($reim_project == null) $reim_project = Project::model()->findByAttributes(array('fund_number'=>$fund_number));

                if($reim_project != null) { //存在该project
                    //若数据库里没有number或fund_number表格里有就存（name是肯定有的，不然存不进去）
                    if(($reim_project->number == null || $reim_project->number == '') &&
                        ($number != null && $number != '')) {
                        $reim_project->number = $number;
                        $reim_project->save();
                    }
                    if(($reim_project->fund_number == null || $reim_project->fund_number == '') &&
                        ($fund_number != null && $fund_number != '')) {
                        $reim_project->fund_number = $fund_number;
                        $reim_project->save();
                    }
                    if(!in_array($reim_project->id, $patent->save_reim_projects_id)) { //不应放入重复的值进去
                        $patent->save_reim_projects_id[] = $reim_project->id;
                    }

                }else { //创建新Project
                    if($name == null || $name == '') continue; //新建必须存在name

                    $reim_project = new Project;
                    $reim_project->number = $number;
                    $reim_project->name = empty($name) ? null : $name;
                    $reim_project->fund_number = empty($fund_number) ? null : $fund_number;
                    if($reim_project->save()){
                        $patent->save_reim_projects_id[] = $reim_project->id; //新建的没有可能重复，不做重复检查
                    }
                }
            }

            for($i=0; $i<5; $i++){
                $name = $p[2 * $i + 29];
                $number = $p[2 * $i + 30];

                if(($name == '' || $name == null) &&
                    ($number == '' || $number == null) ) { //name和number都没有直接continue
                    continue;
                }

                //project以name，number做搜索，但以name做区分（新建必须存在）
                $achievement_project = Project::model()->findByAttributes(array('name'=>$name));
                if($achievement_project == null) $achievement_project = Project::model()->findByAttributes(array('number'=>$number));

                if($achievement_project != null) { //存在该project
                    //若数据库里没有number表格里有就存（name是肯定有的，不然存不进去）
                    if(($achievement_project->number == null || $achievement_project->number == '') &&
                        ($number != null && $number != '')) {
                        $achievement_project->number = $number;
                        $achievement_project->save();
                    }
                    if(!in_array($achievement_project->id, $patent->save_achievement_projects_id)) { //不应放入重复的值进去
                        $patent->save_achievement_projects_id[] = $achievement_project->id;
                    }

                }else { //创建新Project
                    if($name == null || $name == '') continue; //新建必须存在name

                    $achievement_project = new Project;
                    $achievement_project->name = $name;
                    $achievement_project->number = empty($number) ? null : $number;
                    if($achievement_project->save()){
                        $patent->save_achievement_projects_id[] = $achievement_project->id; //新建的没有可能重复，不做重复检查
                    }
                }
            }

            $patent->abstract = $p[39];

            $maintainerName = $p[40];
            $maintainer = People::model()->findByAttributes(array('name' => $maintainerName));
            if ($maintainer != null) {
                $patent->maintainer_id = $maintainer->id;
            } else {
                $maintainer = new People;
                $maintainer->name = $maintainerName;
                if ($maintainer->save()) {
                    $patent->maintainer_id = $maintainer->id;
                }
            }

            $patent->re_relation = true;
            if ($patent->save()) {
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
        if($yesno == '是')
            return 1;
        else if($yesno == '否' || $yesno == "" || $yesno == null) {
            return 0;
        }else{
            return 1;
        }
    }

    /**
     * upload file
     */
    public function actionUploadfile() {
        if (isset($_FILES['fileField'])) {
            $files = CUploadedFile::getInstancesByName('fileField');
            foreach($files as $file) {
                if(($patent = Patent::model()->findByAttributes(array('file_name'=>$file->name))) != null) {
                    $patent->save_file = $file;

                    $patent->save();
                }
            }
        }

        $this->render('uploadfile');
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Patent;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Patent'])) {
            //除people和project其它的所有属性直接存储进model
            $model->attributes=$_POST['Patent'];

            //category因为一些动态因素用前台代码写的，这里也需要手动添加
            $model->category = $_POST['category'];

            //上传大文件需要设置php的upload_max_filesize和post_max_size，不然表单不会被提交过来！
            //相应的还要修改mysql的max_allowed_packed参数
            //处理文件
            $model->save_file = CUploadedFile::getInstance($model,'save_file');

            //_form中people和project通过POST传值给控制器
            //控制器把这些POST的值也存入对应的变量，调用save()时会根据变量进行关联表的处理
            $model->save_peoples_id = $_POST['Patent']['peoples'];
            $model->save_reim_projects_id = $_POST['Project']['reim_projects'];
            $model->save_achievement_projects_id = $_POST['Project']['achievement_projects'];

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
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Patent'])) {

            //除people和project其它的所有属性直接存储进model
            $model->attributes=$_POST['Patent'];

            //category因为一些动态因素用前台代码写的，这里也需要手动添加
            $model->category = $_POST['category'];

            //上传大文件需要设置php的upload_max_filesize和post_max_size，不然表单不会被提交过来！
            //相应的还要修改mysql的max_allowed_packed参数
            //处理文件
            $model->save_file = CUploadedFile::getInstance($model,'save_file');

            //_form中people和project通过POST传值给控制器
            //控制器把这些POST的值也存入对应的变量，调用save()时会根据变量进行关联表的处理
            $model->save_peoples_id = $_POST['Patent']['peoples'];
            $model->save_reim_projects_id = $_POST['Project']['reim_projects'];
            $model->save_achievement_projects_id = $_POST['Project']['achievement_projects'];

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
        //不用自动删除了，直接将3个关联表全部清空
        PatentPeople::model()->deleteAll();
        PatentProjectReim::model()->deleteAll();
        PatentProjectAchievement::model()->deleteAll();
        //清空patent数据表
        Patent::model()->deleteAll();

        $this->redirect(array('admin'));
    }

    public function actionDownload() {
        $model = $this->loadModel($_GET['id']);
        //header('Pragma: public');
        //header('Expires: 0');
        //header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Transfer-Encoding: binary');
        header('Content-length: '.$model->file_size);
        header('Content-Type: '.$model->file_type);
        header('Content-Disposition: attachment; filename='.$model->file_name);
        echo $model->file_content;

        //$this->redirect(array('view','id'=>$model->id));
    }

    /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Patent the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Patent::model()/*->with('peoples')*/->findByPk($id);
        if($model === null)
            throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
