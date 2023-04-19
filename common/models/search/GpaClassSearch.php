<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GpaClass;

/**
 * GpaClassSearch represents the model behind the search form of `common\models\GpaClass`.
 */
class GpaClassSearch extends GpaClass
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'academic_year_id', 'course_id', 'created_by'], 'integer'],
            [['starting_point', 'end_point'], 'number'],
            [['gpa_class', 'created_at', 'updated_at','nta_level'], 'safe'],
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
        $query = GpaClass::find();

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
            'starting_point' => $this->starting_point,
            'end_point' => $this->end_point,
            'academic_year_id' => $this->academic_year_id,
            'course_id' => $this->course_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'gpa_class', $this->gpa_class]);
        $query->andFilterWhere(['like', 'nta_level', $this->nta_level])->orderBy(['starting_point'=>SORT_DESC]);

        return $dataProvider;
    }
}
