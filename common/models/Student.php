<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property int $id
 * @property string $fname
 * @property string|null $mname
 * @property int $lname
 * @property string $dob
 * @property string $place_of_birth
 * @property int $phone_number
 * @property int $identity_type_id
 * @property string $id_number
 * @property string $marital_status
 * @property string $email
 * @property string $gender
 * @property string $passport_size
 * @property string $registration_number
 * @property int $nationality_id
 * @property int $region_id Region your coming from
 * @property int $district_id
 * @property string $village Village/Street
 * @property int $academic_year_id
 * @property string $home_address
 * @property int $course_id
 * @property string $sponsorship
 * @property string $status
 * @property string $date_of_admission
 * @property string $college_residence
 * @property int $department_id
 * @property string $intake_type
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ALevelGradeScore[] $aLevelGradeScores
 * @property ALevelInformation[] $aLevelInformations
 * @property Assignment[] $assignments
 * @property CarryOver[] $carryOvers
 * @property Certificate[] $certificates
 * @property Coursework[] $courseworks
 * @property ExamResult[] $examResults
 * @property FinalExam[] $finalExams
 * @property Gpa[] $gpas
 * @property OLevelGradeScore[] $oLevelGradeScores
 * @property OLevelInformation[] $oLevelInformations
 * @property ParentInformation[] $parentInformations
 * @property Payment[] $payments
 * @property PostponedStudent[] $postponedStudents
 * @property RegisteredModule[] $registeredModules
 * @property AcademicYear $academicYear
 * @property Course $course
 * @property UserAccount $createdBy
 * @property Department $department
 * @property District $district
 * @property IdentityType $identityType
 * @property Nationality $nationality
 * @property Region $region
 * @property YearOfStudy $yearOfStudy
 * @property StudentFinancialCategory[] $studentFinancialCategories
 * @property Supplementary[] $supplementaries
 * @property Test[] $tests
 * @property Transcript[] $transcripts
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fname', 'lname', 'dob', 'place_of_birth', 'phone_number', 'marital_status', 'email', 'gender', 'registration_number', 'nationality_id', 'region_id', 'district_id', 'village', 'academic_year_id', 'home_address', 'course_id', 'nta_level', 'sponsorship', 'status', 'date_of_admission', 'college_residence', 'department_id', 'intake_type'], 'required'],
            [[ 'phone_number', 'identity_type_id', 'nationality_id', 'region_id', 'district_id', 'academic_year_id', 'course_id', 'department_id', 'created_by'], 'integer'],
            [['dob', 'date_of_admission', 'created_at', 'updated_at', 'identity_type_id', 'id_number', 'created_by','passport_size', 'passport_size'], 'safe'],
            [['marital_status', 'gender', 'sponsorship', 'status', 'college_residence', 'intake_type'], 'string'],
            [['fname', 'mname', 'place_of_birth', 'id_number', 'email', 'registration_number', 'village', 'home_address'], 'string', 'max' => 100],
            [['registration_number'], 'unique'],
            [['passport_size'],'file','extensions' => ['jpg','png','jepg'],'checkExtensionByMimeType'=>true],
            [['passport_size'], 'file','skipOnEmpty'=>false,'extensions' => ['jpg','png','jepg'],'checkExtensionByMimeType'=>true,'message'=>'Incorrect file uploaded','skipOnError'=>false,'maxSize'=>1024 * 1024 * 2,'on'=>'update-photo-upload'],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['identity_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => IdentityType::className(), 'targetAttribute' => ['identity_type_id' => 'id']],
            [['nationality_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nationality::className(), 'targetAttribute' => ['nationality_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
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
            'lname' => 'Last Name',
            'dob' => 'Date of birth',
            'place_of_birth' => 'Place Of Birth',
            'phone_number' => 'Phone Number',
            'identity_type_id' => 'Identity Type ',
            'id_number' => 'Id Number',
            'marital_status' => 'Marital Status',
            'email' => 'Email',
            'gender' => 'Gender',
            'passport_size' => 'Passport Size',
            'registration_number' => 'Registration Number',
            'nationality_id' => 'Nationality',
            'region_id' => 'Region Name',
            'district_id' => 'District Name',
            'village' => 'Village/Street',
            'academic_year_id' => 'Academic Year ',
            'home_address' => 'Home Address',
            'course_id' => 'Course ',
            'nta_level' => 'NTA Level',
            'sponsorship' => 'Sponsorship',
            'status' => 'Status',
            'date_of_admission' => 'Date Of Admission',
            'college_residence' => 'College Residence',
            'department_id' => 'Department Name',
            'intake_type' => 'Intake',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[ALevelGradeScores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getALevelGradeScores()
    {
        return $this->hasMany(ALevelGradeScore::className(), ['student_id' => 'id']);
    }

    /**
     * Gets query for [[ALevelInformations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getALevelInformations()
    {
        return $this->hasMany(ALevelInformation::className(), ['student_id' => 'id']);
    }

    /**
     * Gets query for [[Assignments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignments()
    {
        return $this->hasMany(Assignment::className(), ['student_id' => 'id']);
    }

    /**
     * Gets query for [[CarryOvers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarryOvers()
    {
        return $this->hasMany(CarryOver::className(), ['student_id' => 'id']);
    }

    /**
     * Gets query for [[Certificates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCertificates()
    {
        return $this->hasMany(Certificate::className(), ['student_id' => 'id']);
    }

    /**
     * Gets query for [[Courseworks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourseworks()
    {
        return $this->hasMany(Coursework::className(), ['student_id' => 'id']);
    }

    /**
     * Gets query for [[ExamResults]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExamResults()
    {
        return $this->hasMany(ExamResult::className(), ['student_id' => 'id']);
    }

    /**
     * Gets query for [[FinalExams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFinalExams()
    {
        return $this->hasMany(FinalExam::className(), ['student_id' => 'id']);
    }

    /**
     * Gets query for [[Gpas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGpas()
    {
        return $this->hasMany(Gpa::className(), ['student_id' => 'id']);
    }

    /**
     * Gets query for [[OLevelGradeScores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOLevelGradeScores()
    {
        return $this->hasMany(OLevelGradeScore::className(), ['student_id' => 'id']);
    }

    /**
     * Gets query for [[OLevelInformations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOLevelInformations()
    {
        return $this->hasMany(OLevelInformation::className(), ['student_id' => 'id']);
    }

    /**
     * Gets query for [[ParentInformations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParentInformations()
    {
        return $this->hasMany(ParentInformation::className(), ['student_id' => 'id']);
    }

    /**
     * Gets query for [[Payments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['student_id' => 'id']);
    }

    /**
     * Gets query for [[PostponedStudents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostponedStudents()
    {
        return $this->hasMany(PostponedStudent::className(), ['student_id' => 'id']);
    }

    /**
     * Gets query for [[RegisteredModules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegisteredModules()
    {
        return $this->hasMany(RegisteredModule::className(), ['student_id' => 'id']);
    }

    /**
     * Gets query for [[AcademicYear]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear()
    {
        return $this->hasOne(AcademicYear::className(), ['id' => 'academic_year_id']);
    }

    /**
     * Gets query for [[Course]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
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
     * Gets query for [[Department]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
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
     * Gets query for [[IdentityType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdentityType()
    {
        return $this->hasOne(IdentityType::className(), ['id' => 'identity_type_id']);
    }

    /**
     * Gets query for [[Nationality]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNationality()
    {
        return $this->hasOne(Nationality::className(), ['id' => 'nationality_id']);
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
     * Gets query for [[StudentFinancialCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentFinancialCategories()
    {
        return $this->hasMany(StudentFinancialCategory::className(), ['student_id' => 'id']);
    }

    /**
     * Gets query for [[Supplementaries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplementaries()
    {
        return $this->hasMany(Supplementary::className(), ['student_id' => 'id']);
    }

    /**
     * Gets query for [[Tests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::className(), ['student_id' => 'id']);
    }

    /**
     * Gets query for [[Transcripts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranscripts()
    {
        return $this->hasMany(Transcript::className(), ['student_id' => 'id']);
    }
}
