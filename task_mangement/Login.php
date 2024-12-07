<?php
include 'include/connect.php';

$email = "";
$password = "";
$errors = [];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if email is provided
    if (isset($_POST['email'])) {
        if (empty($_POST['email'])) {
            $errors['email'] = "Please enter your email";
        } else {
            $email = $_POST['email'];
        }
    }

    // Check if password is provided
    if (isset($_POST['password'])) {
        if (empty($_POST['password'])) {
            $errors['password'] = "Please enter your password";
        } else {
            $password = $_POST['password'];
        }
    }

    // If no errors, proceed to database query
    if (count($errors) == 0) {
        $query = $pdo->prepare("SELECT * FROM users WHERE user_email = :email  ");
        $array = [
            ':email' => $email
        ];
        $query->execute($array);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $belong = $result['status'];
        if ($result) {
            $pass = $result['password'];
            if (password_verify($password, $pass)) {
                $_SESSION['isLogin'] = true;
                $_SESSION['uid'] = $result['uid'];
                $_SESSION['status'] = $belong;
                $_SESSION['user_name'] = $result['uname'];
                $_SESSION['user_email'] = $result['user_email'];
                if ($_SESSION['status'] == "admin") {
                    header("Location: index.php?page=dashboard");
                    exit(); // Always call exit after header redirection
                } else if ($_SESSION['status'] == "member") {
                   
                     $query = $pdo->prepare("SELECT * FROM user_profile WHERE uid = :uid");
                     $paramsUser = [':uid' => $_SESSION['uid']];
                     $query->execute($paramsUser);
                     $resultAll = $query->fetch(PDO::FETCH_ASSOC);
 
                     // Check if user profile data is empty
                     if (empty($resultAll)) {
                         // Redirect to profile page if no profile data found
                         header("Location: user_profile.php");
                     } else {
                         // Redirect to dashboard if profile data exists
                         header("Location: index.php?page=dashboard");
                     }
                     exit(); // Always call exit after header redirection
                 }
            } else {
                $errors['password'] = "Invalid password";
            }
        } else {
            $errors['email'] = "No user found with that email address";
        }
    }
}

?>
<?php if (!empty($errors)) : ?>
<?php foreach ($errors as $error) : ?>
<p><?php echo htmlspecialchars($error); ?></p>
<?php endforeach; ?>
<?php endif; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>

<body class="bg-gray-900 flex items-center text-white justify-center min-h-screen">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg max-w-md w-full hover-animate border border-gray-700">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-white">Welcome Back!</h2>
            <p class="text-gray-400 mt-2">Please enter your credentials to access your account and manage your tasks
                efficiently.</p>
        </div>
        <h2 class="text-2xl font-bold text-white text-center mb-6">Login</h2>
        <form method="post" action="index.php?page=Login">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-300">Email:</label>
                <input type="email" id="email" name="email" placeholder="Please Enter Your Email"
                    class="mt-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-300">Password:</label>
                <input type="password" id="password" name="password" placeholder="Please Enter Your Password"
                    class="mt-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
            </div>
            <div>
                <input type="submit" value="Login"
                    class="w-full bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-indigo-700 transition duration-300">
            </div>
        </form>
        <div class="text-center mt-4">
            <span class=" dark:text-gray-400">Register Your Account </span>
            <a href="./register.php" class="text-indigo-600 dark:text-indigo-400 hover:underline">Sign Up</a>
        </div>
    </div>
</body>

</html>