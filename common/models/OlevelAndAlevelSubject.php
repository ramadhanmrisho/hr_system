<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "olevel_and_alevel_subject".
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 *
 * @property ALevelGradeScore[] $aLevelGradeScores
 * @property OLevelGradeScore[] $oLevelGradeScores
 * @property UserAccount $createdBy
 */
class OlevelAndAlevelSubject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'olevel_and_alevel_subject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'created_by'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by'], 'integer'],
            [['name'], 'string', 'max' => 100],
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
            'name' => 'Name',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[ALevelGradeScores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getALevelGradeScores()
    {
        return $this->hasMany(ALevelGradeScore::className(), ['subject_id' => 'id']);
    }

    /**
     * Gets query for [[OLevelGradeScores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOLevelGradeScores()
    {
        return $this->hasMany(OLevelGradeScore::className(), ['subject_id' => 'id']);
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
