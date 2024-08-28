<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user_account".
 *
 * @property int $id
 * @property int $user_id staff /student IDs
 * @property string $username staff No/ Reg No
 * @property string $password
 * @property string $auth_key
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property string $verification_token
 * @property string $category
 * @property string $designation_abbr
 * @property int $created_by

 *
 * @property AcademicYear[] $academicYears
 * @property Allowance[] $allowances
 * @property AssignedModule[] $assignedModules
 * @property Assignment[] $assignments
 * @property AuthAssignment[] $authAssignments
 * @property Certificate[] $certificates
 * @property Course[] $courses
 * @property Department[] $departments
 * @property Designation[] $designations
 * @property District[] $districts



 * @property Staff[] $staff
 * @property StaffSalary[] $staffSalaries
 * @property Student[] $students
 * @property StudentFinancialCategory[] $studentFinancialCategories
 * @property SystemAudit[] $systemAudits

 * @property UserAccount $createdBy
 * @property UserAccount[] $userAccounts
 * @property YearOfStudy[] $yearOfStudies
 */
class UserAccount extends ActiveRecord implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_account}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'username', 'password', 'auth_key', 'password_reset_token', 'email', 'verification_token', 'category', 'designation_abbr', 'created_by'], 'required'],
            [['user_id', 'status', 'created_by'], 'integer'],
            [['category'], 'string'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['username', 'password', 'auth_key', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['designation_abbr'], 'string', 'max' => 30],
            [['username'], 'unique'],
            [['created_at','updated_at'], 'safe'],
            [['email'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'username' => 'Username',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'verification_token' => 'Verification Token',
            'category' => 'Category',
            'designation_abbr' => 'Designation Abbr',
            'created_by' => 'Created By',


        ];
    }





    public function getFullName(){
        return Staff::find()->where(['id'=>$this->user_id])->one()->fname.' '.!empty(Staff::find()->where(['id'=>$this->user_id])->one()->mname)?Staff::find()->where(['id'=>$this->user_id])->one()->mname:' '.' '.Staff::find()->where(['id'=>$this->user_id])->one()->lname;
    }

    /**
     * Gets query for [[AcademicYears]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYears()
    {
        return $this->hasMany(AcademicYear::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Allowances]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAllowances()
    {
        return $this->hasMany(Allowance::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[AssignedModules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedModules()
    {
        return $this->hasMany(AssignedModule::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Assignments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignments()
    {
        return $this->hasMany(Assignment::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[AuthAssignments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Certificates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCertificates()
    {
        return $this->hasMany(Certificate::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Courses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Course::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Departments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartments()
    {
        return $this->hasMany(Department::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Designations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDesignations()
    {
        return $this->hasMany(Designation::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Districts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistricts()
    {
        return $this->hasMany(District::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[ExamResults]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExamResults()
    {
        return $this->hasMany(ExamResult::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[FinalExams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFinalExams()
    {
        return $this->hasMany(FinalExam::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Gpas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGpas()
    {
        return $this->hasMany(Gpa::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[GpaClasses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGpaClasses()
    {
        return $this->hasMany(GpaClass::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Grades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrades()
    {
        return $this->hasMany(Grade::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Modules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModules()
    {
        return $this->hasMany(Module::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[NtaLevels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNtaLevels()
    {
        return $this->hasMany(NtaLevel::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[OlevelAndAlevelSubjects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOlevelAndAlevelSubjects()
    {
        return $this->hasMany(OlevelAndAlevelSubject::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[ParentInformations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParentInformations()
    {
        return $this->hasMany(ParentInformation::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Payments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[PaymentTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentTypes()
    {
        return $this->hasMany(PaymentType::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[PostponedStudents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostponedStudents()
    {
        return $this->hasMany(PostponedStudent::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[RegisteredModules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegisteredModules()
    {
        return $this->hasMany(RegisteredModule::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Semesters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSemesters()
    {
        return $this->hasMany(Semester::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Staff]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasMany(Staff::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StaffSalaries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStaffSalaries()
    {
        return $this->hasMany(StaffSalary::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Students]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[StudentFinancialCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentFinancialCategories()
    {
        return $this->hasMany(StudentFinancialCategory::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[SystemAudits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSystemAudits()
    {
        return $this->hasMany(SystemAudit::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Tests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Transcripts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranscripts()
    {
        return $this->hasMany(Transcript::className(), ['created_by' => 'id']);
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
     * Gets query for [[UserAccounts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAccounts()
    {
        return $this->hasMany(UserAccount::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[YearOfStudies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getYearOfStudies()
    {
        return $this->hasMany(YearOfStudy::className(), ['created_by' => 'id']);
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
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

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }



    public function getDesignation(){
        if($this->category == "staff"){
            return Staff::findOne($this->user_id)->designation->name;
        } else{
            return '';
        }
    }


    public function getUser(){
        if($this->category == "staff"){
            $model = Staff::findOne($this->user_id);
        }

        if(!empty($model)){
            return $model;
        }
        else{
            return null;
        }
    }

    public static function userHas(array $designation){
        $k = null;
        if($designation != null){
            $user = self::findOne(Yii::$app->user->getID());
            if(!empty($user))
            {
                $pos = null;
                if($user->category == 'staff'){

                    foreach($designation as $val){
                        $pos = Staff::find()->where(['staff.id' => $user->user_id])->
                        joinWith('designation')->andWhere(['designation.abbreviation' => strtoupper($val)])->one();
                        if(!empty($pos)){
                            $k = 1;
                            break;
                        }else{ $k = 2; }
                    }
                }

            }
            else{
                return $k = 2; }
        }

        else{ return $k = 2;

        }

        if($k == 1){ return true ;}else{ return false; }
    }







}
