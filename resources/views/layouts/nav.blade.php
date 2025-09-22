<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

        <h1 class="text-lg font-semibold hidden md:block">Welcome To medical store</h1>
        <form action="" class="flex items center gap-2 md:gap:4 max-w-[400px] md:min-w-[700px]">
            <input type="text" placholder="search" value="" name="q" class="border-[#333]  rounded-lg px-2 lg:px-4 py-2 flex-1"/>
            <button class="bg-blue-600 text-white font-semibold px-4 rounded-lg">Search</button>
        </form>
        <div class="relative block">
            <span class="absolute top-[-8px] right-[-16px] bg-red-600 w-5 h-5 rounded-full text-sm text-white text-center vertical-center">
                {{count(session('cart'))}}
            </span>
            <a href="/cart" class="w-full h-full block"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M24 48C10.7 48 0 58.7 0 72C0 85.3 10.7 96 24 96L69.3 96C73.2 96 76.5 98.8 77.2 102.6L129.3 388.9C135.5 423.1 165.3 448 200.1 448L456 448C469.3 448 480 437.3 480 424C480 410.7 469.3 400 456 400L200.1 400C188.5 400 178.6 391.7 176.5 380.3L171.4 352L475 352C505.8 352 532.2 330.1 537.9 299.8L568.9 133.9C572.6 114.2 557.5 96 537.4 96L124.7 96L124.3 94C119.5 67.4 96.3 48 69.2 48L24 48zM208 576C234.5 576 256 554.5 256 528C256 501.5 234.5 480 208 480C181.5 480 160 501.5 160 528C160 554.5 181.5 576 208 576zM432 576C458.5 576 480 554.5 480 528C480 501.5 458.5 480 432 480C405.5 480 384 501.5 384 528C384 554.5 405.5 576 432 576z"/></svg></a>
        </div>
        
        </div>
    </div>

   
</nav>
