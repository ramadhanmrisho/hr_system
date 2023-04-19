<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "module".
 *
 * @property int $id
 * @property string $module_name
 * @property string $module_code
 * @property int $course_id
 * @property int $year_of_study_id
 * @property string $nta_level
 * @property string|null $prerequisite
 * @property int $semester_id
 * @property int $department_id
 * @property int $module_credit
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AssessmentMethodTracking[] $assessmentMethodTrackings
 * @property AssignedModule[] $assignedModules
 * @property Assignment[] $assignments
 * @property CarryOver[] $carryOvers
 * @property Coursework[] $courseworks
 * @property ExamResult[] $examResults
 * @property FinalExam[] $finalExams
 * @property Course $course
 * @property UserAccount $createdBy
 * @property YearOfStudy $yearOfStudy
 * @property Semester $semester
 * @property Department $department
 * @property RegisteredModule[] $registeredModules
 * @property Supplementary[] $supplementaries
 * @property Test[] $tests
 */
class Module extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $module_id;
    public $assessment_method_id;
    public $percent;
    public $category;
    public $assessment_methods;

    public static function tableName()
    {
        return 'module';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['module_name', 'module_code', 'course_id',  'nta_level', 'semester_id', 'department_id', 'module_credit', 'created_by'], 'required'],
            [['course_id', 'year_of_study_id', 'semester_id', 'department_id', 'module_credit', 'created_by'], 'integer'],
            [['nta_level'], 'string'],
            [['created_at', 'updated_at','module_id', 'assessment_method_id', 'percent','category','year_of_study_id','assessment_methods'], 'safe'],
            [['module_name', 'module_code'], 'string', 'max' => 100],
            [['prerequisite'], 'string', 'max' => 255],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['year_of_study_id'], 'exist', 'skipOnError' => true, 'targetClass' => YearOfStudy::className(), 'targetAttribute' => ['year_of_study_id' => 'id']],
            [['semester_id'], 'exist', 'skipOnError' => true, 'targetClass' => Semester::className(), 'targetAttribute' => ['semester_id' => 'id']],
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
            'module_name' => 'Module Name',
            'module_code' => 'Module Code',
            'course_id' => 'Course Name ',
            'year_of_study_id' => 'Year Of Study ',
            'nta_level' => 'NTA Level',
            'prerequisite' => 'Prerequisite',
            'semester_id' => 'Semester ',
            'department_id' => 'Department Name',
            'module_credit' => 'Module Credit',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[AssessmentMethodTrackings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssessmentMethodTrackings()
    {
        return $this->hasMany(AssessmentMethodTracking::className(), ['module_id' => 'id']);
    }

    /**
     * Gets query for [[AssignedModules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedModules()
    {
        return $this->hasMany(AssignedModule::className(), ['module_id' => 'id']);
    }

    /**
     * Gets query for [[Assignments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignments()
    {
        return $this->hasMany(Assignment::className(), ['module_id' => 'id']);
    }

    /**
     * Gets query for [[CarryOvers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarryOvers()
    {
        return $this->hasMany(CarryOver::className(), ['module_id' => 'id']);
    }

    /**
     * Gets query for [[Courseworks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourseworks()
    {
        return $this->hasMany(Coursework::className(), ['module_id' => 'id']);
    }

    /**
     * Gets query for [[ExamResults]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExamResults()
    {
        return $this->hasMany(ExamResult::className(), ['module_id' => 'id']);
    }

    /**
     * Gets query for [[FinalExams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFinalExams()
    {
        return $this->hasMany(FinalExam::className(), ['module_id' => 'id']);
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
     * Gets query for [[YearOfStudy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getYearOfStudy()
    {
        return $this->hasOne(YearOfStudy::className(), ['id' => 'year_of_study_id']);
    }

    /**
     * Gets query for [[Semester]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSemester()
    {
        return $this->hasOne(Semester::className(), ['id' => 'semester_id']);
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
     * Gets query for [[RegisteredModules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegisteredModules()
    {
        return $this->hasMany(RegisteredModule::className(), ['module_id' => 'id']);
    }

    /**
     * Gets query for [[Supplementaries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplementaries()
    {
        return $this->hasMany(Supplementary::className(), ['module_id' => 'id']);
    }

    /**
     * Gets query for [[Tests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::className(), ['module_id' => 'id']);
    }
}
