<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose One Form to Apply For</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .service-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .service-card:hover {
            transform: translateY(-8px);
        }
        .service-card:hover .card-icon {
            transform: scale(1.1);
        }
        .card-icon {
            transition: transform 0.3s ease;
        }
       
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="bg-gradient-to-br from-[#014F5B] to-[#0A7C8A] text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2>Public Awareness and Advocacy, Public Education and capacity development Templates </h2>
        </div>
    </div>

    <!-- Services Grid -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Bi-Annual Drug Prevention Report -->
            <div class="service-card bg-white rounded-xl shadow-lg p-6 border border-gray-100" onclick="navigateToService('bi_annuald_drug_prevention')">
                <div class="text-center">
                    <div class="card-icon text-4xl text-blue-600 mb-4">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Public Awareness and advocacy- Bi-Annual Drug Use Prevention Report</h3>
                    <p class="text-gray-600 text-sm mb-4">Submit bi-annual reports on drug prevention activities, organizational details, and intervention outcomes.</p>
                    <div class="inline-flex items-center text-blue-600 font-medium">
                        <span class="mr-2">View Form</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>

            <!-- Employee Assistance Program -->
            <div class="service-card bg-white rounded-xl shadow-lg p-6 border border-gray-100" onclick="navigateToService('employee_assistance_program_monitoring_form')">
                <div class="text-center">
                    <div class="card-icon text-4xl text-green-600 mb-4">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Public Education and capacity development - Employee Assistance Program</h3>
                    <p class="text-gray-600 text-sm mb-4">Monitor and track employee assistance programs, referrals, counseling services, and workplace wellness initiatives.</p>
                    <div class="inline-flex items-center text-green-600 font-medium">
                        <span class="mr-2">View Form</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>

            <!-- Annual Work Plan Format -->
            <div class="service-card bg-white rounded-xl shadow-lg p-6 border border-gray-100" onclick="navigateToService('access_to_information_form')">
                <div class="text-center">
                    <div class="card-icon text-4xl text-purple-600 mb-4">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Access to Information Request Form</h3>
                    <p class="text-gray-600 text-sm mb-4">This form enables members of the public to formally request access to information held by NACADA, in accordance with the Access to Information Act, 2016.</p>
                    <div class="inline-flex items-center text-purple-600 font-medium">
                        <span class="mr-2">View Form</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>

            <!-- Individual Booking Details -->
            <div class="service-card bg-white rounded-xl shadow-lg p-6 border border-gray-100" onclick="navigateToService('individual-bookig-details')">
                <div class="text-center">
                    <div class="card-icon text-4xl text-orange-600 mb-4">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Public Education and capacity development - Individual Training Booking</h3>
                    <p class="text-gray-600 text-sm mb-4">Book individual training sessions with participant details, payment information, and training requirements.</p>
                    <div class="inline-flex items-center text-orange-600 font-medium">
                        <span class="mr-2">View Form</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>

            <!-- Organization/Group Booking -->
            <div class="service-card bg-white rounded-xl shadow-lg p-6 border border-gray-100" onclick="navigateToService('organization-group-booking-details')">
                <div class="text-center">
                    <div class="card-icon text-4xl text-red-600 mb-4">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Public Education and capacity development - Organization Training Booking</h3>
                    <p class="text-gray-600 text-sm mb-4">Book group training sessions for organizations with participant lists, contact details, and payment options.</p>
                    <div class="inline-flex items-center text-red-600 font-medium">
                        <span class="mr-2">View Form</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>

            <!-- Pre-Test Forms -->
            <div class="service-card bg-white rounded-xl shadow-lg p-6 border border-gray-100" onclick="navigateToService('pre-test-forms')">
                <div class="text-center">
                    <div class="card-icon text-4xl text-teal-600 mb-4">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Public Education and capacity development - Workplace Prevention Pre-Test</h3>
                    <p class="text-gray-600 text-sm mb-4">Complete pre-training assessment to evaluate knowledge on workplace substance use prevention.</p>
                    <div class="inline-flex items-center text-teal-600 font-medium">
                        <span class="mr-2">View Form</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>

            <!-- Post Test Form -->
            <div class="service-card bg-white rounded-xl shadow-lg p-6 border border-gray-100" onclick="navigateToService('post_test_form')">
                <div class="text-center">
                    <div class="card-icon text-4xl text-indigo-600 mb-4">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Public Education and capacity development - Training Post-Test Evaluation</h3>
                    <p class="text-gray-600 text-sm mb-4">Complete post-training evaluation to assess learning outcomes and training effectiveness.</p>
                    <div class="inline-flex items-center text-indigo-600 font-medium">
                        <span class="mr-2">View Form</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>

            <!-- Quarterly Annual Reporting -->
            <div class="service-card bg-white rounded-xl shadow-lg p-6 border border-gray-100" onclick="navigateToService('quarterly_annual_reporting_template')">
                <div class="text-center">
                    <div class="card-icon text-4xl text-pink-600 mb-4">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Public awareness and Advocacy - Quarterly Reporting Template</h3>
                    <p class="text-gray-600 text-sm mb-4">Submit quarterly and annual reports with data on prevention activities and outcomes.</p>
                    <div class="inline-flex items-center text-pink-600 font-medium">
                        <span class="mr-2">View Form</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>

            <!-- School Substance Prevention -->
            <div class="service-card bg-white rounded-xl shadow-lg p-6 border border-gray-100" onclick="navigateToService('school_substance_prevention')">
                <div class="text-center">
                    <div class="card-icon text-4xl text-yellow-600 mb-4">
                        <i class="fas fa-school"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Public Awareness and advocacy - School Substance Prevention</h3>
                    <p class="text-gray-600 text-sm mb-4">Report on school-level substance prevention activities, inspections, and educational programs.</p>
                    <div class="inline-flex items-center text-yellow-600 font-medium">
                        <span class="mr-2">View Form</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>

            <!-- Workplace Prevention Interventions -->
            <div class="service-card bg-white rounded-xl shadow-lg p-6 border border-gray-100" onclick="navigateToService('workplace_based_prevention_interventions')">
                <div class="text-center">
                    <div class="card-icon text-4xl text-cyan-600 mb-4">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Public Education and capacity development - Workplace Prevention Training</h3>
                    <p class="text-gray-600 text-sm mb-4">Evaluate workplace-based prevention intervention training for managers and supervisors.</p>
                    <div class="inline-flex items-center text-cyan-600 font-medium">
                        <span class="mr-2">View Form</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->

    <script>
        function navigateToService(servicePath) {
            window.location.href = servicePath + '/index.php';
        }
    </script>
</body>
</html>