<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "assigned_module".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $module_id
 * @property int $course_id
 * @property int $semester_id
 * @property int $academic_year_id
 * @property int $year_of_study_id
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AcademicYear $academicYear
 * @property Course $course
 * @property UserAccount $createdBy
 * @property Module $module
 * @property Semester $semester
 * @property Staff $staff
 * @property YearOfStudy $yearOfStudy
 */
class AssignedModule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assigned_module';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'module_id',  'academic_year_id', 'created_by'], 'required'],
            [['staff_id', 'module_id', 'course_id', 'semester_id', 'academic_year_id', 'year_of_study_id', 'created_by'], 'integer'],
            [['created_at', 'updated_at','course_id', 'semester_id','year_of_study_id','department_id'], 'safe'],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module_id' => 'id']],
            [['semester_id'], 'exist', 'skipOnError' => true, 'targetClass' => Semester::className(), 'targetAttribute' => ['semester_id' => 'id']],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
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
            'staff_id' => 'Instructor Name',
            'module_id' => 'Module Name',
            'course_id' => 'Course ',
            'semester_id' => 'Semester',
            'department_id' => 'Department',
            'academic_year_id' => 'Academic Year ',
            'year_of_study_id' => 'Year Of Study',
            'created_by' => 'Assigned By',
            'created_at' => 'Assigned At',
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
     * Gets query for [[Staff]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
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
