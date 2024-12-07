<?php
include 'include/connect.php';
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Collect data from form
    $user_Fullname = $_POST['user_Fullname'];
    $user_phone = $_POST['user_phone'];
    $user_address = $_POST['user_address'];
    $user_role = $_POST['user_role'];
    $user_expertises = $_POST['user_expertises'];

    // Prepare and bind
    $stmt = $pdo->prepare("INSERT INTO user_profile (user_Fullname, user_phone, user_address, user_role, user_expertises,uid) 
        VALUES (:user_Fullname, :user_phone, :user_address, :user_role, :user_expertises,:uid)");

    // Define parameters
    $param = [
        ":user_Fullname" => $user_Fullname,
        ":user_phone" => $user_phone,
        ":user_address" => $user_address,
        ":user_role" => $user_role,
        ":user_expertises" => $user_expertises,
         ":uid" => $_SESSION['uid']
    ];

    // Debug: Print parameters
    print_r($param);

    // Execute the query
    try {
        $stmt->execute($param);
        header("Location: index.php?page=dashboard");
        echo "User profile added successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert User Data</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/3.2.7/tailwind.min.css">
</head>

<body class="bg-gray-900 text-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-lg">
        <h1 class="text-2xl font-semibold mb-6 text-gray-100">Add User Profile</h1>
        <form action="user_profile.php" method="POST" class="space-y-4">

            <div>
                <label for="user_Fullname" class="block text-sm font-medium text-gray-300">Full Name</label>
                <input type="text" id="user_Fullname" name="user_Fullname" required
                    class="w-full p-2 mt-1 bg-gray-700 border border-gray-600 rounded-md text-gray-100">
            </div>
            <div>
                <label for="user_phone" class="block text-sm font-medium text-gray-300">Phone</label>
                <input type="text" id="user_phone" name="user_phone" required
                    class="w-full p-2 mt-1 bg-gray-700 border border-gray-600 rounded-md text-gray-100">
            </div>
            <div>
                <label for="user_address" class="block text-sm font-medium text-gray-300">Address</label>
                <input type="text" id="user_address" name="user_address" required
                    class="w-full p-2 mt-1 bg-gray-700 border border-gray-600 rounded-md text-gray-100">
            </div>
            <div>
                <label for="user_role" class="block text-sm font-medium text-gray-300">Role</label>
                <input type="text" id="user_role" name="user_role" required
                    class="w-full p-2 mt-1 bg-gray-700 border border-gray-600 rounded-md text-gray-100">
            </div>
            <div>
                <label for="user_expertises" class="block text-sm font-medium text-gray-300">Expertises</label>
                <input type="text" id="user_expertises" name="user_expertises" required
                    class="w-full p-2 mt-1 bg-gray-700 border border-gray-600 rounded-md text-gray-100">
            </div>
            <button type="submit" class="bg-blue-700 text-gray-100 p-2 rounded-md hover:bg-blue-800">Add User</button>
        </form>
    </div>
</body>

</html>