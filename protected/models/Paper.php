<?php

/**
 * This is the model class for table "tbl_paper".
 *
 * The followings are the available columns in table 'tbl_paper':
 * @property integer $id
 * @property string $info
 * @property integer $status
 * @property string $index_number
 * @property string $pass_date
 * @property string $pub_date
 * @property string $index_date
 * @property string $latest_date //三个日期中最新的日期，用于排序，在beforeSave()中更新
 * @property string $sci_number
 * @property string $ei_number
 * @property string $istp_number
 * @property string $category
 * @property string $file_name
 * @property string $file_type
 * @property integer $file_size
 * @property blob $file_content //16M，若为null或0代表没有文件
 * @property integer $is_high_level
 * @property integer $maintainer_id
 * @property string last_update_date //最后更新时间
 *
 * The followings are the available model relations:
 * @property People $maintainer
 * @property People[] $peoples
 * @property Project[] fund_projects
 * @property Project[] reim_projects
 * @property Project[] achievement_projects
 */
class Paper extends CActiveRecord
{
    //各项最大限制，只更改这里然并卵，除了更改这里，还要注意导入导出方法时的和表格对应，搜索、编辑的页面上的下拉框数量，表格的列，等等
    const MAX_PEOPLE = 8;
    const MAX_PROJECT_FUND = 6;
    const MAX_PROJECT_REIM = 2;
    const MAX_PROJECT_ACHIEVEMENT = 5;

    //status
    const STATUS_PASSED = 0;    //录用待发
    const STATUS_PUBLISHED = 1; //已发表
    const STATUS_INDEXED = 2;   //已检索

    //各标签文字
    const LABEL_PASSED = '录用待发';
    const LABEL_PUBLISHED = '已发表';
    const LABEL_INDEXED = '已检索';
    const LABEL_SCI = 'SCI';
    const LABEL_EI = 'EI';
    const LABEL_ISTP = 'ISTP';
    const LABEL_HIGH_LEVEL = '高水平';

    //用于方法中传递参数
    const PROJECT_FUND = 0;
    const PROJECT_REIM = 1;
    const PROJECT_ACHIEVEMENT = 2;

    //是否重铸关联表，默认是不会重铸的，需要更改关联表的务必在save()调用前进行设置并在$save_*的4个变量（不包括$save_file）中存值，注意，4个变量都要存值，否则会当做清空某个关联处理
    public $re_relation = false;
    //用于save()方法时自动构造关联表，在afterSave()中使用，需要打开$re_relation标记，每次save()时都会检查$re_relation标记，若为true则删除原关联使用数组中的值创建新关联
    //之所以不采用下面上传文件中的有值就上传，是因为逻辑上用户不能清空现有的上传文件（在update中只能替换），但可以清空现有的关联（在update中把现有的关联都选择无就行了）
    public $save_peoples_id = array();
    public $save_fund_projects_id = array();
    public $save_reim_projects_id = array();
    public $save_achievement_projects_id = array();

    //上传的文件，CUploadedFile格式，在beforeSave()中会进行处理；如果要上传文件就在这个变量中存值，每次save()时都会检查该值，若存在就覆盖原文件，若不存在就保留原文件（即不能清空已上传文件只能替换）
    public $save_file;


    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_paper';
    }

//    public function findAll($condition='', $params=array()) {
//        return parent::findAll(array(
//            'select' =>array('info','status','index_number','pass_date','pub_date','index_date','latest_date','sci_number','ei_number','istp_number','category','file_name','is_high_level','maintainer_id','last_update_date'),
//            'with' => array('peoples','fund_projects','reim_projects','achievement_projects'))
//        );
//
//    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //对前台用户将要输入的每个值做检查
            array('info', 'required', 'message'=>'论文信息不能为空'),
            array('info','length','max'=>500),
            array('save_file','file','types'=>'doc, docx, pdf', 'maxSize'=>1024 * 1024 * 16,'allowEmpty' => true), //用在update、create前台页面的检查，后台依然要做检查
            array('status, is_high_level, maintainer_id', 'numerical', 'integerOnly'=>true),
            array('index_number, sci_number, ei_number, istp_number, category', 'length', 'max'=>255),
            array('pass_date, pub_date, index_date, latest_date, last_update_date', 'safe'), //日期会在beforeSave中处理，不进行验证
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            //所有字段在搜索场景时均不需验证
            array('id, info, status, index_number, pass_date, pub_date, index_date, latest_date, last_update_date, sci_number, ei_number, istp_number, category, is_high_level, maintainer_id', 'safe', 'on'=>'search'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
//    public function search() //已废弃，不再使用search filter筛选框
//    {
//        // @todo Please modify the following code to remove attributes that should not be searched.
//
//        $criteria=new CDbCriteria;
//
//        $criteria->compare('status',$this->status);
//        $criteria->compare('pass_date',$this->pass_date,true);
//        $criteria->compare('pub_date',$this->pub_date,true);
//        $criteria->compare('index_date',$this->index_date,true);
//        $criteria->compare('maintainer_id',$this->maintainer_id);
//        return new CActiveDataProvider($this, array(
//            'criteria'=>$criteria,
//            'sort'=>array(
//                'attributes'=>array(
//                    'level'=>array(
//                        'asc'=>'is_high_level, is_intl, is_first_grade, is_core, is_journal, is_conference,  is_domestic',
//                        'desc'=>'is_domestic, is_conference, is_journal, is_core, is_first_grade, is_intl, is_high_level',
//                    ),
//                    '*',
//                ),
//            ),
//        ));
//    }

    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    /*
        must add an alias to disambiguate col names in the order clause,
        can't disambiguate without alias:
        <WRONG_CODE>
            ...
            'execute_peoples' => array(
                self::MANY_MANY,
                'People',
                'tbl_project_people_execute(project_id, people_id)',
                'order'=>'execute_peoples.seq',
            ),
            ...
        </WRONG_CODE>

        seems a bug in the Yii framework, alias seemd to be concated with
        relationName in the SQL JOIN(instead of replacing it):
        eg:
            if not specifying alias, the above WRONG code would render SQL like:
                 LEFT OUTER JOIN `tbl_project_people_execute` `execute_peoples_execute_peoples`
                 ON (`t`.`id`=`execute_peoples_execute_peoples`.`project_id`)
            which makes it not possible to disambiguate col names in order clause

    */

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'maintainer' => array(
                self::BELONGS_TO,
                'People',
                'maintainer_id'
            ),
            'peoples' => array(
                self::MANY_MANY,
                'People',
                'tbl_paper_people(paper_id, people_id)',
                'alias' => 'peoples_',
                'order'=>'peoples_peoples_.seq',
            ),
            'fund_projects' => array(
                self::MANY_MANY,
                'Project',
                'tbl_paper_project_fund(paper_id, project_id)',
                'alias' => 'fund_',
                'order'=>'fund_projects_fund_.seq',
            ),
            'reim_projects' => array(
                self::MANY_MANY,
                'Project',
                'tbl_paper_project_reim(paper_id, project_id)',
                'alias' => 'reim_',
                'order'=>'reim_projects_reim_.seq',
            ),
            'achievement_projects' => array(
                self::MANY_MANY,
                'Project',
                'tbl_paper_project_achievement(paper_id, project_id)',
                'alias' => 'achievement_',
                'order'=>'achievement_projects_achievement_.seq',
            )
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'info' => '论文信息',
            'status' => '状态',
            'index_number' => '检索号',
            'pass_date' => '录用时间',
            'pub_date' => '发表时间',
            'index_date' => '检索时间',
            'latest_date' => '最新状态时间',
            'sci_number' => 'SCI检索号',
            'ei_number' => 'EI检索号',
            'istp_number' => 'ISTP检索号',
            'category' => '类别',
            'file_name' => '文件名',
            'maintainer_id' => '维护人员',
            'is_high_level' => '高水平',
            'last_update_date' => '最后更新时间',

            'peoples'=>'作者',
            'fund_projects' => '支助项目',
            'reim_projects' => '报账项目',
            'achievement_projects' => '成果项目',
            'save_file' => '论文文件',
            'sci'=> 'SCI',
            'ei' => 'EI',
            'istp' => 'ISTP',
        );
    }

    /**
     * 去掉属性前后的空格
     */
    public function trimAttribute() {
        $this->info = trim($this->info);
        $this->status = trim($this->status);
        $this->index_number = trim($this->index_number);
        $this->pass_date = trim($this->pass_date);
        $this->pub_date = trim($this->pub_date);
        $this->index_date = trim($this->index_date);
        $this->sci_number = trim($this->sci_number);
        $this->ei_number = trim($this->ei_number);
        $this->istp_number = trim($this->istp_number);
        $this->category = trim($this->category);
        $this->file_name = trim($this->file_name);
    }


    /**
     * save()方法前自动调用，用于存储前处理一些数据
     */
    protected function beforeSave() {
        $this->trimAttribute();

        if($this->info == null || $this->info == '') return false; //对info做检查

        if ($this->index_number == '')
            $this->index_number = null;
        if ($this->sci_number == '')
            $this->sci_number = null;
        if ($this->ei_number == '')
            $this->ei_number = null;
        if ($this->istp_number == '')
            $this->istp_number = null;
        if ($this->category == '')
            $this->category = null;
        if($this->file_name == '')
            $this->file_name = null;

        //对日期做处理，使其精确到日，不规范的返回null
        $this->processDate();
        $this->latest_date = date('Y-m-d', max(strtotime($this->pass_date), strtotime($this->pub_date), strtotime($this->index_date)));

        //处理上传文件
        if($this->save_file != null &&
            //格式控制doc、docx、pdf
            (
                $this->save_file->type == 'application/msword' ||
                $this->save_file->type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
                $this->save_file->type == 'application/pdf'
            )
        ) {
            //用新文件替代原文件
            $this->file_name = $this->save_file->name;
            $this->file_type = $this->save_file->type;
            $this->file_size = $this->save_file->size;
            $this->file_content = file_get_contents($this->save_file->tempName);
        }

//        if (($this->scenario == 'update' || $this->scenario=='upload') && !$this->uploadedFile) {
//            unset($this->uploadedFile);
//        }

        if($this->re_relation) {
            //删除老的关联，在afterSave()中会重新进行关联
            if (
                self::deletePaperPeople() &&
                self::deletePaperProject(self::PROJECT_FUND) &&
                self::deletePaperProject(self::PROJECT_REIM) &&
                self::deletePaperProject(self::PROJECT_ACHIEVEMENT)
            ) {
                ;
            } else {
                return false;
            }
        }

        $this->last_update_date = date('y-m-d', time()); //最后更新时间

        return parent::beforeSave();
    }

    /**
     * save()方法后自动调用，用于处理一些关联
     */
    protected function afterSave() {

        if($this->re_relation) {
            //重铸关联
            if (
                self::populatePaperPeople() &&
                self::populatePaperProject(self::PROJECT_FUND) &&
                self::populatePaperProject(self::PROJECT_REIM) &&
                self::populatePaperProject(self::PROJECT_ACHIEVEMENT)
            ) {
                ;
            } else {
                return false;
            }
        }

        return parent::afterSave();
    }

    /**
     * delete()方法前自动调用，处理关联表
     */
    protected function beforeDelete() {

        //删除关联
        if(
            self::deletePaperPeople() &&
            self::deletePaperProject(self::PROJECT_FUND) &&
            self::deletePaperProject(self::PROJECT_REIM) &&
            self::deletePaperProject(self::PROJECT_ACHIEVEMENT)
        ) {
            ;
        } else {
            return false;
        }

        return parent::beforeDelete();
    }

    /**
     * delete()方法后自动调用
     */
    protected function afterDelete() {
        //已废弃的逻辑，在beforeDelete()中删除
//        if (
//            self::deletePaperProject(self::PROJECT_FUND) &&
//            self::deletePaperProject(self::PROJECT_REIM) &&
//            self::deletePaperProject(self::PROJECT_ACHIEVEMENT)) {
//            return parent::afterDelete();
//        } else {
//            return false;
//        }

//        return parent::afterDelete();
    }

    /**
     * 删除paper_people关联表
     */
    private function deletePaperPeople() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'paper_id=:paper_id';
        $criteria->params = array(':paper_id'=>$this->id);

        PaperPeople::model()->deleteAll($criteria);
        return true;
    }

    /**
     * 删除@type相应的paper_project关联表
     */
    private function deletePaperProject($type) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'paper_id=:paper_id';
        $criteria->params = array(':paper_id'=>$this->id);

        switch ($type) {
            case self::PROJECT_FUND:
                PaperProjectFund::model()->deleteAll($criteria);
                break;
            case self::PROJECT_REIM:
                PaperProjectReim::model()->deleteAll($criteria);
                break;
            case self::PROJECT_ACHIEVEMENT:
                PaperProjectAchievement::model()->deleteAll($criteria);
                break;
            default:
                PaperProjectFund::model()->deleteAll($criteria);
                break;
        }
        return true;
    }

    /**
     * 构造paper_people关联表
     */
    private function populatePaperPeople() {
        //读出用于构造关联表的变量
        $peoples = $this->save_peoples_id;
        $peoples = array_unique($peoples); //去重
        $unique_peoples = array(); //移位
        while(($temp = array_shift($peoples)) !== null) {
            if($temp > 0) $unique_peoples[] = $temp;
        }
        //构造关联表
        for($i = 0; $i < min(count($unique_peoples), self::MAX_PEOPLE); $i++) {
            if($unique_peoples[$i] != null && $unique_peoples[$i] != 0) {
                $paperPeople = new PaperPeople;
                $paperPeople->seq = $i + 1;
                $paperPeople->paper_id = $this->id;
                $paperPeople->people_id = $unique_peoples[$i];
                if($paperPeople->save()) {
                    yii::trace("peoples[i]:".$unique_peoples[$i]." saved","Paper.populatePaperPeople()");
                } else {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 依据@type构造相应的paper_project关联表
     */
    private function populatePaperProject($type) {
        //读出用于构造关联表的变量
        switch ($type) {
            case self::PROJECT_FUND:
                $projects = $this->save_fund_projects_id;
                $max_projects = self::MAX_PROJECT_FUND;
                break;
            case self::PROJECT_REIM:
                $projects = $this->save_reim_projects_id;
                $max_projects = self::MAX_PROJECT_REIM;
                break;
            case self::PROJECT_ACHIEVEMENT:
                $projects = $this->save_achievement_projects_id;
                $max_projects = self::MAX_PROJECT_ACHIEVEMENT;
                break;
            default:
                $projects = $this->save_fund_projects_id;
                $max_projects = self::MAX_PROJECT_FUND;
                break;
        }
        $projects = array_unique($projects); //去重
        $unique_projects = array(); //移位
        while(($temp = array_shift($projects)) !== null) {
            if($temp > 0) $unique_projects[] = $temp;
        }
        //构造关联表
        for($i = 0; $i < min(count($unique_projects), $max_projects); $i++) {
            if($unique_projects[$i] != null && $unique_projects[$i] != 0){
                switch ($type) {
                    case self::PROJECT_FUND:
                        $paperProject = new PaperProjectFund;
                        break;
                    case self::PROJECT_REIM:
                        $paperProject = new PaperProjectReim;
                        break;
                    case self::PROJECT_ACHIEVEMENT:
                        $paperProject = new PaperProjectAchievement;
                        break;
                    default:
                        $paperProject = new PaperProjectFund;
                        break;
                }
                $paperProject->seq = $i + 1;
                $paperProject->paper_id = $this->id;
                $paperProject->project_id = $unique_projects[$i];
                if($paperProject->save()) {
                    yii::trace("projects[i]:".$unique_projects[$i]." saved","Paper.populatePaperProject()");
                } else {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 返回对外显示信息
     */
    public function getContentToGuest() {
        return $this->info . (!empty($this->index_number) ? '&nbsp;&nbsp;(检索号：'.$this->index_number.')' : '');
    }

    /**
     * 返回所有作者的@attr属性，返回值采用@glue做分隔符
     */
    public function getAuthors($glue='，',$attr='name')
    {
        $peoplesArr = array();
        $peoplesRecord = $this->peoples;
        foreach ($peoplesRecord as $people){
            array_push($peoplesArr, $people->$attr);
        }
        if(count($peoplesArr) != 0) return implode($glue, $peoplesArr);
        else return null;
    }

    /**
     * 返回所有作者的@attr属性，返回值采用@glue做分隔符，并带有链接，指向各作者的view页面
     */
    public function getAuthorsWithLink($glue='，',$attr='name')
    {
        $peoplesArr = array();
        $peoplesRecord = $this->peoples;
        foreach ($peoplesRecord as $people){
            $link = CHtml::link(CHtml::encode($people->$attr), array('people/view', 'id'=>$people->id));
            array_push($peoplesArr, $link);
        }
        if(count($peoplesArr) != 0) return implode($glue, $peoplesArr);
        else return null;
    }

    /**
     * 静态返回所有作者的@attr属性，返回值采用@glue做分隔符
     */
    public static function getAuthorsStatic($id, $glue='，',$attr='name') {
        $paper = Paper::model()->findByPk($id);
        $peoplesArr = array();
        $peoplesRecord = $paper->peoples;
        foreach ($peoplesRecord as $people){
            array_push($peoplesArr, $people->$attr);
        }
        if(count($peoplesArr) != 0) return implode($glue, $peoplesArr);
        else return null;
    }

    /**
     * 返回最新状态的时间，若三个时间都未赋值则返回空字符串
     */
    public function getDateString() {
        if(!empty($this->index_date)){
            return $this->index_date;
        } else if(!empty($this->pub_date)){
            return $this->pub_date;
        } else if(!empty($this->pass_date)){
            return $this->pass_date;
        } else {
            return "";
        }
    }

    /**
     * 返回状态信息，若状态为已检索根据@needIndexNumber参数是否附带检索号一起返回
     */
    public function getStatusString($needIndexNumber = false) {
        if($this->status == self::STATUS_INDEXED) {
            $str = self::LABEL_INDEXED.' ';
        } else if($this->status == self::STATUS_PUBLISHED) {
            $str = self::LABEL_PUBLISHED.' ';
        } else if($this->status == self::STATUS_PASSED) {
            $str = self::LABEL_PASSED.' ';
        } else {
            $str = "";
        }
        if($this->index_number != null && $this->index_number != '')
            $str .= ($needIndexNumber ? '(检索号：'.$this->index_number.')' : '');
        return $str;
    }

    /**
     * 返回SCI、EI、ISTP检索号，若存在多个采用@glue做分割
     */
    public function getIndexString($glue=', ') {
        $indexes = array();
        if(!empty($this->sci_number)){
            array_push($indexes, 'SCI: '.$this->sci_number);
        }
        if(!empty($this->ei_number)){
            array_push($indexes, 'EI: '.$this->ei_number);
        }
        if(!empty($this->istp_number)){
            array_push($indexes, 'ISTP: '.$this->istp_number);
        }
        if(count($indexes) != 0) return implode($glue, $indexes);
        else return null;
    }

    /**
     * 返回类别信息，依@needMoreInfo参数是否显示“SCI、EI、ISTP、高水平”类别，若显示且存在多个采用@glue做分割
     */
    public function getCategoryString($needMoreInfo = false, $glue=', ') {
        $category = array();
        if($needMoreInfo) {
            if($this->sci_number != null && $this->sci_number != '')
                array_push($category, Paper::LABEL_SCI);
            if($this->ei_number != null && $this->ei_number != '')
                array_push($category, Paper::LABEL_EI);
            if($this->istp_number != null && $this->istp_number != '')
                array_push($category, Paper::LABEL_ISTP);
            if($this->category != null && $this->category != '')
                array_push($category, $this->category);
            if($this->is_high_level == 1)
                array_push($category, Paper::LABEL_HIGH_LEVEL);
        }
        else {
            array_push($category, $this->category);
        }
        if(count($category) != 0) return implode($glue, $category);
        else return null;
    }

    /**
     * 对pass_date, pub_date, index_date三个时间进行向下处理
     */
    public function processDate() {
        $this->pass_date = self::processDateStatic($this->pass_date, 0);
        $this->pub_date = self::processDateStatic($this->pub_date, 0);
        $this->index_date = self::processDateStatic($this->index_date, 0);
    }

    /**
     * 对@date日期进行进一步处理，依@opt参数使其精确到日，
     * @opt=0时若日期没有精确到日，则向下精确到日，例如2015处理后返回2015-1-1
     * @opt=1时若日期没有精确到日，则向上精确到日，例如2015处理后返回2015-12-31
     * 若不符合日期格式，则返回null
     */
    public static function processDateStatic($date, $opt = 0) {
        if($date == null || $date == '') return null;

        $max_day = array(0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        $reg1 = '/^(\d{1,4})[.\-\/](\d{1,2})[.\-\/](\d{1,2})$/';
        $reg2 = '/^(\d{1,4})[.\-\/](\d{1,2})$/';
        $reg3 = '/^(\d{1,4})$/';
        $matches = array();
        if(preg_match($reg1, $date, $matches)) {
            $year = intval($matches[1]);
            $mouth = intval($matches[2]);
            $day = intval($matches[3]);
            if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0)) //闰年
                $max_day[2] = 29;
            if($mouth >= 1 && $mouth <= 12 && $day >= 1 && $day <= $max_day[$mouth]) {
                return $year.'-'.$mouth.'-'.$day;
            }
        } else if(preg_match($reg2, $date, $matches)) {
            $year = intval($matches[1]);
            $mouth = intval($matches[2]);
            if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0))
                $max_day[2] = 29;
            if ($mouth >= 1 && $mouth <= 12) {
                return $year . '-' . $mouth . '-' . ($opt ? $max_day[$mouth] : 1);
            }
        } else if(preg_match($reg3, $date, $matches)) {
            $year = intval($matches[1]);
            if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0))
                $max_day[2] = 29;
            return $year . '-' . ($opt ? 12 : 1) . '-' . ($opt ? 31 : 1);
        }
        return null;
    }


    /**
     * 返回所有@type项目的@attr属性值，默认返回的格式为(number)name[fund_number]，返回值采用@glue做分隔符
     */
    public function getProjects($type, $glue='<br/>', $attr = null)
    {
        $projectsArr = array();
        switch ($type) {
            case self::PROJECT_FUND:
                $projectRecords = $this->fund_projects;
                break;
            case self::PROJECT_REIM:
                $projectRecords = $this->reim_projects;
                break;
            case self::PROJECT_ACHIEVEMENT:
                $projectRecords = $this->achievement_projects;
                break;
            default:
                $projectRecords = $this->fund_projects;
                break;
        }
        foreach ($projectRecords as $project) {
            if($attr == null) array_push($projectsArr, $project->getContentToList());
            else array_push($projectsArr, $project->$attr);
        }
        if(count($projectsArr) != 0) return implode($glue, $projectsArr);
        else return null;
    }

    /**
     * 返回所有@type项目的@attr属性值，默认返回的格式为(number)name[fund_number]，返回值采用@glue做分隔符，并带有链接，指向各项目的view页面
     */
    public function getProjectsWithLink($type, $glue='<br/>', $attr = null)
    {
        $projectsArr = array();
        switch ($type) {
            case self::PROJECT_FUND:
                $projectRecords = $this->fund_projects;
                break;
            case self::PROJECT_REIM:
                $projectRecords = $this->reim_projects;
                break;
            case self::PROJECT_ACHIEVEMENT:
                $projectRecords = $this->achievement_projects;
                break;
            default:
                $projectRecords = $this->fund_projects;
                break;
        }
        foreach ($projectRecords as $project) {
            if($attr == null) $text = $project->getContentToList();
            else  $text = $project->$attr;
            $link = CHtml::link(CHtml::encode($text), array('project/view', 'id'=>$project->id));
            array_push($projectsArr, $link);
        }
        if(count($projectsArr) != 0) return implode($glue, $projectsArr);
        else return null;
    }

    /**
     * 返回@this的所有不完整信息，以@glue作分隔符，若@this信息完整，则返回null
     */
    public function getIncompleteInfo($glue='<br/>') {
        $info = array();
        if(empty($this->info)) {
            $info[] = '*论文信息为空';
        }
        if(count($this->peoples) == 0) {
            $info[] = '*论文应至少有一个作者';
        }
        if($this->status == 0) {
            if(!(empty($this->pub_date) && empty($this->index_date))) {
                $info[] = '*论文状态与时间不对应';
            }
        } else if($this->status == 1) {
            if(!empty($this->index_date)) {
                $info[] = '*论文状态与时间不对应';
            }
        }
        if(!empty($this->index_number) && $this->status != 2) {
            $info[] = '*论文存在检索号，状态应为已检索';
        }
        if(empty($this->pass_date) && empty($this->pub_date) && empty($this->index_date)) {
            $info[] = '*论文时间应至少填写一个';
        }
        if(empty($this->category)) {
            $info[] = '*论文应存在类别';
        }
        if(empty($this->file_content)) {
            $info[] = '*论文文件不存在或未上传';
        }
        if(count($this->reim_projects) == 0) {
            $info[] = '*论文应至少存在一个报账项目';
        }
        if(empty($this->maintainer_id)) {
            $info[] = '*论文应存在维护人';
        }

        if(count($info) == 0) {
            return null;
        } else {
            return implode($glue, $info);
        }

    }



    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Paper the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

}
