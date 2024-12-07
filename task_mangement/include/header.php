<?php
ob_start();
include 'include/connect.php';
$uid = $_SESSION['uid'];
// print $uid;

$query = $pdo->prepare("SELECT com_id, com_name FROM company_profile WHERE uid = :uid");
$params = [
    ':uid' => $_SESSION['uid']
];
$query->execute($params);
$result = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<nav class="bg-gray-700 text-white flex items-center justify-between p-4">
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
                <div class="absolute z-50 right-0 mt-2 w-64 bg-gray-800 text-white rounded shadow-lg" x-show="open"
                    @click.away="open = false" x-transition>
                    <?php if (isLogin()) { ?>
                    <a class="block py-2 px-4 hover:bg-gray-700" href="index.php?page=profile">
                        Profile
                    </a>
                    <a class="block py-2 px-4 hover:bg-gray-700" href="#">
                        Dashboard
                    </a>
                    <div class="border-t"></div>
                    <a class="block py-2 px-4 hover:bg-gray-700" href="#">
                        Companies
                    </a>
                    <?php foreach ($result as $company) { ?>
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