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

        $wb_trainer_was_well_prepares = $_POST['wb_trainer_was_well_prepares'];
        $wb_Trainer_was_knowledgeable_about_the_subject_matters = $_POST['wb_Trainer_was_knowledgeable_about_the_subject_matters'];
        $trainer_communicated_the_material_in_a_meaningful_ways = $_POST['trainer_communicated_the_material_in_a_meaningful_ways'];
        $trainer_provided_clear_answers_to_participant_questions = $_POST['trainer_provided_clear_answers_to_participant_questions'];
        $trainer_promoted_engagement_and_participations = $_POST['trainer_promoted_engagement_and_participations'];
        $what_did_you_like_best_about_the_training = $_POST['what_did_you_like_best_about_the_training'];
        $what_one_thing_could_be_improved_for_future_trainings = $_POST['what_one_thing_could_be_improved_for_future_trainings'];
        $kindly_share_any_other_comments_or_suggestions_you_may_have_with_regard_to_workplace_training = $_POST['kindly_share_any_other_comments_or_suggestions_you_may_have_with_regard_to_workplace_training']




        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Invalid email format";
        } else {
            $url = "https://monitoring.jocsoft.net/dhis/api/tracker";
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
<html>
<head>
    <title>WORKPLACE BASED PREVENTION INTERVENTIONS TRAINING FOR MANAGERS AND SUPERVISORS EVALUATION</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background-color: #f5f9fc;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #2c3e50;
            margin-top: 0;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        form { 
            margin-bottom: 25px; 
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #2c3e50;
        }
        input[type="email"], select { 
            padding: 12px; 
            width: 100%; 
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        input[type="email"]:focus, select:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }
        button { 
            padding: 12px 24px; 
            background: #3498db; 
            color: white; 
            border: none; 
            border-radius: 4px;
            cursor: pointer; 
            font-size: 16px;
            font-weight: 600;
            transition: background 0.3s;
        }
        button:hover { 
            background: #2980b9; 
        }
        .message {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .success {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }
        .error {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }
        .response {
            margin-top: 10px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
            font-family: monospace;
            font-size: 14px;
            overflow-x: auto;
        }
        .info-box {
            background-color: #e8f4fc;
            border-left: 4px solid #3498db;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>WORKPLACE BASED PREVENTION INTERVENTIONS TRAINING FOR MANAGERS AND SUPERVISORS EVALUATION</h2>
        
        <form method="POST">
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" placeholder="Enter valid email address" required 
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">

                       <label for="wbpitm_name">Your name:</label>
                <input type="text" id="wbpitm_name" name="wbpitm_name" required 
                       value="<?php echo isset($_POST['wbpitm_name']) ? htmlspecialchars($_POST['wbpitm_name']) : ''; ?>">

                       <label for="wbptime_name_of_your_institution">Name of your institution:</label>
                <input type="text" id="wbptime_name_of_your_institution" name="wbptime_name_of_your_institution" required 
                       value="<?php echo isset($_POST['wbptime_name_of_your_institution']) ? htmlspecialchars($_POST['wbptime_name_of_your_institution']) : ''; ?>">
            </div>
			<div class="form-group">
                <label for="qi">Kindly rate your understanding of the modules learned by checking the relevant space</label>
                <p>Facts about Drugs</p>
				<select name ="result_of" class="form-group">
				<option value="Low">Low</option>
				<option value="Fair">Fair</option>
				<option value="Good">Good</option>
                <option value="Excellent">Excellent</option>
				</select>

                <p>Supervisor Training</p>
                <select name ="result_of_training" class="form-group">
				<option value="Low">Low</option>
				<option value="Fair">Fair</option>
				<option value="Good">Good</option>
                <option value="Excellent">Excellent</option>
				</select> 

                <p>Key components of substance use prevention programmes and policies</p>
                <select name ="programmes_and_policies" class="form-group">
				<option value="Low">Low</option>
				<option value="Fair">Fair</option>
				<option value="Good">Good</option>
                <option value="Excellent">Excellent</option>
				</select> 

                <p>Employee Education</p>
                <select name ="employee_education" class="form-group">
				<option value="Low">Low</option>
				<option value="Fair">Fair</option>
				<option value="Good">Good</option>
                <option value="Excellent">Excellent</option>
				</select> 
            </div>
			
			<div class="form-group">
                <label for="q2">Kindly rate the following training components by checking the relevant option </label>
                <p>Achievement of training objectives</p>
                <select name ="relevant_option" class="form-group">
				<option value="Low">Low</option>
				<option value="Fair">Fair</option>
				<option value="Good">Good</option>
                <option value="Excellent">Excellent</option>
				</select>

                <p>Knowledge and skills gained are relevant to your work</p>
                <select name ="relevant_to_your_work" class="form-group">
				<option value="Low">Low</option>
				<option value="Fair">Fair</option>
				<option value="Good">Good</option>
                <option value="Excellent">Excellent</option>
				</select>

                <p>Training schedule and duration</p>
                <select name ="schedule_and_duration" class="form-group">
				<option value="Low">Low</option>
				<option value="Fair">Fair</option>
				<option value="Good">Good</option>
                <option value="Excellent">Excellent</option>
				</select>

                <p>Training methodologies used</p>
                <select name ="training_methodologies_used" class="form-group">
				<option value="Low">Low</option>
				<option value="Fair">Fair</option>
				<option value="Good">Good</option>
                <option value="Excellent">Excellent</option>
				</select>

                <p>Training materials and handouts received</p>
                <select name ="handouts_received" class="form-group">
				<option value="Low">Low</option>
				<option value="Fair">Fair</option>
				<option value="Good">Good</option>
                <option value="Excellent">Excellent</option>
				</select>
            </div>

            <div class="form-group">
                <label for="q3">Trainer 1: Dr. Elizabeth Njani </label>
                
                <p>Trainer was well prepared</p>
            <select name ="trainer_was_well_prepared" class="form-group">
				<option value="Strongly agree">Strongly agree</option>
				<option value="Agree">Agree</option>
				<option value="Disagree">Disagree</option>
                <option value="Strongly disagree">Strongly disagree</option>
				</select>

                <p>Trainer was knowledgeable about the subject matter</p>
                <select name ="about_the_subject_matter" class="form-group">
				<option value="Strongly agree">Strongly agree</option>
				<option value="Agree">Agree</option>
				<option value="Disagree">Disagree</option>
                <option value="Strongly disagree">Strongly disagree</option>
				</select>

                <p>Trainer was knowledgeable about the subject matter</p>
                <select name ="meaningful_way" class="form-group">
				<option value="Strongly agree">Strongly agree</option>
				<option value="Agree">Agree</option>
				<option value="Disagree">Disagree</option>
                <option value="Strongly disagree">Strongly disagree</option>
				</select>

                <p>Trainer provided clear answers to participant questions.</p>
                <select name ="participant_questions" class="form-group">
				<option value="Strongly agree">Strongly agree</option>
				<option value="Agree">Agree</option>
				<option value="Disagree">Disagree</option>
                <option value="Strongly disagree">Strongly disagree</option>
				</select>

                <p>Trainer promoted engagement and participation</p>
                <select name ="engagement_and_participation" class="form-group">
				<option value="Strongly agree">Strongly agree</option>
				<option value="Agree">Agree</option>
				<option value="Disagree">Disagree</option>
                <option value="Strongly disagree">Strongly disagree</option>
				</select>

            </div>


           <div class="form-group">
           <label for="q4">Trainer 2: Diana Ouma  </label>
                
                <p>Trainer was well prepared</p>
            <select name ="wb_trainer_was_well_prepares" class="form-group">
				<option value="Strongly agree">Strongly agree</option>
				<option value="Agree">Agree</option>
				<option value="Disagree">Disagree</option>
                <option value="Strongly disagree">Strongly disagree</option>
				</select>

                <p>Trainer was knowledgeable about the subject matters</p>
            <select name ="wb_Trainer_was_knowledgeable_about_the_subject_matters" class="form-group">
				<option value="Strongly agree">Strongly agree</option>
				<option value="Agree">Agree</option>
				<option value="Disagree">Disagree</option>
                <option value="Strongly disagree">Strongly disagree</option>
				</select>

                <p>Trainer communicated the material in a meaningful ways</p>
            <select name ="trainer_communicated_the_material_in_a_meaningful_ways" class="form-group">
				<option value="Strongly agree">Strongly agree</option>
				<option value="Agree">Agree</option>
				<option value="Disagree">Disagree</option>
                <option value="Strongly disagree">Strongly disagree</option>
				</select>

                <p>Trainer provided clear answers to participant questions</p>
            <select name ="trainer_provided_clear_answers_to_participant_questions" class="form-group">
				<option value="Strongly agree">Strongly agree</option>
				<option value="Agree">Agree</option>
				<option value="Disagree">Disagree</option>
                <option value="Strongly disagree">Strongly disagree</option>
				</select>
           </div>

           <p>Trainer promoted engagement and participations</p>
            <select name ="trainer_promoted_engagement_and_participations" class="form-group">
				<option value="Strongly agree">Strongly agree</option>
				<option value="Agree">Agree</option>
				<option value="Disagree">Disagree</option>
                <option value="Strongly disagree">Strongly disagree</option>
				</select>
           </div>

           <div class="form-group">
           <label for="what_did_you_like_best_about_the_training">What did you like best about the training?</label><br>
           <textarea id="what_did_you_like_best_about_the_training" name="what_did_you_like_best_about_the_training" rows="5" cols="40" placeholder="Enter your comments here..."></textarea>
           </div>

           <div class="form-group">
           <label for="what_one_thing_could_be_improved_for_future_trainings">What one thing could be improved for future trainings?</label><br>
           <textarea id="what_one_thing_could_be_improved_for_future_trainings" name="what_one_thing_could_be_improved_for_future_trainings" rows="5" cols="40" placeholder="Enter your comments here..."></textarea>
           </div>

           <div class="form-group">
           <label for="what_one_thing_could_be_improved_for_future_trainings">Kindly share any other comments or suggestions you may have with regard to workplace training</label><br>
           <textarea id="what_one_thing_could_be_improved_for_future_trainings" name="what_one_thing_could_be_improved_for_future_trainings" rows="5" cols="40" placeholder="Enter your comments here..."></textarea>
           </div>


            <button type="submit">Submit to DHIS2</button>
        </form>

        <?php if ($success_message): ?>
            <div class="message success">
                <strong>Success!</strong> 
                <?php 
                // Display the success message without the technical details for better UX
                $msg = explode("<br>", "Submitted successfully!");
                echo $msg[0]; 
                ?>
                <div class="response">
                    <?php 
                    // Show the response details in a formatted way
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
</body>
</html>