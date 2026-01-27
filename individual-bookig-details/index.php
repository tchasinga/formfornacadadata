<?php
// --- API CONFIG --- //
$programId = "pxfOMnBkko3"; // Program ID
$dhis_url = "https://monitoring.nacada.go.ke/api/programs/$programId?fields=name,shortName,programStages[id,name,programStageDataElements[dataElement[id,name,formName,valueType,optionSet[id,name,options[id,code,name]]]]]";

// Login credentials
$username = "admin";
$password = "Jocsoft@2025!";

// --- Fetch program structure --- //
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $dhis_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERPWD => "$username:$password",
]);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$programStage = $data['programStages'][0]['id'] ?? null;
$dataelements = [];

if (!empty($data['programStages'][0]['programStageDataElements'])) {
    foreach ($data['programStages'][0]['programStageDataElements'] as $psde) {
        $dataelements[] = $psde['dataElement'];
    }
}

// --- STEP Fetch Organisation Units --- //
$orgunit_url = "https://monitoring.nacada.go.ke/api/organisationUnits?level=2&paging=false&fields=id,name";
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $orgunit_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERPWD => "$username:$password",
]);
$org_response = curl_exec($ch);
curl_close($ch);

$org_data = json_decode($org_response, true);
$org_units = $org_data['organisationUnits'] ?? [];

//Function to poll DHIS2 until file is STORED
function pollFileResourceReady($fileUrl, $fileResourceId, $username, $password, $timeoutSeconds = 30, $intervalMs = 500) {
    $deadline = microtime(true) + $timeoutSeconds;
    $lastStatus = null;
    while (microtime(true) < $deadline) {
        $chPoll = curl_init($fileUrl . "/" . urlencode($fileResourceId) . "?fields=id,storageStatus");
        curl_setopt($chPoll, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chPoll, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($chPoll, CURLOPT_USERPWD, "$username:$password");
        $pollResponse = curl_exec($chPoll);
        $httpPoll = curl_getinfo($chPoll, CURLINFO_HTTP_CODE);
        curl_close($chPoll);

        if ($httpPoll == 200 && $pollResponse) {
            $pollData = json_decode($pollResponse, true);
            $lastStatus = $pollData['storageStatus'] ?? null;
            if ($lastStatus === 'STORED') {
                return true;
            }
        }
        usleep($intervalMs * 1000);
    }
    return false;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($data['shortName'] ?? 'Individual Training Booking') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .booking-container {
            max-width: 1000px;
            margin: 40px auto;
        }
        .card {
            border-radius: 15px;
        }
        .form-label {
            font-weight: 600;
            color: #333;
        }
        .hidden {
            display: none;
        }
    </style>
</head>

<body>
<div class="container booking-container">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0"><?= htmlspecialchars($data['shortName'] ?? 'Individual Booking') ?></h4>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <!-- Organisation County -->
				<div class="row">
                <div class="col-md-6 mb-4">
                   <label class="form-label">Select County</label>
                    <select class="form-select" name="orgUnit" required>
                        <option value="">-- Select County --</option>
                        <?php foreach ($org_units as $org): 
                            if ($org['id'] === 'QxehsVZTUlH') continue; 
                        ?>
                            <option value="<?= htmlspecialchars($org['id']) ?>">
                                <?= htmlspecialchars($org['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
				</div>

                <div class="row">
                    <?php
                    $qNumber = 1;
                    foreach ($dataelements as $q) {
                        $id = htmlspecialchars($q['id']);
                        $label = htmlspecialchars($q['formName'] ?? $q['name']);
                        $valueType = $q['valueType'];

                        echo "<div class='col-md-6 mb-4' id='field_$id'>";
                        echo "<label class='form-label'>$label</label>";

                        if ($id === "pJxxjthNFNX") { // Payment Status
                            echo "<select class='form-select mt-2' name='answers[$id]' id='paymentStatus' required>
                                    <option value=''>-- Select Option --</option>
                                    <option value='Yes'>Yes</option>
                                    <option value='No'>No</option>
                                  </select>";
                        } elseif (isset($q['optionSet'])) {
                            echo "<select class='form-select mt-2' name='answers[$id]' required>";
                            echo "<option value=''>-- Select Option --</option>";
                            foreach ($q['optionSet']['options'] as $opt) {
                                $val = htmlspecialchars($opt['code']);
                                $name = htmlspecialchars($opt['name']);
                                echo "<option value='$val'>$name</option>";
                            }
                            echo "</select>";
                        } elseif ($id === "vPSf29ehYN3") { 
                            echo "<input type='file' class='form-control mt-2 hidden' name='answers[$id]' id='paymentInvoice'>";
                        } else {
                            $inputType = 'text';
                            if ($valueType === 'NUMBER') $inputType = 'number';
                            if ($valueType === 'DATE') $inputType = 'date';
                            if ($valueType === 'EMAIL') $inputType = 'email';

                            echo "<input type='$inputType' class='form-control mt-2' name='answers[$id]' placeholder='Enter $label' required>";
                        }

                        echo "</div>";
                        $qNumber++;
                    }
                    ?>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" name="submit" class="btn btn-success btn-lg px-5">Submit Booking</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-3">
        <?php
        // --- Handle Submission --- //
if (isset($_POST['submit'])) {
    $answers = $_POST['answers'] ?? [];
    $orgUnit = $_POST['orgUnit'] ?? '';
	
	
	

    if (empty($orgUnit)) {
        echo "<div class='alert alert-warning text-center mt-3'>Please select county</div>";
    } else {

        $payment_status = $answers['pJxxjthNFNX'] ?? ''; // Payment Status
        $fileResourceId = null;
        $fileUrl = "https://monitoring.nacada.go.ke/api/fileResources";

        // If payment_status is Yes, upload receipt file
        if ($payment_status === "Yes" && isset($_FILES['answers']['name']['vPSf29ehYN3']) && $_FILES['answers']['error']['vPSf29ehYN3'] === 0) {
            $fileTmpPath = $_FILES['answers']['tmp_name']['vPSf29ehYN3'];
            $fileName = $_FILES['answers']['name']['vPSf29ehYN3'];
            $fileMime = $_FILES['answers']['type']['vPSf29ehYN3'];

            $ch = curl_init($fileUrl);
            curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                'file' => new CURLFile($fileTmpPath, $fileMime, $fileName)
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $uploadResponse = curl_exec($ch);
            $uploadHttp = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $uploadData = json_decode($uploadResponse, true);
            if (($uploadHttp == 200 || $uploadHttp == 201 || $uploadHttp == 202) && isset($uploadData['response']['fileResource']['id'])) {
                $fileResourceId = $uploadData['response']['fileResource']['id'];
                $initialStatus = $uploadData['response']['fileResource']['storageStatus'] ?? null;
                if ($initialStatus !== 'STORED') {
                    pollFileResourceReady($fileUrl, $fileResourceId, $username, $password, 30, 500);
                }
            } else {
                echo "<div class='alert alert-warning mt-3'>File upload failed. HTTP $uploadHttp<br><pre>$uploadResponse</pre></div>";
            }
        }
		
		
         //echo json_encode($answers);

        $payload = [
            "events" => [[
                "program" => $programId,
                "programStage" => $programStage,
                "orgUnit" => $orgUnit,
                "occurredAt" => date("c"),
                "dataValues" => []
            ]]
        ];

        foreach ($answers as $deId => $value) {
            if ($deId === "vPSf29ehYN3" && $fileResourceId) {
                //Replace value with file resource ID for Payment Receipt
                $payload["events"][0]["dataValues"][] = [
                    "dataElement" => $deId,
                    "value" => $fileResourceId
                ];
            } elseif (trim($value) !== "") {
                $payload["events"][0]["dataValues"][] = [
                    "dataElement" => $deId,
                    "value" => $value
                ];
            }
        }
         //echo json_encode($payload);
		// die();
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
            echo "<div class='alert alert-success text-center mt-3'>Booking submitted successfully!</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'><strong>Failed to submit!</strong><br>HTTP $status<br><pre>$result</pre></div>";
        }
    }
}

        ?>
    </div>
</div>

<script>
document.getElementById('paymentStatus')?.addEventListener('change', function() {
    const fileField = document.getElementById('paymentInvoice');
    if (this.value === 'Yes') {
        fileField.classList.remove('hidden');
        fileField.setAttribute('required', 'required');
    } else {
        fileField.classList.add('hidden');
        fileField.removeAttribute('required');
        fileField.value = '';
    }
});
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
