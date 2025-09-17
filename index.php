<?php
// DHIS2 API configuration
$dhis2Url = 'https://your-dhis2-instance.com/api/';
$username = 'your-username';
$password = 'your-password';

// Function to send data to DHIS2
function sendToDHIS2($dataValueSet, $url, $username, $password) {
    $jsonData = json_encode($dataValueSet);
    
    $ch = curl_init($url . 'dataValueSets');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonData))
    );
    
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return array('code' => $httpCode, 'response' => $result);
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataValueSet = array(
        'dataSet' => $_POST['dataSet'],
        'completeDate' => $_POST['completeDate'],
        'period' => $_POST['period'],
        'orgUnit' => $_POST['orgUnit'],
        'dataValues' => array()
    );
    
    // Add data values (simplified example)
    if (!empty($_POST['dataValues'])) {
        foreach ($_POST['dataValues'] as $dataValue) {
            $dataValueSet['dataValues'][] = array(
                'dataElement' => $dataValue['dataElement'],
                'categoryOptionCombo' => $dataValue['categoryOptionCombo'],
                'value' => $dataValue['value']
            );
        }
    }
    
    // Send to DHIS2
    $result = sendToDHIS2($dataValueSet, $dhis2Url, $username, $password);
    
    if ($result['code'] == 200) {
        $message = "Data successfully submitted to DHIS2!";
        $messageType = "success";
    } else {
        $message = "Error submitting data: " . $result['response'];
        $messageType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DHIS2 Data Collection Form</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        header {
            background-color: #2c6b9e;
            color: white;
            padding: 1rem;
            text-align: center;
            border-radius: 5px 5px 0 0;
            margin-bottom: 20px;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            background-color: #2c6b9e;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 10px;
        }
        button:hover {
            background-color: #1c5585;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .data-value {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 15px;
            border-left: 4px solid #2c6b9e;
        }
        .add-btn {
            background-color: #28a745;
            width: auto;
            margin-bottom: 15px;
        }
        .add-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>DHIS2 Data Collection Form</h1>
            <p>Submit data to your DHIS2 instance</p>
        </header>

        <div class="form-container">
            <?php if (isset($message)): ?>
                <div class="message <?php echo $messageType; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="dataSet">Data Set ID</label>
                    <input type="text" id="dataSet" name="dataSet" required placeholder="Enter data set ID">
                </div>

                <div class="form-group">
                    <label for="period">Period</label>
                    <input type="text" id="period" name="period" required placeholder="e.g., 202301">
                </div>

                <div class="form-group">
                    <label for="orgUnit">Organization Unit ID</label>
                    <input type="text" id="orgUnit" name="orgUnit" required placeholder="Enter org unit ID">
                </div>

                <div class="form-group">
                    <label for="completeDate">Completion Date</label>
                    <input type="date" id="completeDate" name="completeDate" required>
                </div>

                <h3>Data Values</h3>
                <div id="dataValuesContainer">
                    <div class="data-value">
                        <div class="form-group">
                            <label>Data Element ID</label>
                            <input type="text" name="dataValues[0][dataElement]" required placeholder="Enter data element ID">
                        </div>
                        <div class="form-group">
                            <label>Category Option Combo ID</label>
                            <input type="text" name="dataValues[0][categoryOptionCombo]" required placeholder="Enter category option combo ID">
                        </div>
                        <div class="form-group">
                            <label>Value</label>
                            <input type="text" name="dataValues[0][value]" required placeholder="Enter value">
                        </div>
                    </div>
                </div>

                <button type="button" class="add-btn" id="addDataValue">+ Add Another Data Value</button>

                <button type="submit">Submit to DHIS2</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let dataValueCount = 1;
            
            document.getElementById('addDataValue').addEventListener('click', function() {
                const container = document.getElementById('dataValuesContainer');
                const newDataValue = document.createElement('div');
                newDataValue.className = 'data-value';
                newDataValue.innerHTML = `
                    <div class="form-group">
                        <label>Data Element ID</label>
                        <input type="text" name="dataValues[${dataValueCount}][dataElement]" required placeholder="Enter data element ID">
                    </div>
                    <div class="form-group">
                        <label>Category Option Combo ID</label>
                        <input type="text" name="dataValues[${dataValueCount}][categoryOptionCombo]" required placeholder="Enter category option combo ID">
                    </div>
                    <div class="form-group">
                        <label>Value</label>
                        <input type="text" name="dataValues[${dataValueCount}][value]" required placeholder="Enter value">
                    </div>
                `;
                container.appendChild(newDataValue);
                dataValueCount++;
            });
        });
    </script>
</body>
</html>