<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | DICT Document Tracker</title>
    
    <!-- Google Fonts: Poppins for a Modern/Tech look -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            /* DICT Specific Color Palette */
            --dict-blue: #0038A8;
            --dict-dark-blue: #002366;
            --dict-red: #CE1126;
            --dict-yellow: #FCD116;
            --dict-bg-gray: #f4f6f9;
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif; /* Updated Font */
            background-color: var(--dict-bg-gray);
        }

        .main-container {
            display: flex;
            min-height: 100vh;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }

        /* LEFT PANEL: Form */
        .form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            background-color: #ffffff;
            position: relative;
        }

        .form-wrapper {
            max-width: 420px;
            width: 100%;
            padding: 20px;
        }

        .logo-container img {
            width: 110px;
            height: auto;
            transition: transform 0.3s ease;
        }
        
        .logo-container img:hover {
            transform: scale(1.05);
        }

        .welcome-title {
            font-weight: 700;
            color: var(--dict-dark-blue);
            letter-spacing: -0.5px;
        }

        .welcome-subtitle {
            font-weight: 400;
            font-size: 0.95rem;
            color: #6c757d;
        }

        /* Custom Input Fields */
        .form-floating > .form-control {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            background-color: #fdfdfd;
        }

        .form-floating > .form-control:focus {
            border-color: var(--dict-blue);
            box-shadow: 0 0 0 0.25rem rgba(0, 56, 168, 0.15);
        }

        .form-floating > label {
            color: #888;
        }

        /* Custom Button */
        .btn-dict {
            background-color: var(--dict-blue);
            border-color: var(--dict-blue);
            color: white;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }

        .btn-dict:hover {
            background-color: var(--dict-dark-blue);
            border-color: var(--dict-dark-blue);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 35, 102, 0.2);
        }

        /* RIGHT PANEL: Visuals */
        .image-panel {
            flex: 1.5;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            /* Gradient based on DICT Blue with a tech feel */
            background: linear-gradient(135deg, var(--dict-blue) 0%, var(--dict-dark-blue) 100%);
            overflow: hidden;
            color: white;
            padding: 4rem;
            text-align: center;
        }

        /* Abstract Tech Background Overlay */
        .image-panel::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            /* Network/Tech Image overlaid */
            background-image: url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2072&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            opacity: 0.2; /* Low opacity to blend with the blue */
            mix-blend-mode: overlay;
        }

        .image-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
        }

        /* Decorative Accent Line (Yellow/Red) */
        .accent-line {
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--dict-yellow), var(--dict-red));
            margin: 0 auto 1.5rem auto;
            border-radius: 2px;
        }

        .display-title {
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .display-text {
            font-size: 1.1rem;
            font-weight: 300;
            opacity: 0.9;
            line-height: 1.6;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .image-panel {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="main-container">

    <!-- Left Side: The Form Panel -->
    <div class="form-panel">
        <div class="form-wrapper">
            
            <!-- DICT Logo -->
            <div class="text-center mb-4 logo-container">
                <img src="<?= base_url('assets/img/DICT-Logo-2.jpg') ?>" alt="DICT Logo">
            </div>

            <div class="text-center mb-5">
                <h2 class="welcome-title">Welcome Back</h2>
                <p class="welcome-subtitle">Please enter your credentials to access the system.</p>
            </div>

            <!-- Display Login Errors -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="<?= site_url('savelogin') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Username Field with Floating Label -->
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                    <label for="username"><i class="bi bi-person me-2"></i>Username</label>
                </div>

                <!-- Password Field with Floating Label -->
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                </div>

                <button type="submit" class="btn btn-dict w-100 btn-lg shadow-sm">
                    Log In
                </button>
                
                <div class="text-center mt-4">
                    <small class="text-muted">Department of Information and Communications Technology</small>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Side: The Visual Panel -->
    <div class="image-panel">
        <div class="image-content">
            <div class="accent-line"></div>
            <h1 class="display-4 display-title">Document Tracking System</h1>
            <p class="display-text">
                Efficiently monitor the movement and status of official documents. 
                Ensuring <strong>accountability</strong>, <strong>transparency</strong>, and <strong>speed</strong> 
                across all government offices.
            </p>
        </div>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>