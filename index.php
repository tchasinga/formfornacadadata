<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DHIS2 Tracked Entity Enrollment</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7f9;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            text-align: center;
            color: #2c6593;
            margin-bottom: 20px;
        }
        
        .description {
            text-align: center;
            margin-bottom: 30px;
            color: #666;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c6593;
        }
        
        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s;
        }
        
        input[type="text"]:focus,
        input[type="date"]:focus {
            border-color: #2c6593;
            outline: none;
        }
        
        button {
            background-color: #2c6593;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: #1c4a73;
        }
        
        .response {
            margin-top: 30px;
            padding: 15px;
            border-radius: 5px;
            display: none;
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
        
        .loading {
            display: none;
            text-align: center;
            margin-top: 20px;
        }
        
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #2c6593;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .info-box {
            background-color: #e8f4fc;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>DHIS2 Tracked Entity Enrollment</h1>
        <p class="description">Submit data to the collectingthosedata program</p>
        
        <div class="info-box">
            <strong>API Information:</strong><br>
            Program: collectingthosedata (PgKF7mXlZe0)<br>
            Tracked Entity: trackdatacollector (ad6uk49xve7)<br>
            Org Unit: ORwhnDymBpM
        </div>
        
        <form id="enrollmentForm">
            <div class="form-group">
                <label for="fullName">Full Name *</label>
                <input type="text" id="fullName" name="fullName" required placeholder="Enter full name">
            </div>
            
            <div class="form-group">
                <label for="enrollmentDate">Enrollment Date *</label>
                <input type="date" id="enrollmentDate" name="enrollmentDate" required>
            </div>
            
            <div class="form-group">
                <label for="occurredDate">Occurred Date *</label>
                <input type="date" id="occurredDate" name="occurredDate" required>
            </div>
            
            <button type="submit">Submit Enrollment</button>
        </form>
        
        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p>Submitting data to DHIS2...</p>
        </div>
        
        <div class="response" id="response"></div>
    </div>

    <script>
        document.getElementById('enrollmentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading indicator
            document.getElementById('loading').style.display = 'block';
            document.getElementById('response').style.display = 'none';
            
            // Get form values
            const fullName = document.getElementById('fullName').value;
            const enrollmentDate = document.getElementById('enrollmentDate').value;
            const occurredDate = document.getElementById('occurredDate').value;
            
            // Current date for enrolledAt and scheduledAt
            const now = new Date().toISOString();
            
            // Prepare the payload for DHIS2 API
            const payload = {
                "trackedEntities": [
                    {
                        "enrollments": [
                            {
                                "attributes": [
                                    {
                                        "attribute": "v7FLq8y7EMu", // Full Name attribute
                                        "value": fullName
                                    }
                                ],
                                "enrolledAt": enrollmentDate + "T00:00:00.000",
                                "occurredAt": occurredDate + "T00:00:00.000",
                                "orgUnit": "ORwhnDymBpM",
                                "program": "PgKF7mXlZe0", // collectingthosedata program
                                "status": "ACTIVE"
                            }
                        ],
                        "events": [
                            
                        ]
                        "orgUnit": "ORwhnDymBpM",
                        "trackedEntityType": "ad6uk49xve7" // trackdatacollector entity
                    }
                ]
            };
            
            // PHP proxy endpoint to handle the API request
            fetch('submit_enrollment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                // Hide loading indicator
                document.getElementById('loading').style.display = 'none';
                
                const responseDiv = document.getElementById('response');
                responseDiv.style.display = 'block';
                
                if (data.status === 'success') {
                    responseDiv.className = 'response success';
                    responseDiv.innerHTML = `<strong>Success!</strong> Enrollment created successfully. Response: ${data.message}`;
                    
                    // Reset form
                    document.getElementById('enrollmentForm').reset();
                } else {
                    responseDiv.className = 'response error';
                    responseDiv.innerHTML = `<strong>Error!</strong> ${data.message}`;
                }
            })
            .catch(error => {
                document.getElementById('loading').style.display = 'none';
                
                const responseDiv = document.getElementById('response');
                responseDiv.style.display = 'block';
                responseDiv.className = 'response error';
                responseDiv.innerHTML = `<strong>Error!</strong> ${error.message}`;
            });
        });
        
        // Set default dates to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('enrollmentDate').value = today;
        document.getElementById('occurredDate').value = today;
    </script>
</body>
</html>