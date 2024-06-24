<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>PIN</title>
</head>
<body>
    <div class="flex min-h-screen w-screen font-sans bg-[#F2F6FA]">
        <aside class="bg-dark-gray min-w-[181px] text-white">
            <div class="flex">
                <div class="h-[59px] w-[79px] bg-white rounded-br-[20px]">
                    <img class="m-auto py-4" src="./images/min-logo.png" alt="logo">
                </div>
                <div class="text-[11px] leading-3 p-2 pl-3 font-normal">
                    Enterprise<br/>Resource<br/>Planning
                </div>
            </div>
            <nav>
                <ul class="py-3 px-8 opacity-70 text-[12px]">
                    <a href="#">Продукты</a>
                </ul>
            </nav>
        </aside>
        <div class="w-full">
            <header class="w-full bg-white h-[59px] flex justify-between">
                <nav class="h-full text-center inline-block">
                    <ul class="h-full text-[12px] flex uppercase ml-5">
                        <li class="mr-4 flex justify-center items-center border-red-500 border-b-4 text-red-500 font-normal">
                            <a href="#">Продукты</a>
                        </li>
                    </ul>
                </nav>
                <div class="flex justify-center items-center mr-5 text-gray-400 text-[11px]">Иванов Иван Иванович</div>
            </header>
            <main class="content">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
