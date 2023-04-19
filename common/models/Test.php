<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property int $id
 * @property int $student_id
 * @property string $category
 * @property int $year_of_study_id
 * @property int $academic_year_id
 * @property int $module_id
 * @property int $semester_id
 * @property int $course_id
 * @property float $score
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Coursework[] $courseworks
 * @property Coursework[] $courseworks0
 * @property AcademicYear $academicYear
 * @property Course $course
 * @property UserAccount $createdBy
 * @property Module $module
 * @property Semester $semester
 * @property Student $student
 * @property YearOfStudy $yearOfStudy
 */
class Test extends \yii\db\ActiveRecord
{

    public $csv_file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'category', 'year_of_study_id', 'academic_year_id', 'module_id', 'semester_id', 'course_id', 'score', 'created_by','csv_file'], 'required'],
            [['student_id', 'year_of_study_id', 'academic_year_id', 'module_id', 'semester_id', 'course_id', 'created_by'], 'integer'],
            [['category'], 'string'],
            [['score'], 'number'],
            [['created_at', 'updated_at','registration_number'], 'safe'],
            ['csv_file','file','extensions' => ['csv'],'checkExtensionByMimeType'=>true],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module_id' => 'id']],
            [['semester_id'], 'exist', 'skipOnError' => true, 'targetClass' => Semester::className(), 'targetAttribute' => ['semester_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
            [['year_of_study_id'], 'exist', 'skipOnError' => true, 'targetClass' => YearOfStudy::className(), 'targetAttribute' => ['year_of_study_id' => 'id']],
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
            'registration_number' => 'Registration Number',
            'category' => 'Category',
            'year_of_study_id' => 'Year Of Study ',
            'academic_year_id' => 'Academic Year',
            'module_id' => 'Module Name',
            'semester_id' => 'Semester ',
            'course_id' => 'Course',
            'score' => 'Score',
            'created_by' => 'Uploaded By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Courseworks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourseworks()
    {
        return $this->hasMany(Coursework::className(), ['test_2' => 'id']);
    }

    /**
     * Gets query for [[Courseworks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourseworks0()
    {
        return $this->hasMany(Coursework::className(), ['test_1' => 'id']);
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
     * Gets query for [[YearOfStudy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getYearOfStudy()
    {
        return $this->hasOne(YearOfStudy::className(), ['id' => 'year_of_study_id']);
    }
}
