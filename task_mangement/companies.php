<?php
session_start();
ob_start();
$userName = $_SESSION['user_name'];
$userEmail = $_SESSION['user_email'];


include 'include/connect.php';
include 'include/function.php';
$comp_id = $_GET['comp_id'];
// print $comp_id;
$uid = $_SESSION['uid'];
$user = $pdo->prepare("select * from users where uid = :uid");
$userArray = [
    ':uid' => $uid,
];
$user->execute($userArray);
$users = $user->fetchAll(PDO::FETCH_ASSOC);
// print_r($users);


$query = $pdo->prepare("SELECT * FROM `company_profile` WHERE company_profile.com_id = :comp_id");
$params = [
    ':comp_id' => $comp_id
];

$query->execute($params);

$result = $query->fetch(PDO::FETCH_ASSOC);
// print_r($result);

$allCom = $pdo->prepare("SELECT * FROM `company_profile` WHERE uid = :uid");
$params = [
    ':uid' => $uid
];

$allCom->execute($params);

$AllComp = $allCom->fetchAll(PDO::FETCH_ASSOC);
// print_r($AllComp);



// Fetch user's projects
// $query = $pdo->prepare("SELECT * FROM project WHERE com_id = :uid");
// $params = [':uid' => $uid];
// $query->execute($params);
// $projects = $query->fetchAll(PDO::FETCH_ASSOC);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Task Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-900 text-white">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside
            class="flex flex-col text-white w-72 h-screen   overflow-y-auto bg-gray-800 border-r rtl:border-r-0 rtl:border-l dark:bg-gray-900 dark:border-gray-700 transition-all duration-300">
            <?php //foreach ($result as $all) { 
            ?>
            <a class="text-center py-4 rounded-lg bg-yellow-500"
                href="companies.php?page=com_profile&comp_id=<?php echo $result['com_id'] ?>">
                <span class="text-3xl text-white text-center font-bold"><?php echo $result['com_name'] ?></span>
            </a>
            <?php //} 
            ?>
            <div class="flex flex-col justify-between text-white flex-1 mt-6">
                <nav class="flex-1 space-y-3">
                    <li class="px-10 py-3 list-none hover:bg-gray-700">
                        <a class="flex items-center text-yellow-500 text-xl gap-3 hover:text-white"
                            href="companies.php?page=companyDash&comp_id=<?php echo $comp_id; ?>">
                            <i class=" text-white fa-solid fa-layer-group"></i><span class="flex-1"> Dashboard</span>
                        </a>
                    </li>
                    <li class="px-10 py-3 list-none hover:bg-gray-700">
                        <a class="flex items-center text-yellow-500 text-xl gap-3 hover:text-white"
                            href="companies.php?page=com_profile&comp_id=<?php echo $comp_id; ?>">
                            <i class="text-white fa-solid fa-layer-group"></i><span class="flex-1">Company
                                Profile</span>
                        </a>
                    </li>
                    <li class="px-10 py-3  list-none hover:bg-gray-700">
                        <a class="flex items-center text-yellow-500 text-xl gap-3 hover:text-white"
                            href="companies.php?page=register&status=member&comp_id=<?php echo $comp_id; ?>">
                            <i class="text-white fa-solid fa-user"></i> <span class="flex-1">Add Member</span>
                        </a>
                    </li>
                    <li class="px-10 py-3  list-none hover:bg-gray-700">
                        <a class="flex items-center text-yellow-500 text-xl gap-3 hover:text-white"
                            href="companies.php?page=project&status=project&comp_id=<?php echo $comp_id; ?>">
                            <i class="text-white fa-solid fa-right-from-bracket"></i> <span class="flex-1">Add
                                Project</span>
                        </a>
                    </li>
                    <li class="px-10 py-3  list-none hover:bg-gray-700">
                        <a class="flex items-center text-yellow-500 text-xl gap-3 hover:text-white"
                            href="companies.php?page=createtask&comp_id=<?php echo $comp_id; ?>">
                            <i class="text-white fa-solid fa-list-check"></i> <span class="flex-1">Create Task</span>
                        </a>
                    </li>

                    <li class="px-10 py-3  list-none hover:bg-gray-700">
                        <a class="flex items-center text-yellow-500 text-xl gap-3 hover:text-white"
                            href="companies.php?page=task_Status&comp_id=<?php echo $comp_id; ?>">
                            <i class="text-white fa-brands fa-atlassian"></i> <span class="flex-1"> Task Status</span>
                        </a>
                    </li>


                </nav>
            </div>
        </aside>


        <!-- Main content -->
        <div class="flex-1 ">
            <!-- Header -->

            <nav class="bg-gray-700 text-white flex items-center justify-between py-5 px-6">
                <a class="cursor-pointer font-bold text-2xl">
                    <i class="fa-solid fa-bars"></i>
                </a>

                <div class="flex items-center space-x-4">
                    <ul class="flex items-center space-x-4">
                        <li class="relative" x-data="{ open: false }">
                            <a class="flex items-center cursor-pointer sm:hidden" @click="open = !open">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>
                            <a class="flex items-center cursor-pointer hidden sm:flex" @click="open = !open">
                                <img src="https://img.freepik.com/premium-photo/futuristic-robotic-woman-standing-proudly-futuristic-building-science-fiction_1099938-1.jpg?ga=GA1.1.2046820249.1709015459"
                                    class="w-8 h-8 rounded-full mr-2" alt="Charles Hall">
                                <span class="text-dark">
                                    <?php
                                    if (isset($_SESSION['isLogin'])) {
                                        print ucwords($_SESSION['user_name']);
                                    } else {
                                        print "Login";
                                    }
                                    ?></span>
                            </a>
                            <div class="absolute right-0 mt-2 w-48 bg-gray-800 text-white rounded shadow-lg"
                                x-show="open" @click.away="open = false" x-transition>
                                <?php if (isLogin()) { ?>
                                <a class="block py-2 px-4 bg-gray-900 border-b hover:bg-gray-700"
                                    href="index.php?page=profile">
                                    <?php echo $userName; ?>
                                </a>


                                <a class="block py-2 px-4 border-b bg-gray-900 hover:bg-gray-700"
                                    href="index.php?page=profile">
                                    <?php echo $userEmail; ?>
                                </a>

                                <a class="block py-2 px-4 border-b hover:bg-gray-700" href="#">
                                    Dashboard
                                </a>
                                <div class="border-t"></div>
                                <a class="block py-2 px-4 hover:bg-gray-700" href="index.php?page=status">
                                    Companies
                                </a>
                                <?php foreach ($AllComp as $company) { ?>
                                <a class="block py-2 px-4 hover:bg-gray-700"
                                    href="./companies.php?page=companyDash&comp_id=<?php echo $company['com_id'] ?>">
                                    <?php echo htmlspecialchars($company['com_name']); ?>
                                </a>
                                <?php } ?>
                                <div class="border-t"></div>
                                <a class="block py-2 px-4 hover:bg-gray-700" href="logout.php">
                                    Log out
                                </a>
                                <?php } ?>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div id="projects" class="bg-gray-800 min-h-screen  p-4 rounded-lg shadow-lg mb-8">
                <main class="flex-1 text-white flex items-center justify-center  bg-gray-800">
                    <?php if (isset($_GET['page'])) {
                        include $_GET['page'] . '.php';
                    } else {
                        include 'dashboard.php';
                    } ?>

                </main>
            </div>

        </div>
    </div>
</body>

</html>