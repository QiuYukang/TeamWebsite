<?php

/**
 * This is the model class for table "tbl_project".
 *
 * The followings are the available columns in table 'tbl_project':
 * @property integer $id
 * @property string $name
 * @property string $number
 * @property string $fund_number
 * @property string $start_date
 * @property string $deadline_date
 * @property string $conclude_date
 * @property string $latest_date
 * @property double $fund
 * @property string $unit
 * @property string $level
 * @property string $category
 * @property string $description
 * @property integer $maintainer_id
 * @property string last_update_date //最后更新时间
 *
 * The followings are the available model relations:
 * @property People $maintainer
 * @property People[] $execute_peoples
 * @property People[] $liability_peoples
 * @property Paper[] $fund_papers
 * @property Paper[] $reim_papers
 * @property Paper[] $achievement_papers
 * @property Patent[] $reim_patents
 * @property Patent[] $achievement_patents
 * @property Publication[] $fund_publications
 * @property Publication[] $reim_publications
 * @property Publication[] $achievement_publications
 * @property Software[] $fund_softwares
 * @property Software[] $reim_softwares
 * @property Software[] $achievement_softwares
 */
class Project extends CActiveRecord
{
    //各项最大限制，只更改这里然并卵，除了更改这里，还要注意导入导出方法时的和表格对应，搜索、编辑的页面上的下拉框数量，表格的列，等等
    const MAX_EXECUTE_PEOPLE = 20;
    const MAX_LIABILITY_PEOPLE = 20;

    //用于方法中传递参数
	const PEOPLE_EXECUTE = 0;
    const PEOPLE_LIABILITY = 1;

    const PAPER_FUND = 0;
    const PAPER_REIM = 1;
    const PAPER_ACHIEVEMENT = 2;

    const PATENT_REIM = 1;
    const PATENT_ACHIEVEMENT = 2;

    const PUBLICATION_FUND = 0;
    const PUBLICATION_REIM = 1;
    const PUBLICATION_ACHIEVEMENT = 2;

    const SOFTWARE_FUND = 0;
    const SOFTWARE_REIM = 1;
    const SOFTWARE_ACHIEVEMENT = 2;

    //是否重铸关联表，默认是不会重铸的，需要更改关联表的务必在save()调用前进行设置并在$save_*的2个变量中存值，注意，2个变量都要存值，否则会当做清空某个关联处理
    public $re_relation = false;
    //用于save()方法时自动构造关联表，在afterSave()中使用，需要打开$re_relation标记，每次save()时都会检查$re_relation标记，若为true则删除原关联使用数组中的值创建新关联
    public $save_execute_peoples_id = array();
    public $save_liability_peoples_id = array();


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_project';
	}

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //对前台用户将要输入的每个值做检查
            array('name', 'required', 'message'=>'科研项目名称不能为空'),
            array('name','length','max'=>500),
            array('maintainer_id', 'numerical', 'integerOnly'=>true),
            array('fund', 'numerical'),
            array('number, fund_number, unit, level, category', 'length', 'max'=>255),
            array('description', 'length', 'max'=>2048),
            array('start_date, deadline_date, conclude_date, latest_date, last_update_date', 'safe'), //日期会在beforeSave中处理，不进行验证
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            //所有字段在搜索场景时均不需验证
            array('id, name, number, fund_number, start_date, deadline_date, conclude_date, latest_date, fund, unit, category, description, maintainer_id', 'safe', 'on'=>'search'),
        );
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'maintainer' => array(
            self::BELONGS_TO,
            'People',
            'maintainer_id'
            ),
            'execute_peoples' => array(
                self::MANY_MANY,
                'People',
                'tbl_project_people_execute(project_id, people_id)',
                'alias' => 'execute_',
                'order'=>'execute_peoples_execute_.seq',
            ),
			'liability_peoples' => array(
				self::MANY_MANY, 
				'People', 
				'tbl_project_people_liability(project_id, people_id)',
                'alias'=>'liability_',
				'order'=>'liability_peoples_liability_.seq'
			),
            'fund_papers' => array(
                self::MANY_MANY,
                'Paper',
                'tbl_paper_project_fund(project_id, paper_id)',
                'alias' => 'fund_papers_fund_',
                'order' => 'latest_date DESC'
            ),
            'reim_papers' => array(
                self::MANY_MANY,
                'Paper',
                'tbl_paper_project_reim(project_id, paper_id)',
                'alias' => 'reim_papers_reim_',
                'order' => 'latest_date DESC'
            ),
            'achievement_papers' => array(
                self::MANY_MANY,
                'Paper',
                'tbl_paper_project_achievement(project_id, paper_id)',
                'alias' => 'achievement_papers_achievement_',
                'order' => 'latest_date DESC'
            ),
            'reim_patents' => array(
                self::MANY_MANY,
                'Patent',
                'tbl_patent_project_reim(project_id, patent_id)',
                'alias' => 'reim_patents_reim_',
                'order' => 'latest_date DESC'
            ),
            'achievement_patents' => array(
                self::MANY_MANY,
                'Patent',
                'tbl_patent_project_achievement(project_id, patent_id)',
                'alias' => 'achievement_patents_achievement_',
                'order' => 'latest_date DESC'
            ),
            'fund_publications' => array(
                self::MANY_MANY,
                'Publication',
                'tbl_publication_project_fund(project_id, publication_id)',
                'alias' => 'fund_publications_fund_',
                'order' => 'pub_date DESC'
            ),
            'reim_publications' => array(
                self::MANY_MANY,
                'Publication',
                'tbl_publication_project_reim(project_id, publication_id)',
                'alias' => 'reim_publications_reim_',
                'order' => 'pub_date DESC'
            ),
            'achievement_publications' => array(
                self::MANY_MANY,
                'Publication',
                'tbl_publication_project_achievement(project_id, publication_id)',
                'alias' => 'achievement_publications_achievement_',
                'order' => 'pub_date DESC'
            ),
            'fund_softwares' => array(
                self::MANY_MANY,
                'Software',
                'tbl_software_project_fund(project_id, software_id)',
                'alias' => 'fund_softwares_fund_',
                'order' => 'reg_date DESC'
            ),
            'reim_softwares' => array(
                self::MANY_MANY,
                'Software',
                'tbl_software_project_reim(project_id, software_id)',
                'alias' => 'reim_softwares_reim_',
                'order' => 'reg_date DESC'
            ),
            'achievement_softwares' => array(
                self::MANY_MANY,
                'Software',
                'tbl_software_project_achievement(project_id, software_id)',
                'alias' => 'achievement_softwares_achievement_',
                'order' => 'reg_date DESC'
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
			'name' => '项目名称',
			'number' => '编号',
			'fund_number' => '经费本编号',
			'start_date' => '开始时间',
			'deadline_date' => '截至时间',
			'conclude_date' => '结题时间',
            'latest_date' => '最新状态时间',
            'fund' => '经费(万元)',
            'unit' => '牵头/合作单位',
            'level' => '级别',
            'category' => '类别',
            'description' => '简介',
            'maintainer_id' => '维护人员',
            'last_update_date' => '最后更新时间',

			'execute_peoples' => '实际执行人员',
			'liability_peoples' => '项目书人员',
		);
	}

    /**
     * 去掉属性前后的空格
     */
    public function trimAttribute() {
        $this->name = trim($this->name);
        $this->number = trim($this->number);
        $this->fund_number = trim($this->fund_number);
        $this->start_date = trim($this->start_date);
        $this->deadline_date = trim($this->deadline_date);
        $this->conclude_date = trim($this->conclude_date);
        $this->fund = trim($this->fund);
        $this->unit = trim($this->unit);
        $this->level = trim($this->level);
        $this->category = trim($this->category);
        $this->description = trim($this->description);
    }

    /**
     * save()方法前自动调用，用于存储前处理一些数据
     */
    protected function beforeSave() {
        $this->trimAttribute();

        if($this->name == null || $this->name == '') return false; //对name做检查

        //逐个检查每个属性
        if ($this->number == '')
            $this->number = null;
        if ($this->fund_number == '')
            $this->fund_number = null;
        if ($this->unit == '')
            $this->unit = null;
        if ($this->level == '')
            $this->level = null;
        if ($this->category == '')
            $this->category = null;
        if ($this->description == '')
            $this->description = null;

        //对资金做处理，不是数字的处理为null
        $this->fund = floatval($this->fund);
        if ($this->fund == 0 || $this->fund == '')
            $this->fund = null;

        //对日期做处理，使其精确到日，不规范的返回null
        $this->processDate();
        $this->latest_date = date('Y-m-d', max(strtotime($this->start_date), strtotime($this->deadline_date), strtotime($this->conclude_date)));

        $this->last_update_date = date('y-m-d', time()); //最后更新时间

        if($this->re_relation) {
            //删除老的关联，在afterSave()中会重新进行关联
            if (
                self::deleteProjectPeople(self::PEOPLE_EXECUTE) &&
                self::deleteProjectPeople(self::PEOPLE_LIABILITY)
            ) {
                ;
            } else {
                return false;
            }
        }

        return parent::beforeSave();
    }

    /**
     * save()方法后自动调用，用于处理一些关联
     */
    protected function afterSave() {

        if($this->re_relation) {
            //重铸关联
            if (
                self::populateProjectPeople(self::PEOPLE_EXECUTE) &&
                self::populateProjectPeople(self::PEOPLE_LIABILITY)
            ) {
                ;
            } else {
                return false;
            }
        }

        return parent::afterSave();
    }

    /**
     * delete()方法前自动调用，删除项目相关的所有关联表
     */
    protected function beforeDelete() {

        //删除关联
        if(
            self::deleteProjectPaper(self::PAPER_FUND) &&
            self::deleteProjectPaper(self::PAPER_REIM) &&
            self::deleteProjectPaper(self::PAPER_ACHIEVEMENT) &&
            self::deleteProjectPatent(self::PATENT_REIM) &&
            self::deleteProjectPatent(self::PATENT_ACHIEVEMENT) &&
            self::deleteProjectPublication(self::PUBLICATION_FUND) &&
            self::deleteProjectPublication(self::PUBLICATION_REIM) &&
            self::deleteProjectPublication(self::PUBLICATION_ACHIEVEMENT) &&
            self::deleteProjectSoftware(self::SOFTWARE_FUND) &&
            self::deleteProjectSoftware(self::SOFTWARE_REIM) &&
            self::deleteProjectSoftware(self::SOFTWARE_ACHIEVEMENT) &&
            self::deleteProjectPeople(self::PEOPLE_EXECUTE) &&
            self::deleteProjectPeople(self::PEOPLE_LIABILITY)
        ) {
            ;
        } else {
            return false;
        }

        return parent::beforeDelete();
    }

    /**
     * 删除@type相应的project_people关联表
     */
    private function deleteProjectPeople($type) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'project_id=:project_id';
        $criteria->params = array(':project_id'=>$this->id);

        switch ($type) {
            case self::PEOPLE_EXECUTE:
                ProjectPeopleExecute::model()->deleteAll($criteria);
                break;
            case self::PEOPLE_LIABILITY:
                ProjectPeopleLiability::model()->deleteAll($criteria);
                break;
            default:
                ProjectPeopleExecute::model()->deleteAll($criteria);
                break;
        }
        return true;
    }

    /**
     * 删除@type相应的paper_project关联表
     */
    private function deleteProjectPaper($type) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'project_id=:project_id';
        $criteria->params = array(':project_id'=>$this->id);

        switch ($type) {
            case self::PAPER_FUND:
                PaperProjectFund::model()->deleteAll($criteria);
                break;
            case self::PAPER_REIM:
                PaperProjectReim::model()->deleteAll($criteria);
                break;
            case self::PAPER_ACHIEVEMENT:
                PaperProjectAchievement::model()->deleteAll($criteria);
                break;
            default:
                PaperProjectFund::model()->deleteAll($criteria);
                break;
        }
        return true;
    }

    /**
     * 删除@type相应的patent_project关联表
     */
    private function deleteProjectPatent($type) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'project_id=:project_id';
        $criteria->params = array(':project_id'=>$this->id);

        switch ($type) {
                case self::PATENT_REIM:
                PatentProjectReim::model()->deleteAll($criteria);
                break;
            case self::PATENT_ACHIEVEMENT:
                PatentProjectAchievement::model()->deleteAll($criteria);
                break;
            default:
                PatentProjectReim::model()->deleteAll($criteria);
                break;
        }
        return true;
    }

    /**
     * 删除@type相应的publicaition_project关联表
     */
    private function deleteProjectPublication($type) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'project_id=:project_id';
        $criteria->params = array(':project_id'=>$this->id);

        switch ($type) {
            case self::PUBLICATION_FUND:
                PublicationProjectFund::model()->deleteAll($criteria);
                break;
            case self::PUBLICATION_REIM:
                PublicationProjectReim::model()->deleteAll($criteria);
                break;
            case self::PUBLICATION_ACHIEVEMENT:
                PublicationProjectAchievement::model()->deleteAll($criteria);
                break;
            default:
                PublicationProjectFund::model()->deleteAll($criteria);
                break;
        }
        return true;
    }

    /**
     * 删除@type相应的software_project关联表
     */
    private function deleteProjectSoftware($type) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'project_id=:project_id';
        $criteria->params = array(':project_id'=>$this->id);

        switch ($type) {
            case self::SOFTWARE_FUND:
                SoftwareProjectFund::model()->deleteAll($criteria);
                break;
            case self::SOFTWARE_REIM:
                SoftwareProjectReim::model()->deleteAll($criteria);
                break;
            case self::SOFTWARE_ACHIEVEMENT:
                SoftwareProjectAchievement::model()->deleteAll($criteria);
                break;
            default:
                SoftwareProjectFund::model()->deleteAll($criteria);
                break;
        }
        return true;
    }

    /**
     * 依据@type构造相应的project_people关联表
     */
    private function populateProjectPeople($type) {
        //读出用于构造关联表的变量
        switch ($type) {
            case self::PEOPLE_EXECUTE:
                $peoples = $this->save_execute_peoples_id;
                $max_peoples = self::MAX_EXECUTE_PEOPLE;
                break;
            case self::PEOPLE_LIABILITY:
                $peoples = $this->save_liability_peoples_id;
                $max_peoples = self::MAX_LIABILITY_PEOPLE;
                break;
            default:
                $peoples = $this->save_execute_peoples_id;
                $max_peoples = self::MAX_EXECUTE_PEOPLE;
                break;
        }
        $peoples = array_unique($peoples); //去重
        $unique_peoples = array(); //移位
        while(($temp = array_shift($peoples)) !== null) {
            if($temp > 0) $unique_peoples[] = $temp;
        }
        //构造关联表
        for($i = 0; $i < min(count($unique_peoples), $max_peoples); $i++) {
            if($unique_peoples[$i] != null && $unique_peoples[$i] != 0){
                switch ($type) {
                    case self::PEOPLE_EXECUTE:
                        $projectPeople = new ProjectPeopleExecute;
                        break;
                    case self::PEOPLE_LIABILITY:
                        $projectPeople = new ProjectPeopleLiability;
                        break;
                    default:
                        $projectPeople = new ProjectPeopleExecute;
                        break;
                }
                $projectPeople->seq = $i + 1;
                $projectPeople->project_id = $this->id;
                $projectPeople->people_id = $unique_peoples[$i];
                if($projectPeople->save()) {
                    yii::trace("projects[i]:".$unique_peoples[$i]." saved","Project.populateProjectPeople()");
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
        $has_more_info = false;
        $need_comma = false;
        $category = (empty($this->category) ? null : $this->category) ;
        $date = ((empty($this->start_date) || empty($this->deadline_date)) ? null : preg_split('/[.\-\/]/',$this->start_date)[0] . '~' .preg_split('/[.\-\/]/',$this->deadline_date)[0]); //取start_date和deadline_date的年份
        if($category != null || $date != null) $has_more_info = true;
        if($category != null && $date != null) $need_comma = true;
        if(!$has_more_info) return $this->name;
        else return $this->name.'（'. $category . ($need_comma ? '，':'') .$date.'）';
    }

    /**
     * 返回在其它地方的项目下拉框中project的显示格式
     */
    public function getContentToList() {
        return (empty($this->number) ? '' : '(' . $this->number . ')') . $this->name . (empty($this->fund_number) ?  '' : '[' . $this->fund_number . ']');
    }

    /**
     * 返回所有@type人员的@attr属性，返回值采用@glue做分隔符
     */
    public function getAuthors($type, $glue='，',$attr='name')
    {
        $peoplesArr = array();
        switch ($type) {
            case self::PEOPLE_EXECUTE:
                $peoplesRecord = $this->execute_peoples;
                break;
            case self::PEOPLE_LIABILITY:
                $peoplesRecord = $this->liability_peoples;
                break;
            default:
                $peoplesRecord = $this->execute_peoples;
                break;
        }
        foreach ($peoplesRecord as $people){
            array_push($peoplesArr, $people->$attr);
        }
        if(count($peoplesArr) == 0) return null;
        return implode($glue, $peoplesArr);
    }

    /**
     * 返回所有@type人员的@attr属性，返回值采用@glue做分隔符，并带有链接，指向各作者的view页面
     */
    public function getAuthorsWithLink($type, $glue='，',$attr='name')
    {
        $peoplesArr = array();
        switch ($type) {
            case self::PEOPLE_EXECUTE:
                $peoplesRecord = $this->execute_peoples;
                break;
            case self::PEOPLE_LIABILITY:
                $peoplesRecord = $this->liability_peoples;
                break;
            default:
                $peoplesRecord = $this->execute_peoples;
                break;
        }
        foreach ($peoplesRecord as $people){
            $link = CHtml::link(CHtml::encode($people->$attr), array('people/view', 'id'=>$people->id));
            array_push($peoplesArr, $link);
        }
        if(count($peoplesArr) == 0) return null;
        return implode($glue, $peoplesArr);
    }

    /**
     * 静态返回所有@type人员的@attr属性，返回值采用@glue做分隔符
     */
    public static function getAuthorsStatic($id, $type,  $glue='，',$attr='name') {
        $project = Project::model()->findByPk($id);
        $peoplesArr = array();
        switch ($type) {
            case self::PEOPLE_EXECUTE:
                $peoplesRecord = $project->execute_peoples;
                break;
            case self::PEOPLE_LIABILITY:
                $peoplesRecord = $project->liability_peoples;
                break;
            default:
                $peoplesRecord = $project->execute_peoples;
                break;
        }
        foreach ($peoplesRecord as $people){
            array_push($peoplesArr, $people->$attr);
        }
        if(count($peoplesArr) == 0) return null;
        return implode($glue, $peoplesArr);
    }

    /**
     * 返回所有@type论文的@attr属性，返回值采用@glue做分隔符，并带有链接，指向各论文的view页面
     */
    public function getPapersWithLink($type, $glue='<br>',$attr='info')
    {
        $papersArr = array();
        switch ($type) {
            case self::PAPER_FUND:
                $papersRecord = $this->fund_papers;
                break;
            case self::PAPER_REIM:
                $papersRecord = $this->reim_papers;
                break;
            case self::PAPER_ACHIEVEMENT:
                $papersRecord = $this->achievement_papers;
                break;
            default:
                $papersRecord = $this->fund_papers;
                break;
        }
        $count_flag = false; $count_num = 1;
        if(count($papersRecord) > 1) {
            $count_flag = true;
            $count_num = 1;
        }
        foreach ($papersRecord as $paper){
            //$link = CHtml::link(($count_flag ? $count_num++ . '. ' : '') . CHtml::encode($paper->$attr), array('paper/view', 'id'=>$paper->id));
            $link = CHtml::link(($count_flag ? $count_num++ . '. ' : '') . $paper->getContentToGuest(), array('paper/view', 'id'=>$paper->id));
            array_push($papersArr, $link);
        }
        if(count($papersArr) == 0) return null;
        return implode($glue, $papersArr);
    }

    /**
     * 返回所有@type专利的@attr属性，返回值采用@glue做分隔符，并带有链接，指向各专利的view页面
     */
    public function getPatentsWithLink($type, $glue='<br>',$attr='name')
    {
        $patentsArr = array();
        switch ($type) {
            case self::PATENT_REIM:
                $patentsRecord = $this->reim_patents;
                break;
            case self::PATENT_ACHIEVEMENT:
                $patentsRecord = $this->achievement_patents;
                break;
            default:
                $patentsRecord = $this->reim_patents;
                break;
        }
        $count_flag = false; $count_num = 1;
        if(count($patentsRecord) > 1) {
            $count_flag = true;
            $count_num = 1;
        }
        foreach ($patentsRecord as $patent){
            //$link = CHtml::link(($count_flag ? $count_num++ . '. ' : '') . CHtml::encode($patent->$attr), array('patent/view', 'id'=>$patent->id));
            $link = CHtml::link(($count_flag ? $count_num++ . '. ' : '') . $patent->getContentToGuest(), array('patent/view', 'id'=>$patent->id));
            array_push($patentsArr, $link);
        }
        if(count($patentsArr) == 0) return null;
        return implode($glue, $patentsArr);
    }

    /**
     * 返回所有@type著作的@attr属性，返回值采用@glue做分隔符，并带有链接，指向各著作的view页面
     */
    public function getPublicationsWithLink($type, $glue='<br>',$attr='info')
    {
        $publicationsArr = array();
        switch ($type) {
            case self::PUBLICATION_FUND:
                $publicationsRecord = $this->fund_publications;
                break;
            case self::PUBLICATION_REIM:
                $publicationsRecord = $this->reim_publications;
                break;
            case self::PUBLICATION_ACHIEVEMENT:
                $publicationsRecord = $this->achievement_publications;
                break;
            default:
                $publicationsRecord = $this->fund_publications;
                break;
        }
        $count_flag = false; $count_num = 1;
        if(count($publicationsRecord) > 1) {
            $count_flag = true;
            $count_num = 1;
        }
        foreach ($publicationsRecord as $publication){
            //$link = CHtml::link(($count_flag ? $count_num++ . '. ' : '') . CHtml::encode($publication->$attr), array('publication/view', 'id'=>$publication->id));
            $link = CHtml::link(($count_flag ? $count_num++ . '. ' : '') . $publication->getContentToGuest(), array('publication/view', 'id'=>$publication->id));
            array_push($publicationsArr, $link);
        }
        if(count($publicationsArr) == 0) return null;
        return implode($glue, $publicationsArr);
    }

    /**
     * 返回所有@type软件著作权的@attr属性，返回值采用@glue做分隔符，并带有链接，指向各软件著作权的view页面
     */
    public function getSoftwaresWithLink($type, $glue='<br>',$attr='name')
    {
        $softwaresArr = array();
        switch ($type) {
            case self::SOFTWARE_FUND:
                $softwaresRecord = $this->fund_softwares;
                break;
            case self::SOFTWARE_REIM:
                $softwaresRecord = $this->reim_softwares;
                break;
            case self::SOFTWARE_ACHIEVEMENT:
                $softwaresRecord = $this->achievement_softwares;
                break;
            default:
                $softwaresRecord = $this->fund_softwares;
                break;
        }
        $count_flag = false; $count_num = 1;
        if(count($softwaresRecord) > 1) {
            $count_flag = true;
            $count_num = 1;
        }
        foreach ($softwaresRecord as $software){
            //$link = CHtml::link(($count_flag ? $count_num++ . '. ' : '') . CHtml::encode($software->$attr), array('software/view', 'id'=>$software->id));
            $link = CHtml::link(($count_flag ? $count_num++ . '. ' : '') . $software->getContentToGuest(), array('software/view', 'id'=>$software->id));
            array_push($softwaresArr, $link);
        }
        if(count($softwaresArr) == 0) return null;
        return implode($glue, $softwaresArr);
    }

    /**
     * 返回最新状态的时间，若三个时间都未赋值则返回空字符串
     */
    public function getDateString() {
        if(!empty($this->conclude_date)){
            return $this->conclude_date;
        } else if(!empty($this->deadline_date)){
            return $this->deadline_date;
        } else if(!empty($this->start_date)){
            return $this->start_date;
        } else {
            return "";
        }
    }

    /**
     * 返回类别信息
     */
    public function getCategoryString() {
        return  $this->category;
    }

    /**
     * 对start_date, deadline_date, conclude_date三个时间进行向下处理
     */
    public function processDate() {
        $this->start_date = self::processDateStatic($this->start_date, 0);
        $this->deadline_date = self::processDateStatic($this->deadline_date, 1); //采用向后精确
        $this->conclude_date = self::processDateStatic($this->conclude_date, 1); //采用向后精确
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
     * 返回@this的所有不完整信息，以@glue作分隔符，若@this信息完整，则返回null
     */
    public function getIncompleteInfo($glue='<br/>') {
        $info = array();
        if(empty($this->name)) {
            $info[] = '*项目名称为空';
        }
        if(count($this->execute_peoples) == 0) {
            $info[] = '*项目应至少有一个执行人员';
        }
        if(empty($this->start_date)) {
            $info[] = '*项目应存在开始时间';
        }
        if(empty($this->category)) {
            $info[] = '*项目应存在类别';
        }
        if(empty($this->maintainer_id)) {
            $info[] = '*项目应存在维护人';
        }

        if(count($info) == 0) {
            return null;
        } else {
            return implode($glue, $info);
        }

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

		$criteria=new CDbCriteria;
		$criteria->with=array(
			'execute_peoples'=>array(
				//'joinType'=>'INNER JOIN',
			),
			'liability_peoples'=>array(
				//'joinType'=>'INNER JOIN',
			),
		);
		$criteria->together=true;
		//$criteria->distinct=true;
		$criteria->group = 't.id';//IMPORTANT!!
		if($this->searchExecutePeople!=null){
			$criteria->addInCondition('execute_.id',array($this->searchExecutePeople),true);
		}
		if($this->searchLiabilityPeople!=null){
			$criteria->addInCondition('liability_.id',array($this->searchLiabilityPeople),true);
		}
		$criteria->compare('name',$this->name,true);
		$criteria->compare('number',$this->number,true);
		$criteria->compare('fund_number',$this->fund_number,true);
		$criteria->compare('is_intl',$this->is_intl);
		$criteria->compare('is_national',$this->is_national);
		$criteria->compare('is_provincial',$this->is_provincial);
		$criteria->compare('is_city',$this->is_city);
		$criteria->compare('is_school',$this->is_school);
		$criteria->compare('is_enterprise',$this->is_enterprise);
		$criteria->compare('is_NSF',$this->is_NSF);
		$criteria->compare('is_973',$this->is_973);
		$criteria->compare('is_863',$this->is_863);
		$criteria->compare('is_NKTRD',$this->is_NKTRD);
		$criteria->compare('is_DFME',$this->is_DFME);
		$criteria->compare('is_major',$this->is_major);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('deadline_date',$this->deadline_date,true);
		$criteria->compare('conclude_date',$this->conclude_date,true);
		$criteria->compare('app_date',$this->app_date,true);
		$criteria->compare('pass_date',$this->pass_date,true);
		$criteria->compare('app_fund',$this->app_fund,true);
		$criteria->compare('pass_fund',$this->pass_fund,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
     */

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Project the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
