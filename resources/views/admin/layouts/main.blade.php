<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('title','PerpusKita')</title>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

body{
font-family:'Inter',sans-serif;
}

/* Scrollbar */
*{
scrollbar-width:thin;
}
*::-webkit-scrollbar{
width:6px;
}
*::-webkit-scrollbar-thumb{
background:#cbd5e1;
border-radius:3px;
}
*::-webkit-scrollbar-thumb:hover{
background:#94a3b8;
}

/* Sidebar link */
.link{
transition:all .3s ease;
}
.link:hover{
background:linear-gradient(90deg,rgba(59,130,246,.1) 0%,transparent 100%);
border-left:4px solid #3b82f6;
}
.link.active{
background:linear-gradient(90deg,rgba(59,130,246,.15) 0%,transparent 100%);
border-left:4px solid #3b82f6;
color:#3b82f6;
}

/* Card hover */
.stat-card{
transition:transform .3s ease,box-shadow .3s ease;
}
.stat-card:hover{
transform:translateY(-5px);
box-shadow:0 20px 25px -5px rgba(0,0,0,.1),
0 10px 10px -5px rgba(0,0,0,.04);
}
</style>

@yield('style')
</head>

<body class="bg-gray-50 overflow-hidden">

<div class="flex h-screen w-full">

<!-- Sidebar -->
@include('admin.partials.sidebar')

<!-- Right Area -->
<div class="flex-1 flex flex-col overflow-hidden">

<!-- Topbar -->
<div class="sticky top-0 z-40 bg-white border-b">
@include('admin.partials.topbar')
</div>

<!-- Content -->
<main class="flex-1 overflow-y-auto p-6">
@yield('main-content')
</main>

</div>

</div>

@yield('script')
</body>
</html>
