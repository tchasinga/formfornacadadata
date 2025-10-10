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
            <div class="pulse-animation">
                <i class="fas fa-clipboard-list text-6xl mb-6"></i>
            </div>
            <h1 class="text-5xl font-light mb-4">Choose One Form to Apply For</h1>
            <p class="text-xl font-light max-w-3xl mx-auto">
                Select from our comprehensive range of forms and services designed to support substance abuse prevention and workplace safety initiatives.
            </p>
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
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Bi-Annual Drug Prevention Report</h3>
                    <p class="text-gray-600 text-sm mb-4">Submit comprehensive bi-annual reports on drug prevention activities, organizational details, and intervention outcomes.</p>
                    <div class="inline-flex items-center text-blue-600 font-medium">
                        <span class="mr-2">Apply Now</span>
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
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Employee Assistance Program</h3>
                    <p class="text-gray-600 text-sm mb-4">Monitor and track employee assistance programs, referrals, counseling services, and workplace wellness initiatives.</p>
                    <div class="inline-flex items-center text-green-600 font-medium">
                        <span class="mr-2">Apply Now</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>

            <!-- Annual Work Plan Format -->
            <div class="service-card bg-white rounded-xl shadow-lg p-6 border border-gray-100" onclick="navigateToService('form_annual_work_plan_format')">
                <div class="text-center">
                    <div class="card-icon text-4xl text-purple-600 mb-4">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Annual Work Plan Format</h3>
                    <p class="text-gray-600 text-sm mb-4">Submit your annual work plan with institutional details, quarterly targets, and ADA activities.</p>
                    <div class="inline-flex items-center text-purple-600 font-medium">
                        <span class="mr-2">Apply Now</span>
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
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Individual Training Booking</h3>
                    <p class="text-gray-600 text-sm mb-4">Book individual training sessions with participant details, payment information, and training requirements.</p>
                    <div class="inline-flex items-center text-orange-600 font-medium">
                        <span class="mr-2">Apply Now</span>
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
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Group Training Booking</h3>
                    <p class="text-gray-600 text-sm mb-4">Book group training sessions for organizations with participant lists, contact details, and payment options.</p>
                    <div class="inline-flex items-center text-red-600 font-medium">
                        <span class="mr-2">Apply Now</span>
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
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Workplace Prevention Pre-Test</h3>
                    <p class="text-gray-600 text-sm mb-4">Complete pre-training assessment to evaluate knowledge on workplace substance use prevention.</p>
                    <div class="inline-flex items-center text-teal-600 font-medium">
                        <span class="mr-2">Apply Now</span>
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
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Training Post-Test Evaluation</h3>
                    <p class="text-gray-600 text-sm mb-4">Complete post-training evaluation to assess learning outcomes and training effectiveness.</p>
                    <div class="inline-flex items-center text-indigo-600 font-medium">
                        <span class="mr-2">Apply Now</span>
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
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Quarterly Reporting Template</h3>
                    <p class="text-gray-600 text-sm mb-4">Submit quarterly and annual reports with comprehensive data on prevention activities and outcomes.</p>
                    <div class="inline-flex items-center text-pink-600 font-medium">
                        <span class="mr-2">Apply Now</span>
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
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">School Substance Prevention</h3>
                    <p class="text-gray-600 text-sm mb-4">Report on school-level substance prevention activities, inspections, and educational programs.</p>
                    <div class="inline-flex items-center text-yellow-600 font-medium">
                        <span class="mr-2">Apply Now</span>
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
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Workplace Prevention Training</h3>
                    <p class="text-gray-600 text-sm mb-4">Evaluate workplace-based prevention intervention training for managers and supervisors.</p>
                    <div class="inline-flex items-center text-cyan-600 font-medium">
                        <span class="mr-2">Apply Now</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <div class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <div class="flex justify-center items-center space-x-4 mb-4">
                <i class="fas fa-shield-alt text-2xl"></i>
                <span class="text-lg font-semibold">Substance Abuse Prevention Portal</span>
            </div>
            <p class="text-gray-400 text-sm">
                Comprehensive forms and services for effective substance abuse prevention and workplace safety
            </p>
        </div>
    </div>

    <script>
        function navigateToService(servicePath) {
            window.location.href = servicePath + '/index.php';
        }
    </script>
</body>
</html>