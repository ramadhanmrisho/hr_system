<?php

namespace common\models\search;

use common\models\AcademicYear;
use common\models\Course;
use common\models\YearOfStudy;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Student;

/**
 * StudentSearch represents the model behind the search form of `common\models\Student`.
 */
class StudentSearch extends Student
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lname', 'phone_number', 'identity_type_id', 'nationality_id', 'region_id', 'district_id', 'academic_year_id', 'course_id', 'department_id', 'created_by'], 'integer'],
            [['fname', 'mname', 'dob', 'place_of_birth', 'id_number', 'marital_status', 'email', 'gender', 'passport_size', 'registration_number', 'village', 'home_address', 'sponsorship', 'status', 'date_of_admission', 'college_residence', 'intake_type', 'created_at', 'updated_at'], 'safe'],
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
        $query = Student::find();

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
            'lname' => $this->lname,
            'dob' => $this->dob,
            'phone_number' => $this->phone_number,
            'identity_type_id' => $this->identity_type_id,
            'nationality_id' => $this->nationality_id,
            'region_id' => $this->region_id,
            'district_id' => $this->district_id,
            'academic_year_id' => $this->academic_year_id,
            'course_id' => $this->course_id,
            'date_of_admission' => $this->date_of_admission,
            'department_id' => $this->department_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);


    $current_academic_year=AcademicYear::find()->where(['status'=>'Active'])->one()->id;

    $query->andFilterWhere(['like','academic_year_id',$current_academic_year]);


        $cm1=Course::find()->where(['abbreviation'=>'NTA4_CM'])->one()->id;
        $cm2=Course::find()->where(['abbreviation'=>'NTA5_CM'])->one()->id;
        $cm3=Course::find()->where(['abbreviation'=>'NTA6_CM'])->one()->id;

        if (\Yii::$app->request->get('authorization')=='clinical_1'){
            $query->andFilterWhere(['like','course_id',$cm1]);
        }

        if (\Yii::$app->request->get('authorization')=='clinical_2'){
            $query->andFilterWhere(['like','course_id',$cm2]);
        }

        if (\Yii::$app->request->get('authorization')=='clinical_3'){
            $query->andFilterWhere(['like','course_id',$cm3]);
        }




        $nm1=Course::find()->where(['abbreviation'=>'NTA4_NM'])->one()->id;
        $nm2=Course::find()->where(['abbreviation'=>'NTA5_NM'])->one()->id;
        $nm3=Course::find()->where(['abbreviation'=>'NTA6_NM'])->one()->id;

        if (\Yii::$app->request->get('authorization')=='nursing_1'){
            $query->andFilterWhere(['like','course_id',$nm1]);
        }

        if (\Yii::$app->request->get('authorization')=='nursing_2'){
            $query->andFilterWhere(['like','course_id',$nm2]);
        }
        if (\Yii::$app->request->get('authorization')=='nursing_3'){
            $query->andFilterWhere(['like','course_id',$nm3]);
        }



        $query->andFilterWhere(['like', 'fname', $this->fname])
            ->andFilterWhere(['like', 'mname', $this->mname])
            ->andFilterWhere(['like', 'place_of_birth', $this->place_of_birth])
            ->andFilterWhere(['like', 'id_number', $this->id_number])
            ->andFilterWhere(['like', 'marital_status', $this->marital_status])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'passport_size', $this->passport_size])
            ->andFilterWhere(['like', 'registration_number', $this->registration_number])
            ->andFilterWhere(['like', 'village', $this->village])
            ->andFilterWhere(['like', 'home_address', $this->home_address])
            ->andFilterWhere(['like', 'sponsorship', $this->sponsorship])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'college_residence', $this->college_residence])
            ->andFilterWhere(['like', 'intake_type', $this->intake_type])->orderBy([
 
  'fname'=>SORT_ASC
]);

        return $dataProvider;
    }
}
