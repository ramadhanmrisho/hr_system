<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "deductions_percentage".
 *
 * @property int $id
 * @property float|null $NSSF
 * @property float|null $WCF
 * @property float|null $SDL
 * @property float|null $NHIF
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $status
 * @property int|null $created_by
 *
 * @property Staff $createdBy
 */
class DeductionsPercentage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deductions_percentage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NSSF', 'WCF', 'SDL', 'NHIF'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by'], 'integer'],
            [['status'], 'string', 'max' => 20],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'NSSF' => 'NSSF',
            'WCF' => 'WCF',
            'SDL' => 'SDL',
            'NHIF' => 'NHIF',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Staff::className(), ['id' => 'created_by']);
    }
}
