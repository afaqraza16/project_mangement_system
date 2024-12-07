<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
    /* Custom Animations */
    .hover-animate:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease-in-out;
    }

    .hover-animate img:hover {
        transform: scale(1.1);
        transition: transform 0.3s ease-in-out;
    }
    </style>
</head>

<body class="bg-gray-900 text-white">
    <?php
    include 'header.php';
    include 'main.php';
    include 'footer.php';
    ?>



    <script>
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('menu');

    menuToggle.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
    </script>
</body>

</html>