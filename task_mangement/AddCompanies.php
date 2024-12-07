<?php

include 'include/connect.php';

$uid = "";
if (isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];
    print $uid;
}

$com_name = "";
$com_email = "";
$comp_desc = "";
$contact = "";
$comp_address = "";
$created_on = time();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['com_name'])) {
        if (empty($_POST['com_name'])) {
            $errors['com_name'] = "Company name is required";
        }
        $com_name = $_POST['com_name'];
    }
    if (isset($_POST['com_email'])) {
        if (empty($_POST['com_email'])) {
            $errors['com_email'] = "Company email is required";
        }
        $com_email = $_POST['com_email'];
    }
    if (isset($_POST['comp_desc'])) {
        if (empty($_POST['comp_desc'])) {
            $errors['comp_desc'] = "Company description is required";
        }
        $comp_desc = $_POST['comp_desc'];
    }
    if (isset($_POST['contact'])) {
        if (empty($_POST['contact'])) {
            $errors['contact'] = "Contact information is required";
        }
        $contact = $_POST['contact'];
    }
    if (isset($_POST['comp_address'])) {
        if (empty($_POST['comp_address'])) {
            $errors['comp_address'] = "Company address is required";
        }
        $comp_address = $_POST['comp_address'];
    }

    if (count($errors) == 0) {
        $stmt = $pdo->prepare("INSERT INTO company_profile (com_name, com_email, comp_desc, contact, comp_address, created_on, uid) 
                               VALUES (:com_name, :com_email, :comp_desc, :contact, :comp_address, :created_on, :uid)");
        $params = [
            ':com_name' => $com_name,
            ':com_email' => $com_email,
            ':comp_desc' => $comp_desc,
            ':contact' => $contact,
            ':comp_address' => $comp_address,
            ':created_on' => $created_on,
            ':uid' => $uid
        ];

        $stmt->execute($params);
    }
}
?>


<div class="flex min-h-screen items-center justify-center">
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-8 w-full max-w-lg">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6 text-center">Create Company Profile</h2>
        <form action="index.php?page=AddCompanies" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="Com_Name" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Company
                    Name</label>
                <input type="text" name="com_name" id="contact" placeholder="Enter Company information" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
            </div>
            <div class="mb-4">
                <label for="Email" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Email</label>
                <input type="email" name="com_email" id="contact" placeholder="Enter Email information" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
            </div>
            <div class="mb-4">
                <label for="comp_desc" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Company
                    Description</label>
                <textarea name="comp_desc" id="comp_desc" placeholder="Enter company description" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"></textarea>
            </div>
            <div class="mb-4">
                <label for="contact" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Contact</label>
                <input type="number" name="contact" id="contact" placeholder="Enter contact information" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
            </div>
            <div class="mb-4">
                <label for="comp_address" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Company
                    Address</label>
                <input type="text" name="comp_address" id="comp_address" placeholder="Enter company address" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
            </div>

            <input type="hidden" name="com_id" value="<?php echo $uid; ?>">
            <div class="text-center">
                <button type="submit" class="bg-blue-500 w-full text-white px-4 py-2 rounded-lg hover:bg-blue-600">Submit</button>
            </div>
        </form>
    </div>
</div>