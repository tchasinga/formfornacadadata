<?php
if (isset($_POST['submit'])) {
	
	   $dataElementMap = [
        "institution"       => "HfZLjC3F1HH",
        "summary"           => "a2MF2P8J7xu",
        "method"            => "E665cwDEa9g",
        "applicant"         => "wwy9f0PzK1h",
        "postal"            => "YyXldtJh5qL",
        "physical_address"  => "q5hZw0LCC5d",
        "telephone"         => "zhvWaH90wBn"
    ];
  
        $payload = [
            "events" => [[
                "program" => 'srIkklwqECM',
                "programStage" => 'bDQGpT6AYTc',
                "orgUnit" => 'ORwhnDymBpM',
                "occurredAt" => date("c"),
                "dataValues" => []
            ]]
        ];

        //Build dataValues dynamically from POST
			foreach ($dataElementMap as $postKey => $deId) {
				if (!empty($_POST[$postKey])) {
					$payload["events"][0]["dataValues"][] = [
						"dataElement" => $deId,
						"value"       => trim($_POST[$postKey])
					];
				}
			}
         //echo json_encode($payload);
		 $username='admin';
		 $password='Jocsoft@2025!';
        // Send to Tracker API
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => "https://monitoring.nacada.go.ke/api/tracker",
            CURLOPT_USERPWD => "$username:$password",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ["Content-Type: application/json"]
        ]);
        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (in_array($status, [200, 201])) {
            echo "<div class='alert alert-success text-center mt-3'>Request submitted successfully!</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'><strong>Failed to submit!</strong><br>HTTP $status<br><pre>$result</pre></div>";
        }
    }


        ?>
<!DOCTYPE html>
<html>
<head>
    <title>Access to Information Request Form</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { background: #fff; padding: 25px; border-radius: 6px; max-width: 900px; margin: auto; }
        h2 { text-align: center; }
        .step-box { background: #eef3fb; padding: 10px; border-left: 5px solid #0056b3; margin-bottom: 20px; }
        label { font-weight: bold; display: block; margin-top: 15px; }
        input[type="text"], textarea { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .row { display: flex; gap: 20px; }
        .row div { flex: 1; }
        button { background: #0056b3; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; margin-top: 20px; cursor: pointer; }
        button:hover { background: #003d80; }
    </style>
</head>
<body>

<div class="container">
    <h2>ACCESS TO INFORMATION REQUEST FORM</h2>

    <!-- STEPS INFORMATION -->
    <div class="step-box">
        <strong>STEP 1:</strong> Decide if you need to make an informal request or a formal request under the Access to Information Act 2016.  
        If it’s an informal request, send your request to <strong>info@nacada.go.ke</strong>.
    </div>
    <div class="step-box">
        <strong>STEP 2:</strong> If you need to make a formal request under the Act, complete this form or a written request mentioning the Act.  
        Describe the information being sought in detail to help NACADA locate it.
    </div>
    <div class="step-box">
        <strong>STEP 3:</strong> Forward the access request to the NACADA Information Access Officer (CEO).  
        Email: <strong>info@nacada.go.ke</strong>.  
        You may be asked to pay charges depending on the nature or amount of information requested.
    </div>
    <div class="step-box">
        <strong>STEP 4:</strong> After receiving the response, you may request further information or submit a complaint  
        if you believe your rights under the Access to Information Act, 2016 have been violated.
    </div>

    <!-- FORM -->
    <form action="index.php" method="POST">
        
        <label>Government Institution:</label>
        <input type="text" name="institution" required>

        <label>Summary of the information being sought and purpose:</label>
        <textarea name="summary" rows="4" required></textarea>

        <label>Method of access preferred:</label>
        <input type="text" name="method" placeholder="e.g. Receive copies, examine originals" required>

        <div class="row">
            <div>
                <label>Name of the Applicant:</label>
                <input type="text" name="applicant" required>
            </div>
        </div>

        <div class="row">
            <div>
                <label>Postal Address:</label>
                <input type="text" name="postal">
            </div>
           
        </div>

        <label>Physical Address:</label>
        <input type="text" name="physical_address">

        <label>Telephone No.:</label>
        <input type="text" name="telephone">

    

        <button type="submit" name="submit">Submit Request</button>
    </form>
</div>

</body>
</html>
