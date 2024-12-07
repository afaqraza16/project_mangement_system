<?php
include 'include/connect.php';
$comp_id = $_GET['comp_id'];
// print $comp_id;
$com_id = $_SESSION['uid'];
$pro_name = "";
$pro_desc = "";
$start_date = "";
$deadLine = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['pro_name'])) {
        if (empty($_POST['pro_name'])) {
            $errors['pro_name'] = "Project Name is Required";
        }
        $pro_name = $_POST['pro_name'];
    }
    if (isset($_POST['pro_desc'])) {
        if (empty($_POST['pro_desc'])) {
            $errors['pro_desc'] = "Project Description is Required";
        }
        $pro_desc = $_POST['pro_desc'];
    }
    if (isset($_POST['start_date'])) {
        if (empty($_POST['start_date'])) {
            $errors['start_date'] = "Start Date is Required";
        }
        $start_date = $_POST['start_date'];
    }

    if (isset($_POST['deadLine'])) {
        if (empty($_POST['deadLine'])) {
            $errors['deadLine'] = "Deadline is Required";
        }
        $deadLine = $_POST['deadLine'];
    }

    // Check if there are no errors
    if (count($errors) === 0) {
        $query = $pdo->prepare("INSERT INTO `project`( `pro_name`, `pro_desc`, `start_date`, `deadLine`, `com_id`) VALUES (:proj_name, :proj_desc, :start_date, :deadLine, :com_id)");
        $params = [
            ':proj_name' => $pro_name,
            ':proj_desc' => $pro_desc,
            ':start_date' => $start_date,
            ':deadLine' => $deadLine,
            ':com_id' => $comp_id
        ];
        $query->execute($params);
    } else {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}
$projects = $pdo->prepare("SELECT * FROM project where com_id = :com_id");
$projects->execute([
     ':com_id' => $comp_id
]);
$allProjects = $projects->fetchAll(PDO::FETCH_ASSOC);
// print_r($allProjects);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
    function toggleForm() {
        const formContainer = document.getElementById('formContainer');
        formContainer.classList.toggle('hidden');
    }
    </script>
</head>

<body class="bg-gray-900 flex items-center justify-center min-h-screen p-4">
    <div class="flex flex-col w-full max-w-7xl space-y-8 ">

        <!-- Project List -->
        <div class="container shadow-2xl border p-8 bg-  mb-8">
            <h1 class="text-4xl font-bold text-white mb-6 italic text-start">Project List</h1>

            <table class="min-w-full bg-gray-800 shadow-2xl border rounded-lg overflow-hidden">
                <thead>
                    <tr class=" bg-yellow-500">
                        <th class="py-3 px-5  border-b border-gray-600 text-left text-lg text-white">Project
                            Name</th>
                        <th class="py-3 px-5  border-b border-gray-600 text-left text-lg text-white">
                            Description</th>
                        <th class="py-3 px-5  border-b border-gray-600 text-left text-lg text-white">Start
                            Date</th>
                        <th class="py-3 px-5  border-b border-gray-600 text-left text-lg text-white">Deadline
                        </th>
                        <th class="py-3 px-5  border-b border-gray-600 text-center text-lg text-white">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allProjects as $projects) { ?>
                    <tr class="hover:bg-gray-700 transition duration-300">
                        <td class="py-3 px-5 border-b border-gray-600 text-gray-300"><?php echo $projects['pro_name'] ?>
                        </td>
                        <td class="py-3 px-5 border-b border-gray-600 text-gray-300"><?php echo $projects['pro_desc'] ?>
                        </td>
                        <td class="py-3 px-5 border-b border-gray-600 text-gray-300">
                            <?php echo $projects['start_date'] ?></td>
                        <td class="py-3 px-5 border-b border-gray-600 text-gray-300"><?php echo $projects['deadLine'] ?>
                        </td>
                        <td class="py-3 px-5 border-b border-gray-600 text-gray-300 text-center">
                            <a href="#" class="text-blue-400 hover:text-blue-600">Edit</a> |
                            <a href="#" class="text-red-400 hover:text-red-600">Delete</a>
                        </td>
                    </tr>
                    <?php  }; ?>
                </tbody>
            </table>

            <div class="text-start mt-8">
                <button onclick="toggleForm()"
                    class="bg-yellow-500 text-white px-6 py-3 rounded-full hover:bg-blue-600 transition duration-300 shadow-lg">
                    Add Project
                </button>
            </div>
        </div>

        <!-- Project Form -->
        <div id="formContainer"
            class="bg-gray-800 border border-gray-700 rounded-xl shadow-2xl p-8 w-full max-w-lg mx-auto hidden transition duration-500 transform scale-95">
            <h2 class="text-3xl font-bold text-gray-100 mb-6 text-center">Create Project</h2>
            <form action="companies.php?page=project&status=NewProjectAdded&comp_id=<?php echo $comp_id; ?>"
                method="POST" enctype="multipart/form-data">

                <!-- Project Name -->
                <div class="mb-6">
                    <label for="pro_name" class="block text-gray-300 font-semibold mb-2">Project Name</label>
                    <input type="text" name="pro_name" id="pro_name" placeholder="Enter project name"
                        class="w-full px-4 py-3 border rounded-lg bg-gray-700 border-gray-600 text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Project Description -->
                <div class="mb-6">
                    <label for="pro_desc" class="block text-gray-300 font-semibold mb-2">Project Description</label>
                    <textarea name="pro_desc" id="pro_desc" placeholder="Enter project description"
                        class="w-full px-4 py-3 border rounded-lg bg-gray-700 border-gray-600 text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <!-- Start Date -->
                <div class="mb-6">
                    <label for="start_date" class="block text-gray-300 font-semibold mb-2">Start Date</label>
                    <input type="date" name="start_date" id="start_date"
                        class="w-full px-4 py-3 border rounded-lg bg-gray-700 border-gray-600 text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Deadline -->
                <div class="mb-6">
                    <label for="deadLine" class="block text-gray-300 font-semibold mb-2">Deadline</label>
                    <input type="date" name="deadLine" id="deadLine"
                        class="w-full px-4 py-3 border rounded-lg bg-gray-700 border-gray-600 text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Hidden Company ID -->
                <input type="hidden" name="com_id" value="<?php echo $_SESSION['uid']; ?>">

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit"
                        class="bg-blue-500 w-full text-white px-4 py-3 rounded-full hover:bg-blue-600 transition duration-300 shadow-lg">
                        Submit
                    </button>
                </div>
            </form>
        </div>

    </div>
</body>


</html>