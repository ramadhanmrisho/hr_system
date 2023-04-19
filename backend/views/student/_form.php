<?php

use buttflattery\formwizard\FormWizard;
use common\models\ALevelInformation;
use common\models\IdentityType;
use common\models\OLevelInformation;
use common\models\ParentInformation;
use common\models\Student;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;


$studentModel=new Student();
$parentModel=new ParentInformation();
$OlevelModel=new OLevelInformation();
$AlevelModel=new ALevelInformation();




echo  FormWizard::widget([

    'theme'=>FormWizard::THEME_MATERIAL_V,
    'formOptions' => [
        'options'=>[
            'class'=>'student-form'
        ],
    ],

    'steps'=>[
        [
            'model'=>$studentModel,
            'title'=>'Step 1',
            'previewHeading'=>'Student Information',
            'description'=>'STUDENT INFORMATION',
            'formInfoText'=>'<h3><b style="font-family: Bell MT">Fill Student Information below in CAPITAL letters:
</b>
</h3>',

            'fieldConfig' => [
                'fname' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'mname' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'lname' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'gender' => [
                    'options' => [
                        'type' => 'dropdown',
                        'itemsList' => ['Male' => 'Male', 'Female' => 'Female'], //the list can be from the database
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'place_of_birth' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'dob' => [
                    'widget' => DatePicker::className(),
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                    'options' => [ // you will pass the widget options here
                        'options' => [
                            'placeholder' => 'Date of Birth',
                            'pluginOptions' => ['format' => 'yyyy-mm-dd',
                                'autoclose'=> true,
                                'todayHighlight' => true,
                            ]

                        ],
                    ],
                ],

                'marital_status' => [
                    'options' => [
                        'type' => 'dropdown',
                        'itemsList' =>[ 'Married' => 'Married', 'Single' => 'Single', 'Divorced' => 'Divorced', ], ['prompt' => 'Select Marital Status'], //the list can be from the database
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'village' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'email' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'registration_number' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],

                'id_number' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],

                'phone_number' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'home_address' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'passport_size' => [
                    'options'=>[
                        'multifield'=>true,
                        'type'=>'file',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],


                'intake_type' => [
                    'options' => [
                        'type' => 'dropdown',
                        'itemsList' =>[ 'March' => 'March', 'September' => 'September', ], ['prompt' => 'Select Intake Type'], //the list can be from the database
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'nationality_id' => [
                    'widget' => Select2::class,
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                    'options' => [
                        'data'=>\yii\helpers\ArrayHelper::map(\common\models\Nationality::find()->all(),'id','name'),
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'pluginOptions' => [
                            'allowClear' => true,
                            'placeholder' => 'Nationality'
                        ]
                    ]],

                'region_id' => [
                    'widget' => Select2::class,
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                    'options' => [
                        'data'=>\yii\helpers\ArrayHelper::map(\common\models\Region::find()->all(),'id','name'),


                        'pluginOptions' => [


                            'allowClear' => true,
                            'placeholder' => 'Select region ....', 'multiple' => false,

//                            'ajax'=>[
//                                'url'=>"web/index.php?r=student/listsdistrict",
//                                'method'=>'post',
//                                'dataType' => 'json',
//                                'data'=>'{"id":$(this).val()}',
//                                'success'=>'function(data){
//                                console.log(data)
//                                }',
//                                'error'=>'function(error){
//                                console.log(error)}'
//                            ]
                        ],



                    ]],


                'district_id' => [
                    'widget' =>Select2::classname(),
                    'containerOptions' => [
                        'class' => 'col-md-4',
                    ],
                    'options' => [
                        'data'=>\yii\helpers\ArrayHelper::map(\common\models\District::find()->all(),'id','name'),
                        //'data'=>[],
                       // 'theme' => Select2::THEME_BOOTSTRAP,
                        'pluginOptions' => [
                            'allowClear' => true,
                            'placeholder' => '-----Select District-----'
                        ]
                    ]],

                'academic_year_id' => [
                    'widget' => Select2::class,
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                    'options' => [
                        'data'=>\yii\helpers\ArrayHelper::map(\common\models\AcademicYear::find()->all(),'id','name'),
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'pluginOptions' => [
                            'allowClear' => true,
                            'placeholder' => 'Select Academic Year'
                        ]
                    ]],
                'course_id' => [
                    'widget' => Select2::class,
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                    'options' => [
                        'data'=>\yii\helpers\ArrayHelper::map(\common\models\Course::find()->all(),'id','course_name'),
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'pluginOptions' => [
                            'allowClear' => true,
                            'placeholder' => 'Select Course'
                        ]
                    ]],



                'department_id' => [
                    'widget' => Select2::class,
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                    'options' => [
                        'data'=>\yii\helpers\ArrayHelper::map(\common\models\Department::find()->all(),'id','name'),
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'pluginOptions' => [
                            'allowClear' => true,
                            'placeholder' => 'Select Department Name'
                        ]
                    ]],


                'sponsorship' => [
                    'options' => [
                        'type' => 'dropdown',
                        'itemsList' =>[ 'Private' => 'Private', 'HESLB' => 'HESLB', 'Sponsor' => 'Sponsor' ], ['prompt' => 'Select Sponsorship Type'], //the list can be from the database
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'status' => [
                    'options' => [
                        'type' => 'dropdown',
                        'itemsList' =>[ 'First Year' => 'First Year', 'Continuing' => 'Continuing', 'Discontinuing' => 'Discontinuing', 'Completed' => 'Completed', ], ['prompt' => 'Select Status'], //the list can be from the database
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'college_residence' => [
                    'options' => [
                        'type' => 'dropdown',
                        'itemsList' =>[ 'Off Campus' => 'Off Campus', 'Hostel' => 'Hostel', ], ['prompt' => 'Residence Status'], //the list can be from the database
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],


                'identity_type_id' => [
                    'widget' => Select2::class,
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                    'options' => [
                        'data'=>\yii\helpers\ArrayHelper::map(IdentityType::find()->all(),'id','name'),
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'pluginOptions' => [
                            'allowClear' => true,
                            'placeholder' => 'Select ID Type'
                        ]
                    ]],


                'date_of_admission' => [
                    'widget' => DatePicker::className(),
                    'options' => [ // you can pass the widget options here
                        'options' => [
                            'placeholder' => 'Date of Admission',
                            'pluginOptions' => ['format' => 'dd-mm-yyyy',
                                'autoclose'=> true,
                                'todayHighlight' => true,
                            ]

                        ],
                        'containerOptions' => [
                            'class' => 'col-md-4'
                        ],
                    ],
                ],
                'created_by' => [
                    'options'=>[

                        'type'=>'hidden',
                    ]],

                'nta_level' => [
                    'options' => [
                        'type' => 'dropdown',
                        'itemsList' =>[ '4' => '4', '5' => '5','6'=>'6' ], ['prompt' => 'NTA Level'], //the list can be from the database
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
//                'created_at' => [
//                    'options'=>[
//                        'type'=>'hidden',
//                    ]],
//                'updated_at' => [
//                    'options'=>[
//
//                        'type'=>'hidden',
//                    ]],

                'created_at' =>false,
                'updated_at' =>false,




            ],
            'fieldOrder'=>['fname','mname','lname','gender','place_of_birth','marital_status','phone_number','email','home_address','registration_number','region_id','village ','district_id','academic_year_id','course_id','sponsorship','status','college_residence','department_id','intake_type','nationality','date_of_admission','identity_type_id','passport_size','year_of_study_id','dob','id_number'],
        ],

        [
            'model'=> $parentModel,
            'title'=>'Step 2',
            'previewHeading'=>'Parent/Guardian Information',
            'description'=>'PARENT/GUARDIAN INFORMATION',
            'formInfoText'=>'<h3><b style="font-family: Bell MT">Fill Parent/Guardian Information below in CAPITAL letters:</b></h3>',
            'fieldConfig' => [


                'full_name' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
             
              
                'gender' => [
                    'options' => [
                        'type' => 'dropdown',
                        'itemsList' => ['Male' => 'Male', 'Female' => 'Female'], //the list can be from the database
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'phone_number' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'altenate_phone_number' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'email' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],

                'occupation' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'physical_address' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'relationship' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'nationality_id' => [
                    'widget' => Select2::class,
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                    'options' => [
                        'data'=>\yii\helpers\ArrayHelper::map(\common\models\Nationality::find()->all(),'id','name'),
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'pluginOptions' => [
                            'allowClear' => true,
                            'placeholder' => 'Nationality'
                        ]
                    ]],

                'student_id' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'hidden',
                    ]],
//                'created_at' => [
//                    'options'=>[
//                        'multifield'=>false,
//                        'type'=>'hidden',
//                    ]],
//                'updated_at' => [
//                    'options'=>[
//                        'multifield'=>false,
//                        'type'=>'hidden',
//                    ]],
                'created_at' =>false,
                'updated_at' =>false,




            ],
            'fieldOrder'=>['full_name','gender','phone_number','physical_address','email'],

        ],

        [
            'model'=> $OlevelModel,
            'title'=>'Step 3',
            'previewHeading'=>'O Level Information',
            'description'=>'O LEVEL INFORMATION',
            'formInfoText'=>'<h3><b style="font-family: Bell MT">Fill Secondary School Information below in CAPITAL letters:</b></h3>',
            'fieldConfig' => [


                'name_of_school' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'index_number' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'year_of_complition' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'division' => [
                    'options' => [
                        'type' => 'dropdown',
                        'itemsList' => [ 'I' => 'I', 'II' => 'II', 'III' => 'III', 'IV' => 'IV', ],
                        'prompt' => 'Select Division'//the list can be from the database
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'Physics' => [
                    'options' => [
                        'type' => 'dropdown',
                        'itemsList' =>['A' => 'A', 'B' => 'B','C' => 'C', 'D' => 'D','F' => 'F'],
                        'prompt' => 'Select Grade Score',




                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4',

                    ],

                ],
                'Mathematics' => [
                    'options' => [
                        'type' => 'dropdown',
                        'itemsList' =>['A' => 'A', 'B' => 'B','C' => 'C', 'D' => 'D','F' => 'F'],
                        'prompt' => 'Select Grade Score'//the list can be from the database
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'Chemistry' => [
                    'options' => [
                        'type' => 'dropdown',
                        'itemsList' =>['A' => 'A', 'B' => 'B','C' => 'C', 'D' => 'D','F' => 'F'],
                        'prompt' => 'Select Grade Score' //the list can be from the database
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'Biology' => [
                    'options' => [
                        'type' => 'dropdown',
                        'itemsList' =>['A' => 'A', 'B' => 'B','C' => 'C', 'D' => 'D','F' => 'F'],
                        'prompt' => 'Select Grade Score' //the list can be from the database
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'English' => [
                    'options' => [
                        'type' => 'dropdown',
                        'itemsList' =>['A' => 'A', 'B' => 'B','C' => 'C', 'D' => 'D','F' => 'F'],
                        'prompt' => 'Select Grade Score', //the list can be from the database
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'o_level_certificate' => [
                    'options'=>[
                        'multifield'=>true,
                        'type'=>'file',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],

                'student_id' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'hidden',
                    ]],
//                'created_at' => [
//                    'options'=>[
//                        'multifield'=>false,
//                        'type'=>'hidden',
//                    ]],
//                'updated_at' => [
//                    'options'=>[
//                        'multifield'=>false,
//                        'type'=>'hidden',
//                    ]],
                'created_at' =>false,
                'updated_at' =>false,




            ],
            'fieldOrder'=>['name_of_school','index_number','year_of_complition','division','Physics','Chemistry','Biology','Mathematics','English','o_level_certificate'],

        ],

        [
            'model'=> $AlevelModel,
            'title'=>'Step 4',
            'isSkipable '=>true,
            'previewHeading'=>'A Level Information',
            'description'=>'A LEVEL INFORMATION',
            'formInfoText'=>'<h3><b style="font-family: Bell MT">Fill Advanced Secondary School Information below in CAPITAL letters:</b></h3>',
            'fieldConfig' => [

                'name_of_school' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'index_number' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'year_of_complition' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'text',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'division' => [
                    'options' => [
                        'type' => 'dropdown',
                        'itemsList' => [ 'I' => 'I', 'II' => 'II', 'III' => 'III', 'IV' => 'IV', ],
                        'prompt' => 'Select Division'//the list can be from the database
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'Physics' => [
                    'options' => [
                        'type' => 'dropdown',
                        'itemsList' =>['A' => 'A', 'B' => 'B','C' => 'C', 'D' => 'D','F' => 'F','S' => 'S'],
                        'prompt' => 'Select Grade Score',




                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4',

                    ],

                ],
                'Mathematics' => [
                    'options' => [
                        'type' => 'dropdown',
                        'itemsList' =>['A' => 'A', 'B' => 'B','C' => 'C', 'D' => 'D','F' => 'F','S' => 'S'],
                        'prompt' => 'Select Grade Score'//the list can be from the database
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'Chemistry' => [
                    'options' => [
                        'type' => 'dropdown',
                        'itemsList' =>['A' => 'A', 'B' => 'B','C' => 'C', 'D' => 'D','F' => 'F','S' => 'S'],
                        'prompt' => 'Select Grade Score' //the list can be from the database
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'Biology' => [
                    'options' => [
                        'type' => 'dropdown',
                        'itemsList' =>['A' => 'A', 'B' => 'B','C' => 'C', 'D' => 'D','F' => 'F','S' => 'S'],
                        'prompt' => 'Select Grade Score' //the list can be from the database
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],
                'a_level_certificate' => [
                    'options'=>[
                        'multifield'=>true,
                        'type'=>'file',
                    ],
                    'containerOptions' => [
                        'class' => 'col-md-4'
                    ],
                ],

                'student_id' => [
                    'options'=>[
                        'multifield'=>false,
                        'type'=>'hidden',
                    ]],
//                'created_at' => [
//                    'options'=>[
//                        'multifield'=>false,
//                        'type'=>'hidden',
//                    ]],
//                'updated_at' => [
//                    'options'=>[
//                        'multifield'=>false,
//                        'type'=>'hidden',
//                    ]],
                'created_at' =>false,
                'updated_at' =>false,




            ],
            'fieldOrder'=>['name_of_school','index_number','year_of_complition','division','Physics','Chemistry','Biology','Mathematics','a_level_certificate'],

        ],




    ]





]);