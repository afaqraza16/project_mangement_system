 <!-- Header -->
 <header class="bg-gray-800 px-4 md:px-10">
     <div class="container mx-auto flex justify-between items-center p-6">
         <div class="text-3xl flex gap-2 items-center text-gray-300 uppercase font-bold"><i class="fa-solid fa-bars-progress"></i>SAAS
         </div>
         <nav class="hidden md:flex space-x-6">
             <a href="#" class="hover:text-gray-400">Home</a>
             <a href="#features" class="hover:text-gray-400">Features</a>
             <a href="#pricing" class="hover:text-gray-400">Pricing</a>
             <a href="#contact" class="hover:text-gray-400">Contact</a>
         </nav>
         <div class="hidden md:flex">
             <a href="../register.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Sign Up</a>
             <a href="../Login.php" class="ml-4 bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Login</a>
         </div>
         <div class="md:hidden">
             <button id="menu-toggle" class="text-gray-400 focus:outline-none focus:text-white">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                     </path>
                 </svg>
             </button>
         </div>
     </div>
     <div id="menu" class="hidden md:hidden">
         <a href="#" class="block px-4 py-2 text-gray-400 hover:text-white">Home</a>
         <a href="#features" class="block px-4 py-2 text-gray-400 hover:text-white">Features</a>
         <a href="#pricing" class="block px-4 py-2 text-gray-400 hover:text-white">Pricing</a>
         <a href="#contact" class="block px-4 py-2 text-gray-400 hover:text-white">Contact</a>
         <div class="px-4 py-2">
             <a href="#" class="block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Sign Up</a>
             <a href="#" class="block mt-2 bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Login</a>
         </div>
     </div>
 </header>