<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "course".
 *
 * @property int $id
 * @property string $course_name
 * @property string $duration_in_years
 * @property string $abbreviation
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 *
 * @property AssignedModule[] $assignedModules
 * @property Assignment[] $assignments
 * @property CarryOver[] $carryOvers
 * @property Certificate[] $certificates
 * @property UserAccount $createdBy
 * @property NtaLevel $level
 * @property Coursework[] $courseworks
 * @property ExamResult[] $examResults
 * @property FinalExam[] $finalExams
 * @property GpaClass[] $gpaClasses
 * @property Grade[] $grades
 * @property Module[] $modules
 * @property Payment[] $payments
 * @property RegisteredModule[] $registeredModules
 * @property Student[] $students
 * @property Supplementary[] $supplementaries
 * @property Test[] $tests
 * @property Transcript[] $transcripts
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_name', 'duration_in_years', 'abbreviation', 'created_by','department_id','nta_level'], 'required'],
            [[ 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['course_name'], 'string', 'max' => 100],
            [['duration_in_years'], 'string', 'max' => 30],
            [['abbreviation'], 'string', 'max' => 11],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_name' => 'Course Name',
            'duration_in_years' => 'Duration In Years',
            'nta_level' => 'NTA Level',
            'abbreviation' => 'Abbreviation',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[AssignedModules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedModules()
    {
        return $this->hasMany(AssignedModule::className(), ['course_id' => 'id']);
    }

    /**
     * Gets query for [[Assignments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignments()
    {
        return $this->hasMany(Assignment::className(), ['course_id' => 'id']);
    }

    /**
     * Gets query for [[CarryOvers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarryOvers()
    {
        return $this->hasMany(CarryOver::className(), ['course_id' => 'id']);
    }

    /**
     * Gets query for [[Certificates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCertificates()
    {
        return $this->hasMany(Certificate::className(), ['course_id' => 'id']);
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
     * Gets query for [[Level]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLevel()
    {
        return $this->hasOne(NtaLevel::className(), ['id' => 'level_id']);
    }

    /**
     * Gets query for [[Courseworks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourseworks()
    {
        return $this->hasMany(Coursework::className(), ['course_id' => 'id']);
    }

    /**
     * Gets query for [[ExamResults]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExamResults()
    {
        return $this->hasMany(ExamResult::className(), ['course_id' => 'id']);
    }

    /**
     * Gets query for [[FinalExams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFinalExams()
    {
        return $this->hasMany(FinalExam::className(), ['course_id' => 'id']);
    }

    /**
     * Gets query for [[GpaClasses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGpaClasses()
    {
        return $this->hasMany(GpaClass::className(), ['course_id' => 'id']);
    }

    /**
     * Gets query for [[Grades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrades()
    {
        return $this->hasMany(Grade::className(), ['course_id' => 'id']);
    }

    /**
     * Gets query for [[Modules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModules()
    {
        return $this->hasMany(Module::className(), ['course_id' => 'id']);
    }

    /**
     * Gets query for [[Payments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['course_id' => 'id']);
    }

    /**
     * Gets query for [[RegisteredModules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegisteredModules()
    {
        return $this->hasMany(RegisteredModule::className(), ['course_id' => 'id']);
    }

    /**
     * Gets query for [[Students]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['course_id' => 'id']);
    }

    /**
     * Gets query for [[Supplementaries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplementaries()
    {
        return $this->hasMany(Supplementary::className(), ['course_id' => 'id']);
    }

    /**
     * Gets query for [[Tests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::className(), ['course_id' => 'id']);
    }

    /**
     * Gets query for [[Transcripts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranscripts()
    {
        return $this->hasMany(Transcript::className(), ['course_id' => 'id']);
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
}
