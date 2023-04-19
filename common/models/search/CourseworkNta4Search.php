<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CourseworkNta4;

/**
 * CourseworkNta4Search represents the model behind the search form of `common\models\CourseworkNta4`.
 */
class CourseworkNta4Search extends CourseworkNta4
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'student_id', 'module_id', 'academic_year_id', 'course_id', 'semester_id', 'staff_id'], 'integer'],
            [['cat_1', 'cat_2', 'assignment_1', 'assignment_2', 'practical', 'ppb', 'total_score'], 'number'],
            [['created_at', 'updated_at','remarks'], 'safe'],
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
        $query = CourseworkNta4::find();

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
            'student_id' => $this->student_id,
            'module_id' => $this->module_id,
            'cat_1' => $this->cat_1,
            'cat_2' => $this->cat_2,
            'assignment_1' => $this->assignment_1,
            'assignment_2' => $this->assignment_2,
            'practical' => $this->practical,
            'ppb' => $this->ppb,
            'total_score' => $this->total_score,
            'remarks' => $this->remarks,
            'academic_year_id' => $this->academic_year_id,
            'course_id' => $this->course_id,
            'semester_id' => $this->semester_id,
            'created_at' => $this->created_at,
            'staff_id' => $this->staff_id,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
