<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "assessment_method_tracking".
 *
 * @property int $id
 * @property int $module_id
 * @property int $assessment_method_id
 * @property string $category
 * @property int $percent
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AssessmentMethod $assessmentMethod
 * @property Module $module
 */
class AssessmentMethodTracking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assessment_method_tracking';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['module_id', 'assessment_method_id', 'category', 'percent'], 'required'],
            [['module_id', 'assessment_method_id'], 'integer'],
            [['category'], 'string'],
            [['created_at', 'updated_at','percent'], 'safe'],
            [['assessment_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssessmentMethod::className(), 'targetAttribute' => ['assessment_method_id' => 'id']],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module_id' => 'Module ID',
            'assessment_method_id' => 'Assessment Method ID',
            'category' => 'Category',
            'percent' => 'Percent',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[AssessmentMethod]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssessmentMethod()
    {
        return $this->hasOne(AssessmentMethod::className(), ['id' => 'assessment_method_id']);
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
}
