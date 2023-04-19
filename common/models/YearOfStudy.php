<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "year_of_study".
 *
 * @property int $id
 * @property string $name
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AssignedModule[] $assignedModules
 * @property Assignment[] $assignments
 * @property CarryOver[] $carryOvers
 * @property Coursework[] $courseworks
 * @property ExamResult[] $examResults
 * @property FinalExam[] $finalExams
 * @property GpaClass[] $gpaClasses
 * @property Grade[] $grades
 * @property Module[] $modules
 * @property Payment[] $payments
 * @property RegisteredModule[] $registeredModules
 * @property Student[] $students
 * @property StudentFinancialCategory[] $studentFinancialCategories
 * @property Supplementary[] $supplementaries
 * @property Test[] $tests
 * @property UserAccount $createdBy
 */
class YearOfStudy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'year_of_study';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 30],
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
            'created_at' => 'Created At',
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
        return $this->hasMany(AssignedModule::className(), ['year_of_study_id' => 'id']);
    }

    /**
     * Gets query for [[Assignments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignments()
    {
        return $this->hasMany(Assignment::className(), ['year_of_study_id' => 'id']);
    }

    /**
     * Gets query for [[CarryOvers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarryOvers()
    {
        return $this->hasMany(CarryOver::className(), ['year_of_study_id' => 'id']);
    }

    /**
     * Gets query for [[Courseworks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourseworks()
    {
        return $this->hasMany(Coursework::className(), ['year_of_study_id' => 'id']);
    }

    /**
     * Gets query for [[ExamResults]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExamResults()
    {
        return $this->hasMany(ExamResult::className(), ['year_of_study_id' => 'id']);
    }

    /**
     * Gets query for [[FinalExams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFinalExams()
    {
        return $this->hasMany(FinalExam::className(), ['year_of_study_id' => 'id']);
    }

    /**
     * Gets query for [[GpaClasses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGpaClasses()
    {
        return $this->hasMany(GpaClass::className(), ['year_of_study_id' => 'id']);
    }

    /**
     * Gets query for [[Grades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrades()
    {
        return $this->hasMany(Grade::className(), ['year_of_study' => 'id']);
    }

    /**
     * Gets query for [[Modules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModules()
    {
        return $this->hasMany(Module::className(), ['year_of_study_id' => 'id']);
    }

    /**
     * Gets query for [[Payments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['year_of_study_id' => 'id']);
    }

    /**
     * Gets query for [[RegisteredModules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegisteredModules()
    {
        return $this->hasMany(RegisteredModule::className(), ['year_of_study_id' => 'id']);
    }

    /**
     * Gets query for [[Students]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['year_of_study_id' => 'id']);
    }

    /**
     * Gets query for [[StudentFinancialCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentFinancialCategories()
    {
        return $this->hasMany(StudentFinancialCategory::className(), ['year_of_study' => 'id']);
    }

    /**
     * Gets query for [[Supplementaries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplementaries()
    {
        return $this->hasMany(Supplementary::className(), ['year_of_study_id' => 'id']);
    }

    /**
     * Gets query for [[Tests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::className(), ['year_of_study_id' => 'id']);
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
}
