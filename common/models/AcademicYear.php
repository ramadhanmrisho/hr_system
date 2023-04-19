<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "academic_year".
 *
 * @property int $id
 * @property string $name
 * @property string $status
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property UserAccount $createdBy
 * @property AssignedModule[] $assignedModules
 * @property Assignment[] $assignments
 * @property CarryOver[] $carryOvers
 * @property Certificate[] $certificates
 * @property Coursework[] $courseworks
 * @property ExamResult[] $examResults
 * @property FinalExam[] $finalExams
 * @property Gpa[] $gpas
 * @property GpaClass[] $gpaClasses
 * @property Grade[] $grades
 * @property Module[] $modules
 * @property Payment[] $payments
 * @property PostponedStudent[] $postponedStudents
 * @property PostponedStudent[] $postponedStudents0
 * @property RegisteredModule[] $registeredModules
 * @property Student[] $students
 * @property StudentFinancialCategory[] $studentFinancialCategories
 * @property Supplementary[] $supplementaries
 * @property Test[] $tests
 * @property Transcript[] $transcripts
 */
class AcademicYear extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'academic_year';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status', 'created_by'], 'required'],
            [['status'], 'string'],
            [['name'], 'unique'],
            [['created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 30],
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
            'name' => 'Name',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
     * Gets query for [[AssignedModules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedModules()
    {
        return $this->hasMany(AssignedModule::className(), ['academic_year_id' => 'id']);
    }

    /**
     * Gets query for [[Assignments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignments()
    {
        return $this->hasMany(Assignment::className(), ['academic_year_id' => 'id']);
    }

    /**
     * Gets query for [[CarryOvers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarryOvers()
    {
        return $this->hasMany(CarryOver::className(), ['academic_year_id' => 'id']);
    }

    /**
     * Gets query for [[Certificates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCertificates()
    {
        return $this->hasMany(Certificate::className(), ['academic_year_id' => 'id']);
    }

    /**
     * Gets query for [[Courseworks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourseworks()
    {
        return $this->hasMany(Coursework::className(), ['academic_year_id' => 'id']);
    }

    /**
     * Gets query for [[ExamResults]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExamResults()
    {
        return $this->hasMany(ExamResult::className(), ['academic_year_id' => 'id']);
    }

    /**
     * Gets query for [[FinalExams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFinalExams()
    {
        return $this->hasMany(FinalExam::className(), ['academic_year_id' => 'id']);
    }

    /**
     * Gets query for [[Gpas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGpas()
    {
        return $this->hasMany(Gpa::className(), ['academic_year_id' => 'id']);
    }

    /**
     * Gets query for [[GpaClasses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGpaClasses()
    {
        return $this->hasMany(GpaClass::className(), ['academic_year_id' => 'id']);
    }

    /**
     * Gets query for [[Grades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrades()
    {
        return $this->hasMany(Grade::className(), ['academic_year_id' => 'id']);
    }

    /**
     * Gets query for [[Modules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModules()
    {
        return $this->hasMany(Module::className(), ['academic_year_id' => 'id']);
    }

    /**
     * Gets query for [[Payments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['academic_year_id' => 'id']);
    }

    /**
     * Gets query for [[PostponedStudents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostponedStudents()
    {
        return $this->hasMany(PostponedStudent::className(), ['academic_year_id' => 'id']);
    }

    /**
     * Gets query for [[PostponedStudents0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostponedStudents0()
    {
        return $this->hasMany(PostponedStudent::className(), ['postone_to' => 'id']);
    }

    /**
     * Gets query for [[RegisteredModules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegisteredModules()
    {
        return $this->hasMany(RegisteredModule::className(), ['academic_year_id' => 'id']);
    }

    /**
     * Gets query for [[Students]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['academic_year_id' => 'id']);
    }

    /**
     * Gets query for [[StudentFinancialCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentFinancialCategories()
    {
        return $this->hasMany(StudentFinancialCategory::className(), ['academic_year_id' => 'id']);
    }

    /**
     * Gets query for [[Supplementaries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplementaries()
    {
        return $this->hasMany(Supplementary::className(), ['academic_year_id' => 'id']);
    }

    /**
     * Gets query for [[Tests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::className(), ['academic_year_id' => 'id']);
    }

    /**
     * Gets query for [[Transcripts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranscripts()
    {
        return $this->hasMany(Transcript::className(), ['academic_year_id' => 'id']);
    }
}
