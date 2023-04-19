<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "system_audit".
 *
 * @property int $id
 * @property int $session_id
 * @property string $item_class
 * @property int|null $item_id
 * @property string $action
 * @property string $description
 * @property string|null $extra
 * @property int $created_by
 * @property string $created_at
 *
 * @property StaffSessions $session
 * @property UserAccount $createdBy
 */
class SystemAudit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_audit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['session_id', 'item_class', 'action', 'description', 'created_by'], 'required'],
            [['session_id', 'item_id', 'created_by'], 'integer'],
            [['action', 'extra'], 'string'],
            [['created_at'], 'safe'],
            [['item_class'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 1000],
            [['session_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaffSessions::className(), 'targetAttribute' => ['session_id' => 'id']],
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
            'session_id' => 'Session ID',
            'item_class' => 'Item Class',
            'item_id' => 'Item ID',
            'action' => 'Action',
            'description' => 'Description',
            'extra' => 'Extra',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Session]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSession()
    {
        return $this->hasOne(StaffSessions::className(), ['id' => 'session_id']);
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
