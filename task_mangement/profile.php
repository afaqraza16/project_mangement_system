<?php
// session_start();
include 'include/connect.php';

$prof_id = "";
if (isset($_SESSION['uid'])) {
    $prof_id = $_SESSION['uid'];
}
$query = $pdo->prepare("Select * from users where uid = :uid ");
$params = [
    ':uid' => $prof_id
];
$query->execute($params);
$result = $query->fetch(PDO::FETCH_ASSOC);

// update the user data which user is login that user
// if()
?>

<div class=" bg-gray-900 text-white  flex">


    <!-- Main Content -->
    <div class="flex-1 p-6 ">
        <div class="max-w-10xl  bg-gray-800 rounded-lg shadow-xl shadow-indigo-600 shadow-lg p-6 ">
            <h2 class="text-2xl font-bold mb-6">Profile</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Profile Picture -->
                <div class="flex justify-center bg-cover object-cover md:justify-start">
                    <img class="w-32 h-32 rounded-full border-4 border-indigo-500"
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQjRgQ6GO5weA2WE-ALI0QTNTavaeCYQfY-dQ&s"
                        alt="Profile Picture">
                </div>

                <!-- Profile Details -->
                <div>
                    <h3 class="text-xl font-semibold">Personal Information</h3>
                    <div class="mt-4">
                        <label class="block text-sm font-medium">Name:</label>
                        <p class="mt-1 px-3 py-2 bg-gray-700 rounded-lg"><?php echo $result['uname']  ?></p>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium">Email:</label>
                        <p class="mt-1 px-3 py-2 bg-gray-700 rounded-lg"><?php echo $result['user_email'] ?></p>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium">Role:</label>
                        <p class="mt-1 px-3 py-2 bg-gray-700 rounded-lg"><?php
                                                                            if ($result['status'] == "admin") {
                                                                                echo "Admin";
                                                                            } else {
                                                                                echo "Member";
                                                                            } ?>
                        </p>
                    </div>

                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-xl font-semibold">Update Profile</h3>
                <form method="post" action="index.php?page=profile">
                    <div class="mt-4">
                        <label for="name" class="block text-sm font-medium">Name:</label>
                        <input type="text" id="name" name="name"
                            class="mt-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg w-full"
                            value="<?php //echo $userDetails['name']; 
                                                                                                                                                    ?>">
                    </div>
                    <div class="mt-4">
                        <label for="email" class="block text-sm font-medium">Email:</label>
                        <input type="email" id="email" name="email"
                            class="mt-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg w-full"
                            value="<?php //echo $userDetails['email']; 
                                                                                                                                                        ?>">
                    </div>
                    <div class="mt-4">
                        <label for="password" class="block text-sm font-medium">Password:</label>
                        <input type="password" id="password" name="password"
                            class="mt-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg w-full"
                            placeholder="Enter new password">
                    </div>
                    <div class="mt-4">
                        <input type="submit" value="Update Profile"
                            class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-indigo-700 transition duration-300">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>