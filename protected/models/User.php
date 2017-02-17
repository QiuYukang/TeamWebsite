<?php

Yii::import('application.vendor.*');
require_once('password_compat/password_compat.php');

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $is_admin
 * @property integer is_manager
 * @property integer is_user
 */
class User extends CActiveRecord
{
    public $old_password;
    public $new_password;
	public $repeat_password;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            //array('username', 'required', 'message'=>"用户名不能为空"),
            //array('password', 'required', 'message'=>"密码不能为空"),
			array('is_admin, is_manager, is_user', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>30),
			array('password', 'length', 'max'=>30),
            //修改密码时验证以下
            array('old_password, new_password, repeat_password', 'required', 'message'=>"密码不能为空", 'on' => 'setting'),
            array('old_password', 'matchPassword', 'on' => 'setting'),
            array('repeat_password', 'compare', 'compareAttribute'=>'new_password', 'message'=>"两次密码不一致", 'on'=>'setting'),
            //创建用户场景下验证以下
            array('username', 'required', 'message'=>"用户名不能为空"),
            array('password, repeat_password', 'required', 'message'=>"密码不能为空", 'on' => 'create'),
            array('username', 'existUsername', 'on' => 'create'),
            array('repeat_password', 'compare', 'compareAttribute'=>'password', 'message'=>"两次密码不一致", 'on'=>'create'),
            //修改用户场景下验证以下
            //array('username, password, repeat_password', 'required', 'message'=>"密码不能为空", 'on' => 'update'),
            array('repeat_password', 'compare', 'compareAttribute'=>'password', 'message'=>"两次密码不一致", 'on'=>'update'),
            //上传用户场景下
            array('username, password', 'required', 'message'=>"密码不能为空", 'on'=>'upload'),
            array('is_admin, is_manager, is_user', 'numerical', 'integerOnly'=>true, 'on'=>'upload'),
			array('username, password, is_admin, is_manager, is_user', 'safe', 'on'=>'upload'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
//			array('id, username, password, email, is_admin, is_manager, is_user', 'safe', 'on'=>'search'),
		);
	}

    /**
     * matching the old password with your existing password.
     */
    public function matchPassword($attribute)
    {
        $user = User::model()->findByPk(Yii::app()->user->id);
        if(!password_verify($this->old_password,$user->password))
            $this->addError($attribute, '原密码错误');

//        if ($user->password != password_hash($this->old_password, PASSWORD_DEFAULT))
//            $this->addError($attribute, password_hash($this->old_password, PASSWORD_DEFAULT));
    }

    /**
     * 不能创建同名用户
     */
    public function existUsername($attribute)
    {
        if(User::model()->findByAttributes(array('username'=>$this->username)))
            $this->addError($attribute, '存在相同用户名的用户');

//        if ($user->password != password_hash($this->old_password, PASSWORD_DEFAULT))
//            $this->addError($attribute, password_hash($this->old_password, PASSWORD_DEFAULT));
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => '用户名',
			'password' => '密码',
			'is_admin' => '超级管理员权限',
			'is_manager' => '管理员权限',
			'is_user' => '普通用户权限',

            'old_password' => '原密码',
            'new_password' => '新密码',
            'repeat_password' => '重复密码',
		);
	}

    /**
     * 去掉属性前后的空格
     */
    public function trimAttribute() {
        $this->username = trim($this->username);
        $this->password = trim($this->password);
    }

    protected function beforeSave(){
        $this->trimAttribute();
        if($this->username == null || $this->username == '') return false; //对username做检查
//        if($this->password == null || $this->password == '') return false; //对password做检查
//        if(User::model()->findByAttributes(array('username' => $this->username)) != null) return false; //有相同用户名存在则false

        if(!empty($this->is_user)) $this->is_user = 1;
        else $this->is_user = 0;

        //依次赋权限，大权限包含小权限
        if(!empty($this->is_manager)) {
            $this->is_manager = 1;
            $this->is_user = 0;
        }
        else $this->is_manager = 0;

        if(!empty($this->is_admin)) {
            $this->is_admin = 1;
            $this->is_manager = 0;
            $this->is_user = 0;
        }
        else $this->is_admin = 0;

        if(!$this->is_admin && !$this->is_manager && !$this->is_user) $this->is_user = 1; //默认用户权限


//        if($this->getIsNewRecord()) {
//            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
//        }
        if($this->password != null && $this->password != '') {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT); //密码使用hash加密
        } else {
            $this->password = User::model()->findByAttributes(array('username' => $this->username))->password;
        }

        return parent::beforeSave();
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('is_admin',$this->is_admin);
		$criteria->compare('is_manager',$this->is_manager);
		$criteria->compare('is_user',$this->is_user);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
     */

    /*
	protected function afterFind() {
		$this->passwordInitial = $this->password;
		return  parent::afterFind();
	}
    */

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
