<?php
Yii::import('application.vendor.*');
require_once('PHPExcel/PHPExcel.php');

//上传大文件需要设置php的upload_max_filesize和post_max_size，不然表单不会被提交过来！
//相应的还要修改mysql的max_allowed_packed参数
class PaperController extends Controller
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
        //登录用户往admin页面跳转
//        $user = Yii::app()->user;
//        if(!(isset($user->is_admin) && $user->is_admin) &&
//            !(isset($user->is_manager) && $user->is_manager) &&
//            !(isset($user->is_user) && $user->is_user)) {
//            Yii::app()->runController('paper/admin');
//            return;
//	    }
        $criteria = new CDbCriteria;
        $user = Yii::app()->user;
        //index页面中只展示高水平论文
        $criteria->condition = "is_high_level=1";
        $criteria->select = array('info','index_number');
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
            'dataProvider' => $dataProvider, //所有数据
            'page' => $page, //当前页，GET方式得到
        ));
    }



    /**
     * admin & export
     */
    public function actionAdmin()
    {
        //已废弃，现在按统一格式ByDefault导出
//        $isByMaintainer = false;
//        $isByPeople = false;
//        $isByDate = false;
//        $isByProject = false;

        $fileName = array(); //显示的搜索条件，导出的文件名

        $criteria = new CDbCriteria();
        //搜索出了的行只读出以下列来显示
        //        $criteria->select = array('info','index_number','sci_number','ei_number','istp_number','category');
        //如果要查找不完整的数据，就要查询数据所有列进行筛选；否则只需查找要显示的列，提高加载速度
        if(isset($_GET['incomplete']) && $_GET['incomplete'] ) $criteria->select = array('info','status','index_number','pass_date','pub_date','index_date','latest_date','sci_number','ei_number','istp_number','category','file_name','file_size','is_high_level','maintainer_id','last_update_date');
        else $criteria->select = array('info','index_number','sci_number','ei_number','istp_number','category','file_content');
//        $criteria->with = array('peoples','fund_projects','reim_projects','achievement_projects');
        $criteria->with = array('peoples', 'fund_projects','reim_projects','achievement_projects');
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
            $criteria->addCondition('lower(t.info) like :keyword'); //info和param全部转小写进行判断，达到忽略大小写的效果
            $params[':keyword']='%'.strtolower($_GET['keyword']).'%';
            $now_criteria['keyword'] = $_GET['keyword'];
        }
        if(isset($_GET['author']) && $_GET['author']) {
//            $isByPeople = true;
            $people = People::model()->find('id=:id',array(':id'=>$_GET['author']));
            $peopleName = isset($people) ? $people->name : '';
            array_push($fileName, $peopleName."发表");
            $criteria->addCondition('peoples_.id=:people_id');
            $params[':people_id']=$_GET['author'];
            $now_criteria['author'] = $_GET['author'];
        } else {
            array_push($fileName, "以团队发表");
        }
        if(isset($_GET['maintainer']) && $_GET['maintainer']){
//            $isByMaintainer = true;
//            $isByPeople = true;
            $people = People::model()->find('id=:id',array(':id'=>$_GET['maintainer']));
            $peopleName = isset($people) ? $people->name : '';
            array_push($fileName,$peopleName."维护");
            $criteria->addCondition('t.maintainer_id=:maintainer_id');
            $params[':maintainer_id']=$_GET['maintainer'];
            $now_criteria['maintainer'] = $_GET['maintainer'];
        }
        if(isset($_GET['index_number']) && $_GET['index_number']){
            array_push($fileName,'检索号为'.$_GET['index_number']);
            $criteria->addCondition('lower(t.index_number) like :index_number'); //info和param全部转小写进行判断，达到忽略大小写的效果
            $params[':index_number']='%'.strtolower($_GET['index_number']).'%';
            $now_criteria['index_number'] = $_GET['index_number'];
        }
        $status = null;
        if(isset($_GET['status']) && $_GET['status'] != null) {
            $status = $_GET['status'];
            if($status == 0) {
                array_push($fileName, "状态为".Paper::LABEL_PASSED);
            } else if($status == 1) {
                array_push($fileName, "状态为".Paper::LABEL_PUBLISHED);
            } else if($status == 2) {
                array_push($fileName, "状态为".Paper::LABEL_INDEXED);
            } else;
            $criteria->addCondition('t.status = :status');
            $params[':status'] = $status;
            $now_criteria['status'] = $_GET['status'];
        };
        //当选择了status时搜索的时间段就是基于status的
        if(isset($_GET['start_date']) && $_GET['start_date'] && isset($_GET['end_date']) && $_GET['end_date']) {
            if ((($start_date = Paper::processDateStatic($_GET['start_date'], 0)) != null) &&
                (($end_date = Paper::processDateStatic($_GET['end_date'], 1)) != null) ) {
//                $isByDate = true;
                if($status == null) {
                    array_push($fileName,'时间在'.$start_date.'之后，在'.$end_date.'之前');
                    //三个时间任意一个落在时间段中都ok
                    $criteria->addCondition('((t.pass_date >= :start_date AND t.pass_date <= :end_date) OR
                    (t.pub_date >= :start_date AND t.pub_date <= :end_date) OR
                    (t.index_date >= :start_date AND t.index_date <= :end_date))');
                } else if($status == 0) {
                    array_push($fileName,'录用时间在'.$start_date.'之后，在'.$end_date.'之前');
                    $criteria->addCondition('t.pass_date >= :start_date AND t.pass_date <= :end_date');
                } else if($status == 1) {
                    array_push($fileName,'发表时间在'.$start_date.'之后，在'.$end_date.'之前');
                    $criteria->addCondition('t.pub_date >= :start_date AND t.pub_date <= :end_date');
                } else if($status == 2) {
                    array_push($fileName,'索引时间在'.$start_date.'之后，在'.$end_date.'之前');
                    $criteria->addCondition('t.index_date >= :start_date AND t.index_date <= :end_date');
                } else;
                $params[':start_date'] = $start_date;
                $params[':end_date'] = $end_date;
                $now_criteria['start_date'] = $_GET['start_date'];
                $now_criteria['end_date'] = $_GET['end_date'];
            }
        }
        else if(isset($_GET['start_date']) && $_GET['start_date']){
            if(($start_date = Paper::processDateStatic($_GET['start_date'], 0)) != null) {
//                $isByDate = true;
                if($status == null) {
                    array_push($fileName,'时间在'.$start_date.'之后');
                    $criteria->addCondition('(t.pass_date >= :start_date OR t.pub_date >= :start_date OR t.index_date >= :start_date)');
                } else if($status == 0) {
                    array_push($fileName,'录用时间在'.$start_date.'之后');
                    $criteria->addCondition('t.pass_date >= :start_date');
                } else if($status == 1) {
                    array_push($fileName,'发表时间在'.$start_date.'之后');
                    $criteria->addCondition('t.pub_date >= :start_date');
                } else if($status == 2) {
                    array_push($fileName,'索引时间在'.$start_date.'之后');
                    $criteria->addCondition('t.index_date >= :start_date');
                } else;
                $params[':start_date']=$start_date;
                $now_criteria['start_date'] = $_GET['start_date'];
            }
        }
        else if(isset($_GET['end_date']) && $_GET['end_date']){
            if(($end_date = Paper::processDateStatic($_GET['end_date'], 1)) != null) {
//                $isByDate = true;
                if($status == null) {
                    array_push($fileName, '时间在' . $end_date . '之前');
                    $criteria->addCondition('(t.pass_date <= :end_date OR t.pub_date <= :end_date OR t.index_date <= :end_date)');
                } else if ($status == 0) {
                    array_push($fileName, '录用时间在' . $end_date . '之前');
                    $criteria->addCondition('t.pass_date <= :end_date');
                } else if ($status == 1) {
                    array_push($fileName, '发表时间在' . $end_date . '之前');
                    $criteria->addCondition('t.pub_date <= :end_date');
                } else if ($status == 2) {
                    array_push($fileName, '索引时间在' . $end_date . '之前');
                    $criteria->addCondition('t.index_date <= :end_date');
                } else;
                $params[':end_date'] = $end_date;
                $now_criteria['end_date'] = $_GET['end_date'];
            }
        }
        if(isset($_GET['fund_project']) && $_GET['fund_project']){
//            $isByProject = true;
            $project=Project::model()->find('id=:id',array(':id'=>$_GET['fund_project']));
            array_push($fileName,'支助项目为'.$project->name);
            $criteria->addCondition('fund_.id=:fund_id');
            $params[':fund_id']=$_GET['fund_project'];
            $now_criteria['fund_project'] = $_GET['fund_project'];
        }
        if(isset($_GET['reim_project']) && $_GET['reim_project']){
//            $isByProject = true;
            $project=Project::model()->find('id=:id',array(':id'=>$_GET['reim_project']));
            array_push($fileName,'报账项目为'.$project->name);
            $criteria->addCondition('reim_.id=:reim_id');
            $params[':reim_id']=$_GET['reim_project'];
            $now_criteria['reim_project'] = $_GET['reim_project'];
        }
        if(isset($_GET['achievement_project']) && $_GET['achievement_project']){
//            $isByProject = true;
            $project=Project::model()->find('id=:id',array(':id'=>$_GET['achievement_project']));
            array_push($fileName,'成果项目为'.$project->name);
            $criteria->addCondition('achievement_.id=:achievement_id');
            $params[':achievement_id']=$_GET['achievement_project'];
            $now_criteria['achievement_project'] = $_GET['achievement_project'];
        }
        $levelLabelShowed = false; //标记“级别为”3个字是否已经显示过，因为只用显示一次
        if(isset($_GET['is_sci']) && $_GET['is_sci'] ){
            if(!$levelLabelShowed) {
                array_push($fileName,'级别为'.Paper::LABEL_SCI);
                $levelLabelShowed = true;
            } else array_push($fileName,Paper::LABEL_SCI);
            $criteria->addCondition('t.sci_number <> :sci_empty');
            $params[':sci_empty'] = '';
            $now_criteria['is_sci'] = 1;
        }
        if(isset($_GET['is_ei']) && $_GET['is_ei'] ){
            if(!$levelLabelShowed) {
                array_push($fileName,'级别为'.Paper::LABEL_EI);
                $levelLabelShowed = true;
            } else array_push($fileName,Paper::LABEL_EI);
            $criteria->addCondition('t.ei_number <> :ei_empty');
            $params[':ei_empty'] = '';
            $now_criteria['is_ei'] = 1;
        }
        if(isset($_GET['is_istp']) && $_GET['is_istp'] ){
            if(!$levelLabelShowed) {
                array_push($fileName,'级别为'.Paper::LABEL_ISTP);
                $levelLabelShowed = true;
            } else array_push($fileName,Paper::LABEL_ISTP);
            $criteria->addCondition('t.istp_number <> :istp_empty');
            $params[':istp_empty'] = '';
            $now_criteria['is_istp'] = 1;
        }
        if(isset($_GET['category']) && $_GET['category'] ){
            array_push($fileName,'类别为'.$_GET['category']);
            $criteria->addCondition('lower(t.category) like :category');
            $params[':category']='%'.strtolower($_GET['category']).'%';
            $now_criteria['category'] = $_GET['category'];
        }
        if(isset($_GET['is_high_level']) && $_GET['is_high_level'] ){
            array_push($fileName,'标记为高水平');
            $criteria->addCondition('t.is_high_level = :is_high_level');
            $params[':is_high_level']=$_GET['is_high_level'];
            $now_criteria['is_high_level'] = 1;
        }
        if(isset($_GET['order']) && $_GET['order'] == 2) { //选择了按最新更新时间排序
            $order .= 't.last_update_date DESC ,'; //按最后更新时间排序
            array_push($fileName, '按最后更新时间排序');
            $now_criteria['order'] = 2;
        } else if(isset($_GET['order']) && $_GET['order'] == 1) { //选择了按作者顺序排序
            if(isset($_GET['author']) && $_GET['author']) { //且选择了作者
                $order .= 'peoples_peoples_.seq ,'; //首先按作者顺序排序
                array_push($fileName, '按作者顺序排序');
                $now_criteria['order'] = 1;
            } else { //没选择作者就按时间排序
                array_push($fileName, '按时间排序');
                $now_criteria['order'] = 0;
            }
        } else {
            array_push($fileName, '按时间排序');
            $now_criteria['order'] = 0;
        }

        $fileNameString = implode(', ',$fileName);

        //var_dump($params);
        $criteria->params = $params;
        $order .= 't.latest_date DESC';

        $dataProvider = new CActiveDataProvider(
            'Paper',
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
//            $incomplete_data_arr = $data_arr;
            $dataProvider->setData($incomplete_data_arr);
//            $dataProvider->setTotalItemCount(count($incomplete_data_arr));
            $fileNameString .= '的信息不完整或有误的论文';
            $now_criteria['incomplete'] = 1;
        } else {
            $fileNameString .= '的全部论文';
        }

        //var_dump($dataProvider);
        //var_dump($dataProvider->countCriteria);
        //导出与否
        if(isset($_GET['export']) && $_GET['export']){
//            $dataProvider->pagination = false; //不分页全导出，因为显示也不分页了，前面已经写了
            self::exportPapersToXlsByDefault($dataProvider->getData(), $fileNameString);
            //已废弃，现在按统一格式ByDefault导出
//            if($isByMaintainer) {
//                self::exportPapersToXlsByMaintainer($dataProvider->getData(),$fileNameString);
//            } else if($isByPeople) {
//                self::exportPapersToXlsByPeople($dataProvider->getData(),$fileNameString);
//            } else {
//                self::exportPapersToXlsByPeople($dataProvider->getData(),$fileNameString);
//            }
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
     * 按默认方式导出文件，@papers传入导出的数据，生成的文件名为@fileName
     */
    private function exportPapersToXlsByDefault($papers,$fileName){
        $formatPath = dirname(__FILE__)."/../xls_format/paper_import_format.xlsx"; //载入标准格式
        $objPHPExcel = PHPExcel_IOFactory::load($formatPath);
//        $objPHPExcel->getDefaultStyle()->getNumberFormat()->setFormatCode('PHPExcel_Style_NumberFormat::FORMAT_TEXT');
//        $objPHPExcel->getProperties()->setTitle("导出的论文");
        $objPHPExcel->setActiveSheetIndex(0);
        $row=2;
        $activeSheet = $objPHPExcel->getActiveSheet();
//        $activeSheet->setTitle('papers');
        foreach($papers as $p){
            $col=0;
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->info, PHPExcel_Cell_DataType::TYPE_STRING);
            //这里不能使用$p->peoples，该数组中只有一个作者，不明原因，下projects同
            foreach(Paper::model()->findByPk($p->id)->peoples as $people) {
                if($col>16){
                    break;
//                    throw new CHttpException(503,'Exceeding peoples output formant limit!');
                }
                $activeSheet->setCellValueByColumnAndRow($col++,$row,$people->name);
                $activeSheet->setCellValueByColumnAndRow($col++,$row,$people->name_en);
//                $col++;//no output for english name.
            }
            $col=17;
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->pass_date);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->pub_date);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->index_date);
            $activeSheet->setCellValueExplicitByColumnAndRow($col++,$row,$p->index_number, PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicitByColumnAndRow($col++,$row,$p->sci_number, PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicitByColumnAndRow($col++,$row,$p->ei_number, PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicitByColumnAndRow($col++,$row,$p->istp_number, PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicitByColumnAndRow($col++,$row,$p->category, PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueByColumnAndRow($col++,$row,$p->file_name);
            foreach (Paper::model()->findByPk($p->id)->fund_projects as $pp) {
                if($col>37) {
                    break;
//                    throw new CHttpException(503,'Exceeding fund_projects output formant limit!');
                }
                $activeSheet->setCellValueByColumnAndRow($col++,$row,$pp->name);
                $activeSheet->setCellValueExplicitByColumnAndRow($col++,$row,$pp->number, PHPExcel_Cell_DataType::TYPE_STRING);
            }
            $col=38;
            foreach (Paper::model()->findByPk($p->id)->reim_projects as $pp) {
                if($col>43) {
                    break;
//                    throw new CHttpException(503,'Exceeding reim_projects output formant limit: '.$col);
                }
                $activeSheet->setCellValueByColumnAndRow($col++,$row,$pp->name);
                $activeSheet->setCellValueExplicitByColumnAndRow($col++,$row,$pp->number, PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicitByColumnAndRow($col++,$row,$pp->fund_number, PHPExcel_Cell_DataType::TYPE_STRING);
            }
            $col=44;
            foreach (Paper::model()->findByPk($p->id)->achievement_projects as $pp) {
                if($col>53) {
                    break;
//                    throw new CHttpException(503,'Exceeding achievement_projects output formant limit!');
                }
                $activeSheet->setCellValueByColumnAndRow($col++,$row,$pp->name);
                $activeSheet->setCellValueExplicitByColumnAndRow($col++,$row,$pp->number, PHPExcel_Cell_DataType::TYPE_STRING);
            }
            $col=54;
            $activeSheet->setCellValueByColumnAndRow($col++,$row,self::convertIntToYesNo($p->is_high_level));
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
        $path = dirname(__FILE__)."/../xls_format/paper_import_format.xlsx";

        header('Content-Transfer-Encoding: binary');
        header('Content-length: '.filesize($path));
        header('Content-Type: '.mime_content_type($path));
        header('Content-Disposition: attachment; filename='.'论文标准导入格式.xlsx');
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
        $papers = self::xlsToArray($xlsPath);
        return self::saveXlsArrayToDb($papers);
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
     * 将@papers数组中的数据逐个提取并存入数据库
     */
    public function saveXlsArrayToDb($papers)
    {
//        $connection = Yii::app()->db;
        foreach($papers as $k => $p) {
            //var_dump($k);
            //var_dump($p);
            for($i = 0; $i <56; $i++) {
                $p[$i] = trim($p[$i]); //所有数据去空格
//                echo $p[$i].' ';
            }

            if(empty($p[0])) continue;
            //以name、index_number做搜索，若数据库中有则修改该数据，没有则创建一条新数据
            $paper = Paper::model()->findByAttributes(array('info' => $p[0]));
            if($paper == null) $paper = Paper::model()->findByAttributes(array('index_number' => $p[20]));
            if($paper == null){ //以info为准，若数据库中有则修改该数据，没有则创建一条新数据
                $paper = new Paper;
            }
            $paper->info=$p[0];

            for($i=0; $i<8; $i++) {
                $peopleName = $p[2 * $i + 1];
                $peopleNameEN = $p[2 * $i + 2];

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
                    if(!in_array($people->id, $paper->save_peoples_id)) { //不应放入重复的值进去，beforeSave()中也做了检查
                        $paper->save_peoples_id[] = $people->id;
                    }

                }else { //若不存在创建新People
                    if($peopleName == null || $peopleName == '') continue; //新建必须存在name

                    $people = new People;
                    $people->name = $peopleName;
                    $people->name_en = empty($peopleNameEN) ? null : $peopleNameEN; //为空就赋null
                    if($people->save()){
                        $paper->save_peoples_id[] = $people->id; //新建的不可能重复，不做重复检查
                    }
                }
            }

            //不合适的日期格式会在beforeSave()中处理
            $paper->pass_date = $p[17];
            $paper->pub_date = $p[18];
            $paper->index_date = $p[19];

            if($paper->pass_date!=null)
                $paper->status = Paper::STATUS_PASSED;
            if($paper->pub_date!=null)
                $paper->status = Paper::STATUS_PUBLISHED;
            if($paper->index_date!=null)
                $paper->status = Paper::STATUS_INDEXED;
            if(self::convertYesNoToInt($p[20])) {
                $paper->index_number = $p[20];
                $paper->status = Paper::STATUS_INDEXED;
            }

            $paper->sci_number =  $p[21];
            $paper->ei_number = $p[22];
            $paper->istp_number = $p[23];
            $paper->category = $p[24];
            $paper->file_name = $p[25];


            for($i=0; $i<6; $i++){
                $name = $p[2 * $i + 26];
                $number = $p[2 * $i + 27];

                if(($name == '' || $name == null) &&
                    ($number == '' || $number == null) ) { //name和number都没有直接continue
                    continue;
                }

                //project以name，number做搜索，但以name做区分（新建必须存在）
                $fund_project = Project::model()->findByAttributes(array('name'=>$name));
                if($fund_project == null) $fund_project = Project::model()->findByAttributes(array('number'=>$number));

                if($fund_project != null) { //存在该project
                    //若数据库里没有number表格里有就存（name是肯定有的，不然存不进去）
                    if(($fund_project->number == null || $fund_project->number == '') &&
                        ($number != null && $number != '')) {
                        $fund_project->number = $number;
                        $fund_project->save();
                    }
                    if(!in_array($fund_project->id, $paper->save_fund_projects_id)) { //不应放入重复的值进去
                        $paper->save_fund_projects_id[] = $fund_project->id;
                    }

                }else { //创建新Project
                    if($name == null || $name == '') continue; //新建必须存在name

                    $fund_project = new Project;
                    $fund_project->name = $name;
                    $fund_project->number = empty($number) ? null : $number;
                    if($fund_project->save()){
                        $paper->save_fund_projects_id[] = $fund_project->id; //新建的没有可能重复，不做重复检查
                    }
                }
            }

            for($i=0; $i<2; $i++){
                $name = $p[3 * $i + 38];
                $number = $p[3 * $i + 39];
                $fund_number = $p[3 * $i + 40];

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
                    if(!in_array($reim_project->id, $paper->save_reim_projects_id)) { //不应放入重复的值进去
                        $paper->save_reim_projects_id[] = $reim_project->id;
                    }

                }else { //创建新Project
                    if($name == null || $name == '') continue; //新建必须存在name

                    $reim_project = new Project;
                    $reim_project->number = $number;
                    $reim_project->name = empty($name) ? null : $name;
                    $reim_project->fund_number = empty($fund_number) ? null : $fund_number;
                    if($reim_project->save()){
                        $paper->save_reim_projects_id[] = $reim_project->id; //新建的没有可能重复，不做重复检查
                    }
                }
            }
            for($i=0; $i<5; $i++){
                $name = $p[2 * $i + 44];
                $number = $p[2 * $i + 45];

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
                    if(!in_array($achievement_project->id, $paper->save_achievement_projects_id)) { //不应放入重复的值进去
                        $paper->save_achievement_projects_id[] = $achievement_project->id;
                    }

                }else { //创建新Project
                    if($name == null || $name == '') continue; //新建必须存在name

                    $achievement_project = new Project;
                    $achievement_project->name = $name;
                    $achievement_project->number = empty($number) ? null : $number;
                    if($achievement_project->save()){
                        $paper->save_achievement_projects_id[] = $achievement_project->id; //新建的没有可能重复，不做重复检查
                    }
                }
            }

            $paper->is_high_level = self::convertYesNoToInt($p[54]);

            $maintainerName = $p[55];
            if($maintainerName != null && $maintainerName != '') { //没有填写就跳过余下的处理
                $maintainer = People::model()->findByAttributes(array('name'=>$maintainerName));
                if($maintainer == null) $maintainer = People::model()->findByAttributes(array('name_en'=>$maintainerName));
                if($maintainer != null) {
                    $paper->maintainer_id = $maintainer->id;
                }else {
                    $maintainer = new People;
                    $maintainer->name = $maintainerName;
                    if($maintainer->save()){
                        $paper->maintainer_id = $maintainer->id;
                    }
                }
            }

            $paper->re_relation = true; //打开重铸关联标记
            if($paper->save()) {
                ;
            } else {
//                var_dump( $paper->getErrors());
                //var_dump($paper->info);
                return false;
            }

            //已废弃的逻辑
//            if($paper->save()) {
//                $paper->save_peoples_id = array();
//                for($i=0;$i<5;$i++){
//                    //英文名暂时不管
////                    $peopleName = $p[2 * $i + 1];
////                    $peopleNameEN = $p[2 * $i + 2];
////                    if($peopleName == null || $peopleName == '') {
////                        if($peopleNameEN != null && $peopleNameEN != '') {
////                            $peopleName = $peopleNameEN;
////                        }
////                        else continue;
////                    }
//                    $peopleName=$p[2 * $i + 1];
//                    if($peopleName=='' || $peopleName==null) {
//                        $peopleName = $p[2 * $i + 2];
//                    }
//
//                    if($peopleName=='' || $peopleName==null) {
//                        continue;
//                    }
//
//                    $people = People::model()->findByAttributes(array('name'=>$peopleName));
//                    if($people!=null) {
//                        $paper->save_peoples_id[] = $people->id;
//
//                    }else {
//                        $people = new People;
//                        $people->name = $peopleName;
//                        if($people->save()){
//                            $paper->save_peoples_id[] = $people->id;
//                        }
//                    }
//                }
//                //已废弃的逻辑
////                if(!self::populatePeople($paper,$peoplesId))
////                    return false;
//
//
//                $paper->save_fund_projects_id = array();
//                for($i=0;$i<5;$i++){
//                    $fundName=$p[2 * $i + 26];
//
//                    if($fundName=='' || $fundName==null) {
//                        continue;
//                    }
//
//                    $fund_project = Project::model()->findByAttributes(array('name'=>$fundName));
//                    if($fund_project != null) {
//                        $paper->save_fund_projects_id[] = $fund_project->id;
//
//                    }else {
//                        $fund_project = new Project;
//                        $fund_project->name = $fundName;
//                        if($p[2 * $i + 27] != '' && $p[2 * $i + 27] != null) $fund_project->number = $p[2 * $i + 27];
//                        if($fund_project->save()){
//                            $paper->save_fund_projects_id[] = $fund_project->id;
//                        }
//                    }
//                    //已废弃的逻辑
////                    if(!self::populateProject($paper, $fund_id, Paper::PROJECT_FUND))
////                        return false;
//                }
//
//
//                $paper->save_reim_projects_id = array();
//                for($i=0;$i<5;$i++){
//                    $reimName=$p[2 * $i + 36];
//
//                    if($reimName=='' || $reimName==null) {
//                        continue;
//                    }
//
//                    $reim_project = Project::model()->findByAttributes(array('name'=>$reimName));
//                    if($reim_project!=null) {
//                        $paper->save_reim_projects_id[] = $reim_project->id;
//
//                    }else {
//                        $reim_project = new Project;
//                        $reim_project->name = $reimName;
//                        if($p[2 * $i + 37] != '' && $p[2 * $i + 37] != null) $reim_project->number = $p[2 * $i + 37];
//                        if($reim_project->save()){
//                            $paper->save_reim_projects_id[] = $reim_project->id;
//                        }
//                    }
//                    //已废弃的逻辑
////                    if(!self::populateProject($paper, $reim_id, Paper::PROJECT_REIM))
////                        return false;
//                }
//
//
//                $paper->save_achievement_projects_id = array();
//                for($i=0;$i<5;$i++){
//                    $achievementName=$p[2 * $i + 46];
//
//                    if($achievementName=='' || $achievementName==null) {
//                        continue;
//                    }
//
//                    $achievement_project = Project::model()->findByAttributes(array('name'=>$achievementName));
//                    if($achievement_project!=null) {
//                        $paper->save_achievement_projects_id[] = $achievement_project->id;
//
//                    }else {
//                        $achievement_project = new Project;
//                        $achievement_project->name = $achievementName;
//                        if($p[2 * $i + 47] != '' && $p[2 * $i + 47] != null) $achievement_project->number = $p[2 * $i + 47];
//                        if($achievement_project->save()){
//                            $paper->save_achievement_projects_id[] = $achievement_project->id;
//                        }
//                    }
//                    //已废弃的逻辑
////                    if(!self::populateProject($paper, $achievement_id, Paper::PROJECT_ACHIEVEMENT))
////                        return false;
//                }
//
//            } else {
//                var_dump( $paper->getErrors());
//                //var_dump($paper->info);
//                return false;
//            }
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
     * upload file
     */
    public function actionUploadfile() {
        if (isset($_FILES['fileField'])) {
            $files = CUploadedFile::getInstancesByName('fileField');
            foreach($files as $file) {
                if(($paper = Paper::model()->findByAttributes(array('file_name'=>$file->name))) != null) { //找到文件名为file_name的
                    $paper->save_file = $file;

                    $paper->save();
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
        $model = new Paper;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Paper'])) {
            //除category、people和project其它的所有属性直接存储进model
            $model->attributes=$_POST['Paper'];

            //category因为一些动态因素用前台代码写的，这里也需要手动添加
            $model->category = $_POST['category'];

            //上传大文件需要设置php的upload_max_filesize和post_max_size，不然表单不会被提交过来！
            //相应的还要修改mysql的max_allowed_packed参数
            //处理文件
            $model->save_file = CUploadedFile::getInstance($model,'save_file');

            //_form中people和project通过POST传值给控制器
            //控制器把这些POST的值也存入对应的变量，调用save()时会根据变量进行关联表的处理
            $model->save_peoples_id = $_POST['Paper']['peoples'];
            $model->save_fund_projects_id = $_POST['Project']['fund_projects'];
            $model->save_reim_projects_id = $_POST['Project']['reim_projects'];
            $model->save_achievement_projects_id = $_POST['Project']['achievement_projects'];

            $model->re_relation = true;
            if ($model->save()) {
                //已废弃的逻辑
//                $peoples = $_POST['Paper']['peoples'];
//                self::populatePeople($model, $peoples);
//
//                $fund_projects = $_POST['Project']['fund_projects'];
//                $reim_projects = $_POST['Project']['reim_projects'];
//                $achievement_projects = $_POST['Project']['achievement_projects'];
//                self::populateProject($model, $fund_projects, Paper::PROJECT_FUND);
//                self::populateProject($model, $reim_projects, Paper::PROJECT_REIM);
//                self::populateProject($model, $achievement_projects, Paper::PROJECT_ACHIEVEMENT);

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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Paper'])) {
//            var_dump($_FILES['uploaded_file']);
//            var_dump($model->uploaded_file);

            //除category、people和project其它的所有属性直接存储进model
            $model->attributes = $_POST['Paper'];

            //category因为一些动态因素用前台代码写的，这里也需要手动添加
            $model->category = $_POST['category'];

            //上传大文件需要设置php的upload_max_filesize和post_max_size，不然表单不会被提交过来！
            //相应的还要修改mysql的max_allowed_packed参数
            //处理文件
            $model->save_file = CUploadedFile::getInstance($model,'save_file');

            //_form中people和project通过POST传值给控制器
            //控制器把这些POST的值也存入对应的变量，调用save()时会根据变量进行关联表的处理
            $model->save_peoples_id = $_POST['Paper']['peoples'];
            $model->save_fund_projects_id = $_POST['Project']['fund_projects'];
            $model->save_reim_projects_id = $_POST['Project']['reim_projects'];
            $model->save_achievement_projects_id = $_POST['Project']['achievement_projects'];

            $model->re_relation = true;
            if ($model->save()) {
//                var_dump($model->uploaded_file);
//                $model->uploaded_file->saveAs('D:\\test');

                //已废弃的逻辑
//                $criteria = new CDbCriteria;
//                $criteria->condition = 'paper_id=:paper_id';
//                $criteria->params = array(':paper_id'=>$model->id);
//                PaperPeople::model()->deleteAll($criteria);
//                $peoples = $_POST['Paper']['peoples'];
//                self::populatePeople($model, $peoples);
//
//                $fund_projects = $_POST['Project']['fund_projects'];
//                $reim_projects = $_POST['Project']['reim_projects'];
//                $achievement_projects = $_POST['Project']['achievement_projects'];
//                self::populateProject($model, $fund_projects, Paper::PROJECT_FUND);
//                self::populateProject($model, $reim_projects, Paper::PROJECT_REIM);
//                self::populateProject($model, $achievement_projects, Paper::PROJECT_ACHIEVEMENT);

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
//        $this->redirect(array('admin'));
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            //已废弃，会自动进行关联表的删除
//            PaperPeople::model()->deleteAllByAttributes(array(
//                'paper_id'=>$id,
//            ));
//            PaperProjectFund::model()->deleteAllByAttributes(array(
//                'paper_id'=>$id,
//            ));
//            PaperProjectReim::model()->deleteAllByAttributes(array(
//                'paper_id'=>$id,
//            ));
//            PaperProjectAchievement::model()->deleteAllByAttributes(array(
//                'paper_id'=>$id,
//            ));
            $this->loadModel($id)->delete();

            $this->redirect(array('admin'));

//            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//            if (!isset($_GET['ajax'])) {
//                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//            }
        } else {
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }


    /**
     * Delete all models.
     */
    public function actionClear() {
            //不用自动删除了，直接将4个关联表全部清空
            PaperPeople::model()->deleteAll();
            PaperProjectFund::model()->deleteAll();
            PaperProjectReim::model()->deleteAll();
            PaperProjectAchievement::model()->deleteAll();
            //清空paper数据表
            Paper::model()->deleteAll();

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

        $this->redirect(array('view','id'=>$model->id));
    }



    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Paper the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Paper::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404,'The requested page does not exist.');
        }
        return $model;
    }

//





    /**
     *  已废弃的逻辑
     */
//    /**
//     * Performs the AJAX validation.
//     * @param Paper $model the model to be validated
//     */
//    protected function performAjaxValidation($model)
//    {
//        if (isset($_POST['ajax']) && $_POST['ajax']==='paper-form') {
//            echo CActiveForm::validate($model);
//            Yii::app()->end();
//        }
//    }

//    /**
//     * 为model设置值，在afterSave()中会自动进行关联
//     */
//    private function setModelProjects($model) {
//        if(isset($_POST['Paper']['fund_projects']))
//            $model->fundProjects=$_POST['Paper']['fund_projects'];
//        if(isset($_POST['Paper']['reim_projects']))
//            $model->reimProjects=$_POST['Paper']['reim_projects'];
//        if(isset($_POST['Paper']['achievement_projects']))
//            $model->achievementProjects=$_POST['Paper']['achievement_projects'];
//    }

//    /**
//     * 在@paper和@peoples数组中构造paper_people关联，若paper和people已存在管理则会替换原关联
//     */
//    private function populatePeople($paper, $peoples)
//    {
//        for($i=0;$i<count($peoples);$i++) {
//            if($peoples[$i]!=null && $peoples[$i]!=0) {
//                //@TODO : can be optimized.
//                if(($paperPeople=PaperPeople::model()->findByPk(array('paper_id'=>$paper->id,'people_id'=>$peoples[$i]))) != null){
//                    $paperPeople->delete();
//                }
//                $paperPeople = new PaperPeople;
//                $paperPeople->seq = $i+1;
//                $paperPeople->paper_id=$paper->id;
//                $paperPeople->people_id=$peoples[$i];
//                //echo $paperPeople->paper_id." ".$paperPeople->people_id."<br>";
//                if($paperPeople->save()) {
//                    yii::trace("peoples[i]:".$peoples[$i]." saved","paperController.actionCreate()");
//                } else {
//                    return false;
//                }
//            }
//        }
//        return true;
//    }
//
//    /**
//     * 在@paper和@projects数组中依@type构造paper_project关联，若paper和project已存在关联则会替换原关联
//     */
//    private function populateProject($paper, $projects, $type)
//    {
//        for($i=0; $i<count($projects); $i++) {
//            if($projects[$i]!=null && $projects[$i]!=0) {
//                $paperProject = null;
//                if($type == Paper::PROJECT_FUND) $paperProject = PaperProjectFund::model()->findByPk(array('paper_id'=>$paper->id,'project_id'=>$projects[$i]));
//                else if($type == Paper::PROJECT_REIM) $paperProject = PaperProjectReim::model()->findByPk(array('paper_id'=>$paper->id,'project_id'=>$projects[$i]));
//                else if($type == Paper::PROJECT_ACHIEVEMENT) $paperProject = PaperProjectAchievement::model()->findByPk(array('paper_id'=>$paper->id,'project_id'=>$projects[$i]));
//                else return false;
//
//                if($paperProject != null){
//                    $paperProject->delete();
//                }
//                $paperProject = null;
//                if($type == Paper::PROJECT_FUND) $paperProject = new PaperProjectFund;
//                else if($type == Paper::PROJECT_REIM) $paperProject = new PaperProjectReim;
//                else if($type == Paper::PROJECT_ACHIEVEMENT) $paperProject = new PaperProjectAchievement;
//                else return false;
//
//                $paperProject->seq = $i+1;
//                $paperProject->paper_id=$paper->id;
//                $paperProject->project_id=$projects[$i];
//                //echo $paperPeople->paper_id." ".$paperPeople->people_id."<br>";
//
//                if($paperProject->save()) {
//                    yii::trace("peoples[i]:".$projects[$i]." saved","paperController.actionCreate()");
//                } else {
//                    return false;
//                }
//            }
//        }
//        return true;
//    }

    /**
     * 测试用
     */
//    public function actionAdminTODO() {
//        $model = new Paper('search');
//        $model->unsetAttributes();  // clear any default values
//        if(isset($_GET['Paper'])) {
//            $model->attributes=$_GET['Paper'];
//            if($_GET['Paper']['is_first_grade']=='0') {
//                $model->is_first_grade="";
//            }
//            if($_GET['Paper']['is_core']=='0') {
//                $model->is_core="";
//            }
//            if($_GET['Paper']['is_journal']=='0') {
//                $model->is_journal="";
//            }
//            if($_GET['Paper']['is_conference']=='0') {
//                $model->is_conference="";
//            }
//            if($_GET['Paper']['is_domestic']=='0') {
//                $model->is_domestic="";
//            }
//            if($_GET['Paper']['is_high_level']=='0') {
//                $model->is_high_level="";
//            }
//            if($_GET['Paper']['is_intl']=='0') {
//                $model->is_intl="";
//            }
//
//            $peopleNameArr=array();
//            if(!empty($_GET['People']['execute_id'])){
//                $people=People::model()->findByPk($_GET['People']['execute_id']);
//                $model->searchExecutePeople=$people->id;
//                $peopleNameArr[]=$people->name;
//
//            }
//            if(!empty($_GET['People']['liability_id'])){
//                $people=People::model()->findByPk($_GET['People']['liability_id']);
//                $model->searchExecutePeople=$people->id;
//                $peopleNameArr[]=$people->name;
//            }
//
//        }
//        if( isset($_GET['export']) && $_GET['export']) {
//            $dataProvider=$model->search();
//            $dataProvider->pagination=false;
//            self::exportProjectsToXlsByPeople($dataProvider->getData(),'参与者包括'.implode('， ',$peopleNameArr).'的项目');
//        } else {
//            $this->render('admin',array(
//                'model'=>$model,
//            ));
//        }
//
//    }

    /**
     * 测试用
     */
//    public function actionTestSearchByPeople() {
//        header('Content-Type: text/html; charset=utf-8');
//        echo 'function actionTestSearchByPeople()';
//        $people = People::model()->with(array(
//            'papers'=>array(
//                'condition'=>"",
//                'order'=>'papers.index_date DESC'
//            ),
//        ))->findByPk('48');
//        //http://www.yiiframework.com/doc/guide/1.1/en/database.arr#dynamic-relational-query-options
//        //tables in relations should be disambiguated like papers.index_date
//        //Relational Query Options:
//        //  select
//        //  condition
//        //  order
//
//        Yii::trace('actionTestSearchByPeople() big sql ended');
//        if(isset($people->papers))
//            var_dump($people->papers);
//        echo '!!!'.'<hr />';
//        $paper = Paper::model()->with(array(
//            'peoples'=>array(
//                'condition'=>'peoples.id=48',
//            )
//        ));
//
//        var_dump($paper->findAll(array(
//                'order'=>'index_date DESC'
//            )
//        ));
//
//    }

    /**
     * 已废弃，现在按统一格式导出
     */
//    public function actionExportAll() {
//        $dataProvider = new CActiveDataProvider('Paper',array('pagination' => false));
//        self::exportPapersToXlsByDefault($dataProvider->getData(),'全部论文');
//    }
//
//    private function exportPapersToXlsByPeople($papers,$fileName='export'){
//        $objPHPExcel = new PHPExcel();
//        $objPHPExcel->getProperties()->setTitle("导出的论文");
//        $objPHPExcel->setActiveSheetIndex(0);
//
//        $i=1;
//        $activeSheet = $objPHPExcel->getActiveSheet();
//        $activeSheet->setTitle('papers');
//        $activeSheet->SetCellValue('A'.$i,'序号');
//        $activeSheet->SetCellValue('B'.$i,'论文信息');
//        $activeSheet->SetCellValue('C'.$i,'作者');
//        $activeSheet->SetCellValue('D'.$i,'状态');
//        $activeSheet->SetCellValue('E'.$i,'时间');
//        $activeSheet->SetCellValue('F'.$i,'检索');
//        $activeSheet->SetCellValue('G'.$i,'发表级别');
//        $activeSheet->SetCellValue('H'.$i,'报账项目');
//        $activeSheet->SetCellValue('I'.$i,'文件名');
//        $i++;
//        foreach($papers as $p) {
//            $activeSheet->SetCellValue('A'.$i,$i-1);
//            $activeSheet->SetCellValue('B'.$i,$p->info);
//            $activeSheet->SetCellValue('C'.$i,!empty($p->peoples)? $p->peoples[0]->name:'');
//            $activeSheet->SetCellValue('D'.$i,$p->getStatusString());
//            $activeSheet->SetCellValue('E'.$i,$p->getDateString());
//            $activeSheet->SetCellValue('F'.$i,$p->getIndexString());
//            $activeSheet->SetCellValue('G'.$i,$p->getLevelString());
//            $activeSheet->SetCellValue('H'.$i,''); //@TODO when Project MVC is done! $p->getReimbursementProjectString()
//            $activeSheet->SetCellValue('I'.$i,$p->file_name);
//            $i++;
//
//        }
//        //http://stackoverflow.com/questions/19155488/array-to-excel-2007-using-phpexcel
//        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//        header("Pragma: public");
//        header("Expires: 0");
//        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
//        header("Content-Type:application/force-download");
//        header("Content-Type:application/vnd.ms-excel");
//        header("Content-Type:application/octet-stream");
//        header("Content-Type:application/download");;
//        //$fileName = iconv('utf-8', "gb2312", $fileName);
//        header('Content-Disposition:attachment;filename="'.$fileName.'.xlsx"');
//        header("Content-Transfer-Encoding:binary");
//        $objWriter->save('php://output');
//
//    }

    /**
     * 已废弃，现在按统一格式导出
     */
//    private function exportPapersToXlsByMaintainer($papers,$fileName='export'){
//
//        $objPHPExcel = new PHPExcel();
//        $objPHPExcel->getProperties()->setTitle("导出的论文");
//        $objPHPExcel->setActiveSheetIndex(0);
//
//        $i=1;
//        $activeSheet = $objPHPExcel->getActiveSheet();
//        $activeSheet->setTitle(substr($fileName,0,28));
//        $activeSheet->SetCellValue('A'.$i,'序号');
//        $activeSheet->SetCellValue('B'.$i,'论文信息');
//        $activeSheet->SetCellValue('C'.$i,'状态');
//        $activeSheet->SetCellValue('D'.$i,'时间');
//        $activeSheet->SetCellValue('E'.$i,'检索');
//        $i++;
//        foreach($papers as $p) {
//            $activeSheet->SetCellValue('A'.$i,$i-1);
//            $activeSheet->SetCellValue('B'.$i,$p->info);
//            $activeSheet->SetCellValue('C'.$i,$p->getStatusString());
//            $activeSheet->SetCellValue('D'.$i,$p->status==Paper::STATUS_PASSED ? $p->pass_date : $p->index_date);
//            $activeSheet->SetCellValue('E'.$i,$p->getIndexString());
//            $i++;
//
//        }
//        //http://stackoverflow.com/questions/19155488/array-to-excel-2007-using-phpexcel
//        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//        header("Pragma: public");
//        header("Expires: 0");
//        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
//        header("Content-Type:application/force-download");
//        header("Content-Type:application/vnd.ms-excel");
//        header("Content-Type:application/octet-stream");
//        header("Content-Type:application/download");;
//        $fileName = iconv('utf-8', "gb2312", $fileName);
//        header('Content-Disposition:attachment;filename="'.$fileName.'.xlsx"');
//        header("Content-Transfer-Encoding:binary");
//        $objWriter->save('php://output');
//
//    }

}
