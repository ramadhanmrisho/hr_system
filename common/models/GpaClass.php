<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gpa_class".
 *
 * @property int $id
 * @property float $starting_point upper score
 * @property float $end_point lower score
 * @property string $gpa_class
 * @property int $academic_year_id
 * @property int $course_id
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Gpa[] $gpas
 * @property AcademicYear $academicYear
 * @property Course $course
 * @property UserAccount $createdBy
 * @property YearOfStudy $yearOfStudy
 */
class GpaClass extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gpa_class';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['starting_point', 'end_point', 'gpa_class', 'academic_year_id', 'course_id', 'created_by','nta_level'], 'required'],
            [['starting_point', 'end_point'], 'number'],
            [[ 'academic_year_id', 'course_id', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['gpa_class'], 'string', 'max' => 255],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'starting_point' => 'Starting Point',
            'end_point' => 'End Point',
            'gpa_class' => 'Gpa Class',
            'nta_level' => 'NTA Level',
            'academic_year_id' =>'Academic Year',
            'course_id' => 'Course',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Gpas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGpas()
    {
        return $this->hasMany(Gpa::className(), ['gpa_class_id' => 'id']);
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
     * Gets query for [[YearOfStudy]].
     *
     * @return \yii\db\ActiveQuery
     */

}
