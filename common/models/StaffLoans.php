<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "staff_loans".
 *
 * @property int $id
 * @property int $staff_id
 * @property float $loan_amount
 * @property float $monthly_return
 * @property string $description
 * @property float $amount_paid
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 */
class StaffLoans extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'staff_loans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'loan_amount', 'monthly_return', 'description', 'created_by'], 'required'],
            [['staff_id', 'created_by'], 'integer'],
            [['loan_amount', 'monthly_return', 'amount_paid'], 'safe'],
            [['description', 'status'], 'string'],
            ['monthly_return', 'validateMonthlyReturn'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function validateMonthlyReturn($attribute, $params)
    {
        if ($this->monthly_return >= $this->loan_amount) {
            $this->addError($attribute, 'Monthly return must be less than the loan amount.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff ID',
            'loan_amount' => 'Loan Amount',
            'monthly_return' => 'Monthly Return',
            'description' => 'Description',
            'amount_paid' => 'Amount Paid',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }
}
