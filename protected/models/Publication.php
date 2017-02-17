<?php

/**
 * This is the model class for table "tbl_publication".
 *
 * The followings are the available columns in table 'tbl_publication':
 * @property integer $id
 * @property string $info
 * @property string $press
 * @property string $isbn_number
 * @property string $pub_date
 * @property string $category
 * @property string $description
 * @property string $last_update_date //最后更新时间
 *
 * The followings are the available model relations:
 * @property People[] $peoples
 * @property Project[] fund_projects
 * @property Project[] reim_projects
 * @property Project[] achievement_projects
 */
class Publication extends CActiveRecord
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

    //是否重铸关联表，默认是不会重铸的，需要更改关联表的务必在save()调用前进行设置并在$save_*的4个变量中存值，注意，4个变量都要存值，否则会当做清空某个关联处理
    public $re_relation = false;
    //用于save()方法时自动构造关联表，在afterSave()中使用，需要打开$re_relation标记，每次save()时都会检查$re_relation标记，若为true则删除原关联使用数组中的值创建新关联
    public $save_peoples_id = array();
    public $save_fund_projects_id = array();
    public $save_reim_projects_id = array();
    public $save_achievement_projects_id = array();



	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_publication';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('info', 'required', 'message'=>'著作信息不能为空'),
            array('info','length','max'=>500),
//            array('isbn_number', 'required', 'message'=>'著作ISBN书号不能为空'),
            array('press, isbn_number, category', 'length', 'max'=>255),
            array('pub_date, last_update_date', 'safe'), //日期会在beforeSave中处理，不进行验证
//			array('is_textbook, is_pub, is_other', 'numerical', 'integerOnly'=>true),
            array('description', 'length', 'max'=>2048),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
            //所有字段在搜索场景时均不需验证
			array('id, info, press, isbn_number, pub_date, last_update_date, category, description', 'safe', 'on'=>'search'),
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
            'peoples' => array(
                self::MANY_MANY,
                'People',
                'tbl_publication_people(publication_id, people_id)',
                'alias' => 'peoples_',
                'order'=>'peoples_peoples_.seq',
            ),
            'fund_projects' => array(
                self::MANY_MANY,
                'Project',
                'tbl_publication_project_fund(publication_id, project_id)',
                'alias' => 'fund_',
                'order'=>'fund_projects_fund_.seq',
            ),
            'reim_projects' => array(
                self::MANY_MANY,
                'Project',
                'tbl_publication_project_reim(publication_id, project_id)',
                'alias' => 'reim_',
                'order'=>'reim_projects_reim_.seq',
            ),
            'achievement_projects' => array(
                self::MANY_MANY,
                'Project',
                'tbl_publication_project_achievement(publication_id, project_id)',
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
			'info' => '著作信息',
			'press' => '出版社',
            'isbn_number' => 'ISBN书号',
			'pub_date' => '出版时间',
			'category' => '类别',
			'description' => '描述',
            'last_update_date' => '最后更新时间',

			'peoples'=>'编写人',
            'fund_projects' => '支助项目',
            'reim_projects' => '报账项目',
            'achievement_projects' => '成果项目',
		);
	}

    public function trimAttribute() {
        $this->info = trim($this->info);
        $this->press = trim($this->press);
        $this->isbn_number = trim($this->isbn_number);
        $this->pub_date = trim($this->pub_date);
        $this->category = trim($this->category);
        $this->description = trim($this->description);
    }

    /**
     * save()方法前自动调用，用于存储前处理一些数据
     */
    protected function beforeSave() {
        $this->trimAttribute();

        if($this->info == null || $this->info == '') return false; //对info做检查
//        if($this->isbn_number == null || $this->isbn_number == '') return false; //对isbn做检查

        if($this->press == '')
            $this->press = null;
        if($this->isbn_number == '')
            $this->isbn_number = null;
        if($this->category == '')
            $this->category = null;
        if($this->description == '')
            $this->description = null;

        //对日期做处理，使其精确到日，不规范的返回null
        $this->processDate();



        if($this->re_relation) {
            //删除老的关联，在afterSave()中会重新进行关联
            if (
                self::deletePublicationPeople() &&
                self::deletePublicationProject(self::PROJECT_FUND) &&
                self::deletePublicationProject(self::PROJECT_REIM) &&
                self::deletePublicationProject(self::PROJECT_ACHIEVEMENT)
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
                self::populatePublicationPeople() &&
                self::populatePublicationProject(self::PROJECT_FUND) &&
                self::populatePublicationProject(self::PROJECT_REIM) &&
                self::populatePublicationProject(self::PROJECT_ACHIEVEMENT)
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
            self::deletePublicationPeople() &&
            self::deletePublicationProject(self::PROJECT_FUND) &&
            self::deletePublicationProject(self::PROJECT_REIM) &&
            self::deletePublicationProject(self::PROJECT_ACHIEVEMENT)
        ) {
            ;
        } else {
            return false;
        }

        return parent::beforeDelete();
    }

    /**
     * 删除publication_people关联表
     */
    private function deletePublicationPeople() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'publication_id=:publication_id';
        $criteria->params = array(':publication_id'=>$this->id);

        PublicationPeople::model()->deleteAll($criteria);
        return true;
    }

    /**
     * 删除@type相应的publication_project关联表
     */
    private function deletePublicationProject($type) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'publication_id=:publication_id';
        $criteria->params = array(':publication_id'=>$this->id);

        switch ($type) {
            case self::PROJECT_FUND:
                PublicationProjectFund::model()->deleteAll($criteria);
                break;
            case self::PROJECT_REIM:
                PublicationProjectReim::model()->deleteAll($criteria);
                break;
            case self::PROJECT_ACHIEVEMENT:
                PublicationProjectAchievement::model()->deleteAll($criteria);
                break;
            default:
                PublicationProjectFund::model()->deleteAll($criteria);
                break;
        }
        return true;
    }

    /**
     * 构造publication_people关联表
     */
    private function populatePublicationPeople() {
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
                $publicationPeople = new PublicationPeople;
                $publicationPeople->seq = $i + 1;
                $publicationPeople->publication_id = $this->id;
                $publicationPeople->people_id = $unique_peoples[$i];
                if($publicationPeople->save()) {
                    yii::trace("peoples[i]:".$unique_peoples[$i]." saved","Publication.populatePublicationPeople()");
                } else {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 依据@type构造相应的publication_project关联表
     */
    private function populatePublicationProject($type) {
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
                        $publicationProject = new PublicationProjectFund;
                        break;
                    case self::PROJECT_REIM:
                        $publicationProject = new PublicationProjectReim;
                        break;
                    case self::PROJECT_ACHIEVEMENT:
                        $publicationProject = new PublicationProjectAchievement;
                        break;
                    default:
                        $publicationProject = new PublicationProjectFund;
                        break;
                }
                $publicationProject->seq = $i + 1;
                $publicationProject->publication_id = $this->id;
                $publicationProject->project_id = $unique_projects[$i];
                if($publicationProject->save()) {
                    yii::trace("projects[i]:".$unique_projects[$i]." saved","Publication.populatePublicationProject()");
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
        return (count($this->peoples) == 0 ? '' : $this->getAuthors(',').'.') . $this->info . ((empty($this->isbn_number)) ? '' : ' (ISBN:' .$this->isbn_number.')');
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
        $publication = Publication::model()->findByPk($id);
        $peoplesArr = array();
        $peoplesRecord = $publication->peoples;
        foreach ($peoplesRecord as $people){
            array_push($peoplesArr, $people->$attr);
        }
        return implode($glue, $peoplesArr);
    }

    /**
     * 返回类别信息
     */
    public function getCategoryString() {
        return  $this->category;
    }

    /**
     * 对pub_date时间进行向下处理
     */
    public function processDate() {
        $this->pub_date = self::processDateStatic($this->pub_date, 0);
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
     * 返回所有@type项目的@attr属性值，默认返回的格式为(number)name[fund_number]，返回值采用@glue做分隔符
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
        if(empty($this->info)) {
            $info[] = '*著作信息为空';
        }
        if(empty($this->press)) {
            $info[] = '*著作出版社为空';
        }
        if(empty($this->isbn_number)) {
            $info[] = '*著作ISBN号为空';
        }
        if(empty($this->pub_date)) {
            $info[] = '*著作出版时间未填写';
        }
        if(count($this->peoples) == 0) {
            $info[] = '*著作应至少有一个作者';
        }
        if(empty($this->category)) {
            $info[] = '*著作应存在类别';
        }
        if(count($this->reim_projects) == 0) {
            $info[] = '*著作应至少存在一个报账项目';
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
	 * @return Publication the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
