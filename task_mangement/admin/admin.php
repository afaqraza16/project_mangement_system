<?php
// include 'include/connect.php';
include '../include/connect.php';


$ad_id = "";
$ad_name = "";
$ad_username = "";
$ad_email = "";
$ad_password = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['ad_id'])) {
        if (empty($_POST['ad_id'])) {
            $errors['ad_id'] = "Admin ID is required";
        }
        $ad_id = $_POST['ad_id'];
    }
    if (isset($_POST['ad_name'])) {
        if (empty($_POST['ad_name'])) {
            $errors['ad_name'] = "Admin name is required";
        }
        $ad_name = $_POST['ad_name'];
    }
    if (isset($_POST['ad_username'])) {
        if (empty($_POST['ad_username'])) {
            $errors['ad_username'] = "Username is required";
        }
        $ad_username = $_POST['ad_username'];
    }
    if (isset($_POST['ad_email'])) {
        if (empty($_POST['ad_email'])) {
            $errors['ad_email'] = "Email is required";
        }
        $ad_email = $_POST['ad_email'];
    }
    if (isset($_POST['ad_password'])) {
        if (empty($_POST['ad_password'])) {
            $errors['ad_password'] = "Password is required";
        }
        $ad_password = $_POST['ad_password'];
        $ad_password = password_hash($ad_password, PASSWORD_DEFAULT);
    }

    $insert = false;
    if (count($errors) == 0) {
        $insert = true;
    }

    if ($insert) {
        $register = $pdo->prepare("INSERT INTO `admin` ( `ad_name`, `ad_username`, `ad_email`, `ad_password`) VALUES ( :ad_name, :ad_username, :ad_email, :ad_password)");
        $params = [
            ':ad_name' => $ad_name,
            ':ad_username' => $ad_username,
            ':ad_email' => $ad_email,
            ':ad_password' => $ad_password
        ];

        // Uncomment the following lines for debugging
        print "<pre>";
        print_r($params);
        print "</pre>";

        $register->execute($params);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <div class="flex items-center bg-gray-800 justify-center h-screen">

        <div class="bg-gray-900 p-10 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center text-white">Add Admin</h2>
            <form action="index.php?page=admin" method="POST">

                <div class="mb-4">
                    <label for="ad_name" class="block text-sm font-medium text-gray-300 mb-2">Admin Name</label>
                    <input type="text" id="ad_name" name="ad_name"
                        class="form-input w-full p-2.5 rounded-lg border border-gray-700 bg-gray-800 text-gray-300 focus:border-blue-500 focus:outline-none"
                        required>
                </div>
                <div class="mb-4">
                    <label for="ad_username" class="block text-sm font-medium text-gray-300 mb-2">Username</label>
                    <input type="text" id="ad_username" name="ad_username"
                        class="form-input w-full p-2.5 rounded-lg border border-gray-700 bg-gray-800 text-gray-300 focus:border-blue-500 focus:outline-none"
                        required>
                </div>
                <div class="mb-4">
                    <label for="ad_email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                    <input type="email" id="ad_email" name="ad_email"
                        class="form-input w-full p-2.5 rounded-lg border border-gray-700 bg-gray-800 text-gray-300 focus:border-blue-500 focus:outline-none"
                        required>
                </div>
                <div class="mb-6">
                    <label for="ad_password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                    <input type="password" id="ad_password" name="ad_password"
                        class="form-input w-full p-2.5 rounded-lg border border-gray-700 bg-gray-800 text-gray-300 focus:border-blue-500 focus:outline-none"
                        required>
                </div>
                <div class="text-center">
                    <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Add
                        Admin</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>