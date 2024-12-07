<?php
include 'include/connect.php';
$comp_id = $_GET['comp_id'];

$query = $pdo->prepare("SELECT * FROM `company_profile` WHERE company_profile.com_id = :comp_id");
$params = [
    ':comp_id' => $comp_id
];

$query->execute($params);

$result = $query->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
    /* Custom animation for elements to fade in */
    .fade-in {
        animation: fadeIn ease 2s;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    /* Custom gradient for the background */
    .custom-gradient-bg {
        background: linear-gradient(to right, #4b55, #FFF1);
    }
    </style>
</head>

<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">

    <div class="w-full h-full flex items-center justify-center p-4">
        <div
            class="custom-gradient-bg p-8 rounded-lg shadow-2xl transform transition duration-500 hover:scale-105 max-w-7xl w-full mx-4 md:mx-8 fade-in">

            <!-- Company Image -->
            <div class="flex justify-center mb-6">
                <img src="https://via.placeholder.com/150" alt="Company Logo"
                    class="rounded-full shadow-lg w-32 h-32 object-cover">
            </div>

            <!-- Company Name -->
            <div class="text-center mb-6">
                <h2 class="text-3xl md:text-4xl font-extrabold text-white border-b border-gray-900 pb-2">
                    <?= htmlspecialchars($result['com_name']); ?>
                </h2>
            </div>

            <!-- Email -->
            <div class="bg-gray-700 p-4 rounded mb-4 shadow-inner">
                <div class="flex justify-between">
                    <p class="text-lg font-semibold text-yellow-300">Email:</p>
                    <p class="text-lg"><?= htmlspecialchars($result['com_email']); ?></p>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-gray-700 p-4 rounded mb-4 shadow-inner">
                <div class="flex justify-between">
                    <p class="text-lg font-semibold text-yellow-300">Description:</p>
                    <p class=" pl-64 text-lg"><?= htmlspecialchars($result['comp_desc']); ?></p>
                </div>
            </div>

            <!-- Contact -->
            <div class="bg-gray-700 p-4 rounded mb-4 shadow-inner">
                <div class="flex justify-between">
                    <p class="text-lg font-semibold text-yellow-300">Contact:</p>
                    <p class="text-lg"><?= htmlspecialchars($result['contact']); ?></p>
                </div>
            </div>

            <!-- Address -->
            <div class="bg-gray-700 p-4 rounded mb-4 shadow-inner">
                <div class="flex justify-between">
                    <p class="text-lg font-semibold text-yellow-300">Address:</p>
                    <p class="text-lg"><?= htmlspecialchars($result['comp_address']); ?></p>
                </div>
            </div>

            <!-- Created On -->
            <div class="bg-gray-700 p-4 rounded mb-4 shadow-inner">
                <div class="flex justify-between">
                    <p class="text-lg font-semibold text-yellow-300">Created On:</p>
                    <p class="text-lg"><?= htmlspecialchars($result['created_on']); ?></p>
                </div>
            </div>

            <!-- User ID -->
            <div class="bg-gray-700 p-4 rounded mb-4 shadow-inner">
                <div class="flex justify-between">
                    <p class="text-lg font-semibold text-yellow-300">User ID:</p>
                    <p class="text-lg"><?= htmlspecialchars($result['uid']); ?></p>
                </div>
            </div>
        </div>
    </div>

</body>


</html>