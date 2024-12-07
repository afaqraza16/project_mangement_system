<?php
include 'include/connect.php';
// session_start(); // Make sure to start the session
$uid = $_SESSION['uid'];
$comp_id = $_GET['comp_id'];

// Fetch existing tasks
$query = $pdo->prepare("SELECT * FROM `project` WHERE project.com_id =:com_id");
$params = [':com_id' => $comp_id];
$query->execute($params);
$result = $query->fetchAll(PDO::FETCH_ASSOC);

// Fetch users for assignment
$users = $pdo->prepare("SELECT users.uid, users.uname FROM `user_com_junc` LEFT JOIN users on users.uid = user_com_junc.uid WHERE user_com_junc.com_id =:uid");
$param = [':uid' => $comp_id];
$users->execute($param);
$allUsers = $users->fetchAll(PDO::FETCH_ASSOC);
// print_r($allUsers);

// Handle form submission
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (!isset($_GET['edit_id'])) {
    
    if (isset($_POST['task_name'])) {
        if (empty($_POST['task_name'])) {
            $errors['task_name'] = "TASK NAME is required";
        }
        $task_name = $_POST['task_name'];
    }
    if (isset($_POST['task_desc'])) {
        if (empty($_POST['task_desc'])) {
            $errors['task_desc'] = "TASK description is required";
        }
        $task_desc = $_POST['task_desc'];
    }
    if (isset($_POST['start_date'])) {
        if (empty($_POST['start_date'])) {
            $errors['start_date'] = "Start Date is required";
        }
        $start_date = $_POST['start_date'];
    }
    if (isset($_POST['end_date'])) {
        if (empty($_POST['end_date'])) {
            $errors['end_date'] = "End Date is required";
        }
        $end_date = $_POST['end_date'];
    }
    if (isset($_POST['proj_name'])) {
        if (empty($_POST['proj_name'])) {
            $errors['proj_name'] = "Project Name is required";
        }
        $proj_name = $_POST['proj_name'];
    }
    if (isset($_POST['task_status'])) {
        if (empty($_POST['task_status'])) {
            $errors['task_status'] = "Task Status is required";
        }
        $task_status = $_POST['task_status'];
    }
    if (isset($_POST['member'])) {
        if (empty($_POST['member'])) {
            $errors['member'] = "Member is required";
        }
        $member = $_POST['member'];
    }
    
    if (count($errors) == 0) {
        $insert = true;
    }
    
    if ($insert) {
        // Insert new task
        $task = $pdo->prepare("INSERT INTO `create_task`(`task_name`, `task_desc`, `start_date`, `end_date`, `task_status`, `proj_id`) VALUES (:task_name,:task_desc,:start_date,:end_date,:task_status,:proj_id)");
        $tasks = [
            ':task_name' => $task_name,
            ':task_desc' => $task_desc,
            ':start_date' => $start_date,
            ':end_date' => $end_date,
            ':task_status' => $task_status,
            ':proj_id' => $proj_name
        ];
        $task->execute($tasks);
        $lastId = $pdo->lastInsertId();

        // Assign task to user
        $insert_member = $pdo->prepare("INSERT INTO `assign_task_junc`(`uid`, `task_id`, `proj_id`) VALUES (:uid,:task_id,:proj_id)");
        $assign_Task = [
            ':uid' => $member,
            ':task_id' => $lastId,
            ':proj_id' => $proj_name
        ];
        $insert_member->execute($assign_Task);
    }
}
}


// Handle task edit
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $task_query = $pdo->prepare("SELECT * FROM `create_task` WHERE `cat_task_id` = :task_id");
    $task_query->execute([':task_id' => $edit_id]);
    $task_to_edit = $task_query->fetch(PDO::FETCH_ASSOC);
}
if (isset($_GET['edit_id'])) {
    // print $_GET['edit_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_task'])) {
    $edit_id = $_POST['edit_id'];
    $update_task = $pdo->prepare("UPDATE `create_task` SET `task_name` = :task_name, `task_desc` = :task_desc, `start_date` = :start_date, `end_date` = :end_date, `task_status` = :task_status WHERE `cat_task_id` = :task_id");
    $update_task->execute([
        ':task_name' => $_POST['task_name'],
        ':task_desc' => $_POST['task_desc'],
        ':start_date' => $_POST['start_date'],
        ':end_date' => $_POST['end_date'],
        ':task_status' => $_POST['task_status'],
        ':task_id' => $edit_id
    ]);
    header("Location: companies.php?page=createtask&comp_id=$comp_id");
}
}
// Handle task deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    try {
        $delete_task = $pdo->prepare("DELETE FROM `create_task` WHERE `cat_task_id` = :task_id");
        $delete_task->execute([':task_id' => $delete_id]);
        header("Location: companies.php?page=createtask&comp_id=$comp_id");
        exit(); // Ensure the script stops after redirection
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}


// Fetch tasks for display
$tasks = $pdo->prepare("SELECT create_task.task_name, project.pro_name, create_task.start_date, create_task.end_date, create_task.task_status, users.uname, create_task.cat_task_id FROM `assign_task_junc` LEFT JOIN create_task ON create_task.cat_task_id = assign_task_junc.task_id LEFT JOIN project ON project.pro_id = assign_task_junc.proj_id LEFT JOIN users ON users.uid = assign_task_junc.uid");
$tasks->execute();
$allTsk = $tasks->fetchAll(PDO::FETCH_ASSOC);
// print_r($allTsk);

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

    function handleDelete(taskId) {
        // Store the task ID in a data attribute of the confirm button
        document.getElementById('confirmDeleteBtn').setAttribute('data-task-id', taskId);
        // Show the modal
        toggleModal('popup-modal');
    }

    function confirmDelete() {
        // Get the task ID from the data attribute
        const taskId = document.getElementById('confirmDeleteBtn').getAttribute('data-task-id');
        // Redirect to the deletion URL
        window.location.href = `companies.php?page=createtask&comp_id=<?php echo $comp_id; ?>&delete_id=${taskId}`;
    }

    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }
    </script>
</head>

<body class="bg-gray-900 flex items-center justify-center min-h-screen ">
    <div class="flex flex-col w-full max-w-7xl">
        <!-- Project List -->
        <div class="container mb-8 shadow-2xl rounded-lg  ">
            <h1 class="text-4xl font-bold text-white mb-6 text-start">Task List</h1>
            <table class="min-w-full bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <thead>
                    <tr>
                        <th class="py-3 px-5 bg-gray-700 border-b-2 border-gray-600 text-white text-left">Task Name</th>
                        <th class="py-3 px-5 bg-gray-700 border-b-2 border-gray-600 text-white text-left">Project Name
                        </th>
                        <th class="py-3 px-5 bg-gray-700 border-b-2 border-gray-600 text-white text-left">Start Date
                        </th>
                        <th class="py-3 px-5 bg-gray-700 border-b-2 border-gray-600 text-white text-left">Deadline</th>
                        <th class="py-3 px-5 bg-gray-700 border-b-2 border-gray-600 text-white text-left">Status</th>
                        <th class="py-3 px-5 bg-gray-700 border-b-2 border-gray-600 text-white text-left">Assign To</th>
                        <th class="py-3 px-5 bg-gray-700 border-b-2 border-gray-600 text-white text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allTsk as $task) { ?>
                    <tr class="hover:bg-gray-700 transition duration-200 ease-in-out">
                        <td class="py-3 px-5 border-b border-gray-600 text-gray-300"><?php echo $task['task_name'] ?>
                        </td>
                        <td class="py-3 px-5 border-b border-gray-600 text-gray-300"><?php echo $task['pro_name'] ?>
                        </td>
                        <td class="py-3 px-5 border-b border-gray-600 text-gray-300"><?php echo $task['start_date'] ?>
                        </td>
                        <td class="py-3 px-5 border-b border-gray-600 text-gray-300"><?php echo $task['end_date'] ?>
                        </td>
                        <td class="py-3 px-5 border-b border-gray-600 text-gray-300"><?php echo $task['task_status'] ?>
                        </td>
                        <td class="py-3 px-5 border-b border-gray-600 text-gray-300"><?php echo $task['uname'] ?></td>
                        <td class="py-3 px-5 border-b border-gray-600 text-gray-300 text-center">
                            <a href="companies.php?page=createtask&comp_id=<?php echo $comp_id; ?>&edit_id=<?php echo $task['cat_task_id']; ?>"
                                class="text-blue-400 hover:text-blue-600 transition duration-200">Edit</a> |
                            <a href="javascript:void(0);" onclick="handleDelete(<?php echo $task['cat_task_id']; ?>);"
                                class="text-red-400 hover:text-red-600 transition duration-200">
                                Delete
                            </a>

                            <!-- <button onclick="handleDelete(<?php //echo $task['cat_task_id']; ?>)"
                                class="text-red-400 hover:text-red-600 transition duration-200">Delete</button> -->
                        </td>
                    </tr>

                    </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div id="popup-modal" tabindex="-1"
                class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
                <div class="relative p-4 w-full max-w-md bg-gray-800 rounded-lg shadow-lg">
                    <button type="button"
                        class="absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                        onclick="toggleModal('popup-modal')">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to
                            delete this task?</h3>
                        <button id="confirmDeleteBtn" type="button"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center"
                            onclick="confirmDelete()">
                            Yes, I'm sure
                        </button>
                        <button type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                            onclick="toggleModal('popup-modal')">
                            No, cancel
                        </button>
                    </div>
                </div>
            </div>
            <div class="text-start mt-6">
                <button onclick="toggleForm()"
                    class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300 ease-in-out transform hover:scale-105">Create
                    Task</button>
            </div>
        </div>

        <!-- Project Form -->
        <div id="formContainer" class="bg-gray-800 rounded-lg shadow-lg p-8 w-full max-w-lg mx-auto hidden">
            <form action="companies.php?page=createtask&comp_id=<?php echo $comp_id ?>" method="POST"
                class="bg-gray-800 border p-4 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-4 text-white">Create a New Task</h2>
                <div class="mb-4">
                    <label for="task_name" class="block text-sm font-medium text-gray-300">Task Name</label>
                    <input type="text" name="task_name" id="task_name"
                        class="mt-1 p-2 w-full rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="task_desc" class="block text-sm font-medium text-gray-300">Task Description</label>
                    <textarea name="task_desc" id="task_desc"
                        class="mt-1 p-2 w-full rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500"></textarea>
                </div>
                <div class="mb-4">
                    <label for="start_date" class="block text-sm font-medium text-gray-300">Start Date</label>
                    <input type="date" name="start_date" id="start_date"
                        class="mt-1 p-2 w-full rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="end_date" class="block text-sm font-medium text-gray-300">End Date</label>
                    <input type="date" name="end_date" id="end_date"
                        class="mt-1 p-2 w-full rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="task_status" class="block text-sm font-medium text-gray-300">Task Status</label>
                    <select name="task_status" id="task_status"
                        class="mt-1 p-2 w-full rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500">
                        <option value="">Select Status</option>
                        <option value="Not Started">Not Started</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <div class="mb-4">
                    <label for="proj_id" class="block text-sm font-medium text-gray-300">Select Project</label>
                    <select name="proj_name" id="proj_id"
                        class="mt-1 p-2 w-full rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500">
                        <option value="" disabled selected>Select The Project</option>
                        <?php foreach ($result as $row) { ?>
                        <option value="<?php echo $row['pro_id']; ?>" class="text-white"><?php echo $row['pro_name']; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="member" class="block text-sm font-medium text-gray-300">Assign To</label>
                    <select name="member" id="member"
                        class="mt-1 p-2 w-full rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500">
                        <option value="" disabled selected>Select The Member</option>
                        <?php foreach ($allUsers as $row) { ?>
                        <option value="<?php echo $row['uid']; ?>" class="text-white"><?php echo $row['uname']; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-300">Create
                    Task</button>
            </form>
        </div>

        <!-- Edit Task Form -->
        <?php if (isset($task_to_edit)) { ?>
        <div id="editFormContainer" class="bg-gray-800 rounded-lg shadow-lg p-8 w-full max-w-lg mx-auto">
            <form action="companies.php?page=createtask&comp_id=<?php echo $comp_id ?>" method="POST"
                class="bg-gray-800 border p-4 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-4 text-white">Edit Task</h2>
                <input type="hidden" name="edit_id" value="<?php echo $task_to_edit['cat_task_id']; ?>">
                <div class="mb-4">
                    <label for="task_name" class="block text-sm font-medium text-gray-300">Task Name</label>
                    <input type="text" name="task_name" id="task_name" value="<?php echo $task_to_edit['task_name']; ?>"
                        class="mt-1 p-2 w-full rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="task_desc" class="block text-sm font-medium text-gray-300">Task Description</label>
                    <textarea name="task_desc" id="task_desc"
                        class="mt-1 p-2 w-full rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500"><?php echo $task_to_edit['task_desc']; ?></textarea>
                </div>
                <div class="mb-4">
                    <label for="start_date" class="block text-sm font-medium text-gray-300">Start Date</label>
                    <input type="date" name="start_date" id="start_date"
                        value="<?php echo $task_to_edit['start_date']; ?>"
                        class="mt-1 p-2 w-full rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="end_date" class="block text-sm font-medium text-gray-300">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="<?php echo $task_to_edit['end_date']; ?>"
                        class="mt-1 p-2 w-full rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="task_status" class="block text-sm font-medium text-gray-300">Task Status</label>
                    <select name="task_status" id="task_status"
                        class="mt-1 p-2 w-full rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500">
                        <option value="">Select Status</option>
                        <option value="Not Started"
                            <?php echo $task_to_edit['task_status'] == 'Not Started' ? 'selected' : ''; ?>>Not Started
                        </option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <input type="submit" name="update_task"
                    class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-300"
                    value="Update Task" />
            </form>
        </div>
        <?php } ?>
    </div>
</body>

</html>