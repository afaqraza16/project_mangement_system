<?php
include 'include/connect.php';
if (isset($_GET['comp_id'])) {
    $id = $_GET['comp_id'];
}

$allData = $pdo->prepare("SELECT create_task.task_name, project.pro_id, project.pro_name,company_profile.com_name FROM `create_task` LEFT JOIN project on project.pro_id = create_task.proj_id LEFT JOIN company_profile on company_profile.com_id = project.com_id WHERE project.pro_id = :pro_id ");
// $allData->execute([':pro_id', 1]);
// if ($_GET['id']) {
$params = [
    ':pro_id' => 1

];
// }
$allData->execute($params);
$result = $allData->fetchAll(PDO::FETCH_ASSOC);


// select the task from the task status
// $taskStatus = $pdo->prepare("SELECT * form create_task");


// print "<pre>";
// print_r($result);
// print "</pre>";
?>



<div class="mx-auto max-w-screen-2xl bg-gray-900 text-white p-10">
    <div class="mx-auto">

        <div
            class="flex flex-col rounded-lg border border-gray-700 bg-gray-800 text-white px-5 py-7 shadow-2xl shadow-white">
            <div class="flex justify-between">
                <h3 class="text-3xl font-bold ">
                    Tasks Status
                </h3>


            </div>
        </div>
    </div>
    <!-- Task Header End -->

    <!-- Task List Wrapper Start -->
    <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 xl:grid-cols-3">

        <!-- To-Do List -->
        <div class="swim-lane flex flex-col gap-6">
            <h4 class="text-2xl font-bold text-white mb-4">
                To Do's (03)
            </h4>

            <!-- Task Card -->
            <div draggable="true"
                class="task relative flex cursor-move justify-between rounded-lg border border-gray-600 bg-gray-800 p-7 shadow-lg shadow-black transition duration-300 hover:shadow-2xl">
                <div>
                    <h5 class="mb-4 text-xl font-semibold text-white">
                        Task Title
                    </h5>

                    <div class="flex flex-col gap-4">
                        <?php foreach ($result as $res) {  ?>
                        <label class="cursor-pointer">
                            <div class="relative flex py-4 gap-4 text-lg items-center pt-1">
                                <input type="checkbox"
                                    class="form-checkbox h-6 w-6 text-blue-500 rounded-md border-gray-600 focus:ring-0 focus:outline-none">
                                <p><?php echo $res['task_name']  ?></p>
                            </div>
                            <?php }  ?>
                        </label>




                    </div>
                </div>
            </div>
            <!-- Task Card End -->

            <!-- Duplicate Task Cards as needed -->
            <!-- ... -->

        </div>

        <!-- In Progress List -->
        <div class="swim-lane flex flex-col gap-6">
            <h4 class="text-2xl font-bold text-white mb-4">
                In Progress (01)
            </h4>

            <!-- Task Card -->
            <div draggable="true"
                class="task relative flex cursor-move justify-between rounded-lg border border-gray-600 bg-gray-800 p-7 shadow-lg shadow-black transition duration-300 hover:shadow-2xl">
                <div>
                    <h5 class="mb-4 text-xl font-semibold text-white">
                        Task Title
                    </h5>
                    <p>
                        Dedicated form for a category of users that will perform.
                    </p>

                    <div class="my-4">
                        <img src="https://cdn.pixabay.com/photo/2021/08/02/00/10/flowers-6515538_640.jpg" alt="Task"
                            class="rounded-lg shadow-md shadow-black">
                    </div>

                    <div class="flex flex-col gap-4">
                        <label class="cursor-pointer">
                            <div class="relative flex gap-4 text-lg items-center pt-1">
                                <input type="checkbox"
                                    class="form-checkbox h-6 w-6 text-blue-500 rounded-md border-gray-600 focus:ring-0 focus:outline-none">
                                <p>Here is task one</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <!-- Task Card End -->
        </div>

        <!-- Completed List -->
        <div class="swim-lane flex flex-col gap-6">
            <h4 class="text-2xl font-bold text-white mb-4">
                Completed (01)
            </h4>

            <!-- Task Card -->
            <div draggable="true"
                class="task relative flex cursor-move justify-between rounded-lg border border-gray-600 bg-gray-800 p-7 shadow-lg shadow-black transition duration-300 hover:shadow-2xl">
                <div>
                    <h5 class="mb-4 text-xl font-semibold text-white">
                        Task Title
                    </h5>

                    <div class="flex flex-col gap-4">
                        <label class="cursor-pointer">
                            <div class="relative flex gap-4 text-lg items-center pt-1">
                                <input type="checkbox"
                                    class="form-checkbox h-6 w-6 text-blue-500 rounded-md border-gray-600 focus:ring-0 focus:outline-none">
                                <p>Here is task one</p>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <div class="relative flex gap-4 text-lg items-center pt-1">
                                <input type="checkbox"
                                    class="form-checkbox h-6 w-6 text-blue-500 rounded-md border-gray-600 focus:ring-0 focus:outline-none">
                                <p>Here is task two</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <!-- Task Card End -->
        </div>
    </div>
    <!-- Task List Wrapper End -->
</div>