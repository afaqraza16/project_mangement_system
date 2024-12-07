<?php
ob_start();
$uid = $_SESSION['uid'];
$user = $pdo->prepare("SELECT * FROM users WHERE uid = :uid");
$user->execute([":uid" => $uid]);
$user = $user->fetch(PDO::FETCH_ASSOC);

$task_id = "";
if (isset($_GET['taskid'])) {
    $taskid = $_GET['taskid'];
}
// $task_id = "";
if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];
    // print $task_id;
}
$uid = $_SESSION['uid'];
// $task_id = $_GET['task_id'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the comment form was submitted
    if (isset($_POST['submit_comment'])) {
        $com_desc = $_POST['com_desc'];
        $insert = $pdo->prepare("INSERT INTO comment (com_desc, task_id, uid, time) VALUES (:com_desc, :task_id, :uid, NOW())");
        $params = [
            ':com_desc' => $com_desc,
            ':task_id' => $task_id,
            ':uid' => $uid,
        ];
        $insert->execute($params);
        header("Location: index.php?page=taskInfo&task_id=" . $task_id);
        exit;
    } 
    // Check if the reply form was submitted
    elseif (isset($_POST['submit_reply'])) {
        $rep_desc = $_POST['rep_desc'];
        $com_id = $_POST['com_id'];
        
        // Prepare and execute the insert query for the reply
        $stmt = $pdo->prepare("INSERT INTO replytable (rep_desc, com_id, uid, time) VALUES (:rep_desc, :com_id, :uid, NOW())");
        $stmt->execute([
            ':rep_desc' => $rep_desc,
            ':com_id' => $com_id,
            ':uid' => $uid
        ]);
 if(isset($_GET['page']) == 'dashboard'){
    header("Location: index.php?page=dashboard&taskid=" . $taskid);
   exit;
 }else{
    header("Location: index.php?page=taskInfo&task_id=" . $task_id);
    exit;
 }
    }
}

if(isset($_GET['taskid'])){

    $tasks = $pdo->prepare("SELECT create_task.cat_task_id, create_task.task_name, create_task.task_desc ,   create_task.start_date, create_task.end_date, create_task.task_status, project.pro_name FROM create_task 
    LEFT JOIN project ON create_task.proj_id = project.pro_id WHERE create_task.cat_task_id = :taskid
    ");
    $params = [":taskid" => $taskid];
        $tasks->execute($params);
        $tasks = $tasks->fetch(PDO::FETCH_ASSOC);
        }
if(isset($_GET['task_id'])){
    $tasks = $pdo->prepare("SELECT create_task.cat_task_id, create_task.task_name, create_task.task_desc,create_task.start_date, create_task.end_date, create_task.task_status, project.pro_name FROM create_task LEFT JOIN project ON create_task.proj_id = project.pro_id WHERE create_task.cat_task_id = :taskid
    ");
    $params = [":taskid" => $task_id];
// $params = [":taskid" => $task_id];
$tasks->execute($params);
$tasks = $tasks->fetch(PDO::FETCH_ASSOC);
if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];
} else {
    die('Task ID is required');
}
$update = false ;
if(isset($_GET['page']) == 'taskInfo'){
    $update = true;
}
if($update){
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_status = $_POST['task_status'];
    $update = $pdo->prepare("UPDATE create_task SET task_status = :task_status WHERE cat_task_id = :task_id");
    $update->execute([
        ':task_status' => $task_status,
        ':task_id' => $task_id
    ]);
    // Redirect to prevent form resubmission
    header("Location: index.php?page=taskInfo&task_id=" . $task_id . "");
    exit;
}
}
// if (!isset($_GET['redirected'])) {
//     echo '<script>
//         window.location.href = "index.php?page=taskInfo&task_id=' . $task_id . '&redirected=true";
//     </script>';
// }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>

<body class="bg-gray-900 text-white">
    <?php  if(isset($_GET['taskid'])){ ?>
    <div class="container mx-auto p-6">
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg flex flex-col lg:flex-row gap-6">
            <!-- Left Side -->
            <div class="flex-1 bg-gray-700  rounded-lg shadow-lg">
                <h2
                    class="text-3xl font-bold py-4 text-center rounded p-0 mb-6 text-white bg-gradient-to-l from-yellow-500 to-indigo-500   text-transparent">
                    <?php echo htmlspecialchars($tasks['task_name']); ?>
                </h2>
                <div class="p-6">

                    <div class="mb-6">
                        <p class="text-gray-400 text-lg font-medium mb-2">Task Title:</p>
                        <p class="text-white text-xl font-semibold"><?php echo htmlspecialchars($tasks['task_name']); ?>
                        </p>
                    </div>

                    <div class="mb-6">
                        <p class="text-gray-400 text-lg font-medium mb-2">Task Description:</p>
                        <p class="text-gray-300"><?php echo htmlspecialchars($tasks['task_desc']); ?></p>
                    </div>

                    <div class="flex gap-6">
                        <div class="w-1/2">
                            <p class="text-gray-400 text-lg font-medium mb-2">Start Date:</p>
                            <p class="text-white"><?php echo htmlspecialchars($tasks['start_date']); ?></p>
                        </div>
                        <div class="w-1/2">
                            <p class="text-gray-400 text-lg font-medium mb-2">End Date:</p>
                            <p class="text-white"><?php echo htmlspecialchars($tasks['end_date']); ?></p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Side -->
            <div class="flex-1 bg-gray-700  rounded-lg shadow-lg">
                <h2 class="text-3xl font-bold text-center py-4 mb-6 text-white bg-gradient-to-l from-yellow-500 to-indigo-500
                      text-transparent">
                    Additional Information
                </h2>
                <div class="p-6">

                    <div class="mb-6">
                        <p class="text-gray-400 text-sm font-medium mb-2">Task Status:</p>
                        <p class="text-white text-xl font-semibold">
                            <?php echo htmlspecialchars($tasks['task_status']); ?>
                        </p>
                    </div>

                    <div class="mb-6">
                        <p class="text-gray-400 text-sm font-medium mb-2">Project Name:</p>
                        <p class="text-white text-xl font-semibold"><?php echo htmlspecialchars($tasks['pro_name']); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'comment.php'; ?>
    </div>
    <?php }else if(isset($_GET['task_id'])) { ?>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl px-6 font-bold text-white">My Task Single Task</h1>
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg flex flex-col lg:flex-row gap-6">
            <!-- Left Side -->
            <div class="flex-1 bg-gray-700  rounded-lg shadow-lg">
                <h2
                    class="text-3xl font-bold py-4 text-center rounded p-0 mb-6 text-white bg-gradient-to-l from-yellow-500 to-indigo-500   text-transparent">
                    <?php echo htmlspecialchars($tasks['task_name']); ?>
                </h2>
                <div class="p-6">

                    <div class="mb-6">
                        <p class="text-gray-400 text-lg font-medium mb-2">Task Title:</p>
                        <p class="text-white text-xl font-semibold"><?php echo htmlspecialchars($tasks['task_name']); ?>
                        </p>
                    </div>

                    <div class="mb-6">
                        <p class="text-gray-400 text-lg font-medium mb-2">Task Description:</p>
                        <p class="text-gray-300"><?php echo htmlspecialchars($tasks['task_desc']); ?></p>
                    </div>

                    <div class="flex gap-6">
                        <div class="w-1/2">
                            <p class="text-gray-400 text-lg font-medium mb-2">Start Date:</p>
                            <p class="text-white"><?php echo htmlspecialchars($tasks['start_date']); ?></p>
                        </div>
                        <div class="w-1/2">
                            <p class="text-gray-400 text-lg font-medium mb-2">End Date:</p>
                            <p class="text-white"><?php echo htmlspecialchars($tasks['end_date']); ?></p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Side -->
            <div class="flex-1 bg-gray-700  rounded-lg shadow-lg">
                <h2 class="text-3xl font-bold text-center py-4 mb-6 text-white bg-gradient-to-l from-yellow-500 to-indigo-500
                      text-transparent">
                    Additional Information
                </h2>
                <div class="p-6">

                    <div class="mb-6">
                        <p class="text-gray-400 text-sm font-medium mb-2">Task Status:</p>
                        <p class="text-white text-xl font-semibold">
                            <?php echo htmlspecialchars($tasks['task_status']); ?>
                        </p>
                        <button id="toggleStatusForms"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded mt-4">
                            Change Status
                        </button>
                    </div>

                    <div id="statusForms" class="hidden">


                        <!-- Form 2: Set Status to "Completed" -->
                        <form method="post" action="" class="mb-4">
                            <input type="hidden" name="task_status" value="Pending">
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                                Set to On Pending
                            </button>
                        </form>
                        <!-- Form 1: Set Status to "In Progress" -->

                        <form method="post" action="" class="mb-4">
                            <input type="hidden" name="task_status" value="Progress">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                                Set to In Progress
                            </button>
                        </form>

                        <!-- Form 3: Set Status to "On Hold" -->
                        <form method="post" action="" class="mb-4">
                            <input type="hidden" name="task_status" value="Completed">
                            <button type="submit"
                                class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded">
                                Set to Completed
                            </button>
                        </form>
                    </div>
                    <div class="mb-6">
                        <p class="text-gray-400 text-sm font-medium mb-2">Project Name:</p>
                        <p class="text-white text-xl font-semibold"><?php echo htmlspecialchars($tasks['pro_name']); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'comment.php'; ?>
    </div>
    <?php }else { ?>
    <h1>Kindly SELECT the Task Please</h1>
    <?php }?>
    <script>
    // Toggle the visibility of the status forms
    document.getElementById('toggleStatusForms').addEventListener('click', function() {
        var forms = document.getElementById('statusForms');
        if (forms.classList.contains('hidden')) {
            forms.classList.remove('hidden');
        } else {
            forms.classList.add('hidden');
        }
    });
    </script>
</body>

</html>