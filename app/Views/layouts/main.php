<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> | DICT Document Tracker</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS Links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            /* DICT Color Palette */
            --dict-blue: #0038A8;
            --dict-dark-blue: #002366;
            --dict-red: #CE1126;
            --dict-yellow: #FCD116;
            --dict-bg-gray: #f4f6f9;
            --text-dark: #2c3e50;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--dict-bg-gray);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Card Styling Overrides */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #888; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555; 
        }

        /* Footer Styling */
        footer {
            background-color: var(--dict-dark-blue) !important;
            color: rgba(255,255,255,0.8);
            margin-top: auto; /* Pushes footer to bottom */
        }
        
        .main-content {
            flex: 1;
        }
    </style>
</head>
<body>

    <?= $this->include('templates/header') ?>

    <main class="main-content container mt-4 py-4">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer is usually in a template, but if you put it here directly: -->
    <footer class="text-center py-3">
        <div class="container">
            <small>&copy; <?= date('Y') ?> DICT Document Tracking System. All Rights Reserved.</small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <?= $this->renderSection('scripts') ?>

</body>
</html>