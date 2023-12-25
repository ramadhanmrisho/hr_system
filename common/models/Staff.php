<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "staff".
 *
 * @property int $id
 * @property string $fname
 * @property string|null $mname
 * @property string $lname
 * @property string $dob
 * @property string $place_of_birth
 * @property string $phone_number
 * @property int $identity_type_id
 * @property string $id_number
 * @property string $marital_status
 * @property string $email
 * @property string $gender
 * @property string $employee_number
 * @property string $category
 * @property int $region_id
 * @property int $district_id
 * @property string|null $ward

 * @property string|null $division
 * @property string $home_address
 * @property int|null $house_number
 * @property string $name_of_high_education_level
 * @property int $designation_id
 * @property int $department_id
 * @property string $salary_scale
 * @property int $basic_salary
 * @property int|null $allowance_id
 * @property int|null $helsb
 * @property int $paye
 * @property int|null $nssf
 * @property int $nhif
 * @property string $date_employed
 * @property string $account_name
 * @property int $bank_account_number
 * @property int|null $alternate_phone_number
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AssignedModule[] $assignedModules
 * @property CarryOver[] $carryOvers
 * @property Coursework[] $courseworks
 * @property Allowance $allowance
 * @property Department $department
 * @property Designation $designation
 * @property District $district
 * @property Region $region
 * @property UserAccount $createdBy
 * @property StaffSalary[] $staffSalaries
 * @property StaffSessions[] $staffSessions
 */
class Staff extends \yii\db\ActiveRecord
{
    public $allowances;
    public $allowance_id;
    public $attachments;
    public $dependant_information;
    public $next_of_kin_name;
    public $relationship;
    public $phone;
    public $next_of_kin_address;
    public $spouse_name;
    public $spouse_phone_number;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'staff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fname', 'lname', 'dob', 'place_of_birth', 'phone_number', 'identity_type_id', 'id_number', 'marital_status', 'email', 'gender', 'employee_number', 'category', 'region_id', 'district_id',  'home_address', 'name_of_high_education_level', 'designation_id', 'department_id', 'basic_salary', 'date_employed', 'bank_account_number','has_ot'], 'required'],
            [['dob', 'date_employed', 'created_at', 'updated_at','allowances','photo','allowance_id','TUGHE','salary_scale'], 'safe'],
            [['identity_type_id', 'region_id', 'district_id', 'designation_id', 'department_id', 'alternate_phone_number', 'created_by'], 'integer'],
            [[ 'basic_salary','nssf','nhif','created_by'], 'safe'],
           // [[ 'basic_salary', 'paye', 'nssf', 'nhif'], 'safe'],
            [['marital_status', 'gender', 'category'], 'string'],
            [['fname', 'mname', 'lname', 'place_of_birth', 'bank_account_number',], 'string', 'max' => 255],
            [['phone_number'], 'string', 'max' => 14],
            [['id_number', 'email','home_address'], 'string', 'max' => 30],
            [['employee_number', 'name_of_high_education_level', 'account_name'], 'string', 'max' => 100],
            [['employee_number'], 'unique'],
            //NEXT OF KIN
            [['next_of_kin_name', 'relationship', 'phone', 'next_of_kin_address','spouse_name','spouse_phone_number','dependant_information','attachments'], 'safe'],

            //DEPENDANT INFO
            //[['dependant_name', 'dependant_gender', 'date_of_birth','dependant_information'], 'safe'],

            [['phone_number'], 'match', 'pattern' => '/^[+]?([0-9]?)[(|s|-|.]?([0-9]{3})[)|s|-|.]*([0-9]{3})[s|-|.]*([0-9]{4})$/'],
            [['photo'],'file','extensions' => ['jpg','png','jepg'],'checkExtensionByMimeType'=>true],
            [['photo'], 'file','skipOnEmpty'=>false,'extensions' => ['jpg','png','jepg'],'checkExtensionByMimeType'=>true,'message'=>'Incorrect file uploaded','skipOnError'=>false,'maxSize'=>1024 * 1024 * 2,'on'=>'update-photo-upload'],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'id']],
            [['designation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Designation::className(), 'targetAttribute' => ['designation_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['created_by' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fname' => 'First Name',
            'mname' => 'Middle Name',
            'lname' => 'Surname',
            'dob' => 'Date of Birth',
            'place_of_birth' => 'Place Of Birth',
            'phone_number' => 'Phone Number',
            'identity_type_id' => 'Identity Type ',
            'id_number' => 'Id Number',
            'marital_status' => 'Marital Status',
            'email' => 'Email',
            'gender' => 'Gender',
            'photo' => 'Passport Size',
            'employee_number' => 'Employee Number',
            'category' => 'Category',
            'region_id' => 'Region',
            'district_id' => 'District',
            'home_address' => 'Home Address',
            'has_ot' => 'Has Overtime?',

            'name_of_high_education_level' => 'Name Of High Education Level',
            'designation_id' => 'Designation',
            'department_id' => 'Department Name',
            'basic_salary' => 'Basic Salary',
            'allowance_id' => 'Allowance',
            'nssf' => 'NSSF Number',
            'nhif' => 'Has NHIF',
            'date_employed' => 'Date Employed',
            'account_name' => 'Bank Name',
            'bank_account_number' => 'Bank Account Number',
            'alternate_phone_number' => 'Alternate Phone Number',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }



   public function getFullName(){
        return $this->fname.' '.$this->lname;
    }


    /**
     * Gets query for [[AssignedModules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedModules()
    {
        return $this->hasMany(AssignedModule::className(), ['staff_id' => 'id']);
    }



    /**
     * Gets query for [[Courseworks]].
     *
     * @return \yii\db\ActiveQuery
     */


    /**
     * Gets query for [[StaffAllowance]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function geStaffAllowances()
    {
        return $this->hasMany(StaffAllowance::className(), ['staff_id' => 'id']);
    }

    /**
     * Gets query for [[Department]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }

    /**
     * Gets query for [[Designation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDesignation()
    {
        return $this->hasOne(Designation::className(), ['id' => 'designation_id']);
    }

    /**
     * Gets query for [[District]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(UserAccount::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[StaffSalaries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStaffSalaries()
    {
        return $this->hasMany(StaffSalary::className(), ['staff_id' => 'id']);
    }

    /**
     * Gets query for [[StaffSessions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStaffSessions()
    {
        return $this->hasMany(StaffSessions::className(), ['staff_id' => 'id']);
    }


    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }



    //Pass Taxable Income




}
