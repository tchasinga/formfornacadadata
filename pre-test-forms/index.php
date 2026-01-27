<?php
// --- CONFIGURATION --- //
$dhis_url = "https://monitoring.nacada.go.ke/api/programs/RunfUaO1NTk?fields=name,shortName,programStages[id,name,programStageDataElements[dataElement[id,name,formName,code,valueType,optionSet[id,name,options[id,code,name]]]]]";
// DHIS2 credentials
$username = "admin";
$password = "Jocsoft@2025!";

// --- STEP 1: Fetch program structure --- //
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $dhis_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$program = "RunfUaO1NTk";
$programStage = $data['programStages'][0]['id'] ?? null; // assuming one stage

// --- STEP 2: Flatten and shuffle all questions --- //
$questions = [];

$hiddenDataElements = [
    'M8uqWJQDlny', // Q1_score
    'vkdwQj4nflz', // Q2_score
    'zBEodaOvhZG',   // Q3_score 
    'kq5FoiLyrWs',   // Q4_score
    'BPSRxSP1Yr5',   // Q5_score  	
	'y4wlBAmUTgB', //Q6_score 
	'FlJdPFXlyr6', //Q7_score
    'm3H6N3M69BQ', //Q8_score
    'LzbhdsDHUk4', //Q9_score 
    'vVBauf6F71b', //Q10_score	
	'rIRfnEBVFFt', //Q11_score
	'FvfuyzPzKqy', //Q12_score
	'lyoxY7Ll9WS', //Total_score
];

foreach ($data['programStages'] as $stage) {
    foreach ($stage['programStageDataElements'] as $psde) {

        $de = $psde['dataElement'];

        // Skip hidden data elements
        if (in_array($de['id'], $hiddenDataElements, true)) {
            continue;
        }

        $questions[] = $de;
    }
}

// Shuffle the order of questions
shuffle($questions);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($data['shortName'] ?? 'Test') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .quiz-container {
            max-width: 700px;
            margin: 40px auto;
        }
        .question-label {
            font-weight: 600;
            color: #333;
        }
        .card {
            border-radius: 15px;
        }
    </style>
</head>

<body>
<div class="container quiz-container">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0"><?= htmlspecialchars($data['shortName']) ?></h4>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <?php
                $qNumber = 1;
                foreach ($questions as $q) {
                    $id = htmlspecialchars($q['id']);
                    $label = htmlspecialchars($q['formName'] ?? $q['name']);
                    $valueType = $q['valueType'];

                    echo "<div class='mb-4'>";
                    echo "<label class='form-label question-label'>{$qNumber}. $label</label>";

                    // --- Shuffle options if available --- //
                    if (isset($q['optionSet'])) {
                        $options = $q['optionSet']['options'];
                        shuffle($options); // randomize the options
                        
                        echo "<select class='form-select mt-2' name='answers[$id]' required>";
                        echo "<option value=''>-- Select Option --</option>";
                        foreach ($options as $opt) {
                            $val = htmlspecialchars($opt['code']);
                            $name = htmlspecialchars($opt['name']);
                            echo "<option value='$val'>$name</option>";
                        }
                        echo "</select>";
                    } else {
                        $type = ($valueType == 'NUMBER') ? 'number' : 'text';
                        echo "<input type='$type' class='form-control mt-2' name='answers[$id]' placeholder='Enter answer' required>";
                    }

                    echo "</div>";
                    $qNumber++;
                }
                ?>
                <div class="text-center mt-4">
                    <button type="submit" name="submit" class="btn btn-success btn-lg px-5">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-3">
        <?php
        // --- STEP 3: Handle form submission --- //
        if (isset($_POST['submit'])) {
            $answers = $_POST['answers'] ?? [];

            // Prepare Tracker payload
            $payload = [
                "events" => [[
                    "program" => $program,
                    "programStage" => $programStage,
                    "orgUnit" => "ORwhnDymBpM", // <-- Replace with your orgUnit ID
                    "occurredAt" => date("c"),
                    "dataValues" => []
                ]]
            ];

            foreach ($answers as $deId => $value) {
                if (trim($value) !== "") {
                    $payload["events"][0]["dataValues"][] = [
                        "dataElement" => $deId,
                        "value" => $value
                    ];
                }
            }

            // Send data to Tracker API
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://monitoring.nacada.go.ke/api/tracker");
            curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
            $result = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($status == 200 || $status == 201) {
                echo "<div class='alert alert-success text-center mt-3'>Quiz submitted successfully!</div>";
            } else {
                echo "<div class='alert alert-danger mt-3'><strong>Failed to submit!</strong><br>HTTP $status<br><pre>$result</pre></div>";
            }
        }
        ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
