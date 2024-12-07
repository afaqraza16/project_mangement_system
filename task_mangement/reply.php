<?php
$task_id = "";
if(isset($_GET['task_id'])){
    $task_id =  $_GET['task_id'];
}
if(isset($_GET['taskid'])){
    $task_id =  $_GET['taskid'];
}
// Fetch replies for a specific comment
$replies = $pdo->prepare("
    SELECT r.rep_desc, r.time, u.uname
    FROM replytable r 
    JOIN users u ON r.uid = u.uid 
    WHERE r.com_id = :com_id
    ORDER BY r.time ASC
");
$replies->execute([
    ':com_id' => $comment['com_id']
]);
$replies = $replies->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="bg-gray-800 w-full p-6 rounded-lg shadow-lg mb-6">
    <button id="toggleReplyForm-<?php echo $comment['com_id']; ?>"
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow">
        Reply
    </button>

    <!-- Reply Form -->
    <div id="replyForm-<?php echo $comment['com_id']; ?>"
        class="hidden bg-gray-800 w-full p-6 rounded-lg shadow-lg mb-6 mt-4">
        <h2 class="text-xl font-semibold text-gray-200 mb-4">Add a Reply:</h2>
        <form method="post" action="index.php?page=taskInfo&taskid=<?php echo $task_id; ?>">
            <div class="mb-4">
                <textarea name="rep_desc"
                    class="w-full p-3 border border-gray-600 rounded-lg bg-gray-700 text-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    rows="4" placeholder="Enter your reply here..." required></textarea>
            </div>
            <input type="hidden" name="com_id" value="<?php echo $comment['com_id']; ?>">
            <div class="text-start">
                <button type="submit" name="submit_reply"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow">
                    Submit Reply
                </button>
            </div>
        </form>
    </div>
    <!-- Display Replies -->
    <div class="bg-gray-800 ml-24 w-[70%] p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold text-gray-200 mb-4">Replies:</h2>
        <?php if (!empty($replies)) : ?>
        <?php foreach ($replies as $reply) : ?>
        <div class="flex items-start mb-4">
            <svg class="w-10 h-10 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z"
                    clip-rule="evenodd" />
            </svg>
            <div class="ml-4">
                <p class="text-gray-300">
                    <?php echo htmlspecialchars($reply['rep_desc']); ?>
                </p>
                <p class="text-gray-500 text-sm">
                    <?php echo htmlspecialchars($reply['uname']); ?> -
                    <?php echo date("F j, Y, g:i a", strtotime($reply['time'])); ?>
                </p>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else : ?>
        <p class="text-gray-500">No replies yet. Be the first to reply!</p>
        <?php endif; ?>

        <!-- Reply Button -->

    </div>
</div>

<!-- JavaScript to toggle reply form visibility -->
<script>
document.getElementById('toggleReplyForm-<?php echo $comment['com_id']; ?>').addEventListener('click', function() {
    var replyForm = document.getElementById('replyForm-<?php echo $comment['com_id']; ?>');
    if (replyForm.classList.contains('hidden')) {
        replyForm.classList.remove('hidden');
    } else {
        replyForm.classList.add('hidden');
    }
});
</script>