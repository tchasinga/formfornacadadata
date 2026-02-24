<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$success_message = "";
$error_message = "";

// API credentials: collects family therapy feedback data and submits to DHIS2.
$url = "https://monitoring.nacada.go.ke/api/tracker";
$username = "jack";
$password = "Jocsoft@2027!!";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_name = trim($_POST['client_name'] ?? '');

    if ($client_name !== '') {
        $primary_counsellor = trim($_POST['primary_counsellor'] ?? '');
        $date_of_session = trim($_POST['date_of_session'] ?? '');
        $time_of_session = trim($_POST['time_of_session'] ?? '');
        $family_member_guardian_present = trim($_POST['family_member_guardian_present'] ?? '');
        $relationship_to_client = trim($_POST['relationship_to_client'] ?? '');
        $ftf_signature = trim($_POST['ftf_signature'] ?? '');

        // Topics discussed (tick = Yes, untick = No)
        $disease_concept = isset($_POST['disease_concept']) ? 'Yes' : 'No';
        $treatment_and_recovery = isset($_POST['treatment_and_recovery']) ? 'Yes' : 'No';
        $family_disease = isset($_POST['family_disease']) ? 'Yes' : 'No';
        $comorbidity_and_accompanying_medications = isset($_POST['comorbidity_and_accompanying_medications']) ? 'Yes' : 'No';
        $outstanding_fees = isset($_POST['outstanding_fees']) ? 'Yes' : 'No';
        $exit_planning = isset($_POST['exit_planning']) ? 'Yes' : 'No';
        $relapse_prevention = isset($_POST['relapse_prevention']) ? 'Yes' : 'No';

        $dataValues = [
            ["dataElement" => "QElcG47fh8W", "value" => $client_name],
            ["dataElement" => "xlnWeFVVOiw", "value" => $primary_counsellor],
            ["dataElement" => "ERXeMahTsJr", "value" => $date_of_session],
            ["dataElement" => "LmZiUmetPFo", "value" => $time_of_session],
            ["dataElement" => "U1EsNSeR8Bv", "value" => $family_member_guardian_present],
            ["dataElement" => "hIr47tAH2IQ", "value" => $relationship_to_client],
            ["dataElement" => "nPmLEXAO0gj", "value" => $ftf_signature],
            ["dataElement" => "XCZRevcsUkI", "value" => $disease_concept],
            ["dataElement" => "iop317yRMfv", "value" => $treatment_and_recovery],
            ["dataElement" => "YE6g9IOHIf3", "value" => $family_disease],
            ["dataElement" => "A12HBRywSlB", "value" => $comorbidity_and_accompanying_medications],
            ["dataElement" => "xU5yqOol19I", "value" => $outstanding_fees],
            ["dataElement" => "dVZarDYVsZm", "value" => $exit_planning],
            ["dataElement" => "P14QMpHcMVz", "value" => $relapse_prevention],
        ];

        // Filter out empty text values so we don't send empty strings for optional fields
        $dataValues = array_filter($dataValues, function ($dv) {
            return $dv["value"] !== '';
        });

        $payload = [
            "events" => [[
                "program" => 'MhqA6j3Iumo',
                "orgUnit" => 'ORwhnDymBpM',
                "occurredAt" => date("c"),
                "dataValues" => array_values($dataValues)
            ]]
        ];

        $jsonData = json_encode($payload);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Content-Length: " . strlen($jsonData)
        ]);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error_message = "Connection error: " . curl_error($ch);
        } elseif ($httpcode >= 200 && $httpcode < 300) {
            $success_message = "Family therapy feedback submitted successfully.";
        } else {
            $error_message = "Submission failed (HTTP $httpcode). " . $response;
        }

        curl_close($ch);
    } else {
        $error_message = "Please enter the client name.";
    }
}

$post = $_POST ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Therapy Feedback Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-2xl mx-auto px-4">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Family Therapy Feedback Form</h1>

        <?php if ($success_message): ?>
            <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800"><?= htmlspecialchars($success_message) ?></div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>

        <form method="post" class="bg-white rounded-xl shadow-md p-6 space-y-6">
            <div>
                <label for="client_name" class="block text-sm font-medium text-gray-700 mb-1">Client name <span class="text-red-500">*</span></label>
                <input type="text" name="client_name" id="client_name" required
                    value="<?= htmlspecialchars($post['client_name'] ?? '') ?>"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            </div>

            <div>
                <label for="primary_counsellor" class="block text-sm font-medium text-gray-700 mb-1">Primary counsellor</label>
                <input type="text" name="primary_counsellor" id="primary_counsellor"
                    value="<?= htmlspecialchars($post['primary_counsellor'] ?? '') ?>"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="date_of_session" class="block text-sm font-medium text-gray-700 mb-1">Date of session</label>
                    <input type="date" name="date_of_session" id="date_of_session"
                        value="<?= htmlspecialchars($post['date_of_session'] ?? '') ?>"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div>
                    <label for="time_of_session" class="block text-sm font-medium text-gray-700 mb-1">Time of session</label>
                    <input type="time" name="time_of_session" id="time_of_session"
                        value="<?= htmlspecialchars($post['time_of_session'] ?? '') ?>"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>
            </div>

            <div>
                <label for="family_member_guardian_present" class="block text-sm font-medium text-gray-700 mb-1">Family member / guardian present</label>
                <input type="text" name="family_member_guardian_present" id="family_member_guardian_present"
                    value="<?= htmlspecialchars($post['family_member_guardian_present'] ?? '') ?>"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            </div>

            <div>
                <label for="relationship_to_client" class="block text-sm font-medium text-gray-700 mb-1">Relationship to client</label>
                <input type="text" name="relationship_to_client" id="relationship_to_client"
                    value="<?= htmlspecialchars($post['relationship_to_client'] ?? '') ?>"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            </div>

            <div>
                <label for="ftf_signature" class="block text-sm font-medium text-gray-700 mb-1">FTF signature</label>
                <input type="text" name="ftf_signature" id="ftf_signature"
                    value="<?= htmlspecialchars($post['ftf_signature'] ?? '') ?>"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
            </div>

            <div class="border-t border-gray-200 pt-6">
                <h2 class="text-lg font-medium text-gray-800 mb-3">Topics discussed in session (tick if fully completed)</h2>
                <div class="space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="disease_concept" value="1" <?= !empty($post['disease_concept']) ? 'checked' : '' ?>
                            class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                        <span class="text-gray-700">Disease concept</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="treatment_and_recovery" value="1" <?= !empty($post['treatment_and_recovery']) ? 'checked' : '' ?>
                            class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                        <span class="text-gray-700">Treatment and recovery</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="family_disease" value="1" <?= !empty($post['family_disease']) ? 'checked' : '' ?>
                            class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                        <span class="text-gray-700">Family disease</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="comorbidity_and_accompanying_medications" value="1" <?= !empty($post['comorbidity_and_accompanying_medications']) ? 'checked' : '' ?>
                            class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                        <span class="text-gray-700">Comorbidity and accompanying medications</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="outstanding_fees" value="1" <?= !empty($post['outstanding_fees']) ? 'checked' : '' ?>
                            class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                        <span class="text-gray-700">Outstanding fees</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="exit_planning" value="1" <?= !empty($post['exit_planning']) ? 'checked' : '' ?>
                            class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                        <span class="text-gray-700">Exit planning</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="relapse_prevention" value="1" <?= !empty($post['relapse_prevention']) ? 'checked' : '' ?>
                            class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                        <span class="text-gray-700">Relapse prevention</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-4 rounded-lg">
                Submit feedback
            </button>
        </form>
    </div>
</body>
</html>
