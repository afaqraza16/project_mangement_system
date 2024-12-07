<?php
 include 'include/connect.php';
 $comp_id = $_GET['comp_id'];
//  print $comp_id;
  $projects = $pdo->prepare("SELECT project.pro_name,project.pro_desc
 , company_profile.com_name
 FROM `project` LEFT JOIN company_profile on company_profile.com_id = project.com_id where project.com_id = :com_id ");;
  $params =[
     ':com_id' => $comp_id
  ];
  $projects->execute($params);
  $projects = $projects->fetchAll(PDO::FETCH_ASSOC);
//   print_r($projects);
    $count = count($projects);
    // print $count;
    // All Selection
    $tasks = $pdo->prepare("Select * from create_task ");
    $tasks->execute();
    $tasks = $tasks->fetchAll(PDO::FETCH_ASSOC);
    $countTask = count($tasks);
    // Selection On the base of Status
    $tasksOnStatus = $pdo->prepare("Select * from create_task where task_status = :status");
    $params =[
        ':status' => 'Pending'
        ];
        $tasksOnStatus->execute($params);
          $tasksOnStatus = $tasksOnStatus->fetchAll(PDO::FETCH_ASSOC);
        //   print_r($tasksOnStatus);
    $tasksOnStatusOnProgress = $pdo->prepare("Select * from create_task where task_status = :status");
    $params =[
        ':status' => 'Progress'
        ];
        $tasksOnStatusOnProgress->execute($params);
          $tasksOnStatusOnProgress = $tasksOnStatusOnProgress->fetchAll(PDO::FETCH_ASSOC);
        //   print_r($tasksOnStatusOnProgress);
    $tasksOnStatusOnCompleted= $pdo->prepare("Select * from create_task where task_status = :status");
    $params =[
        ':status' => 'Completed'
        ];
        $tasksOnStatusOnCompleted->execute($params);
          $tasksOnStatusOnCompleted = $tasksOnStatusOnCompleted->fetchAll(PDO::FETCH_ASSOC);
        //   print_r($tasksOnStatusOnCompleted);

    //  print_r($tasksOnStatusOnProgress);


    $users = $pdo->prepare("SELECT user_profile.user_Fullname,users.user_email,
user_profile.user_role FROM `user_com_junc` LEFT JOIN users on users.uid = user_com_junc.uid LEFT JOIN user_profile on user_profile.uid = users.uid where user_com_junc.com_id = :com_id ");
$params =[
    ':com_id' => $comp_id
    ];
    $users->execute($params);
    $users = $users->fetchAll(PDO::FETCH_ASSOC);
    // print_r($users);


?>




<body class="bg-gray-900 text-gray-300">

    <!-- Main Content -->
    <main class="flex-grow p-8 border border-gray-600 space-y-6">
        <h1 class="text-4xl  font-bold italic  rounded-lg   text-white ">
            Company Dashboard
        </h1>
        <section class="shadow-xl shadow-white">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Total Projects Card -->
                <div class="bg-gray-800  rounded-lg shadow text-center border-b border-gray-600">
                    <h3 class="text-2xl font-bold text-white mb-2 py-4 rounded-lg bg-green-700">Total Projects</h3>
                    <p class="text-4xl font-extrabold text-teal-500"><?php echo $count; ?></p>
                    <p class="text-gray-400 mt-2">Ongoing Projects</p>
                </div>
                <!-- Total Tasks Card -->
                <div class="bg-gray-800   rounded-lg  border-b border-gray-600 shadow text-center">
                    <h3 class="text-2xl font-bold py-4 rounded-lg  text-white bg-purple-500 mb-2">Total Tasks</h3>
                    <p class="text-4xl font-extrabold text-teal-500"><?php print $countTask ;?></p>
                    <p class="text-gray-400 mt-2">Total Tasks</p>
                </div>
                <!-- Task Status Card -->
                <div class="bg-gray-800  rounded-lg shadow text-center border-b border-gray-600 pb-2">
                    <h3 class="text-2xl bg-yellow-500 py-4 rounded  font-bold  text-white mb-2">Task Status</h3>
                    <div class="mt-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-400">To Do</span>
                            <span class="text-white font-bold">5</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-4 mb-4">
                            <div class="bg-green-500 h-4 rounded-full" style="width: 80%;"></div>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-400">In Progress</span>
                            <span class="text-white font-bold">12</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-4 mb-4">
                            <div class="bg-yellow-500 h-4 rounded-full" style="width: 50%;"></div>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-400">Done</span>
                            <span class="text-white font-bold">7</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-4">
                            <div class="bg-indigo-500 h-4 rounded-full" style="width: 40%;"></div>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-400">Due Date</span>
                            <span class="text-white font-bold">3</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-4">
                            <div class="bg-red-500 h-4 rounded-full" style="width: 20%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Projects Overview -->
        <section class="shadow-2xl shadow-white">
            <h2 class="text-2xl font-bold mb-4 text-white">Projects Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php  foreach($projects as $project){ ?>
                <div class="bg-gray-800  border border-gray-600 rounded-lg shadow">
                    <h3 class="text-xl text-center  p-0 py-4 px-2 bg-yellow-500 rounded font-bold mb-2 text-white">
                        <?php echo $project['pro_name'] ?>
                    </h3>
                    <p class="text-gray-400 text-center p-4 "><?php echo $project['pro_desc'] ?></p>
                    <h2 class="text-center text-2xl mb-6 mt-4">Company Name:-<?php echo $project['com_name']?></h2>
                </div>
                <?php   } ?>
            </div>
        </section>

        <!-- Team Members -->
        <section class="shadow-2xl shadow-white">
            <h2 class="text-2xl font-bold mb-4 text-white">Team Members</h2>

            <div
                class="bg-gray-800 flex   flex-wrap items-center justify-start p-6 gap-6 rounded-lg shadow shadow-white space-y-4">
                <?php  foreach($users  as $index=> $user){   ?>
                <?php  if($index <4) {  ?>
                <div
                    class="flex  border-b border-yellow-600 bg-gray-800 items-center p-6 shadow-2xl shadow-white space-x-6 ">
                    <img src="https://via.placeholder.com/40" alt="Team Member"
                        class="rounded-full border-4 border-yellow-600 w-12 h-12">
                    <div>
                        <h3 class="text-xl font-bold text-white"><?php echo $user['user_Fullname'] ?></h3>
                        <p class="text-gray-400">Role : <?php echo $user['user_role'] ?> </p>
                        <p class="text-teal-500">User Email : <?php echo $user['user_email'] ?> </p>
                    </div>
                </div>

                <?php }?>
                <?php }?>

                <!-- Add more team members as needed -->
            </div>
        </section>

        <!-- Task Status -->
        <section class="shadow-2xl shadow-white">
            <h2 class="text-2xl font-bold mb-4 text-white">Task Status</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- To Do -->
                <div>
                    <h3
                        class="text-xl font-bold border-b border-gray-600 shadow-2xl shadow-white  text-center bg-purple-500 py-4 rounded-lg text-white">
                        Pending</h3>
                    <?php foreach($tasksOnStatus as $task_status){ ?>
                    <div class="bg-gray-800 p-3 rounded-lg shadow ">
                        <div class="p-4 bg-gray-700 rounded-lg"><?php echo $task_status['task_name'] ?></div>
                    </div>
                    <?php }?>
                </div>
                <!-- In Progress -->
                <div>
                    <h3
                        class="text-xl  border-b border-gray-600 shadow-2xl shadow-white  text-center bg-purple-500 py-4 font-bold rounded-lg mb-2 text-white">
                        In Progress</h3>
                    <?php foreach($tasksOnStatusOnProgress as $task_status){ ?>
                    <div class="bg-gray-800 p-3 rounded-lg shadow ">
                        <div class="p-4 bg-gray-700 rounded-lg"><?php echo $task_status['task_name'] ?></div>
                    </div>
                    <?php }?>
                </div>
                <!-- Done -->
                <div>
                    <h3
                        class="text-xl font-bold mb-2 border-b border-gray-600 shadow-2xl shadow-white  text-center bg-purple-500 py-4 font-bold rounded-lg text-white">
                        Done</h3>
                    <?php foreach($tasksOnStatusOnCompleted as $task_status){ ?>
                    <div class="bg-gray-800 p-3 rounded-lg shadow ">
                        <div class="p-4 bg-gray-700 rounded-lg"><?php echo $task_status['task_name'] ?></div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </section>
    </main>