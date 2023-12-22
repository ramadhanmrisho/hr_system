<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "absentees".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $days
 * @property string $description
 * @property string $category
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 */
class Absentees extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'absentees';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'days', 'description', 'category', 'status', 'created_by'], 'required'],
            [['staff_id', 'days', 'created_by'], 'integer'],
            [['description', 'category', 'status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff Name',
            'days' => 'Days',
            'description' => 'Description',
            'category' => 'Category',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }
}
