<?php
include 'include/connect.php';
$uid = "";
if (isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];
}
$proj_id = "";
if(isset($_GET['pro_id'])){
    $proj_id = $_GET['pro_id'];
    // print $proj_id;
}
// the slelct project deatails by project id;
if(isset($proj_id)){
    $projectbyId = $pdo->prepare("Select * from project where pro_id = :pro_id");
    $params = [
        ":pro_id"=> $proj_id
    ];
    $projectbyId->execute($params);
    $projectbyId = $projectbyId->fetch(PDO::FETCH_ASSOC);
    // print_r($projects);
    $allTask = $pdo->prepare("SELECT * FROM `create_task` WHERE proj_id= :pro_id");
    $allTask->execute($params);
    // $allTask->setFetchMode(PDO::FETCH_ASSOC);
    $allTask=$allTask->fetchAll(PDO::FETCH_ASSOC);
    // print_r($allTask);

}

// $member = "";
if (isset($_SESSION["status"])) {
    $status = $_SESSION["status"];
    // print $status;
}
$company =$pdo->prepare("SELECT create_task.cat_task_id, create_task.task_name, project.pro_id, project.pro_name,project.pro_desc FROM `assign_task_junc` LEFT JOIN project on project.pro_id = assign_task_junc.proj_id LEFT JOIN create_task on create_task.cat_task_id = assign_task_junc.task_id WHERE assign_task_junc.uid = :uid");
// $company->bindParam(':uid', $com_id);
$params=[
     ":uid"=> $uid,
];
$company->execute($params);
$company = $company->fetchAll(PDO::FETCH_ASSOC);
print "<pre>";
// print_r($company);
print "</pre>";
$comp_id = 1;
if(isset($_GET['com_id'])){
    $comp_id = $_GET['com_id'];
}
$allData = $pdo->prepare("SELECT project.pro_id,project.pro_name,project.pro_desc,company_profile.com_name, users.uname, create_task.task_name FROM `assign_task_junc` LEFT JOIN users on users.uid = assign_task_junc.uid LEFT JOIN create_task on create_task.cat_task_id = assign_task_junc.task_id LEFT JOIN project on project.pro_id  = assign_task_junc.proj_id LEFT JOIN company_profile on company_profile.com_id = project.com_id WHERE company_profile.com_id = :com_id");
$params = [
    ":com_id"=> $comp_id,
];
 $allData->execute($params);
  $allData = $allData->fetchAll(PDO::FETCH_ASSOC);

// print "<pre>";
//  print_r($allData);
//  print "</pre>";
// $newArray = [];
// foreach ($allData as  $value) {
//   if(!isset($newArray[$value['pro_id']])){
//     $newArray[$value['pro_id']] =[
//        "pro_name" => $value['pro_name'],
//        "pro_desc" => $value['pro_desc'],
//         "com_name" => $value['com_name'],
//          "task_user" => [
//          $value['uname'],
//         $value['task_name']
//          ]
//         ];
//   }
//   else{
//        $newArray[$value['pro_id']]['task_user'][] = [
//            $value['uname'],
//            $value['task_name'],
//         ];
//   }
    
// }


$allrecords = $pdo->prepare("SELECT create_task.cat_task_id, create_task.task_name,create_task.task_desc, users.uname ,user_profile.user_role,create_task.start_date,create_task.end_date,create_task.task_status,project.pro_name FROM `assign_task_junc` LEFT JOIN create_task on create_task.cat_task_id = assign_task_junc.task_id LEFT JOIN users on users.uid = assign_task_junc.uid LEFT JOIN user_profile on user_profile.uid = users.uid LEFT JOIN project
 on project.pro_id = assign_task_junc.proj_id  
 WHERE project.com_id=:com_id");
 $records =[

     ":com_id"=>$comp_id,
 ];
 $allrecords->execute($records);
 $allrecords = $allrecords->fetchAll(PDO::FETCH_ASSOC);
 print "<pre>";
//  print_r($allrecords);
 print "</pre>";
 $projects = $pdo->prepare("SELECT * FROM `project` WHERE project.com_id=:com_id");
 $param=[
    ":com_id"=>$comp_id
 ];
  $projects->execute($param);
//  $projects->execute();
 $projects = $projects->fetchAll(PDO::FETCH_ASSOC);
//  print_r($projects);

$query = $pdo->prepare("SELECT * FROM project");
$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);
$companies = $pdo->prepare("Select * from company_profile where uid = :uid");
$param=[
    ":uid" => $_SESSION['uid']
    ];
    $companies->execute($param);
    $companies = $companies->fetchAll(PDO::FETCH_ASSOC);
    // print_r($companies);
?>
<?php if($status == 'member'){ ?>

<div class=" w-full">
    <h1 class="p-6 text-4xl bg-gradient-to-l from-yellow-500 to-indigo-500 font-bold text-white italic">Projects</h1>
    <div class="flex flex-wrap justify-start">
        <div class="  w-full md:w-1/2 xl:w-1/3 
                  p-6 text-center bg-yellow-500 rounded-lg shadow-md m-4">
            <li class="list-none font-bold  text-gray-800  text-2xl" onclick="toggleForm()">
                Select Projects
                <i class="fa-brands fa-openid"></i>
                <?php foreach ($company as $row) {?>
                <h2 class="form-container text-2xl border-b  py-3 hidden text-white font-bold mb-4">
                    <a class=""
                        href="index.php?page=dashboard&pro_id=<?php echo $row['pro_id'] ?>"><?= $row['pro_name']?>
                    </a>
                </h2>
                <?php }?>
            </li>
        </div>
        <!-- #region-->
    </div>
</div>
<?php if(isset($_GET['pro_id'])){ ?>
<div class="bg-gray-900 p-6 rounded-lg shadow-lg max-w-7xl mx-auto">
    <h2
        class="text-4xl font-bold italic text-gray-100 mb-6 bg-gradient-to-r from-yellow-500 to-indigo-600 text-center py-4 rounded-lg">
        Project Details
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 px-10 py-4">
        <!-- Project Name -->
        <!-- -->
        <div class="bg-gray-800 p-6 rounded-lg shadow border-b border-yellow-600">
            <p class="text-xl font-semibold text-yellow-400 mb-2">Project Name:</p>
            <p class="text-gray-200 text-2xl font-bold"><?php echo htmlspecialchars($projectbyId['pro_name']); ?></p>
        </div>

        <!-- Start Date -->
        <div class="bg-gray-800 p-6 rounded-lg shadow border-b border-yellow-600">
            <p class="text-xl font-semibold text-yellow-400 mb-2">Start Date:</p>
            <p class="text-gray-200 text-2xl font-bold"><?php echo htmlspecialchars($projectbyId['start_date']); ?></p>
        </div>

        <!-- Description -->
        <div class="bg-gray-800 p-6 rounded-lg shadow border-b border-yellow-600 md:col-span-2">
            <p class="text-xl font-semibold text-yellow-400 mb-2">Description:</p>
            <p class="text-gray-200 font-bold text-lg leading-relaxed">
                <?php echo htmlspecialchars($projectbyId['pro_desc']); ?></p>
        </div>

        <!-- Deadline -->
        <div class="bg-gray-800 p-6 rounded-lg shadow border-b border-yellow-600">
            <p class="text-xl font-semibold text-yellow-400 mb-2">Deadline:</p>
            <p class="text-gray-200 text-2xl font-bold"><?php echo htmlspecialchars($projectbyId['deadLine']); ?></p>
        </div>

        <!-- Status -->
        <div class="bg-gray-800 p-6 rounded-lg shadow border-b border-yellow-600">
            <p class="text-xl font-semibold text-yellow-400 mb-2">Status:</p>
            <p class="text-gray-200 text-2xl font-bold">In Progress</p>
        </div>
    </div>

    <!-- <div class="flex justify-end mt-6 px-10">
        <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow-lg">
            Edit Project
        </a>
    </div> -->
</div>

<div class="overflow-x-auto px-20 my-10 shadow-lg">
    <table class="min-w-full   text-white rounded-lg shadow-lg">
        <thead>
            <tr class="bg-gradient-to-l from-yellow-500 to-indigo-500 text-left py-3">
                <th class="px-4 py-3">Task ID</th>
                <th class="px-4 py-3">Task Name</th>
                <th class="px-4 py-3">Start Date</th>
                <th class="px-4 py-3">End Date</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Project Name</th>
            </tr>
        </thead>
        <tbody>
            <!-- Repeat this block for each task -->
            <?php  foreach($allTask as $tasks ){ ?>
            <tr class="border-b border-gray-700">
                <td class="px-4 py-3"><?php echo $tasks['cat_task_id'] ?></td>

                <td class="px-4 py-3">
                    <a class="text-blue-500 hover:underline"
                        href="index.php?page=dashboard&taskid=<?php echo $tasks['cat_task_id'] ?>">
                        <?php echo $tasks['task_name'] ?>

                    </a>
                </td>
                <td class="px-4 py-3"><?php echo $tasks['start_date'] ?></td>
                <td class="px-4 py-3"><?php echo $tasks['end_date'] ?></td>
                <td class="px-4 py-3"><?php echo $tasks['task_status'] ?></td>
                <td class="px-4 py-3"><?php echo $projectbyId['pro_name'] ?></td>
            </tr>
            <?php } ?>

            <!-- Add more rows as needed -->
        </tbody>
    </table>
</div>



<?php }else if(isset($_GET['taskid'])) { ?>
<?php include 'taskInfo.php'; ?>
<?php }else { ?>

<div class="bg-gray-800 px-10 mt-10 rounded-lg border border-gray-700">
    <h2
        class="text-2xl font-bold text-white mt-3 py-4 px-2 bg-gradient-to-r bg-gradient-to-l  from-indigo-500 to-yellow-500  mb-6">
        Project Details
    </h2>
    <div class="flex flex-wrap justify-center bg-gradient-to-l from-yellow-500 to-indigo-500 p-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full max-w-7xl">
            <?php foreach($projects as $data){ ?>
            <div
                class="bg-gray-800 p-6 rounded-lg shadow-lg border border-gray-700 hover:border-teal-400 transition-all duration-300 ease-in-out">
                <h3 class="text-xl font-bold text-white mb-4"><?php echo $data['pro_name'] ?></h3>
                <p class="text-sm text-gray-300 mb-4">
                    <?php echo $data['pro_desc'] ?>
                </p>
                <h4 class="text-lg font-bold text-teal-400 mb-2">Members</h4>
                <?php
                    // select the members and task on the base of project id
         $query = $pdo->prepare("SELECT users.uname, create_task.cat_task_id, create_task.task_name FROM `assign_task_junc` LEFT JOIN
            users on users.uid  = assign_task_junc.uid
            LEFT JOIN create_task on create_task.cat_task_id = assign_task_junc.task_id
            WHERE assign_task_junc.proj_id = :pro_id");
            $param = [":pro_id"=>$data['pro_id']];
            $query->execute($param);
             $allTasksUsers = $query->fetchAll(PDO::FETCH_ASSOC);
            //   print_r($allTasksUsers);
            // print_r($query);
                ?>
                <ul class="list-disc list-inside text-sm text-gray-300 mb-4">
                    <?php foreach($allTasksUsers as  $taskUsers){  ?>
                    <li><?php echo ucwords($taskUsers['uname']) ?></li>

                    <?php  }?>
                </ul>
                <h4 class="text-lg font-bold text-teal-400 mb-2">Tasks & Progress</h4>
                <ul class="list-disc list-inside text-sm text-gray-300">
                    <?php foreach($allTasksUsers as  $taskUsers){  ?>
                    <li><span class="text-teal-400">
                            <a href="index.php?page=taskInfo&task_id=<?php echo $taskUsers['cat_task_id'] ?>">
                                <?php echo ucwords($taskUsers['task_name']) ?></span></li>
                    </a>

                    <!-- <li></li> -->

                    <?php  }?>

                </ul>
            </div>
            <?php } ?>
        </div>
    </div>

</div>

<?php  }?>
<?php  }?>

<!-- Projects Grid Start -->
<?php if($status == 'admin'){ ?>
<div class="flex-1 p-6">
    <!-- Navbar -->


    <!-- Project Details Section -->


    <!-- Additional Dashboard Sections -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-10">
        <!-- Monthly Revenue -->
        <div class="bg-gray-800 p-6 shadow-md py-4 shadow-yellow-500 rounded-lg shadow-lg">
            <h5 class="text-lg font-semibold text-gray-300 mb-4">Monthly Revenue</h5>
            <p class="text-2xl font-bold text-white">$7,845</p>
        </div>
        <!-- SAAS Subscription Date -->
        <div class="bg-gray-800 p-6 shadow-md py-4 shadow-yellow-500 rounded-lg shadow-lg">
            <h5 class="text-lg font-semibold text-gray-300 mb-4">SAAS Subscription Date</h5>
            <p class="text-2xl font-bold text-white">March 15, 2024</p>
        </div>
        <!-- Last Subscription Date -->
        <div class="bg-gray-800 p-6 shadow-md py-4 shadow-yellow-500 rounded-lg shadow-lg">
            <h5 class="text-lg font-semibold text-gray-300 mb-4">Last Subscription Date</h5>
            <p class="text-2xl font-bold text-white">August 15, 2024</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <!-- Loop through companies and display their details -->
        <?php foreach($companies as $company) { ?>
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <!-- Company Name -->
            <h5 class="text-3xl shadow-md py-4 shadow-yellow-500 text-center font-bold text-gray-300 mb-4">
                <?php echo htmlspecialchars($company['com_name']); ?>
            </h5>

            <div class="bg-gray-700 rounded-lg shadow-md py-4 shadow-yellow-500 p-4 overflow-y-auto">
                <!-- Company Description -->
                <p class="text-white  leading-relaxed">
                    <?php
                // Get the company description and display the first three lines
                $description = htmlspecialchars($company['comp_desc']);

                // Wrap the text and split it into lines
                $lines = explode("\n", wordwrap($description, 72));

                // Get the first three lines and display them
                $first_three_lines = array_slice($lines, 0, 4);
                echo nl2br(implode("\n", $first_three_lines));
                ?>
                </p>

                <!-- Action Blocks -->
                <div class="flex gap-4 mt-6">
                    <div
                        class="bg-gray-800    shadow-md  shadow-yellow-500  rounded-md border border-gray-600 flex-1 text-center">
                        <h6 class="text-xl shadow-md mb-4 text-white shadow-yellow-500 font-bold  py-3 text-white-400">
                            Projects</h6>

                        <?php
                              $projects = $pdo->prepare("Select * from project where com_id = :com_id");
                              $params = [
                                  'com_id' => $company['com_id']
                              ];
                              $projects->execute($params);
                              $projects= $projects->fetchAll(PDO::FETCH_ASSOC);
                            //   print_r($projects);
                            foreach($projects as $project) {
                       
                                echo '<span class="text-lg border-b  text-gray-300 hover:text-teal-400">'. $project['pro_name'] . "<br>" .' </span>' ;
                            }
                            ?>
                    </div>
                    <div
                        class="bg-gray-800   shadow-md  shadow-yellow-500 rounded-md border border-gray-600 flex-1 text-center">
                        <h6 class="text-xl font-bold  shadow-md mb-4 text-white shadow-yellow-500  py-3">Members</h6>
                        <!-- <span class="text-sm text-gray-300"> -->
                        <?php
                              $projects = $pdo->prepare("SELECT users.uname FROM `user_com_junc` LEFT JOIN  users on users.uid = user_com_junc.uid WHERE user_com_junc.com_id = :com_id");
                              $params = [
                                  'com_id' => $company['com_id']
                              ];
                              $projects->execute($params);
                              $projects= $projects->fetchAll(PDO::FETCH_ASSOC);
                            //   print_r($projects);
                            foreach($projects as $project) {
                       
                                echo '<span class="text-lg border-b mb-2  text-gray-300 hover:text-teal-400">'. ucwords($project['uname']) . "<br>" .' </span>' ;
                            }
                            ?>
                        <!-- </span> -->
                    </div>

                </div>
            </div>
        </div>
        <?php } ?>
    </div>


    <!-- Email Subscriptions Chart -->
    <!-- <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h5 class="text-lg font-semibold text-gray-300 mb-4">Email Subscriptions</h5>
            <div class="h-64 bg-gray-700 rounded-lg p-4 overflow-y-auto">
                Add subscription data for multiple companies here
            </div>
        </div> -->

    <!-- Completed Tasks Chart -->
    <!-- <div class="bg-gray-800 p-6 rounded-lg shadow-lg"> -->
    <!-- <h5 class="text-lg font-semibold text-gray-300 mb-4">Completed Tasks</h5>
            <div class="h-64 bg-gray-700 rounded-lg p-4 overflow-y-auto">
                Add completed tasks data for multiple companies here
            </div>
        </div> -->

    <!-- Tasks by Project Chart -->
    <!-- <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h5 class="text-lg font-semibold text-gray-300 mb-4">Tasks by Project</h5>
            <div class="h-64 bg-gray-700 rounded-lg p-4 overflow-y-auto">
                Add tasks by project data for multiple companies here
            </div>
        </div> -->
</div>
</div>

<!-- Add JavaScript for Dropdown -->
<script>
document.getElementById('profileDropdownButton').addEventListener('click', function() {
    var dropdown = document.getElementById('profileDropdown');
    dropdown.classList.toggle('hidden');
});
</script>

<?php  }?>
<script>
function toggleForm() {
    var elements = document.getElementsByClassName('form-container');
    for (var i = 0; i < elements.length; i++) {
        elements[i].classList.toggle('hidden');
    }
}
</script>