<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email'])) {
        $error_message = "Email is required";
    } else {
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $result_of =$_POST['result_of'];
        $wbpitm_name = $_POST['wbpitm_name'];
        $wbptime_name_of_your_institution = $_POST['wbptime_name_of_your_institution'];
        $result_of_training = $_POST['result_of_training'];
        $programmes_and_policies = $_POST['programmes_and_policies'];
        $employee_education = $_POST['employee_education'];
        $relevant_option = $_POST['relevant_option'];
        $relevant_to_your_work = $_POST['relevant_to_your_work'];
        $schedule_and_duration = $_POST['schedule_and_duration'];
        $training_methodologies_used = $_POST['training_methodologies_used'];
        $handouts_received = $_POST['handouts_received'];
        $trainer_was_well_prepared = $_POST['trainer_was_well_prepared'];
        $about_the_subject_matter = $_POST['about_the_subject_matter'];
        $meaningful_way = $_POST['meaningful_way'];
        $participant_questions = $_POST['participant_questions'];
        $engagement_and_participation = $_POST['engagement_and_participation'];
        $name_of_the_trainer = $_POST['name_of_the_trainer'];
        $name_of_the_trainers = $_POST['name_of_the_trainers'];

        $wb_trainer_was_well_prepares = $_POST['wb_trainer_was_well_prepares'];
        $wb_Trainer_was_knowledgeable_about_the_subject_matters = $_POST['wb_Trainer_was_knowledgeable_about_the_subject_matters'];
        $trainer_communicated_the_material_in_a_meaningful_ways = $_POST['trainer_communicated_the_material_in_a_meaningful_ways'];
        $trainer_provided_clear_answers_to_participant_questions = $_POST['trainer_provided_clear_answers_to_participant_questions'];
        $trainer_promoted_engagement_and_participations = $_POST['trainer_promoted_engagement_and_participations'];
        $what_did_you_like_best_about_the_training = $_POST['what_did_you_like_best_about_the_training'];
        $what_one_thing_could_be_improved_for_future_trainings = $_POST['what_one_thing_could_be_improved_for_future_trainings'];
        $kindly_share_any_other_comments_or_suggestions_you_may_have_with_regard_to_workplace_training = $_POST['kindly_share_any_other_comments_or_suggestions_you_may_have_with_regard_to_workplace_training'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Invalid email format";
        } else {
            $url = "https://monitoring.nacada.go.ke/api/tracker";
            $username = "jack";
            $password = "Jocsoft@2027!!";

            // Corrected DHIS2 payload structure
            $data = [
                "trackedEntities" => [
                    [
                        "attributes" => [
                            [
                                "attribute" => "GcY28sK8JnU", // Full Name attribute
                                "value" => $email
                            ]
                        ],
                        "enrollments" => [
                            [
                                "enrolledAt" => date("Y-m-d"),
                                "occurredAt" => date("Y-m-d"),
                                "orgUnit" => "ORwhnDymBpM",
                                "program" => "Jx3L6PmQiEM",
                                "status" => "ACTIVE",
                                "events" => [  // Events should be inside enrollment
                                    [
                                        "dataValues" => [
											[
                                                "dataElement" => "MLJAYxAStqC",
												"value" => $result_of
                                            ],
                                            [
                                                "dataElement" => "q6Lc52NhvGp",
												"value" => $email
                                            ],
                                            [
                                                "dataElement" => "Nec3qnL80Ar",
												"value" => $wbpitm_name
                                            ],
                                            [
                                                "dataElement" => "DOMDwji0qcy",
												"value" => $wbptime_name_of_your_institution
                                            ],
                                            [
                                                "dataElement" => "krtxCg3otEo",
												"value" => $result_of_training
                                            ],
                                            [
                                                "dataElement" => "VTk2tnlHOV3",
												"value" => $programmes_and_policies
                                            ],
                                            [
                                                "dataElement" => "BOwxoPdtcXC",
												"value" => $employee_education
                                            ],
                                            [
                                                "dataElement" => "rCPy024LLiQ",
												"value" => $relevant_option
                                            ],
                                            [
                                                "dataElement" => "tOhjeywOSyq",
												"value" => $relevant_to_your_work
                                            ],
                                            [
                                                "dataElement" => "eJHNTNLV7FY",
												"value" => $schedule_and_duration
                                            ],
                                            [
                                                "dataElement" => "lKTIx5Ak0QU",
												"value" => $training_methodologies_used
                                            ],
                                            [
                                                "dataElement" => "amNyePYrSIb",
												"value" => $handouts_received
                                            ],
                                            [
                                                "dataElement" => "TgBe2DJDoJU",
												"value" => $trainer_was_well_prepared
                                            ],
                                            [
                                                "dataElement" => "v0n8SjfNOLv",
												"value" => $about_the_subject_matter
                                            ],
                                            [
                                                "dataElement" => "CdmwS3SDgB3",
												"value" => $meaningful_way
                                            ],
                                            [
                                                "dataElement" => "p3enA3ux1q5",
												"value" => $participant_questions
                                            ],
                                            [
                                                "dataElement" => "d1dpauBRfZP",
												"value" => $engagement_and_participation
                                            ],
                                            [
                                                "dataElement" => "Rho5FT0sJSs",
												"value" => $wb_trainer_was_well_prepares
                                            ],
                                            [
                                                "dataElement" => "NIebazDM70k",
												"value" => $wb_Trainer_was_knowledgeable_about_the_subject_matters
                                            ],
                                            [
                                                "dataElement" => "ACtrH6Na3VH",
												"value" => $trainer_communicated_the_material_in_a_meaningful_ways
                                            ],
                                            [
                                                "dataElement" => "deepkm4efeQ",
												"value" => $trainer_provided_clear_answers_to_participant_questions
                                            ],
                                            [
                                                "dataElement" => "mNMjmbuwn91",
												"value" => $trainer_promoted_engagement_and_participations
                                            ],
                                            [
                                                "dataElement" => "Av2LTgmtHMv",
												"value" => $what_did_you_like_best_about_the_training
                                            ],

                                            [
                                                "dataElement" => "oKM8l6v8YLP",
												"value" => $what_one_thing_could_be_improved_for_future_trainings
                                            ],

                                            [
                                                "dataElement" => "uyFieWMpzpd",
												"value" => $kindly_share_any_other_comments_or_suggestions_you_may_have_with_regard_to_workplace_training
                                            ],

                                            [
                                                "dataElement" => "hiLRiWPC4u9",
												"value" => $name_of_the_trainer
                                            ],
                                            [
                                                "dataElement" => "nrSeeDuvXVT",
												"value" => $name_of_the_trainers
                                            ],
                                        ],
                                        "enrollmentStatus" => "ACTIVE",
                                        "notes" => [
                                            [
                                                "value" => "Needs review"
                                            ]
                                        ],
                                        "occurredAt" => date("Y-m-d"),
                                        "orgUnit" => "ORwhnDymBpM",
                                        "program" => "Jx3L6PmQiEM",
                                        "programStage" => "j1Ci20huoTK",
                                        "status" => "ACTIVE"
                                    ]
                                ]
                            ]
                        ],
                        "orgUnit" => "ORwhnDymBpM",
                        "trackedEntityType" => "kBS2MoCIdew" 
                    ]
                ]
            ];

            // Encode to JSON
            $jsonData = json_encode($data);
            
            if ($jsonData === false) {
                $error_message = "JSON encoding failed: " . json_last_error_msg();
            } else {
                // Send request
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "Content-Type: application/json",
                    "Accept: application/json",
                    "Content-Length: " . strlen($jsonData)
                ]);
                curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);

                $response = curl_exec($ch);
                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if (curl_errno($ch)) {
                    $error_message = "cURL Error: " . curl_error($ch);
                } else {
                    if ($httpcode == 200 || $httpcode == 201) {
                        $success_message = "Tracked Entity + Enrollment created successfully!";
                        $success_message .= "<br>Response: " . htmlspecialchars($response);
                    } else {
                        $error_message = "Failed. HTTP Code: $httpcode";
                        $error_message .= "<br>Response: " . htmlspecialchars($response);
                    }
                }
                curl_close($ch);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WORKPLACE BASED PREVENTION INTERVENTIONS TRAINING FOR MANAGERS AND SUPERVISORS EVALUATION</title>
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --success: #27ae60;
            --danger: #e74c3c;
            --light: #ecf0f1;
            --dark: #34495e;
            --gray: #95a5a6;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            line-height: 1.6;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: var(--dark);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            font-weight: 100;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 1rem;
        }
        
        .form-content {
            padding: 30px;
        }
        
        .form-section {
            background: var(--light);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            border-left: 4px solid var(--secondary);
        }
        
        .form-section h3 {
            color: var(--primary);
            margin-bottom: 20px;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .personalinformation{
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 10px;
        }
        
        .form-section h3::before {
            content: "•";
            color: var(--secondary);
            font-size: 2rem;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group:last-child {
            margin-bottom: 0;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 100;
            color: var(--dark);
            font-size: 1rem;
        }
        
        .form-hint {
            font-size: 0.85rem;
            color: var(--gray);
            margin-top: 5px;
        }
        
        input[type="email"], 
        input[type="text"], 
        select, 
        textarea { 
            width: 100%; 
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
        }
        
        input[type="email"]:focus, 
        input[type="text"]:focus, 
        select:focus, 
        textarea:focus {
            border-color: var(--secondary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
            transform: translateY(-2px);
        }
        
        textarea {
            min-height: 120px;
            resize: vertical;
            font-family: inherit;
        }
        
        select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
            padding-right: 45px;
        }
        
        .btn-submit {
            display: block;
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--secondary) 0%, #2980b9 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }
        
        .btn-submit:active {
            transform: translateY(-1px);
        }
        
        .message {
            padding: 20px;
            border-radius: 10px;
            margin: 25px 0;
            animation: fadeIn 0.5s ease;
        }
        
        .success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        
        .error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        
        .response {
            margin-top: 15px;
            padding: 15px;
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 5px;
            font-family: monospace;
            font-size: 14px;
            overflow-x: auto;
            white-space: pre-wrap;
        }
        
        .rating-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            /* margin-bottom: 15px; */
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .rating-item:last-child {
            margin-bottom: 0;
        }
        
        .rating-item p {
            margin-bottom: 10px;
            font-weight: 500;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .container {
                border-radius: 10px;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 1.5rem;
            }
            
            .form-content {
                padding: 20px;
            }
            
            .form-section {
                padding: 20px;
            }
        }
        
        @media (max-width: 480px) {
            .header h1 {
                font-size: 1.3rem;
            }
            
            .form-section h3 {
                font-size: 1.1rem;
            }
            .personalinformation{
            display: grid;
            grid-template-columns:(1fr, 1fr);
            gap: 10px;
            width: 100%;
        }
            
            input[type="email"], 
            input[type="text"], 
            select, 
            textarea {
                padding: 10px 12px;
                font-size: 16px; /* Prevents zoom on iOS */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h3>WORKPLACE BASED PREVENTION INTERVENTIONS TRAINING</h3>
            <p>For Managers and Supervisors Evaluation</p>
        </div>
        
        <div class="form-content">
            <form method="POST">
                <div class="form-section">
                    <h3>Personal Information</h3>
                    
                   <div class="personalinformation">
                   <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email address" required 
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="wbpitm_name">Your Name</label>
                        <input type="text" id="wbpitm_name" name="wbpitm_name" required 
                               value="<?php echo isset($_POST['wbpitm_name']) ? htmlspecialchars($_POST['wbpitm_name']) : ''; ?>">
                    </div>
                   </div>
                    
                    <div class="form-group">
                        <label for="wbptime_name_of_your_institution">Name of Your Institution</label>
                        <input type="text" id="wbptime_name_of_your_institution" name="wbptime_name_of_your_institution" required 
                               value="<?php echo isset($_POST['wbptime_name_of_your_institution']) ? htmlspecialchars($_POST['wbptime_name_of_your_institution']) : ''; ?>">
                    </div>
                </div>
                
                <div class="form-section">
                    <h3>Understanding of Training Modules</h3>
                    <p class="form-hint">Kindly rate your understanding of the modules learned by checking the relevant space</p>
                    
                   <div class="personalinformation">
                   <div class="rating-item">
                        <p>Facts about Drugs</p>
                        <select name="result_of" required>
                            <option value="">Select one</option>
                            <option value="Low">Low</option>
                            <option value="Fair">Fair</option>
                            <option value="Good">Good</option>
                            <option value="Excellent">Excellent</option>
                        </select>
                    </div>
                    
                    <div class="rating-item">
                        <p>Supervisor Training</p>
                        <select name="result_of_training" required>
                            <option value="">Select one</option>
                            <option value="Low">Low</option>
                            <option value="Fair">Fair</option>
                            <option value="Good">Good</option>
                            <option value="Excellent">Excellent</option>
                        </select>
                    </div>

                    <div class="rating-item">
                        <p>Key components of substance use prevention programmes and policies</p>
                        <select name="programmes_and_policies" required>
                            <option value="">Select one</option>
                            <option value="Low">Low</option>
                            <option value="Fair">Fair</option>
                            <option value="Good">Good</option>
                            <option value="Excellent">Excellent</option>
                        </select>
                    </div>
                    
                    <div class="rating-item">
                        <p>Employee Education</p>
                        <select name="employee_education" required>
                            <option value="">Select one</option>
                            <option value="Low">Low</option>
                            <option value="Fair">Fair</option>
                            <option value="Good">Good</option>
                            <option value="Excellent">Excellent</option>
                        </select>
                    </div>
                   </div>
                </div>
                
                <div class="form-section">
                    <h3>Training Components Evaluation</h3>
                    <p class="form-hint">Kindly rate the following training components by checking the relevant option</p>
                    
                    <div class="personalinformation">

                    <div class="rating-item">
                        <p>Achievement of training objectives</p>
                        <select name="relevant_option" required>
                            <option value="">Select one</option>
                            <option value="Low">Low</option>
                            <option value="Fair">Fair</option>
                            <option value="Good">Good</option>
                            <option value="Excellent">Excellent</option>
                        </select>
                    </div>
                    
                    <div class="rating-item">
                        <p>Knowledge and skills gained are relevant to your work</p>
                        <select name="relevant_to_your_work" required>
                            <option value="">Select one</option>
                            <option value="Low">Low</option>
                            <option value="Fair">Fair</option>
                            <option value="Good">Good</option>
                            <option value="Excellent">Excellent</option>
                        </select>
                    </div>
                    
                    <div class="rating-item">
                        <p>Training schedule and duration</p>
                        <select name="schedule_and_duration" required>
                            <option value="">Select one</option>
                            <option value="Low">Low</option>
                            <option value="Fair">Fair</option>
                            <option value="Good">Good</option>
                            <option value="Excellent">Excellent</option>
                        </select>
                    </div>
                    
                    <div class="rating-item">
                        <p>Training methodologies used</p>
                        <select name="training_methodologies_used" required>
                            <option value="">Select one</option>
                            <option value="Low">Low</option>
                            <option value="Fair">Fair</option>
                            <option value="Good">Good</option>
                            <option value="Excellent">Excellent</option>
                        </select>
                    </div>
                    
                    <div class="rating-item">
                        <p>Training materials and handouts received</p>
                        <select name="handouts_received" required>
                            <option value="">Select one</option>
                            <option value="Low">Low</option>
                            <option value="Fair">Fair</option>
                            <option value="Good">Good</option>
                            <option value="Excellent">Excellent</option>
                        </select>
                    </div>

                    </div>
                </div>
                
                <div class="form-section">
                    <h3>Reviewing trainer 1</h3>
                    
                    <div class="personalinformation">

                    <div class="">
                        <input placeholder="Type the name of the trainer" type="text" id="name_of_the_trainer" name="name_of_the_trainer" required>
                    </div>

                    <div class="rating-item">
                        <p>Trainer was well prepared</p>
                        <select name="trainer_was_well_prepared" required>
                            <option value="">Select one</option>
                            <option value="Strongly agree">Strongly agree</option>
                            <option value="Agree">Agree</option>
                            <option value="Disagree">Disagree</option>
                            <option value="Strongly disagree">Strongly disagree</option>
                        </select>
                    </div>
                    
                    <div class="rating-item">
                        <p>Trainer was knowledgeable about the subject matter</p>
                        <select name="about_the_subject_matter" required>
                            <option value="">Select one</option>
                            <option value="Strongly agree">Strongly agree</option>
                            <option value="Agree">Agree</option>
                            <option value="Disagree">Disagree</option>
                            <option value="Strongly disagree">Strongly disagree</option>
                        </select>
                    </div>
                    
                    <div class="rating-item">
                        <p>Trainer communicated the material in a meaningful way</p>
                        <select name="meaningful_way" required>
                            <option value="">Select one</option>
                            <option value="Strongly agree">Strongly agree</option>
                            <option value="Agree">Agree</option>
                            <option value="Disagree">Disagree</option>
                            <option value="Strongly disagree">Strongly disagree</option>
                        </select>
                    </div>
                    
                    <div class="rating-item">
                        <p>Trainer provided clear answers to participant questions</p>
                        <select name="participant_questions" required>
                            <option value="">Select one</option>
                            <option value="Strongly agree">Strongly agree</option>
                            <option value="Agree">Agree</option>
                            <option value="Disagree">Disagree</option>
                            <option value="Strongly disagree">Strongly disagree</option>
                        </select>
                    </div>
                    
                    <div class="rating-item">
                        <p>Trainer promoted engagement and participation</p>
                        <select name="engagement_and_participation" required>
                            <option value="">Select one</option>
                            <option value="Strongly agree">Strongly agree</option>
                            <option value="Agree">Agree</option>
                            <option value="Disagree">Disagree</option>
                            <option value="Strongly disagree">Strongly disagree</option>
                        </select>
                    </div>

                    </div>
                </div>
                
                <div class="form-section">
                    <h3>Reviewing the trainer</h3>
                    <!-- will be updated later -->
                    <div class="personalinformation">
                            <div class="">
                            <input placeholder="Type the name of the trainer" type="text" id="name_of_the_trainers" name="name_of_the_trainers" required>
                            </div>
                    <div class="rating-item">
                        <p>Trainer was well prepared</p>
                        <select name="wb_trainer_was_well_prepares" required>
                            <option value="">Select one</option>
                            <option value="Strongly agree">Strongly agree</option>
                            <option value="Agree">Agree</option>
                            <option value="Disagree">Disagree</option>
                            <option value="Strongly disagree">Strongly disagree</option>
                        </select>
                    </div>
                    
                    <div class="rating-item">
                        <p>Trainer was knowledgeable about the subject matter</p>
                        <select name="wb_Trainer_was_knowledgeable_about_the_subject_matters" required>
                            <option value="">Select one</option>
                            <option value="Strongly agree">Strongly agree</option>
                            <option value="Agree">Agree</option>
                            <option value="Disagree">Disagree</option>
                            <option value="Strongly disagree">Strongly disagree</option>
                        </select>
                    </div>
                    
                    <div class="rating-item">
                        <p>Trainer communicated the material in a meaningful way</p>
                        <select name="trainer_communicated_the_material_in_a_meaningful_ways" required>
                            <option value="">Select one</option>
                            <option value="Strongly agree">Strongly agree</option>
                            <option value="Agree">Agree</option>
                            <option value="Disagree">Disagree</option>
                            <option value="Strongly disagree">Strongly disagree</option>
                        </select>
                    </div>
                    
                    <div class="rating-item">
                        <p>Trainer provided clear answers to participant questions</p>
                        <select name="trainer_provided_clear_answers_to_participant_questions" required>
                            <option value="">Select one</option>
                            <option value="Strongly agree">Strongly agree</option>
                            <option value="Agree">Agree</option>
                            <option value="Disagree">Disagree</option>
                            <option value="Strongly disagree">Strongly disagree</option>
                        </select>
                    </div>
                    
                    <div class="rating-item">
                        <p>Trainer promoted engagement and participation</p>
                        <select name="trainer_promoted_engagement_and_participations" required>
                            <option value="">Select one</option>
                            <option value="Strongly agree">Strongly agree</option>
                            <option value="Agree">Agree</option>
                            <option value="Disagree">Disagree</option>
                            <option value="Strongly disagree">Strongly disagree</option>
                        </select>
                    </div>

                    </div>
                </div>
                
                <div class="form-section">
                    <h3>Additional Feedback</h3>
                    
                    <div class="form-group">
                        <label for="what_did_you_like_best_about_the_training">What did you like best about the training?</label>
                        <textarea id="what_did_you_like_best_about_the_training" name="what_did_you_like_best_about_the_training" 
                                  placeholder="Please share what you enjoyed most about the training..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="what_one_thing_could_be_improved_for_future_trainings">What one thing could be improved for future trainings?</label>
                        <textarea id="what_one_thing_could_be_improved_for_future_trainings" name="what_one_thing_could_be_improved_for_future_trainings" 
                                  placeholder="Your suggestions for improvement..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="kindly_share_any_other_comments_or_suggestions_you_may_have_with_regard_to_workplace_training">Kindly share any other comments or suggestions you may have with regard to workplace training</label>
                        <textarea id="kindly_share_any_other_comments_or_suggestions_you_may_have_with_regard_to_workplace_training" 
                                  name="kindly_share_any_other_comments_or_suggestions_you_may_have_with_regard_to_workplace_training" 
                                  placeholder="Any additional comments or suggestions..."></textarea>
                    </div>
                </div>
                
                <button type="submit" class="btn-submit">Submit</button>
            </form>
            
            <?php if ($success_message): ?>
                <div class="message success">
                    <strong>Success!</strong> 
                    <?php 
                    $msg = explode("<br>", "Submitted successfully!");
                    echo $msg[0]; 
                    ?>
                    <div class="response">
                        <?php 
                        if (isset($msg[1])) echo $msg[1]; 
                        ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
                <div class="message error">
                    <strong>Error:</strong> 
                    <?php 
                    $msg = explode("<br>", $error_message);
                    echo $msg[0]; 
                    ?>
                    <div class="response">
                        <?php 
                        if (isset($msg[1])) echo $msg[1]; 
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>