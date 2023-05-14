<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "employee_attachments".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $attachment_type_id
 * @property string $attached_file
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 *
 * @property EmployeeAttachments $attachmentType
 * @property EmployeeAttachments[] $employeeAttachments
 */
class EmployeeAttachments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_attachments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'attachment_type_id', 'attached_file', 'created_by'], 'required'],
            [['staff_id', 'attachment_type_id', 'created_by'], 'integer'],
            [['created_at', 'updated_at','attachment_types_id'], 'safe'],
            [['attached_file'], 'string', 'max' => 100],
            [['attached_file'], 'file', 'extensions' => 'pdf'],
            [['attachment_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AttachmentsType::className(), 'targetAttribute' => ['id' => 'attachment_type_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff ID',
            'attachment_type_id' => 'Attachment Type ID',
            'attached_file' => 'Attached File',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[AttachmentType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttachmentType()
    {
        return $this->hasOne(AttachmentsType::className(), ['id' => 'attachment_type_id']);
    }

    /**
     * Gets query for [[EmployeeAttachments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttachmentsType()
    {
        return $this->hasMany(AttachmentsType::className(), ['id' => 'attachment_type_id']);
    }
}
