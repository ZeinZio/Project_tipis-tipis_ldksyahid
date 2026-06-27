@extends('landing-page.template.body')

@section('styles')
<style>
    /* Base Variables */
    :root {
        --primary-gradient: linear-gradient(135deg, #00a79d 0%, #00796b 100%);
        --accent-gradient: linear-gradient(135deg, #f39c12 0%, #d35400 100%);
        --glass-bg: rgba(255, 255, 255, 0.85);
        --glass-border: rgba(255, 255, 255, 0.5);
        --dark-glass: rgba(30, 41, 59, 0.85);
    }

    html.dark-mode :root {
        --glass-bg: rgba(30, 41, 59, 0.7);
        --glass-border: rgba(255, 255, 255, 0.1);
    }

    /* Typography & Utilities */
    .font-outfit { font-family: 'Outfit', 'Heebo', sans-serif; }
    .text-gradient {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    html.dark-mode .text-gradient {
        background: linear-gradient(135deg, #4fd1c5 0%, #81e6d9 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Glassmorphism Cards */
    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
        position: relative;
    }

    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 167, 157, 0.15);
        border-color: rgba(0, 167, 157, 0.3);
    }

    /* Hero Banner */
    .hero-banner {
        background: var(--primary-gradient);
        border-radius: 24px;
        padding: 3rem 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 15px 30px rgba(0, 167, 157, 0.25);
    }

    .hero-banner::before {
        content: '';
        position: absolute;
        top: -50%; right: -10%;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
        animation: pulse 4s infinite alternate;
    }

    .hero-banner::after {
        content: '';
        position: absolute;
        bottom: -30%; left: 10%;
        width: 200px; height: 200px;
        background: radial-gradient(circle, rgba(243,156,18,0.3) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
        animation: pulse 5s infinite alternate-reverse;
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 0.5; }
        100% { transform: scale(1.5); opacity: 1; }
    }

    /* Progress Bar */
    .custom-progress {
        height: 10px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        overflow: hidden;
    }
    .custom-progress-bar {
        background: #f39c12;
        height: 100%;
        border-radius: 10px;
        position: relative;
        transition: width 1.5s ease-in-out;
    }
    .custom-progress-bar::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0) 100%);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    /* Action Buttons */
    .btn-glass {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        border-radius: 30px;
        padding: 10px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-glass:hover {
        background: white;
        color: #00a79d;
        transform: scale(1.05);
    }

    /* Icon Box */
    .icon-box {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 1.5rem;
        background: rgba(0, 167, 157, 0.1);
        color: #00a79d;
        transition: all 0.3s ease;
    }
    .glass-card:hover .icon-box {
        background: var(--primary-gradient);
        color: white;
        transform: rotate(10deg);
    }
    html.dark-mode .icon-box {
        background: rgba(79, 209, 197, 0.15);
        color: #4fd1c5;
    }

    /* Portfolio Grid */
    .portfolio-img {
        height: 200px;
        object-fit: cover;
        width: 100%;
        border-radius: 12px 12px 0 0;
        transition: transform 0.5s ease;
    }
    .portfolio-card:hover .portfolio-img {
        transform: scale(1.1);
    }
    .img-wrapper {
        overflow: hidden;
        border-radius: 12px 12px 0 0;
    }
    
    .badge-soft {
        background: rgba(0, 167, 157, 0.1);
        color: #00a79d;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    html.dark-mode .badge-soft {
        background: rgba(79, 209, 197, 0.2);
        color: #4fd1c5;
    }

    /* ATS Score Circle */
    .score-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: conic-gradient(#f39c12 {{ $cvScore ?? 85 }}%, rgba(255,255,255,0.2) 0);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .score-circle::before {
        content: '';
        position: absolute;
        width: 100px;
        height: 100px;
        background: var(--primary-gradient);
        border-radius: 50%;
    }
    .score-value {
        position: relative;
        font-size: 2rem;
        font-weight: 800;
        color: white;
    }
</style>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('content')
@php
    // Dummy Data for Preview
    $userName = auth()->user()->name ?? 'Pengguna';
    $cvScore = 85;
    $profileCompleteness = 90;
    $isVerified = true;
@endphp

<div class="container py-5 font-outfit mb-5 mt-5">
    
    <!-- Hero Banner -->
    <div class="hero-banner mb-5">
        <div class="row align-items-center">
            <div class="col-lg-8" style="z-index: 1;">
                <span class="badge bg-white text-dark mb-3 px-3 py-2 rounded-pill shadow-sm" style="font-weight: 600;">
                    <i class="fas fa-rocket text-warning me-2"></i> ATS-Friendly Workspace
                </span>
                <h1 class="display-5 fw-bold mb-2">Ahlan wa Sahlan, {{ $userName }}!</h1>
                <p class="fs-5 mb-4" style="opacity: 0.9;">Tingkatkan peluang karirmu dengan Digital CV dan Portofolio yang terstandarisasi. Biarkan karyamu yang berbicara.</p>
                
                <div class="mb-4 w-75">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-semibold">Kelengkapan Profil</span>
                        <span class="fw-bold">{{ $profileCompleteness }}%</span>
                    </div>
                    <div class="custom-progress">
                        <div class="custom-progress-bar" style="width: {{ $profileCompleteness }}%;"></div>
                    </div>
                </div>

                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('user.cv.index') }}" class="btn-glass text-decoration-none" style="color: inherit;"><i class="fas fa-tools me-2"></i>CV Builder</a>
                    <a href="{{ route('user.portfolio.index') }}" class="btn-glass text-decoration-none" style="color: inherit;"><i class="fas fa-briefcase me-2"></i>Portfolio Builder</a>
                    <div class="dropdown">
                        <button class="btn-glass dropdown-toggle" type="button" data-bs-toggle="dropdown" style="color: inherit; border: none; background: rgba(255,255,255,0.1);">
                            <i class="fas fa-download me-2"></i>Unduh PDF
                        </button>
                        <ul class="dropdown-menu shadow">
                            <li><a class="dropdown-item" href="{{ route('user.cv.download', ['template' => 'profesional']) }}"><i class="fas fa-file-pdf me-2 text-danger"></i>Template Profesional</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.cv.download', ['template' => 'kreatif']) }}"><i class="fas fa-file-pdf me-2 text-warning"></i>Template Kreatif</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 d-flex justify-content-center mt-4 mt-lg-0" style="z-index: 1;">
                <div class="text-center">
                    <div class="score-circle mx-auto mb-3 shadow-lg">
                        <span class="score-value">{{ $cvScore }}</span>
                    </div>
                    <h5 class="fw-bold mb-1">ATS Match Score</h5>
                    <span class="badge bg-white text-success px-3 py-1 rounded-pill"><i class="fas fa-check-circle me-1"></i> Sangat Baik</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Title -->
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-gradient">Manajemen CV</h3>
            <p class="text-muted mb-0">Perbarui data diri, pendidikan, dan pengalamanmu di sini.</p>
        </div>
    </div>

    <!-- CV Quick Actions Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-5 g-4 mb-5">
        <!-- Personal Info -->
        <div class="col">
            <div class="glass-card h-100 p-4">
                <div class="icon-box">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h5 class="fw-bold mb-2">Data Diri</h5>
                <p class="text-muted small mb-4">Informasi dasar, kontak, dan ringkasan profil (summary).</p>
                <div class="d-flex justify-content-between align-items-center mt-auto">
                    <span class="badge-soft"><i class="fas fa-check me-1"></i> Lengkap</span>
                    <a href="{{ route('user.cv.index', ['tab' => 'personal']) }}" class="btn btn-sm btn-light rounded-circle shadow-sm" style="width:35px;height:35px;line-height:22px;"><i class="fas fa-arrow-right" style="color:var(--primary);"></i></a>
                </div>
            </div>
        </div>

        <!-- Education -->
        <div class="col">
            <div class="glass-card h-100 p-4">
                <div class="icon-box" style="background: rgba(243, 156, 18, 0.1); color: #f39c12;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h5 class="fw-bold mb-2">Pendidikan</h5>
                <p class="text-muted small mb-4">Riwayat pendidikan formal dan sertifikasi.</p>
                <div class="d-flex justify-content-between align-items-center mt-auto">
                    <span class="badge-soft" style="background: rgba(243, 156, 18, 0.1); color: #f39c12;"><i class="fas fa-exclamation-circle me-1"></i> 1 Perlu Update</span>
                    <a href="{{ route('user.cv.index', ['tab' => 'education']) }}" class="btn btn-sm btn-light rounded-circle shadow-sm" style="width:35px;height:35px;line-height:22px;"><i class="fas fa-arrow-right" style="color:#f39c12;"></i></a>
                </div>
            </div>
        </div>

        <!-- Experience -->
        <div class="col">
            <div class="glass-card h-100 p-4">
                <div class="icon-box" style="background: rgba(155, 89, 182, 0.1); color: #9b59b6;">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h5 class="fw-bold mb-2">Pengalaman</h5>
                <p class="text-muted small mb-4">Riwayat kerja, magang, dan organisasi.</p>
                <div class="d-flex justify-content-between align-items-center mt-auto">
                    <span class="badge-soft" style="background: rgba(155, 89, 182, 0.1); color: #9b59b6;"><i class="fas fa-check me-1"></i> 3 Entri</span>
                    <a href="{{ route('user.cv.index', ['tab' => 'experience']) }}" class="btn btn-sm btn-light rounded-circle shadow-sm" style="width:35px;height:35px;line-height:22px;"><i class="fas fa-arrow-right" style="color:#9b59b6;"></i></a>
                </div>
            </div>
        </div>

        <!-- Skills -->
        <div class="col">
            <div class="glass-card h-100 p-4">
                <div class="icon-box" style="background: rgba(231, 76, 60, 0.1); color: #e74c3c;">
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="fw-bold mb-2">Keahlian</h5>
                <p class="text-muted small mb-4">Hard skill, soft skill, dan bahasa yang dikuasai.</p>
                <div class="d-flex justify-content-between align-items-center mt-auto">
                    <span class="badge-soft" style="background: rgba(231, 76, 60, 0.1); color: #e74c3c;"><i class="fas fa-check me-1"></i> 8 Keahlian</span>
                    <a href="{{ route('user.cv.index', ['tab' => 'skills']) }}" class="btn btn-sm btn-light rounded-circle shadow-sm" style="width:35px;height:35px;line-height:22px;"><i class="fas fa-arrow-right" style="color:#e74c3c;"></i></a>
                </div>
            </div>
        </div>

        <!-- Projects -->
        <div class="col">
            <div class="glass-card h-100 p-4">
                <div class="icon-box" style="background: rgba(52, 152, 219, 0.1); color: #3498db;">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h5 class="fw-bold mb-2">Proyek</h5>
                <p class="text-muted small mb-4">Proyek pengembangan, publikasi, atau riset.</p>
                <div class="d-flex justify-content-between align-items-center mt-auto">
                    <span class="badge-soft" style="background: rgba(52, 152, 219, 0.1); color: #3498db;"><i class="fas fa-check me-1"></i> 2 Proyek</span>
                    <a href="{{ route('user.cv.index', ['tab' => 'projects']) }}" class="btn btn-sm btn-light rounded-circle shadow-sm" style="width:35px;height:35px;line-height:22px;"><i class="fas fa-arrow-right" style="color:#3498db;"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Section -->
    <div class="d-flex justify-content-between align-items-end mb-4 mt-5">
        <div>
            <h3 class="fw-bold mb-1 text-gradient">Galeri Portofolio</h3>
            <p class="text-muted mb-0">Kelola dan pilih format karya terbaikmu untuk ditampilkan.</p>
        </div>
    </div>

    <style>
        .portfolio-action-card {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            text-decoration: none !important;
            display: flex;
            flex-direction: column;
            color: inherit;
            cursor: pointer;
        }
        .portfolio-action-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            border-color: rgba(255, 255, 255, 1);
        }
        .portfolio-action-card .pac-icon-ring {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 2;
            background: white;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            transition: all 0.4s ease;
        }
        .portfolio-action-card:hover .pac-icon-ring {
            transform: scale(1.1) rotate(5deg);
        }
        .pac-blob {
            position: absolute;
            top: -20%;
            right: -20%;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            opacity: 0.1;
            transition: all 0.5s ease;
            z-index: 0;
        }
        .portfolio-action-card:hover .pac-blob {
            transform: scale(1.5);
            opacity: 0.15;
        }
        .portfolio-action-card h4 {
            font-weight: 800;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 2;
        }
        .portfolio-action-card p {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 2;
            flex-grow: 1;
        }
        .pac-cta {
            font-weight: 700;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            z-index: 2;
            transition: gap 0.3s ease;
        }
        .portfolio-action-card:hover .pac-cta {
            gap: 0.8rem;
        }
    </style>

    <div class="row g-4 mb-5">
        <!-- Card 1: Web App Portfolio -->
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('user.portfolio.index') }}" class="portfolio-action-card">
                <div class="pac-blob" style="background: #10b981;"></div>
                <div class="pac-icon-ring" style="color: #10b981;">
                    <i class="fas fa-globe"></i>
                </div>
                <h4>Portofolio Website</h4>
                <p>Buat situs portofolio interaktif secara online dengan desain profesional dan Live Preview.</p>
                <div class="pac-cta" style="color: #10b981;">
                    Buat Web Portofolio <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>

        <!-- Card 2: PDF Portfolio -->
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('user.portfolio.pdf') }}" class="portfolio-action-card">
                <div class="pac-blob" style="background: #ef4444;"></div>
                <div class="pac-icon-ring" style="color: #ef4444;">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <h4>Portofolio PDF</h4>
                <p>Unggah atau rancang ulang karya kreatif dan desain grafismu dalam format dokumen statis.</p>
                <div class="pac-cta" style="color: #ef4444;">
                    Kelola PDF Portofolio <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>

        <!-- Card 3: Galeri / View All -->
        <div class="col-md-6 col-lg-4">
            <a href="#" class="portfolio-action-card" style="border: 2px dashed rgba(0,0,0,0.1); background: transparent; box-shadow: none;">
                <div class="pac-blob" style="background: #6366f1;"></div>
                <div class="pac-icon-ring" style="color: #6366f1; background: transparent; box-shadow: none; border: 2px dashed rgba(99, 102, 241, 0.3);">
                    <i class="fas fa-images"></i>
                </div>
                <h4>Lihat Semua Karya</h4>
                <p>Jelajahi seluruh karya, proyek, dan desain yang telah kamu pamerkan sebelumnya.</p>
                <div class="pac-cta" style="color: #6366f1;">
                    Buka Galeri <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
