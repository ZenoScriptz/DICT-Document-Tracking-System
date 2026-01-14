<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <style>
        body {
            background-color: #f2f6fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-hover {
            border-radius: 15px;
            color: #fff;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.2);
        }
        .gradient-office {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        }
        .gradient-user {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
        }
        .card-text {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">MyApp Dashboard</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="navbar-text text-light">
                        Logged in as: <?= session()->get('fullname'); ?> (<?= session()->get('role'); ?>)
                    </span>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('logout'); ?>" class="nav-link text-light">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Container -->
<div class="container mt-5">

    <div class="text-center mb-4">
        <h2>Welcome, <?= session()->get('fullname'); ?>!</h2>
        <p class="text-muted">You are logged in as <strong><?= session()->get('role'); ?> but not authorized to view the dashboard. Please click logout.</strong>.</p>
        <p class="text-primary" id="current-time"></p>
    </div>


</div>

<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>

<!-- Script for dynamic date and time -->
<script>
    function updateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour:'2-digit', minute:'2-digit', second:'2-digit' };
        document.getElementById('current-time').innerText = now.toLocaleDateString('en-US', options);
    }
    setInterval(updateTime, 1000);
    updateTime(); // initial call
</script>

</body>
</html>
