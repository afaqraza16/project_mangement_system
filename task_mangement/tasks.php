<?php  
 include 'include/connect.php';

$uid = $_SESSION['uid'];
// print $uid;
$query = $pdo->prepare("SELECT create_task.cat_task_id, create_task.cat_task_id, create_task.task_name, project.pro_name, create_task.start_date, create_task.task_status FROM `assign_task_junc` LEFT JOIN users on users.uid = assign_task_junc.uid LEFT JOIN create_task on create_task.cat_task_id = assign_task_junc.task_id LEFT JOIN project on project.pro_id = assign_task_junc.proj_id WHERE users.uid = :uid");
$params =[
    ':uid' => $uid
];
$query->execute($params);
$result = $query->fetchAll(PDO::FETCH_ASSOC);
// print_r($result);
?>


<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col items-center justify-center">
    <div class="container mx-auto p-8">
        <h2 class="text-3xl font-bold mb-8 text-center text-yellow-500 italic text-4xl">My Assigned Tasks</h2>
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg w-full">
            <table class="min-w-full bg-gray-900 text-left text-gray-400">
                <thead>
                    <tr class="bg-purple-600 text-white">
                        <th class="border-b border-gray-700 p-4">Task id</th>
                        <th class="border-b border-gray-700 p-4">Task Name</th>
                        <th class="border-b border-gray-700 p-4">Project Name</th>
                        <th class="border-b border-gray-700 p-4">Assigned Date</th>
                        <th class="border-b border-gray-700 p-4">Status</th>
                        <th class="border-b border-gray-700 p-4">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example row -->
                    <?php foreach ($result as $row) {?>
                    <tr>
                        <td class="border-b border-gray-700 p-6"> <?php echo $row['cat_task_id'] ?> </td>

                        <td class="border-b border-gray-700 p-6">
                            <a class="text-blue-500 underline "
                                href="index.php?page=taskInfo&task_id=<?php echo $row['cat_task_id'] ?>">

                                <?php echo ucwords( $row['task_name']) ?>

                            </a>
                        </td>
                        <td class="border-b border-gray-700 p-6"><?php echo $row['pro_name'] ?></td>
                        <td class="border-b border-gray-700 p-6"><?php echo $row['start_date'] ?></td>
                        <?php if ($row['task_status'] == "pending") { ?>
                        <td class="border-b border-gray-700 p-6 bg-gray-600 text-yellow-500">
                            <?php  echo $row['task_status']; ?> </td>
                        <?php } else if($row['task_status'] == "In Progress") { ?>
                        <td class="border-b border-gray-700 p-6 bg-yellow-500 text-gray-800">
                            <?php  echo $row['task_status']; ?> </td>
                        <?php } else {?>
                        <td class="border-b border-gray-700 p-6 bg-green-800 text-white">
                            <?php  echo $row['task_status']; ?> </td>
                        <?php  }?>
                        <td class="border-b border-gray-700 p-6 text-green-500">
                            <a href="index.php?page=tasks&id=<?php echo $row['cat_task_id'] ?>">
                                Edit
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                    <!-- More rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</body>