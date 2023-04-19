<?php

namespace common\models\search;

use common\models\AcademicYear;
use common\models\Course;
use common\models\Semester;
use common\models\UserAccount;
use common\models\YearOfStudy;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Supplementary;

/**
 * SupplementarySearch represents the model behind the search form of `common\models\Supplementary`.
 */
class SupplementarySearch extends Supplementary
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'student_id', 'module_id', 'course_id', 'nta_level', 'academic_year_id', 'semester_id'], 'integer'],
            [['status', 'category', 'created_at', 'updated_at','staff_id'], 'safe'],
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
        $query = Supplementary::find();

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
            'course_id' => $this->course_id,
            'academic_year_id' => $this->academic_year_id,
            'semester_id' => $this->semester_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);


        $current_academic_year=AcademicYear::find()->where(['status'=>'Active'])->one()->id;
        $semester1=Semester::find()->where(['name'=>'I'])->one()->id;
        $semester2=Semester::find()->where(['name'=>'II'])->one()->id;

        $query->andFilterWhere(['like','academic_year_id',$current_academic_year]);



        $first_year=4;
        $second_year=5;
        $third_year=6;



        $cm1=Course::find()->where(['abbreviation'=>'NTA4_CM'])->one()->id;
        $cm2=Course::find()->where(['abbreviation'=>'NTA5_CM'])->one()->id;
        $cm3=Course::find()->where(['abbreviation'=>'NTA6_CM'])->one()->id;

        if (\Yii::$app->request->get('authorization')=='clinical_11'){
            $query->andFilterWhere(['like','course_id',$cm1])
                ->andFilterWhere(['like','semester_id',$semester1]);
        }

        if (\Yii::$app->request->get('authorization')=='clinical_12'){
            $query ->andFilterWhere(['like','course_id',$cm1])
                ->andFilterWhere(['like','semester_id',$semester2]);
        }

        if (\Yii::$app->request->get('authorization')=='clinical_21'){
            $query ->andFilterWhere(['like','course_id',$cm2])
                ->andFilterWhere(['like','semester_id',$semester1]);
        }

        if (\Yii::$app->request->get('authorization')=='clinical_22'){
            $query->andFilterWhere(['like','course_id',$cm2])
                ->andFilterWhere(['like','semester_id',$semester2]);
        }

        if (\Yii::$app->request->get('authorization')=='clinical_31'){
            $query->andFilterWhere(['like','course_id',$cm3])
                ->andFilterWhere(['like','semester_id',$semester1]);

        }
        if (\Yii::$app->request->get('authorization')=='clinical_32'){
            $query->andFilterWhere(['like','course_id',$cm3])
                ->andFilterWhere(['like','semester_id',$semester2]);

        }

        //NURSING AND MIDWIFERY

        $nm1=Course::find()->where(['abbreviation'=>'NTA4_NM'])->one()->id;
        $nm2=Course::find()->where(['abbreviation'=>'NTA5_NM'])->one()->id;
        $nm3=Course::find()->where(['abbreviation'=>'NTA6_NM'])->one()->id;


        if (\Yii::$app->request->get('authorization')=='nursing_11'){
            $query->andFilterWhere(['like','course_id',$nm1])
                ->andFilterWhere(['like','semester_id',$semester1]);
        }
        if (\Yii::$app->request->get('authorization')=='nursing_12'){
            $query->andFilterWhere(['like','course_id',$nm1])
                ->andFilterWhere(['like','semester_id',$semester2]);
        }

        if (\Yii::$app->request->get('authorization')=='nursing_21'){
            $query->andFilterWhere(['like','course_id',$nm2])
                ->andFilterWhere(['like','semester_id',$semester1]);
        }
        if (\Yii::$app->request->get('authorization')=='nursing_22'){
            $query->andFilterWhere(['like','course_id',$nm2])
                ->andFilterWhere(['like','semester_id',$semester2]);
        }

        if (\Yii::$app->request->get('authorization')=='nursing_31'){
            $query->andFilterWhere(['like','course_id',$nm3])
                ->andFilterWhere(['like','semester_id',$semester1]);
        }
        if (\Yii::$app->request->get('authorization')=='nursing_32'){
            $query->andFilterWhere(['like','course_id',$nm3])
                ->andFilterWhere(['like','semester_id',$semester2]);
        }

        //YEAR OF STUDY FOR STUDENTS
        if (\Yii::$app->request->get('year')=='year_1'){
            $query->andFilterWhere(['like','nta_level',$first_year]);
        }

        if (\Yii::$app->request->get('year')=='year_2'){
            $query->andFilterWhere(['like','nta_level',$second_year]);

        }
        if (\Yii::$app->request->get('year')=='year_3'){
            $query->andFilterWhere(['like','nta_level',$third_year]);

        }



        if (!UserAccount::userHas(['HOD','PR','ADMIN'])){
            $query->andFilterWhere(['like','staff_id',Yii::$app->user->identity->user_id]);
        }




        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'category', $this->category]);

        return $dataProvider;
    }
}
