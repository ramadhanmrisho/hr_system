<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "grade".
 *
 * @property int $id
 * @property float $lower_score
 * @property float $upper_score
 * @property string $grade
 * @property int $year_of_study
 * @property int $academic_year_id
 * @property int $point
 * @property string $description
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AcademicYear $academicYear
 * @property UserAccount $createdBy
 * @property YearOfStudy $yearOfStudy
 */
class Grade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lower_score', 'upper_score', 'grade', 'nta_level', 'academic_year_id', 'point', 'description', 'created_by'], 'required'],
            [['lower_score', 'upper_score'], 'number'],
            [['nta_level', 'academic_year_id', 'point', 'created_by'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['grade'], 'string', 'max' => 30],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'id']],
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
            'lower_score' => 'Lower Score',
            'upper_score' => 'Upper Score',
            'grade' => 'GRADE',
            'nta_level' => 'NTA Level',
            'academic_year_id' => 'Academic Year',
            'point' => 'POINTS',
            'description' => 'DEFINITION',
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
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(UserAccount::className(), ['id' => 'created_by']);
    }

}
