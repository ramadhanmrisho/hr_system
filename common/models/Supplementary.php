<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "supplementary".
 *
 * @property int $id
 * @property int $student_id
 * @property int $module_id
 * @property int $course_id
 * @property int $year_of_study_id
 * @property int $academic_year_id
 * @property int $semester_id
 * @property string $status
 * @property string $category
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AcademicYear $academicYear
 * @property Module $module
 * @property Semester $semester
 * @property Student $student
 * @property YearOfStudy $yearOfStudy
 * @property Course $course
 */
class Supplementary extends \yii\db\ActiveRecord
{
    public $csv_file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplementary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'module_id', 'course_id', 'year_of_study_id', 'academic_year_id', 'semester_id', 'status', 'category'], 'required'],
            [['student_id', 'module_id', 'course_id', 'year_of_study_id', 'academic_year_id', 'semester_id','staff_id'], 'integer'],
            [['status', 'category'], 'string'],
            [['created_at', 'updated_at','csv_file','written_exam','practical'], 'safe'],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'id']],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module_id' => 'id']],
            [['semester_id'], 'exist', 'skipOnError' => true, 'targetClass' => Semester::className(), 'targetAttribute' => ['semester_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
            [['year_of_study_id'], 'exist', 'skipOnError' => true, 'targetClass' => YearOfStudy::className(), 'targetAttribute' => ['year_of_study_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
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
            'module_id' => 'Module Name',
            'course_id' => 'Course ',
            'year_of_study_id' => 'Year Of Study ',
            'academic_year_id' => 'Academic Year',
            'semester_id' => 'Semester',
            'status' => 'Status',
            'category' => 'Category',
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

    /**
     * Gets query for [[Course]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }
}
