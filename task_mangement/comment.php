<?php
// Connect to the database
include 'include/connect.php';
$task_id = "";
if(isset($_GET['task_id'])){
    $task_id =  $_GET['task_id'];
}
if(isset($_GET['taskid'])){
    $task_id =  $_GET['taskid'];
}


// print $task_id;

// Fetch comments for the task
$comments = $pdo->prepare("SELECT comment.com_id, comment.com_desc, users.uname, comment.time FROM `comment`  LEFT JOIN users on users.uid = comment.uid WHERE comment.task_id =:task_id  ORDER BY time DESC");
    $comments->execute([":task_id" => $task_id]);
$comments = $comments->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="bg-gray-800 p-8 rounded-lg shadow-lg mb-6">
    <h2 class="text-xl font-semibold text-gray-200 mb-4">Add a Comment:</h2>
    <form method="post" action="index.php?page=taskInfo&task_id=<?php echo $task_id;?>">
        <div class="mb-4">
            <textarea name="com_desc"
                class="w-full p-3 border border-gray-600 rounded-lg bg-gray-700 text-gray-300 focus:border-blue-500 focus:ring-blue-500"
                rows="4" placeholder="Enter your comment here..." required></textarea>
        </div>
        <div class="text-start">
            <button type="submit" name="submit_comment"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow">
                Submit Comment
            </button>
        </div>
    </form>
</div>

<!-- Comments Section -->
<div class="bg-gray-800 p-6 rounded-lg shadow-lg">
    <h2 class="text-xl font-semibold text-gray-200 mb-4">Comments:</h2>
    <?php if (!empty($comments)) : ?>
    <?php foreach ($comments as $comment) : ?>

    <div class="flex flex-col  items-start mb-6">
        <!-- User Icon -->
        <div class="flex-shrink-0 flex items-center gap-2 mr-4">
            <svg class="w-10 h-10 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z"
                    clip-rule="evenodd" />
            </svg>
            <p class="text-gray-300 text-xg font-bold underline italic mb-1">
                <?php echo ucwords(htmlspecialchars($comment['uname'])); ?>
            </p>
        </div>
        <!-- Comment Content -->
        <div class="px-10">
            <p class="text-gray-300 text-lg font-medium mb-1">
                <?php echo htmlspecialchars($comment['com_desc']); ?>
            </p>
            <p class="text-gray-500 text-sm">
                <?php echo date("F j, Y, g:i a", strtotime($comment['time'])); ?>
            </p>
        </div>
        <?php  include 'reply.php'; ?>

    </div>
    <?php endforeach; ?>
    <?php else : ?>
    <p class="text-gray-500">No comments yet. Be the first to comment!</p>
    <?php endif; ?>
</div>