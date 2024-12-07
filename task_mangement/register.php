<?php
include 'include/connect.php';

// Initializing 
$com_id = "";
if (isset($_GET['comp_id'])) {
    $com_id = $_GET['comp_id'];
}

$uname = "";
$username = "";
$email = "";
$password = "";
$errors = [];
$status = "admin";
$uid = "";

if (isset($_GET['status'])) {
    $status = $_GET['status'];
}

// Handling the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize name
    if (isset($_POST['name'])) {
        if (empty($_POST['name'])) {
            $errors['name'] = "Name is required";
        } else {
            $uname = htmlspecialchars(trim($_POST['name']));
        }
    }

    // Validate and sanitize username
    if (isset($_POST['username'])) {
        if (empty($_POST['username'])) {
            $errors['username'] = "Username is required";
        } else {
            $username = htmlspecialchars(trim($_POST['username']));
        }
    }

    // Validate and check for existing email
    if (isset($_POST['email'])) {
        if (empty($_POST['email'])) {
            $errors['email'] = "Email is required";
        } else {
            $email = htmlspecialchars(trim($_POST['email']));

            $query = $pdo->prepare('SELECT * FROM users WHERE user_email = :email');
            $query->execute([':email' => $email]);
            if ($query->rowCount() > 0) {
                $errors['email'] = "Email already exists";
            }
        }
    }

    // Validate and hash password
    if (isset($_POST['password'])) {
        if (empty($_POST['password'])) {
            $errors['password'] = "Password is required";
        } else {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }
    }

    // Insert data into the database if no errors
    if (count($errors) == 0) {
        $register = $pdo->prepare("INSERT INTO users (uname, username, user_email, password, status, created) VALUES (:uname, :username, :email, :password, :status, :created)");
        $params = [
            ':uname' => $uname,
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
            ':status' => $status,
            ':created' => time()
        ];
        $register->execute($params);

        // Get the last inserted user ID
        $uid = $pdo->lastInsertId();

        // Insert into the junction table if the status is 'member'
        if ($status == 'member') {
            $junction = $pdo->prepare("INSERT INTO user_com_junc (uid, com_id) VALUES (:uid, :com_id)");
            $junction->execute([
                ":uid" => $uid,
                ":com_id" => $com_id
            ]);
        }

        // Redirect after successful insertion
        header("Location: companies.php?page=register&status=member&comp_id=$com_id");
        exit;
    }

   
}



$allResult = $pdo->prepare("SELECT  user_profile.user_Fullname , users.user_email
 , user_profile.user_role, users.status FROM `user_com_junc` LEFT JOIN users
on users.uid = user_com_junc.uid
LEFT JOIN user_profile on user_profile.uid = users.uid
WHERE user_com_junc.com_id = :com_id");
$allResult->execute([':com_id' => $com_id]);
$allData =  $allResult->fetchAll(PDO::FETCH_ASSOC);
// print_r($allData);
// Display errors
foreach ($errors as $error) {
    echo $error . "<br>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>


<body class="bg-gray-900 text-gray-100 min-h-screen">
    <div class="container mx-auto ">
        <!-- Company Users Table -->
        <?php  if(($status)  == 'member' ){  ?>
        <div class="w-full mb-8">
            <h2 class="text-2xl font-bold ml-6 mb-4">Company Users</h2>
            <div class="bg-gray-800 p-6 rounded-lg shadow">
                <table class="min-w-full bg-gray-900 shadow shadow-lg  text-left text-white">
                    <thead>
                        <tr class="bg-yellow-500 text-white">
                            <th class="border-b border-gray-700 p-4">Full Name</th>
                            <th class="border-b border-gray-700 p-4">Email</th>
                            <th class="border-b border-gray-700 p-4">Role</th>
                            <th class="border-b border-gray-700 p-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allData as $data) { ?>
                        <tr>
                            <td class="border-b border-gray-700 p-4"> <?php echo  $data['user_Fullname'] ;?> </td>
                            <td class="border-b border-gray-700 p-4"><?php echo  $data['user_email'] ;?></td>
                            <td class="border-b border-gray-700 p-4"><?php echo  $data['user_role'] ;?></td>
                            <td class="border-b border-gray-700 p-4"><?php echo $data['status'] ;?></td>
                        </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- Toggle Form Button -->
        <div class="text-start">
            <button id="toggleFormButton"
                class="bg-yellow-600 ml-6 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow">
                Add Member
            </button>
        </div>
        <div id="registrationForm"
            class="hidden mt-8 w-full max-w-md mx-auto bg-gray-700 dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-600 dark:border-gray-700">
            <div class="text-center mt-4">
                <h1 class="text-2xl font-bold text-gray-200">Get started</h1>
                <p class="text-gray-400 mt-2">
                    Start creating the best possible user experience for your customers.
                </p>
            </div>
            <div class="card mt-6 bg-gray-700 dark:bg-gray-800">
                <div class="card-body">
                    <div class="m-3">
                        <form method="post"
                            action="companies.php?page=register&status=member&comp_id=<?php echo $com_id;?>"
                            enctype="multipart/form-data">
                            <div class="mb-6">
                                <label class="block text-gray-300 font-semibold mb-2">Full Name</label>
                                <input
                                    class="form-input mt-1 block py-3 px-2 w-full rounded-lg border-gray-500 dark:border-gray-600 bg-gray-600 dark:bg-gray-700 text-gray-200 focus:border-indigo-500 focus:ring-indigo-500"
                                    type="text" name="name" placeholder="Enter your name" />
                            </div>
                            <div class="mb-6">
                                <label class="block text-gray-300 font-semibold mb-2">Username</label>
                                <input
                                    class="form-input mt-1 block py-3 px-2 w-full rounded-lg border-gray-500 dark:border-gray-600 bg-gray-600 dark:bg-gray-700 text-gray-200 focus:border-indigo-500 focus:ring-indigo-500"
                                    type="text" name="username" placeholder="Enter your username" />
                            </div>
                            <div class="mb-6">
                                <label class="block text-gray-300 font-semibold mb-2">Email</label>
                                <input
                                    class="form-input mt-1 block py-3 px-2 w-full rounded-lg border-gray-500 dark:border-gray-600 bg-gray-600 dark:bg-gray-700 text-gray-200 focus:border-indigo-500 focus:ring-indigo-500"
                                    type="email" name="email" placeholder="Enter your email" />
                            </div>
                            <div class="mb-6">
                                <label class="block text-gray-300 font-semibold mb-2">Password</label>
                                <input
                                    class="form-input mt-1 block py-3 px-2 w-full rounded-lg border-gray-500 dark:border-gray-600 bg-gray-600 dark:bg-gray-700 text-gray-200 focus:border-indigo-500 focus:ring-indigo-500"
                                    type="password" name="password" placeholder="Enter your password" />
                            </div>
                            <div class="mt-6">
                                <input type="submit" value="Register"
                                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <span class="text-gray-400">Already have an account? </span>
                <a href="./Login.php" class="text-indigo-600 hover:text-indigo-400 hover:underline">Log In</a>
            </div>
        </div>
        <?php } else {?>
        <!-- Registration Form -->
        <div id="registrationForm"
            class=" mt-8 w-full max-w-md mx-auto bg-gray-700 dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-600 dark:border-gray-700">
            <div class="text-center mt-4">
                <h1 class="text-2xl font-bold text-gray-200">Get started</h1>
                <p class="text-gray-400 mt-2">
                    Start creating the best possible user experience for your customers.
                </p>
            </div>
            <div class="card mt-6 bg-gray-700 dark:bg-gray-800">
                <div class="card-body">
                    <div class="m-3">
                        <form method="post" action="index.php?page=register" enctype="multipart/form-data">
                            <div class="mb-6">
                                <label class="block text-gray-300 font-semibold mb-2">Full Name</label>
                                <input
                                    class="form-input mt-1 block py-3 px-2 w-full rounded-lg border-gray-500 dark:border-gray-600 bg-gray-600 dark:bg-gray-700 text-gray-200 focus:border-indigo-500 focus:ring-indigo-500"
                                    type="text" name="name" placeholder="Enter your name" />
                            </div>
                            <div class="mb-6">
                                <label class="block text-gray-300 font-semibold mb-2">Username</label>
                                <input
                                    class="form-input mt-1 block py-3 px-2 w-full rounded-lg border-gray-500 dark:border-gray-600 bg-gray-600 dark:bg-gray-700 text-gray-200 focus:border-indigo-500 focus:ring-indigo-500"
                                    type="text" name="username" placeholder="Enter your username" />
                            </div>
                            <div class="mb-6">
                                <label class="block text-gray-300 font-semibold mb-2">Email</label>
                                <input
                                    class="form-input mt-1 block py-3 px-2 w-full rounded-lg border-gray-500 dark:border-gray-600 bg-gray-600 dark:bg-gray-700 text-gray-200 focus:border-indigo-500 focus:ring-indigo-500"
                                    type="email" name="email" placeholder="Enter your email" />
                            </div>
                            <div class="mb-6">
                                <label class="block text-gray-300 font-semibold mb-2">Password</label>
                                <input
                                    class="form-input mt-1 block py-3 px-2 w-full rounded-lg border-gray-500 dark:border-gray-600 bg-gray-600 dark:bg-gray-700 text-gray-200 focus:border-indigo-500 focus:ring-indigo-500"
                                    type="password" name="password" placeholder="Enter your password" />
                            </div>
                            <div class="mt-6">
                                <input type="submit" value="Register"
                                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <span class="text-gray-400">Already have an account? </span>
                <a href="./Login.php" class="text-indigo-600 hover:text-indigo-400 hover:underline">Log In</a>
            </div>
        </div>
        <?php } ?>
    </div>

    <script>
    // Toggle the form visibility
    document.getElementById('toggleFormButton').addEventListener('click', function() {
        var form = document.getElementById('registrationForm');
        if (form.classList.contains('hidden')) {
            form.classList.remove('hidden');
            // this.textContent = 'Hide Registration Form';
        } else {
            form.classList.add('hidden');
            // this.textContent = 'Show Registration Form';
        }
    });
    </script>
</body>


</html>