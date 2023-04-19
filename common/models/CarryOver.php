<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carry_over".
 *
 * @property int $id
 * @property int $student_id
 * @property int $module_id
 * @property int $academic_year_id
 * @property int $year_of_study_id
 * @property int $course_id
 * @property int $staff_id
 * @property int $semester_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 *
 * @property AcademicYear $academicYear
 * @property Course $course
 * @property Module $module
 * @property Semester $semester
 * @property Staff $staff
 * @property Student $student
 * @property YearOfStudy $yearOfStudy
 */
class CarryOver extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carry_over';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'module_id', 'academic_year_id', 'year_of_study_id', 'course_id', 'staff_id', 'semester_id', 'status'], 'required'],
            [['student_id', 'module_id', 'academic_year_id', 'year_of_study_id', 'course_id', 'staff_id', 'semester_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'string'],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module_id' => 'id']],
            [['semester_id'], 'exist', 'skipOnError' => true, 'targetClass' => Semester::className(), 'targetAttribute' => ['semester_id' => 'id']],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
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
            'student_id' => 'Student ID',
            'module_id' => 'Module ID',
            'academic_year_id' => 'Academic Year ID',
            'year_of_study_id' => 'Year Of Study ID',
            'course_id' => 'Course ID',
            'staff_id' => 'Staff ID',
            'semester_id' => 'Semester ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
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
     * Gets query for [[Staff]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
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
