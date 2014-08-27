<?php

/**
 * This is the model class for table "tbl_award".
 *
 * The followings are the available columns in table 'tbl_award':
 * @property integer $id
 * @property string $project_name
 * @property string $award_name
 * @property string $award_date
 * @property string $org_from
 * @property integer $is_intl
 * @property integer $is_national
 * @property integer $is_provincial
 * @property integer $is_city
 * @property integer $is_school
 * @property integer $type
 *
 * The followings are the available model relations:
 * @property People[] $tblPeoples
 */
class Award extends CActiveRecord
{
    const LEVEL_DOMESTIC = '国内';
    const LEVEL_INTL = '国际';
    const LEVEL_CORE = '核心';
    const LEVEL_JOURNAL = '期刊';
    const LEVEL_CONFERENCE = '会议';
    const LEVEL_FIRST_GRADE = '一级';
    const LEVEL_HIGH_LEVEL = '高水平';
    const LEVEL_OTHER_PUB = '其它刊物';


	public $peopleIds = array();
	public $searchPeoples = array();
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_award';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('is_intl, is_national, is_provincial, is_city, is_school', 'numerical', 'integerOnly'=>true),
			array('project_name, award_name, org_from', 'length', 'max'=>255),
			array('award_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, project_name, award_name, award_date, org_from, is_intl, is_national, is_provincial, is_city, is_school', 'safe', 'on'=>'search'),
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
				'tbl_award_people(award_id, people_id)',
				'alias'=>'peoples_',
				'order'=>'peoples_peoples_.seq',
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
			'project_name' => '项目名称',
			'award_name' => '奖项名称',
			'award_date' => '获奖时间',
			'org_from' => '授予单位',
			'is_intl' => '国际',
			'is_national' => '国家级',
			'is_provincial' => '省部级',
			'is_city' => '市级',
			'is_school' => '校级',
			'peoples' => '获奖人',
			'level'=>'级别',
		);
	}

	
	public function getLevelString($glue=', '){
        $levels = array();
        $attrs = self::attributeLabels();
        if($this->is_intl){
            array_push($levels,$attrs['is_intl']);
        }
        if($this->is_national){
            array_push($levels,$attrs['is_national']);
        }
        if($this->is_provincial){
            array_push($levels,$attrs['is_provincial']);
        }
        if($this->is_city){
            array_push($levels,$attrs['is_city']);
        }
        if($this->is_school){
            array_push($levels,$attrs['is_school']);
        }

        return implode($glue,$levels);

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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('project_name',$this->project_name,true);
		$criteria->compare('award_name',$this->award_name,true);
		$criteria->compare('award_date',$this->award_date,true);
		$criteria->compare('org_from',$this->org_from,true);
		$criteria->compare('is_intl',$this->is_intl);
		$criteria->compare('is_national',$this->is_national);
		$criteria->compare('is_provincial',$this->is_provincial);
		$criteria->compare('is_city',$this->is_city);
		$criteria->compare('is_school',$this->is_school);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Award the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getPeoples($glue=', ',$attr='name') {
		$peopleArr = array();
		foreach ($this->peoples as $people) {
			array_push($peopleArr,$people->$attr);
		}
		return implode($glue,$peopleArr);
    }


    public function getPeoplesJsForSelect2Init() {
    	//[{id:"MA", text: "Massachusetts"},{id: "CA", text: "California"}]
    	$nameValuePairArr = array();
		foreach ($this->peoples as $people) {
			$nameValuePair = '{id:"'.$people->id.'", text: "'.$people->name.'"}';
			array_push($nameValuePairArr,$nameValuePair);
		}
		return '['.implode(',', $nameValuePairArr).']';
    }
    private function populateAwardPeople(){
    	$peoples=$this->peopleIds;
    	for($i=0;$i<count($peoples);$i++){
    		if($peoples[$i]!=null && $peoples[$i]!=0) {
    			$awardPeople = new AwardPeople;
    			$awardPeople->seq=$i+1;
    			$awardPeople->award_id=$this->id;
    			$awardPeople->people_id=$peoples[$i];
    			yii::trace("peoples[i]:".$peoples[$i]." saving","Award.populateAwardPeople()");
    			if($awardPeople->save()){
    				yii::trace("peoples[i]:".$peoples[$i]." saved","Award.populateAwardPeople()");
    			} else {
    				return false;
    			}
    		}
    	}
    	return true;
    }

    private function deleteAwardPeople(){
    	$criteria = new CDbCriteria;
    	$criteria->condition = 'award_id=:award_id';
    	$criteria->params = array(':award_id'=>$this->id);
    	AwardPeople::model()->deleteAll($criteria);
    	return true;
    }

    protected function beforeSave(){
    	if($this->award_date=='') {
    		$this->award_date=null;
    	}
	    if($this->scenario=='update') {
	    	if(self::deleteAwardPeople()) {
	    		return parent::beforeSave();
	    	} else {
	    		return false;
	    	}
	    }
	    return parent::beforeSave();
	}

	protected function afterSave() {
		return self::populateAwardPeople() && parent::afterSave(); 
	}

	protected function afterDelete(){
		return 
			self::deleteAwardPeople() &&
			parent::afterDelete();
	}
}
