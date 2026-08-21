<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1">

    <title>
        @yield('title', 'Aplikasi Angsuran')
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: #f5f6fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;

            position: fixed;
            left: 0;
            top: 0;

            background: #212529;
            color: white;

            z-index: 1000;

            display: flex;
            flex-direction: column;

            overflow: hidden;
        }

        .sidebar-brand {
            height: 65px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            font-size: 18px;
            font-weight: 600;
            background: #0d6efd;
        }

        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;

            padding: 15px 10px;
        }

        .sidebar-menu .menu-title {
            font-size: 11px;
            color: #adb5bd;
            margin: 18px 10px 7px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            margin-bottom: 3px;
            color: #dee2e6;
            text-decoration: none;
            border-radius: 6px;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: #0d6efd;
            color: white;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-menu::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.25);
            border-radius: 10px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.4);
        }


        .sidebar-footer {
            flex-shrink: 0;

            padding: 10px;

            background: #212529;

            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logout-button {
            width: 100%;

            display: flex;
            align-items: center;
            gap: 10px;

            padding: 10px 12px;

            border: none;
            border-radius: 6px;

            background: transparent;

            color: #dee2e6;

            text-align: left;

            cursor: pointer;
        }

        .logout-button:hover {
            background: #dc3545;
            color: white;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            padding-top: 65px;
        }

        .topbar {
            height: 65px;
            background: white;
            border-bottom: 1px solid #dee2e6;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 25px;

            position: fixed;
            top: 0;
            right: 0;

            left: 250px;

            z-index: 999;

            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        }

        .content {
            padding: 25px;
        }

        .footer {
            padding: 15px 25px;
            color: #6c757d;
            font-size: 13px;
        }

        .stat-card {
            border: none;
            border-radius: 10px;
        }

        @media (max-width: 768px) {

            .sidebar {
                width: 70px;
            }

            .sidebar-brand span,
            .sidebar-menu span,
            .menu-title {
                display: none;
            }

            .sidebar-menu a {
                justify-content: center;
            }

            .main-content {
                margin-left: 70px;
            }

            .topbar {
                left: 70px;
                padding: 0 15px;
            }

        }
    </style>

    @stack('styles')

</head>

<body>

    @include('layouts.sidebar')

    <div class="main-content">

        @include('layouts.navbar')

        <main class="content">

            @yield('content')

        </main>

        @include('layouts.footer')

    </div>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

    @stack('scripts')

</body>

</html>