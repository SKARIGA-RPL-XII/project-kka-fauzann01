<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Sistem Persewaan Dekorasi</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
            color: #e9ecef;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(145deg, #1e1e2f 0%, #2a2a3e 50%, #3a3a5e 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255,255,255,0.1);
            color: white;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            box-shadow: 4px 0 25px rgba(0,0,0,0.3);
            overflow-y: auto;
        }
        .sidebar.collapsed {
            width: 80px;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            transition: all 0.3s ease;
            border-radius: 12px;
            margin: 8px 15px;
            padding: 12px 20px;
            position: relative;
            overflow: hidden;
        }
        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s;
        }
        .sidebar .nav-link:hover::before {
            left: 100%;
        }
        .sidebar .nav-link:hover {
            color: white;
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            position: relative;
        }
        .sidebar .nav-link.active::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background: white;
            border-radius: 2px;
        }
        .sidebar .nav-link i {
            margin-right: 15px;
            width: 22px;
            font-size: 1.1em;
        }
        .sidebar.collapsed .nav-link span {
            display: none;
        }
        .sidebar.collapsed .nav-link i {
            margin-right: 0;
            text-align: center;
        }
        .sidebar h5 {
            font-weight: 600;
            letter-spacing: 1px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .main-content {
            margin-left: 280px;
            padding: 30px;
            transition: margin-left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            flex: 1;
        }
        .main-content.expanded {
            margin-left: 80px;
        }
        .header {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            padding: 25px 30px;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            font-weight: 600;
            font-size: 2.2em;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5em;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }
        .user-avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        }
        .card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px 20px 0 0 !important;
            padding: 20px 25px;
            font-weight: 600;
            font-size: 1.1em;
        }
        .stats-card {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border: 1px solid rgba(102, 126, 234, 0.2);
        }
        .stats-card .card-body {
            padding: 25px;
        }
        .stats-card h5 {
            font-weight: 500;
            margin-bottom: 10px;
            color: #e9ecef;
        }
        .stats-card p {
            font-size: 2.5em;
            font-weight: 700;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .stats-card i {
            font-size: 2.5em;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .btn-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .table {
            background: rgba(255,255,255,0.05);
            border-radius: 15px;
            overflow: hidden;
        }
        .table th {
            background: rgba(255,255,255,0.1);
            border: none;
            color: #e9ecef;
            font-weight: 600;
            padding: 15px;
        }
        .table td {
            border: none;
            color: #adb5bd;
            padding: 15px;
            vertical-align: middle;
        }
        .table tbody tr {
            transition: all 0.3s ease;
        }
        .table tbody tr:hover {
            background: rgba(255,255,255,0.05);
        }
        .badge {
            border-radius: 20px;
            padding: 6px 12px;
            font-weight: 500;
        }
        .btn-outline-primary {
            border-color: #667eea;
            color: #667eea;
        }
        .btn-outline-primary:hover {
            background: #667eea;
            border-color: #667eea;
        }
        .toggle-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }
        .toggle-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 30px rgba(0,0,0,0.4);
        }
        @media (min-width: 769px) {
            .toggle-btn {
                display: none;
            }
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .main-content.expanded {
                margin-left: 0;
            }
            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 999;
                display: none;
            }
            .overlay.show {
                display: block;
            }
        }
        .footer {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #adb5bd;
            text-align: center;
            padding: 20px;
            margin-top: auto;
        }
        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }
        .dropdown-menu.glassmorphism {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            border-radius: 15px;
            overflow: hidden;
        }
        .dropdown-item {
            color: #e9ecef;
            transition: all 0.3s ease;
            padding: 10px 20px;
        }
        .dropdown-item:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(5px);
        }
        .dropdown-header {
            color: #adb5bd;
            font-weight: 600;
            padding: 10px 20px;
            margin: 0;
            background: rgba(255,255,255,0.05);
        }
        .stats-card:hover {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { box-shadow: 0 8px 32px rgba(0,0,0,0.1); }
            50% { box-shadow: 0 15px 40px rgba(102, 126, 234, 0.3); }
            100% { box-shadow: 0 8px 32px rgba(0,0,0,0.1); }
        }
        .welcome-message {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border: 1px solid rgba(102, 126, 234, 0.2);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }
        .welcome-message h2 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .welcome-message p {
            color: #adb5bd;
            font-size: 1.1em;
        }
    </style>
</head>
<body>
    <!-- Toggle Button for Mobile -->
    <button class="toggle-btn d-md-none" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar">
        <div class="p-3">
            <h5 class="text-center mb-4">
                <i class="fas fa-crown"></i> <span>Admin Panel</span>
            </h5>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#dashboard">
                        <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#dekorasi">
                        <i class="fas fa-palette"></i> <span>Dekorasi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#pelanggan">
                        <i class="fas fa-users"></i> <span>Pelanggan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#pesanan">
                        <i class="fas fa-shopping-cart"></i> <span>Pesanan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#laporan">
                        <i class="fas fa-chart-bar"></i> <span>Laporan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#pengaturan">
                        <i class="fas fa-cog"></i> <span>Pengaturan</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Overlay for Mobile -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <!-- Main Content -->
    <main id="main-content" class="main-content">
        <div class="header fade-in">
            <h1><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h1>
            <div class="dropdown">
                <button class="btn btn-link text-decoration-none p-0 d-flex align-items-center" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar me-3">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="text-start">
                        <div class="fw-bold text-white">Admin</div>
                        <small class="text-white fw-bold"><i class="fas fa-crown me-1"></i>Super Administrator</small>
                    </div>
                    <i class="fas fa-chevron-down ms-2 text-white"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end glassmorphism" aria-labelledby="profileDropdown">
                    <li><h6 class="dropdown-header">Admin Profile</h6></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user-edit me-2"></i>Edit Profil</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-bell me-2"></i>Notifikasi</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>

        <!-- Welcome Message -->
        <div class="welcome-message fade-in">
            <h2>Selamat Datang, Admin!</h2>
            <p>Kelola sistem persewaan dekorasi Anda dengan mudah dan efisien. Pantau performa bisnis dan kelola pesanan dengan dashboard interaktif ini.</p>
        </div>

        <!-- Dashboard Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stats-card fade-in">
                    <div class="card-body text-center">
                        <i class="fas fa-palette"></i>
                        <h5>Total Dekorasi</h5>
                        <p>150</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stats-card fade-in">
                    <div class="card-body text-center">
                        <i class="fas fa-users"></i>
                        <h5>Total Pelanggan</h5>
                        <p>85</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stats-card fade-in">
                    <div class="card-body text-center">
                        <i class="fas fa-shopping-cart"></i>
                        <h5>Pesanan Aktif</h5>
                        <p>23</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stats-card fade-in">
                    <div class="card-body text-center">
                        <i class="fas fa-dollar-sign"></i>
                        <h5>Pendapatan Bulan Ini</h5>
                        <p>Rp 5.2M</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="card fade-in">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-list me-2"></i>Pesanan Terbaru</h5>
                <a href="#" class="btn btn-custom btn-sm">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Dekorasi</th>
                                <th>Tanggal Sewa</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#001</td>
                                <td>John Doe</td>
                                <td>Dekorasi Pernikahan</td>
                                <td>2023-10-15</td>
                                <td><span class="badge bg-success">Selesai</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning me-1">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>#002</td>
                                <td>Jane Smith</td>
                                <td>Dekorasi Ulang Tahun</td>
                                <td>2023-10-20</td>
                                <td><span class="badge bg-warning">Diproses</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning me-1">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>#003</td>
                                <td>Bob Johnson</td>
                                <td>Dekorasi Seminar</td>
                                <td>2023-10-25</td>
                                <td><span class="badge bg-info">Dikonfirmasi</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning me-1">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 Sistem Persewaan Dekorasi. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        // Desktop Sidebar Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            // Add toggle functionality for desktop
            const toggleBtn = document.querySelector('.toggle-btn');
            if (window.innerWidth >= 769) {
                // For desktop, add click to collapse
                document.addEventListener('click', function(e) {
                    if (!sidebar.contains(e.target) && !e.target.classList.contains('toggle-btn')) {
                        sidebar.classList.remove('collapsed');
                        mainContent.classList.remove('expanded');
                    }
                });

                sidebar.addEventListener('click', function(e) {
                    if (e.target.tagName === 'A' || e.target.closest('a')) {
                        sidebar.classList.add('collapsed');
                        mainContent.classList.add('expanded');
                    }
                });
            }
        });

    </script>
</body>
</html>