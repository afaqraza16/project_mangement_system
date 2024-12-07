<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</head>

<body class="bg-gray-900">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg fixed">
            <?php include 'include/sidebar.php'; ?>
        </div>

        <!-- Main Content -->
        <div class="ml-64 flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow ">
                <?php include 'include/header.php'; ?>
            </header>

            <!-- Main Section -->
            <main class="flex-1  bg-gray-800">
                <?php if (isset($_GET['page'])) {
                    include $_GET['page'] . '.php';
                } else {
                    include 'dashboard.php';
                } ?>

            </main>


        </div>
    </div>
    <div class="w-[83%] ml-64">

        <?php include 'include/footer.php'; ?>
    </div>
</body>

</html>