<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "coursework_nta5".
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
 * @property float $practical_2 Field Report/Portifolio/Case study
 * @property float|null $total_score
 * @property string $remarks
 * @property int $academic_year_id
 * @property int $course_id
 * @property int $semester_id
 * @property string $created_at
 * @property int $staff_id
 * @property string $updated_at
 *
 * @property AcademicYear $academicYear
 * @property Course $course
 * @property Module $module
 * @property Semester $semester
 * @property Staff $staff
 * @property Student $student
 * @property YearOfStudy $yearOfStudy
 */
class CourseworkNta5 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coursework_nta5';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'module_id', 'practical_2', 'academic_year_id', 'course_id', 'semester_id', 'staff_id'], 'required'],
            [['student_id', 'module_id', 'academic_year_id','course_id', 'semester_id', 'staff_id'], 'integer'],
            [['cat_1', 'cat_2', 'assignment_1', 'assignment_2', 'practical', 'ppb', 'practical_2', 'total_score'], 'number'],
            [['remarks'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
              [['cat_1p', 'cat_2p', 'assignment_1p', 'assignment_2p','practical_2p', 'practicalp', 'ppbp'], 'safe'],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'id']],
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
            'practical' => 'Clinical Examination/OSCE/OSPE',
            'ppb' => 'PPB',
            'practical_2' => 'Report/Case Study/Portfolio',
            'total_score' => 'TOTAL SCORE/40',
            'remarks' => 'REMARKS',
            'academic_year_id' => 'Academic Year ',
            'course_id' => 'Course ',
            'semester_id' => 'Semester ',
            'created_at' => 'Created At',
            'staff_id' => 'Staff ID',
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

  
  
}
