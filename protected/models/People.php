<?php

/**
 * This is the model class for table "tbl_people".
 *
 * The followings are the available columns in table 'tbl_people':
 * @property integer $id
 * @property string $name
 * @property string $name_en
 * @property string $number //工资号or学号
 * @property string email
 * @property integer $position
 * @property string last_update_date //最后更新时间
 *
 * The followings are the available model relations:
 * @property People[] $execute_projects
 * @property People[] $liability_projects
 * @property Paper[] $papers
 * @property Patent[] $patents
 * @property Publication[] $publications
 * @property Software[] $softwares
 */
class People extends CActiveRecord
{
    const POSITION_PARTNER = -1;   //合作者
    const POSITION_STUDENT = 0;   //学生
    const POSITION_TEACHER = 1;   //老师

    const LABEL_PARTNER = '合作者';
    const LABEL_STUDENT = '学生';
    const LABEL_TEACHER = '教师';

    //用于方法中传递参数
    const PROJECT_EXECUTE = 0;
    const PROJECT_LIABILITY = 1;


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_people';
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
            array('email', 'email'),
			array('name, name_en, number, email', 'length', 'max'=>255),
            array('position', 'numerical', 'integerOnly'=>true),
            array('last_update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, name_en, email, position', 'safe', 'on'=>'search'),
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
            'execute_projects' => array(
                self::MANY_MANY,
                'Project',
                'tbl_project_people_execute(people_id, project_id)',
                'order'=>'latest_date DESC',
            ),
            'liability_projects' => array(
                self::MANY_MANY,
                'Project',
                'tbl_project_people_liability(people_id, project_id)',
                'order'=>'latest_date DESC',
            ),
            'papers' => array(
                self::MANY_MANY,
                'Paper',
                'tbl_paper_people(people_id, paper_id)',
                'alias' => 'papers_',
                'order'=>'papers_papers_.seq, latest_date DESC', //先按作者顺序排序
            ),
            'patents' => array(
                self::MANY_MANY,
                'Patent',
                'tbl_patent_people(people_id, patent_id)',
                'alias' => 'patents_',
                'order'=>'patents_patents_.seq, latest_date DESC',
            ),
            'publications' => array(
                self::MANY_MANY,
                'Publication',
                'tbl_publication_people(people_id, publication_id)',
                'alias' => 'publications_',
                'order'=>'publications_publications_.seq, pub_date DESC',
            ),
            'softwares' => array(
                self::MANY_MANY,
                'Software',
                'tbl_software_people(people_id, software_id)',
                'alias' => 'softwares_',
                'order'=>'softwares_softwares_.seq, reg_date DESC',
            ),
		);
	}



	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => '姓名',
            'name_en' => '外文名',
            'position' => '身份',
            'number' => '工资号/学号',
            'email' => '邮箱',
            'last_update_date' => '最后更新时间',
		);
	}

    /**
     * 去掉属性前后的空格
     */
    public function trimAttribute() {
        $this->name = trim($this->name);
        $this->name_en = trim($this->name_en);
        $this->number = trim($this->number);
        $this->email = trim($this->email);
        $this->position = trim($this->position);
    }

    /**
     * save()方法前自动调用，用于存储前处理一些数据
     */
    protected function beforeSave() {
        $this->trimAttribute();

        if($this->name == null || $this->name == '') {
            if($this->name_en == null || $this->name_en == '') return false; //name、name_en都没有
            else $this->name = $this->name_en; //有外文名没有名字时将外文名复制一份到名字
        }

        //逐个检查每个属性
        if ($this->name_en == '')
            $this->name_en = null;

        if ($this->number == '')
            $this->number = null;

        if ($this->email == '')
            $this->email = null;

        if ($this->position != self::POSITION_TEACHER &&
            $this->position != self::POSITION_STUDENT &&
            $this->position != self::POSITION_PARTNER) {

            $this->position = self::POSITION_STUDENT; //默认为学生
        }

        $this->last_update_date = date('y-m-d', time()); //最后更新时间

        return parent::beforeSave();
    }

    /**
     * delete()方法前自动调用，删除项目相关的所有关联表
     */
    protected function beforeDelete() {

        //删除关联
        if(
            self::deletePeoplePaper() &&
            self::deletePeoplePatent() &&
            self::deletePeoplePublication() &&
            self::deletePeopleSoftware() &&
            self::deletePeopleProject(self::PROJECT_EXECUTE) &&
            self::deletePeopleProject(self::PROJECT_LIABILITY)
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
    private function deletePeopleProject($type) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'people_id=:people_id';
        $criteria->params = array(':people_id'=>$this->id);

        switch ($type) {
            case self::PROJECT_EXECUTE:
                ProjectPeopleExecute::model()->deleteAll($criteria);
                break;
            case self::PROJECT_LIABILITY:
                ProjectPeopleLiability::model()->deleteAll($criteria);
                break;
            default:
                ProjectPeopleExecute::model()->deleteAll($criteria);
                break;
        }
        return true;
    }

    /**
     * 删除@type相应的paper_people关联表
     */
    private function deletePeoplePaper() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'people_id=:people_id';
        $criteria->params = array(':people_id'=>$this->id);

        PaperPeople::model()->deleteAll($criteria);
        return true;
    }

    /**
     * 删除@type相应的patent_people关联表
     */
    private function deletePeoplePatent() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'people_id=:people_id';
        $criteria->params = array(':people_id'=>$this->id);

        PatentPeople::model()->deleteAll($criteria);
        return true;
    }

    /**
     * 删除@type相应的publication_people关联表
     */
    private function deletePeoplePublication() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'people_id=:people_id';
        $criteria->params = array(':people_id'=>$this->id);

        PublicationPeople::model()->deleteAll($criteria);
        return true;
    }

    /**
     * 删除@type相应的software_people关联表
     */
    private function deletePeopleSoftware() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'people_id=:people_id';
        $criteria->params = array(':people_id'=>$this->id);

        SoftwarePeople::model()->deleteAll($criteria);
        return true;
    }

    /**
     * 返回在其它地方的项目下拉框中people的显示格式
     */
    public function getContentToList() {
        return $this->name . (empty($this->name_en) ? '' : ' '.$this->name_en);
    }

    /**
     * 返回人员身份
     */
    public function getPosition() {
        switch($this->position) {
            case self::POSITION_TEACHER:
                return self::LABEL_TEACHER;
            case self::POSITION_STUDENT:
                return self::LABEL_STUDENT;
            case self::POSITION_PARTNER:
                return self::LABEL_PARTNER;
            default:
                return null;
        }
        return null;
    }

    /**
     * 返回所有@type项目的@attr属性，返回值采用@glue做分隔符，并带有链接，指向各项目的view页面
     */
    public function getProjectsWithLink($type, $glue='<br>',$attr='name')
    {
        $projectsArr = array();
        switch ($type) {
            case self::PROJECT_EXECUTE:
                $projectsRecord = $this->execute_projects;
                break;
            case self::PROJECT_LIABILITY:
                $projectsRecord = $this->liability_projects;
                break;
            default:
                $projectsRecord = $this->execute_projects;
                break;
        }
        //显示标号
        $count_flag = false; $count_num = 1;
        if(count($projectsRecord) > 1) {
            $count_flag = true;
            $count_num = 1;
        }
        foreach ($projectsRecord as $project){
            $link = CHtml::link(CHtml::encode(($count_flag ? $count_num++ . '. ' : '') . $project->$attr), array('project/view', 'id'=>$project->id));
            array_push($projectsArr, $link);
        }
        if(count($projectsArr) == 0) return null;
        return implode($glue, $projectsArr);
    }

    /**
     * 返回论文的@attr属性，返回值采用@glue做分隔符，并带有链接，指向各论文的view页面
     */
    public function getPapersWithLink($glue='<br>',$attr='info')
    {
        $papersArr = array();
        $papersRecord = $this->papers;
        $count_flag = false; $count_num = 1;
        if(count($papersRecord) > 1) {
            $count_flag = true;
            $count_num = 1;
        }
        foreach ($papersRecord as $paper){
            $link = CHtml::link(($count_flag ? $count_num++ . '. ' : '') . CHtml::encode($paper->$attr), array('paper/view', 'id'=>$paper->id));
            array_push($papersArr, $link);
        }
        if(count($papersArr) == 0) return null;
        return implode($glue, $papersArr);
    }

    /**
     * 返回专利的@attr属性，返回值采用@glue做分隔符，并带有链接，指向各专利的view页面
     */
    public function getPatentsWithLink($glue='<br>',$attr='name')
    {
        $patentsArr = array();
        $patentsRecord = $this->patents;
        $count_flag = false; $count_num = 1;
        if(count($patentsRecord) > 1) {
            $count_flag = true;
            $count_num = 1;
        }
        foreach ($patentsRecord as $patent){
            $link = CHtml::link(($count_flag ? $count_num++ . '. ' : '') . CHtml::encode($patent->$attr), array('patent/view', 'id'=>$patent->id));
            array_push($patentsArr, $link);
        }
        if(count($patentsArr) == 0) return null;
        return implode($glue, $patentsArr);
    }

    /**
     * 返回著作的@attr属性，返回值采用@glue做分隔符，并带有链接，指向各著作的view页面
     */
    public function getPublicationsWithLink($glue='<br>',$attr='info')
    {
        $publicationsArr = array();
        $publicationsRecord = $this->publications;
        $count_flag = false; $count_num = 1;
        if(count($publicationsRecord) > 1) {
            $count_flag = true;
            $count_num = 1;
        }
        foreach ($publicationsRecord as $publication){
            $link = CHtml::link(($count_flag ? $count_num++ . '. ' : '') . CHtml::encode($publication->$attr), array('publication/view', 'id'=>$publication->id));
            array_push($publicationsArr, $link);
        }
        if(count($publicationsArr) == 0) return null;
        return implode($glue, $publicationsArr);
    }

    /**
     * 返回软件著作权的@attr属性，返回值采用@glue做分隔符，并带有链接，指向各软件著作权的view页面
     */
    public function getSoftwaresWithLink($glue='<br>',$attr='name')
    {
        $softwaresArr = array();
        $softwaresRecord = $this->softwares;
        $count_flag = false; $count_num = 1;
        if(count($softwaresRecord) > 1) {
            $count_flag = true;
            $count_num = 1;
        }
        foreach ($softwaresRecord as $software){
            $link = CHtml::link(($count_flag ? $count_num++ . '. ' : '') . CHtml::encode($software->$attr), array('software/view', 'id'=>$software->id));
            array_push($softwaresArr, $link);
        }
        if(count($softwaresArr) == 0) return null;
        return implode($glue, $softwaresArr);
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
     * */

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return People the static model class
	 */

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
