<?php

/**
 * This is the model class for table "tbl_software".
 *
 * The followings are the available columns in table 'tbl_software':
 * @property integer $id
 * @property string $name
 * @property string $reg_date
 * @property string $reg_number
 * @property string $file_name
 * @property string $file_type
 * @property integer $file_size
 * @property blob $file_content //16M，若为null或0代表没有文件
 * @property string $description
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
class Software extends CActiveRecord
{
    //各项最大限制，只更改这里然并卵，除了更改这里，还要注意导入导出方法时的和表格对应，搜索、编辑的页面上的下拉框数量，表格的列，等等
    const MAX_PEOPLE = 8;
    const MAX_PROJECT_FUND = 6;
    const MAX_PROJECT_REIM = 2;
    const MAX_PROJECT_ACHIEVEMENT = 5;

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
		return 'tbl_software';
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
            array('name', 'required', 'message'=>'著作权名称不能为空'),
            array('name','length','max'=>500),
            array('save_file','file','types'=>'jpg, rar, zip', 'maxSize'=>1024 * 1024 * 16,'allowEmpty' => true), //用在update、create前台页面的检查，后台依然要做检查
            array('maintainer_id', 'numerical', 'integerOnly'=>true),
            array('reg_number', 'length', 'max'=>255),
            array('reg_date, last_update_date', 'safe'), //日期会在beforeSave中处理，不进行验证
            array('description', 'length', 'max'=>2048),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            //所有字段在搜索场景时均不需验证
            array('id, name, reg_date, reg_number, description, last_update_date', 'safe', 'on'=>'search'),
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
                'tbl_software_people(software_id, people_id)',
                'alias' => 'peoples_',
                'order'=>'peoples_peoples_.seq',
            ),
            'fund_projects' => array(
                self::MANY_MANY,
                'Project',
                'tbl_software_project_fund(software_id, project_id)',
                'alias' => 'fund_',
                'order'=>'fund_projects_fund_.seq',
            ),
            'reim_projects' => array(
                self::MANY_MANY,
                'Project',
                'tbl_software_project_reim(software_id, project_id)',
                'alias' => 'reim_',
                'order'=>'reim_projects_reim_.seq',
            ),
            'achievement_projects' => array(
                self::MANY_MANY,
                'Project',
                'tbl_software_project_achievement(software_id, project_id)',
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
			'name' => '著作权名称',
			'reg_date' => '登记时间',
			'reg_number' => '登记号',
            'file_name' => '文件名',
			'description' => '简介',
            'maintainer_id' => '维护人员',
            'last_update_date' => '最后更新时间',

			'peoples'=>'申请人',
			'fund_projects'=>'支助项目',
			'reim_projects'=>'报账项目',
			'achievement_projects'=>'成果项目',
            'save_file' => '软件著作权资料',
		);
	}

    public function trimAttribute() {
        $this->name = trim($this->name);
        $this->reg_date = trim($this->reg_date);
        $this->reg_number = trim($this->reg_number);
        $this->file_name = trim($this->file_name);
        $this->description = trim($this->description);
    }


    /**
     * save()方法前自动调用，用于存储前处理一些数据
     */
    protected function beforeSave() {
        $this->trimAttribute();

        if($this->name == null || $this->name == '') return false; //对name做检查

        if ($this->reg_number == '')
            $this->reg_number = null;
        if ($this->file_name == '')
            $this->file_name = null;
        if ($this->description == '')
            $this->description = null;

        //对日期做处理，使其精确到日，不规范的返回null
        $this->processDate();

        //处理上传文件
        if($this->save_file != null &&
            //格式控制doc、docx、pdf
            (
                $this->save_file->type == 'image/jpeg' ||
                $this->save_file->type == 'application/x-rar-compressed' ||
                $this->save_file->type == 'application/zip'
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
                self::deleteSoftwarePeople() &&
                self::deleteSoftwareProject(self::PROJECT_FUND) &&
                self::deleteSoftwareProject(self::PROJECT_REIM) &&
                self::deleteSoftwareProject(self::PROJECT_ACHIEVEMENT)
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
                self::populateSoftwarePeople() &&
                self::populateSoftwareProject(self::PROJECT_FUND) &&
                self::populateSoftwareProject(self::PROJECT_REIM) &&
                self::populateSoftwareProject(self::PROJECT_ACHIEVEMENT)
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
            self::deleteSoftwarePeople() &&
            self::deleteSoftwareProject(self::PROJECT_FUND) &&
            self::deleteSoftwareProject(self::PROJECT_REIM) &&
            self::deleteSoftwareProject(self::PROJECT_ACHIEVEMENT)
        ) {
            ;
        } else {
            return false;
        }

        return parent::beforeDelete();
    }

    /**
     * 删除software_people关联表
     */
    private function deleteSoftwarePeople() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'software_id=:software_id';
        $criteria->params = array(':software_id'=>$this->id);

        SoftwarePeople::model()->deleteAll($criteria);
        return true;
    }

    /**
     * 删除@type相应的software_project关联表
     */
    private function deleteSoftwareProject($type) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'software_id=:software_id';
        $criteria->params = array(':software_id'=>$this->id);

        switch ($type) {
            case self::PROJECT_FUND:
                SoftwareProjectFund::model()->deleteAll($criteria);
                break;
            case self::PROJECT_REIM:
                SoftwareProjectReim::model()->deleteAll($criteria);
                break;
            case self::PROJECT_ACHIEVEMENT:
                SoftwareProjectAchievement::model()->deleteAll($criteria);
                break;
            default:
                SoftwareProjectFund::model()->deleteAll($criteria);
                break;
        }
        return true;
    }

    /**
     * 构造software_people关联表
     */
    private function populateSoftwarePeople() {
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
                $softwarePeople = new SoftwarePeople;
                $softwarePeople->seq = $i + 1;
                $softwarePeople->software_id = $this->id;
                $softwarePeople->people_id = $unique_peoples[$i];
                if($softwarePeople->save()) {
                    yii::trace("peoples[i]:".$unique_peoples[$i]." saved","Software.populateSoftwarePeople()");
                } else {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 依据@type构造相应的software_project关联表
     */
    private function populateSoftwareProject($type) {
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
                        $softwareProject = new SoftwareProjectFund;
                        break;
                    case self::PROJECT_REIM:
                        $softwareProject = new SoftwareProjectReim;
                        break;
                    case self::PROJECT_ACHIEVEMENT:
                        $softwareProject = new SoftwareProjectAchievement;
                        break;
                    default:
                        $softwareProject = new SoftwareProjectFund;
                        break;
                }
                $softwareProject->seq = $i + 1;
                $softwareProject->software_id = $this->id;
                $softwareProject->project_id = $unique_projects[$i];
                if($softwareProject->save()) {
                    yii::trace("projects[i]:".$unique_projects[$i]." saved","Software.populateSoftwareProject()");
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
        return (count($this->peoples) == 0 ? '' : $this->getAuthors(',').'.') . $this->name . ((empty($this->reg_number)) ? '' : ' (' .$this->reg_number.')');
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
        return implode($glue, $peoplesArr);
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
        return implode($glue, $peoplesArr);
    }

    /**
     * 静态返回所有作者的@attr属性，返回值采用@glue做分隔符
     */
    public static function getAuthorsStatic($id, $glue='，',$attr='name') {
        $software = Software::model()->findByPk($id);
        $peoplesArr = array();
        $peoplesRecord = $software->peoples;
        foreach ($peoplesRecord as $people){
            array_push($peoplesArr, $people->$attr);
        }
        return implode($glue, $peoplesArr);
    }

    /**
     * 对reg_date进行向下处理
     */
    public function processDate() {
        $this->reg_date = self::processDateStatic($this->reg_date, 0);
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
        return implode($glue, $projectsArr);
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
        return implode($glue, $projectsArr);
    }

    /**
     * 返回@this的所有不完整信息，以@glue作分隔符，若@this信息完整，则返回null
     */
    public function getIncompleteInfo($glue='<br/>') {
        $info = array();
        if(empty($this->name)) {
            $info[] = '*软件著作权名称为空';
        }
        if(count($this->peoples) == 0) {
            $info[] = '*软件著作权应至少有一个申请人';
        }
        if(empty($this->reg_number)) {
            $info[] = '*登记号为空';
        }
        if(empty($this->reg_number)) {
            $info[] = '*登记时间为空';
        }
        if(empty($this->file_size)) {
            $info[] = '*软件著作权资料不存在或未上传';
        }
        if(count($this->reim_projects) == 0) {
            $info[] = '*软件著作权应至少存在一个报账项目';
        }
        if(empty($this->maintainer_id)) {
            $info[] = '*软件著作权应存在维护人';
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
     * @return Software the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
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

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('reg_date',$this->reg_date,true);
		$criteria->compare('reg_number',$this->reg_number,true);
		$criteria->compare('department',$this->department,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
     */
}
