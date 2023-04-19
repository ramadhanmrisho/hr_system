<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "coursework_nta4".
 *
 * @property int $id
 * @property int $student_id
 * @property int $module_id
 * @property float|null $cat_1
 * @property float|null $cat_2
 * @property float|null $assignment_1
 * @property float|null $assignment_2
 * @property float|null $practical
 * @property float|null $ppb
 * @property float $total_score
 * @property int $academic_year_id
 * @property int $year_of_study_id
 * @property int $course_id
 * @property int $semester_id
 * @property string $created_at
 * @property int $staff_id
 * @property string $updated_at
 *
 * @property AcademicYear $academicYear
 * @property YearOfStudy $yearOfStudy
 * @property Course $course
 * @property Module $module
 * @property Semester $semester
 * @property Staff $staff
 * @property Student $student
 * @property ExamResult[] $examResults
 */
class CourseworkNta4 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coursework_nta4';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'module_id',  'academic_year_id', 'year_of_study_id', 'course_id', 'semester_id', 'staff_id'], 'required'],
            [['student_id', 'module_id', 'academic_year_id', 'year_of_study_id', 'course_id', 'semester_id', 'staff_id'], 'integer'],
            [['cat_1', 'cat_2', 'assignment_1', 'assignment_2', 'practical', 'ppb', 'total_score'], 'number'],
            [['cat_1p', 'cat_2p', 'assignment_1p', 'assignment_2p', 'practicalp', 'ppbp'], 'safe'],
            [['created_at', 'updated_at','total_score','practical_2'], 'safe'],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'id']],
            [['year_of_study_id'], 'exist', 'skipOnError' => true, 'targetClass' => YearOfStudy::className(), 'targetAttribute' => ['year_of_study_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module_id' => 'id']],
            [['semester_id'], 'exist', 'skipOnError' => true, 'targetClass' => Semester::className(), 'targetAttribute' => ['semester_id' => 'id']],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
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
            'cat_1' => 'CAT 1',
            'cat_2' => 'CAT 2',
            'assignment_1' => 'Assignment 1',
            'assignment_2' => 'Assignment 2',
            'practical' => 'Practical/OSPE/OSCE',
            'ppb' => 'PPB',
            'total_score' => 'TOTAL SCORE/40',
            'remarks' => 'Remarks',
            'academic_year_id' => 'Academic Year ',
            'year_of_study_id' => 'Year Of Study',
            'course_id' => 'Course ',
            'semester_id' => 'Semester ',
            'created_at' => 'Created At',
            'staff_id' => 'Staff',
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
     * Gets query for [[ExamResults]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExamResults()
    {
        return $this->hasMany(ExamResult::className(), ['coursework_id' => 'id']);
    }
}
