<?php
// DHIS2 Configuration
$dhis2Config = [
    'baseUrl' => 'https://monitoring.jocsoft.net/dhis/',
    'username' => 'jack',
    'password' => 'Jocsoft@2027!!',
    'trackedEntityType' => 'RjKhXS9Dmp3', // mytracking01
    'orgUnit' => 'ORwhnDymBpM',
    'attributeId' => 'aF3JppzS7kO' // testing-names
];

// Function to make API calls to DHIS2
function callDhis2Api($url, $data = null, $method = 'POST') {
    global $dhis2Config;
    
    $ch = curl_init();
    $fullUrl = $dhis2Config['baseUrl'] . 'api/' . $url;
    
    curl_setopt($ch, CURLOPT_URL, $fullUrl);
    curl_setopt($ch, CURLOPT_USERPWD, $dhis2Config['username'] . ":" . $dhis2Config['password']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($data))
            ]);
        }
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'code' => $httpCode,
        'response' => json_decode($response, true),
        'raw' => $response
    ];
}

// Handle form submission
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['testing_names'])) {
    $testingNames = trim($_POST['testing_names']);
    
    if (!empty($testingNames)) {
        // Prepare the data for DHIS2 API
        $teiData = [
            'trackedEntityType' => $dhis2Config['trackedEntityType'],
            'orgUnit' => $dhis2Config['orgUnit'],
            'attributes' => [
                [
                    'attribute' => $dhis2Config['attributeId'],
                    'value' => $testingNames
                ]
            ]
        ];
        
        // Make API call to create tracked entity instance
        $result = callDhis2Api('trackedEntityInstances', $teiData);
        
        if ($result['code'] === 201) {
            $message = "Successfully created tracked entity instance!";
            $messageType = "success";
        } else {
            $message = "Error creating tracked entity instance. HTTP Code: " . $result['code'];
            if (isset($result['response']['message'])) {
                $message .= " - " . $result['response']['message'];
            }
            $messageType = "error";
        }
    } else {
        $message = "Please enter a value for testing names.";
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DHIS2 - Create Tracked Entity Instance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #34495e;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        button {
            background-color: #3498db;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        
        button:hover {
            background-color: #2980b9;
        }
        
        .message {
            padding: 15px;
            margin: 20px 0;
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
        
        .info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create Tracked Entity Instance</h1>
        
        <?php if (!empty($message)): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="testing_names">Testing Names:</label>
                <input type="text" id="testing_names" name="testing_names" 
                       placeholder="Enter testing names" required
                       value="<?php echo isset($_POST['testing_names']) ? htmlspecialchars($_POST['testing_names']) : ''; ?>">
            </div>
            
            <button type="submit">Submit to DHIS2</button>
        </form>
        
        <div class="message info">
            <strong>Program:</strong> dataexamplecollection (FkmngCuxM1Z)<br>
            <strong>Tracked Entity:</strong> mytracking01 (RjKhXS9Dmp3)<br>
            <strong>Organization Unit:</strong> ORwhnDymBpM
        </div>
    </div>
</body>
</html>