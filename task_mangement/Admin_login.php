<!-- <div class="bg-gray-900 flex text-white items-center justify-center min-h-screen">

    <div class="bg-gray-800 p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-2xl font-bold text-white text-center mb-6">Login</h2>
        <form method="post" action="index.php?page=Login">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-300">Email:</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-300">Password:</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-full">
            </div>
            <div>
                <input type="submit" value="Login"
                    class="w-full bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-indigo-700 transition duration-300">
            </div>
        </form>
    </div>
</div> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Dark Theme</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-gray-100 min-h-screen flex flex-col shadow-lg">
            <div class="p-6">
                <h1 class="text-3xl font-bold text-center text-white">SAAS</h1>
            </div>
            <nav class="">
                <a href="#"
                    class="block py-4 px-4  rounded transition duration-200 hover:bg-purple-600 hover:text-white flex items-center bg-purple-500 text-white">
                    <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                </a>
                <a href="#"
                    class="block py-4 px-4  rounded transition duration-200 hover:bg-gray-700 hover:text-white flex items-center">
                    <i class="fas fa-user mr-3"></i> Profile
                </a>
                <a href="#"
                    class="block py-4 px-4 py-3 rounded transition duration-200 hover:bg-gray-700 hover:text-white flex items-center">
                    <i class="fas fa-building mr-3"></i> Companies
                </a>

            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <!-- Navbar -->
            <div class="flex justify-between items-center  mb-6 bg-gray-800 p-4 rounded shadow">
                <h2 class="text-2xl font-semibold text-gray-100">Dashboard</h2>
                <div class="flex items-center">
                    <div class="relative">
                        <input type="text" placeholder="Search"
                            class="px-4 py-2 rounded-full border border-gray-600 bg-gray-700 text-gray-300 focus:outline-none focus:border-blue-500 shadow">
                    </div>
                    <div class="ml-4 relative">
                        <button class="text-gray-300 hover:text-gray-100 focus:outline-none">
                            <i class="fas fa-bell"></i>
                        </button>
                        <span
                            class="absolute top-0 right-0 inline-block w-2 h-2 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"></span>
                    </div>
                    <div class="ml-6 relative">
                        <button id="profileDropdownButton"
                            class="flex items-center text-gray-300 hover:text-gray-100 focus:outline-none">
                            <img class="h-8 w-8 rounded-full object-cover mr-2" src="https://via.placeholder.com/150"
                                alt="User avatar">
                            <span class="text-gray-300 font-medium">John Doe</span>
                            <i class="fas fa-caret-down ml-2"></i>
                        </button>
                        <!-- Dropdown Menu -->
                        <div id="profileDropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-gray-800 rounded-lg shadow-lg py-2">
                            <a href="#"
                                class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">Profile</a>
                            <a href="#"
                                class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">Settings</a>
                            <a href="#"
                                class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">Logout</a>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Pricing and Subscription Blocks -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <!-- Monthly Revenue -->
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h5 class="text-lg font-semibold text-gray-300 mb-4">Monthly Revenue</h5>
                    <p class="text-2xl font-bold text-white">$7,845</p>
                </div>
                <!-- SAAS Subscription Date -->
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h5 class="text-lg font-semibold text-gray-300 mb-4">SAAS Subscription Date</h5>
                    <p class="text-2xl font-bold text-white">March 15, 2024</p>
                </div>
                <!-- Last Subscription Date -->
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h5 class="text-lg font-semibold text-gray-300 mb-4">Last Subscription Date</h5>
                    <p class="text-2xl font-bold text-white">August 15, 2024</p>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                <!-- Daily Sales Chart with Multiple Companies -->
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h5 class="text-lg font-semibold text-gray-300 mb-4">Daily Sales</h5>
                    <div class="h-64 bg-gray-700 rounded-lg p-4 overflow-y-auto">
                        <!-- Company A Sales -->
                        <div class="mb-4">
                            <h6 class="text-md font-semibold text-white">Company A</h6>
                            <p class="text-sm text-gray-400">Revenue: $24,500</p>
                            <p class="text-sm text-gray-400">Last Updated: Aug 15, 2024</p>
                        </div>
                        <!-- Company B Sales -->
                        <div class="mb-4">
                            <h6 class="text-md font-semibold text-white">Company B</h6>
                            <p class="text-sm text-gray-400">Revenue: $18,200</p>
                            <p class="text-sm text-gray-400">Last Updated: Aug 14, 2024</p>
                        </div>
                        <!-- Company C Sales -->
                        <div class="mb-4">
                            <h6 class="text-md font-semibold text-white">Company C</h6>
                            <p class="text-sm text-gray-400">Revenue: $32,850</p>
                            <p class="text-sm text-gray-400">Last Updated: Aug 13, 2024</p>
                        </div>
                        <!-- Add More Companies as Needed -->
                    </div>
                </div>

                <!-- Email Subscriptions Chart with Multiple Companies -->
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h5 class="text-lg font-semibold text-gray-300 mb-4">Email Subscriptions</h5>
                    <div class="h-64 bg-gray-700 rounded-lg p-4 overflow-y-auto">
                        <!-- Company A Subscriptions -->
                        <div class="mb-4">
                            <h6 class="text-md font-semibold text-white">Company A</h6>
                            <p class="text-sm text-gray-400">Subscriptions: 150</p>
                            <p class="text-sm text-gray-400">Last Updated: Aug 15, 2024</p>
                        </div>
                        <!-- Company B Subscriptions -->
                        <div class="mb-4">
                            <h6 class="text-md font-semibold text-white">Company B</h6>
                            <p class="text-sm text-gray-400">Subscriptions: 120</p>
                            <p class="text-sm text-gray-400">Last Updated: Aug 14, 2024</p>
                        </div>
                        <!-- Company C Subscriptions -->
                        <div class="mb-4">
                            <h6 class="text-md font-semibold text-white">Company C</h6>
                            <p class="text-sm text-gray-400">Subscriptions: 200</p>
                            <p class="text-sm text-gray-400">Last Updated: Aug 13, 2024</p>
                        </div>
                        <!-- Add More Companies as Needed -->
                    </div>
                </div>

                <!-- Completed Tasks Chart with Multiple Companies -->
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h5 class="text-lg font-semibold text-gray-300 mb-4">Completed Tasks</h5>
                    <div class="h-64 bg-gray-700 rounded-lg p-4 overflow-y-auto">
                        <!-- Company A Completed Tasks -->
                        <div class="mb-4">
                            <h6 class="text-md font-semibold text-white">Company A</h6>
                            <p class="text-sm text-gray-400">Completed Tasks: 45</p>
                            <p class="text-sm text-gray-400">Last Updated: Aug 15, 2024</p>
                        </div>
                        <!-- Company B Completed Tasks -->
                        <div class="mb-4">
                            <h6 class="text-md font-semibold text-white">Company B</h6>
                            <p class="text-sm text-gray-400">Completed Tasks: 30</p>
                            <p class="text-sm text-gray-400">Last Updated: Aug 14, 2024</p>
                        </div>
                        <!-- Company C Completed Tasks -->
                        <div class="mb-4">
                            <h6 class="text-md font-semibold text-white">Company C</h6>
                            <p class="text-sm text-gray-400">Completed Tasks: 50</p>
                            <p class="text-sm text-gray-400">Last Updated: Aug 13, 2024</p>
                        </div>
                        <!-- Add More Companies as Needed -->
                    </div>
                </div>
            </div>



        </div>

    </div>


    <!-- JavaScript to Toggle Dropdown -->
    <script>
    document.getElementById('profileDropdownButton').addEventListener('click', function() {
        var dropdown = document.getElementById('profileDropdown');
        dropdown.classList.toggle('hidden');
    });

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('#profileDropdownButton') && !event.target.closest('#profileDropdownButton')) {
            var dropdowns = document.getElementsByClassName('dropdown-content');
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (!openDropdown.classList.contains('hidden')) {
                    openDropdown.classList.add('hidden');
                }
            }
        }
    }
    </script>

</body>

</html>