<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "assignment".
 *
 * @property int $id
 * @property int $student_id
 * @property int $module_id
 * @property int $course_id
 * @property int $nta_level
 * @property int $academic_year_id
 * @property int $semester_id
 * @property float $score
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AcademicYear $academicYear
 * @property Course $course
 * @property UserAccount $createdBy
 * @property Module $module
 * @property Semester $semester
 * @property Student $student
 * @property YearOfStudy $yearOfStudy
 * @property Coursework[] $courseworks
 * @property Coursework[] $courseworks0
 */
class Assignment extends \yii\db\ActiveRecord
{

    public  $csv_file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['module_id', 'course_id','academic_year_id', 'semester_id', 'created_by','csv_file','assessment_method_id'], 'required'],
            [['student_id', 'module_id', 'course_id', 'academic_year_id', 'semester_id', 'created_by','assessment_method_id'], 'integer'],
            [['score'], 'number'],
            [['created_at', 'updated_at','student_id', 'score','registration_number','practical_2','nta_level'], 'safe'],
            ['csv_file','file','extensions' => ['csv'],'checkExtensionByMimeType'=>false],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module_id' => 'id']],
            [['semester_id'], 'exist', 'skipOnError' => true, 'targetClass' => Semester::className(), 'targetAttribute' => ['semester_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
            [['assessment_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssessmentMethod::className(), 'targetAttribute' => ['assessment_method_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'Student Name',
            'registration_number' => 'REGISTRATION NUMBER',

            'module_id' => 'Module Name',
            'course_id' => 'Course ',
            'nta_level' => 'NTA Level',
            'assessment_method_id' => 'Assessment Method/Category',
            'academic_year_id' => 'Academic Year',
            'semester_id' => 'Semester',
            'score' => 'Score',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
     * Gets query for [[Module]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(Module::className(), ['id' => 'module_id']);
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
     * Gets query for [[Student]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }

 
    /**
     * Gets query for [[AssessmentMethod]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssessmentMethod()
    {
        return $this->hasMany(AssessmentMethod::className(), ['id' => 'assessment_method_id']);
    }

    /**
     * Gets query for [[Courseworks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourseworks()
    {
        return $this->hasMany(Coursework::className(), ['assignment_1' => 'id']);
    }

    /**
     * Gets query for [[Courseworks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourseworks0()
    {
        return $this->hasMany(Coursework::className(), ['assignment_2' => 'id']);
    }
}
