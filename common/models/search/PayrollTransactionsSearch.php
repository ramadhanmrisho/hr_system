<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PayrollTransactions;

/**
 * PayrollTransactionsSearch represents the model behind the search form of `common\models\PayrollTransactions`.
 */
class PayrollTransactionsSearch extends PayrollTransactions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'staff_id', 'departiment_id', 'designation_id', 'night_hours', 'normal_ot_hours', 'special_ot_hours', 'absent_days', 'created_by'], 'integer'],
            [['basic_salary', 'salary_adjustiment_id', 'allowances', 'night_allowance', 'normal_ot_amount', 'special_ot_amount', 'absent_amount', 'total_earnings', 'nssf', 'taxable_income', 'paye', 'loan', 'salary_advance', 'union_contibution', 'net_salary', 'wcf', 'sdl', 'nhif', 'total'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PayrollTransactions::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'staff_id' => $this->staff_id,
            'departiment_id' => $this->departiment_id,
            'designation_id' => $this->designation_id,
            'basic_salary' => $this->basic_salary,
            'salary_adjustiment_id' => $this->salary_adjustiment_id,
            'allowances' => $this->allowances,
            'night_hours' => $this->night_hours,
            'night_allowance' => $this->night_allowance,
            'normal_ot_hours' => $this->normal_ot_hours,
            'special_ot_hours' => $this->special_ot_hours,
            'normal_ot_amount' => $this->normal_ot_amount,
            'special_ot_amount' => $this->special_ot_amount,
            'absent_days' => $this->absent_days,
            'absent_amount' => $this->absent_amount,
            'total_earnings' => $this->total_earnings,
            'nssf' => $this->nssf,
            'taxable_income' => $this->taxable_income,
            'paye' => $this->paye,
            'loan' => $this->loan,
            'salary_advance' => $this->salary_advance,
            'union_contibution' => $this->union_contibution,
            'net_salary' => $this->net_salary,
            'wcf' => $this->wcf,
            'sdl' => $this->sdl,
            'nhif' => $this->nhif,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
        ]);

        return $dataProvider;
    }
}
