<?php

/**
 * This is the model class for table "tbl_patent".
 *
 * The followings are the available columns in table 'tbl_patent':
 * @property integer $id
 * @property string $name
 * @property string $number
 * @property integer $status
 * @property string $app_date
 * @property string $auth_date
 * @property string $latest_date
 * @property string level
 * @property string $category
 * @property string $file_name
 * @property string $file_type
 * @property integer $file_size
 * @property blob $file_content //16M，若为null或0代表没有文件
 * @property string $abstract
 * @property integer $maintainer_id
 * @property string $last_update_date //最后更新时间
 *
 * The followings are the available model relations:
 * @property People $maintainer
 * @property People[] $peoples
 * @property Project[] reim_projects
 * @property Project[] achievement_projects
 */
class Patent extends CActiveRecord
{
    //各项最大限制，只更改这里然并卵，除了更改这里，还要注意导入导出方法时的和表格对应，搜索、编辑的页面上的下拉框数量，表格的列，等等
    const MAX_PEOPLE = 8;
    const MAX_PROJECT_REIM = 2;
    const MAX_PROJECT_ACHIEVEMENT = 5;

    //status
    const STATUS_APPLIED = 0;       //已申请
    const STATUS_AUTHORISED = 1;   //已授权

    //各标签文字
    const LABEL_APPLIED = '已申请';
    const LABEL_AUTHORISED = '已授权';

    //用于方法中传递参数
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
		return 'tbl_patent';
	}

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //对前台用户将要输入的每个值做检查
            array('name', 'required', 'message'=>'专利名称不能为空'),
            array('name','length','max'=>500),
            array('number', 'required', 'message'=>'专利号不能为空'),
            array('number, level, category', 'length', 'max'=>255),
            array('save_file','file','types'=>'doc, docx, pdf, zip, rar', 'maxSize'=>1024 * 1024 * 16,'allowEmpty' => true), //用在update、create前台页面的检查，后台依然要做检查
            array('status, maintainer_id', 'numerical', 'integerOnly'=>true),
            array('app_date, auth_date, latest_date, last_update_date', 'safe'), //日期会在beforeSave中处理，不进行验证
            array('abstract', 'length', 'max'=>2048),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, number, status, app_date, auth_date, latest_date, last_update_date, category, abstract, maintainer_id', 'safe', 'on'=>'search'),
        );
    }

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
                'tbl_patent_people(patent_id, people_id)',
                'alias' => 'peoples_',
                'order'=>'peoples_peoples_.seq',
            ),
            'reim_projects' => array(
                self::MANY_MANY,
                'Project',
                'tbl_patent_project_reim(patent_id, project_id)',
                'alias'=>'reim_',
                'order'=>'reim_projects_reim_.seq',
            ),
            'achievement_projects' => array(
                self::MANY_MANY,
                'Project',
                'tbl_patent_project_achievement(patent_id, project_id)',
                'alias'=>'achievement_',
                'order'=>'achievement_projects_achievement_.seq',
            ),

        );
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => '专利名',
            'number' => '专利号',
            'status' => '状态',
            'app_date' => '申请时间',
            'auth_date' => '授权时间',
            'latest_date' => '最新状态时间',
            'level' => '级别',
            'category' => '类别',
            'file_name' => '文件名',
            'abstract' => '简介',
            'maintainer_id' => '维护人员',
            'last_update_date' => '最后更新时间',

            'peoples' => '发明人',
            'reim_projects' => '报账项目',
            'achievement_projects' => '成果项目',
            'save_file' => '专利文件',
        );
    }

    /**
     * 去掉属性前后的空格
     */
    public function trimAttribute() {
        $this->name = trim($this->name);
        $this->number = trim($this->number);
        $this->status = trim($this->status);
        $this->app_date = trim($this->app_date);
        $this->auth_date = trim($this->auth_date);
        $this->level = trim($this->level);
        $this->category = trim($this->category);
        $this->file_name = trim($this->file_name);
    }

    /**
     * save()方法前自动调用，用于存储前处理一些数据
     */
    protected function beforeSave() {


        if($this->name == null || $this->name == '') return false; //对name做检查
//        if($this->number == null || trim($this->number) == '') return false; //对number做检查

        if($this->level == '')
            $this->level = null;
        if($this->category == '')
            $this->category = null;
        if($this->file_name == '')
            $this->file_name = null;
        if($this->abstract == '')
            $this->abstract = null;

        //对日期做处理，使其精确到日，不规范的返回null
        $this->processDate();
        $this->latest_date = date('Y-m-d', max(strtotime($this->app_date), strtotime($this->auth_date)));

        //处理上传文件
        if($this->save_file != null &&
            //格式控制doc、docx、zip、 rar
            (
                $this->save_file->type == 'application/msword' ||
                $this->save_file->type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
                $this->save_file->type == 'application/pdf' ||
                $this->save_file->type == 'application/zip' ||
                $this->save_file->type == 'application/x-rar-compressed'
            )
        ) {
            //用新文件替代原文件
            $this->file_name = $this->save_file->name;
            $this->file_type = $this->save_file->type;
            $this->file_size = $this->save_file->size;
            $this->file_content = file_get_contents($this->save_file->tempName);
        }


        if($this->re_relation) {
            //删除老的关联，在afterSave()中会重新进行关联
            if (
                self::deletePatentPeople() &&
                self::deletePatentProject(self::PROJECT_REIM) &&
                self::deletePatentProject(self::PROJECT_ACHIEVEMENT)
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
                self::populatePatentPeople() &&
                self::populatePatentProject(self::PROJECT_REIM) &&
                self::populatePatentProject(self::PROJECT_ACHIEVEMENT)
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
            self::deletePatentPeople() &&
            self::deletePatentProject(self::PROJECT_REIM) &&
            self::deletePatentProject(self::PROJECT_ACHIEVEMENT)
        ) {
            ;
        } else {
            return false;
        }

        return parent::beforeDelete();
    }


    /**
     * 删除patent_people关联表
     */
    private function deletePatentPeople() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'patent_id=:patent_id';
        $criteria->params = array(':patent_id'=>$this->id);

        PatentPeople::model()->deleteAll($criteria);
        return true;
    }

    /**
     * 删除@type相应的patent_project关联表
     */
    private function deletePatentProject($type) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'patent_id=:patent_id';
        $criteria->params = array(':patent_id'=>$this->id);

        switch ($type) {
            case self::PROJECT_REIM:
                PatentProjectReim::model()->deleteAll($criteria);
                break;
            case self::PROJECT_ACHIEVEMENT:
                PatentProjectAchievement::model()->deleteAll($criteria);
                break;
            default:
                PatentProjectReim::model()->deleteAll($criteria);
                break;
        }
        return true;
    }

    /**
     * 构造patent_people关联表
     */
    private function populatePatentPeople() {
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
                $patentPeople = new PatentPeople;
                $patentPeople->seq = $i + 1;
                $patentPeople->patent_id = $this->id;
                $patentPeople->people_id = $unique_peoples[$i];
                if($patentPeople->save()) {
                    yii::trace("peoples[i]:".$unique_peoples[$i]." saved","Patent.populatePatentPeople()");
                } else {
                    return false;
                }
            }
        }
        return true;
    }


    /**
     * 依据@type构造相应的patent_project关联表
     */
    private function populatePatentProject($type) {
        //读出用于构造关联表的变量
        switch ($type) {
            case self::PROJECT_REIM:
                $projects = $this->save_reim_projects_id;
                $max_projects = self::MAX_PROJECT_REIM;
                break;
            case self::PROJECT_ACHIEVEMENT:
                $projects = $this->save_achievement_projects_id;
                $max_projects = self::MAX_PROJECT_ACHIEVEMENT;
                break;
            default:
                $projects = $this->save_reim_projects_id;
                $max_projects = self::MAX_PROJECT_REIM;
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
                    case self::PROJECT_REIM:
                        $patentProject = new PatentProjectReim;
                        break;
                    case self::PROJECT_ACHIEVEMENT:
                        $patentProject = new PatentProjectAchievement;
                        break;
                    default:
                        $patentProject = new PatentProjectReim;
                        break;
                }
                $patentProject->seq = $i + 1;
                $patentProject->patent_id = $this->id;
                $patentProject->project_id = $unique_projects[$i];
                if($patentProject->save()) {
                    yii::trace("projects[i]:".$unique_projects[$i]." saved","Patent.populatePatentProject()");
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
        //不能使用$this->getAuthors()，有bug
        return (count($this->peoples) == 0 ? '' : $this->getAuthorsStatic($this->id, ',') .'.') . $this->name . ((empty($this->number)) ? '' : '.' .$this->number);
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
        return null;
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
        return null;
    }

    /**
     * 静态返回所有作者的@attr属性，返回值采用@glue做分隔符
     */
    public static function getAuthorsStatic($id, $glue='，',$attr='name') {
        $patent = Patent::model()->findByPk($id);
        $peoplesArr = array();
        $peoplesRecord = $patent->peoples;
        foreach ($peoplesRecord as $people){
            array_push($peoplesArr, $people->$attr);
        }
        if(count($peoplesArr) != 0) return implode($glue, $peoplesArr);
        return null;
    }

    /**
     * 返回最新状态的时间，若两个时间都未赋值则返回空字符串
     */
    public function getDateString() {
        if(!empty($this->auth_date)){
            return $this->auth_date;
        } else if(!empty($this->app_date)){
            return $this->app_date;
        } else {
            return "";
        }
    }

    /**
     * 返回状态信息
     */
    public function getStatusString() {
        if($this->status == self::STATUS_AUTHORISED) {
            return self::LABEL_AUTHORISED;
        } else if($this->status == self::STATUS_APPLIED) {
            return self::LABEL_APPLIED;
        } else {
            return "";
        }
    }

    /**
     * 返回类别信息
     */
    public function getCategoryString() {

        if($this->category != '') $this->category;
        return null;
    }

    /**
     * 对app_date, auth_date两个个时间进行向下处理
     */
    public function processDate() {
        $this->app_date = self::processDateStatic($this->app_date, 0);
        $this->auth_date = self::processDateStatic($this->auth_date, 0);
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
            case self::PROJECT_REIM:
                $projectRecords = $this->reim_projects;
                break;
            case self::PROJECT_ACHIEVEMENT:
                $projectRecords = $this->achievement_projects;
                break;
            default:
                $projectRecords = $this->reim_projects;
                break;
        }
        foreach ($projectRecords as $project) {
            if($attr == null) array_push($projectsArr, $project->getContentToList());
            else array_push($projectsArr, $project->$attr);
        }
        if(count($projectsArr) != 0) return implode($glue, $projectsArr);
        return null;
    }

    /**
     * 返回所有@type项目的@attr属性值，默认返回的格式为(number)name[fund_number]，返回值采用@glue做分隔符，并带有链接，指向各项目的view页面
     */
    public function getProjectsWithLink($type, $glue='<br/>', $attr = null)
    {
        $projectsArr = array();
        switch ($type) {
            case self::PROJECT_REIM:
                $projectRecords = $this->reim_projects;
                break;
            case self::PROJECT_ACHIEVEMENT:
                $projectRecords = $this->achievement_projects;
                break;
            default:
                $projectRecords = $this->reim_projects;
                break;
        }
        foreach ($projectRecords as $project) {
            if($attr == null) $text = $project->getContentToList();
            else  $text = $project->$attr;
            $link = CHtml::link(CHtml::encode($text), array('project/view', 'id'=>$project->id));
            array_push($projectsArr, $link);
        }
        if(count($projectsArr) != 0) return implode($glue, $projectsArr);
        return null;
    }

    /**
     * 返回@this的所有不完整信息，以@glue作分隔符，若@this信息完整，则返回null
     */
    public function getIncompleteInfo($glue='<br/>') {
        $info = array();
        if(empty($this->name)) {
            $info[] = '*专利名称为空';
        }
        if(empty($this->number)) {
            $info[] = '*专利号为空';
        }
        if(count($this->peoples) == 0) {
            $info[] = '*专利应至少有一个作者';
        }
        if($this->status == 0) {
            if(!(empty($this->auth_date))) {
                $info[] = '*专利状态与时间不对应';
            }
        }
        if(empty($this->app_date) && empty($this->auth_date)) {
            $info[] = '*申请时间与授权时间应至少填写一个';
        }
        if(empty($this->category)) {
            $info[] = '*专利应存在类别';
        }
        if(empty($this->file_size)) {
            $info[] = '*专利文件不存在或未上传';
        }
        if(count($this->reim_projects) == 0) {
            $info[] = '*专利应至少存在一个报账项目';
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
	 * @return Patent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
