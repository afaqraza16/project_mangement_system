<?php
session_start();
include 'include/function.php';
$status = '';

if (isLogin()) {
    if (isset($_SESSION['status'])) {
        $status = $_SESSION['status'];
        // print $status;
    }
}
?>

<nav id="sidebar" class="w-64 shadow-xl shadow-yellow-500 h-screen bg-gray-800 border gap-5 text-white">
    <div class="flex flex-col ">
        <a class="block py-4 px-6 text-3xl gap-5 flex items-center justify-start font-bold text-center bg-gray-900"
            href="index.php">
            <i class="text-yellow-500 fa-solid fa-house"></i> SAAS
        </a>

        <ul class="mt-4 flex px-3 flex-col gap-4">
            <?php if (isLogin()) { ?>
            <li class="px-4 py-2 hover:bg-yellow-500 hover:text-black">
                <a class="flex items-center text-xl  shadow-yellow-500 gap-3" href="index.php">
                    <i class="fa-solid fa-house"></i> <span class="flex-1">Dashboard</span>
                </a>
            </li>
            <li class="px-4 py-2 hover:bg-yellow-500 hover:text-black">
                <a class="flex items-center text-xl gap-3" href="index.php?page=profile">
                    <i class="fa-solid fa-user"></i> <span class="flex-1">Profile</span>
                </a>
            </li>
            <?php if ($status == "admin") {  ?>
            <li class="px-4 py-2 hover:bg-yellow-500 hover:text-black">
                <a class="flex items-center text-xl gap-3" href="index.php?page=AddCompanies">
                    <i class="fa-solid fa-user"></i> <span class="flex-1">Add Company</span>
                </a>
            </li>
            <?php } elseif ($status == "member") {   ?>
            <li class="px-4 py-2 hover:bg-yellow-500 hover:text-black">
                <a class="flex items-center text-xl gap-3" href="index.php?page=tasks">
                    <i class="fa-solid fa-user"></i> <span class="flex-1">Task Status</span>
                </a>
            </li>

            <?php } ?>
            <?php }   ?>


        </ul>
    </div>
</nav>