@extends('landing-page.template.body')

@section('styles')
<style>
    .glass-card-cv {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        padding: 2rem;
    }
    .sticky-preview {
        position: sticky;
        top: 20px;
        height: 100vh;
        overflow-y: hidden;
    }
    .cv-paper-container {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        background: #fff;
    }
    .nav-tabs .nav-link {
        color: #6c757d;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 1rem;
        font-weight: 500;
        transition: all 0.3s;
    }
    .nav-tabs .nav-link:hover {
        color: var(--primary);
        border-color: rgba(0, 167, 157, 0.2);
    }
    .nav-tabs .nav-link.active {
        color: var(--primary);
        border: none;
        border-bottom: 2px solid var(--primary);
        background: transparent;
    }
</style>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid py-5 mt-5 font-outfit px-lg-5" style="min-height: 80vh;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--primary);">Portfolio Builder</h2>
            <p class="text-muted">Bangun portofolio karya kamu. Perubahan akan langsung terlihat di sebelah kanan.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <a href="{{ route('user.portfolio.downloadZip') }}" class="btn btn-success rounded-pill px-4" style="background: #10b981; border: none;">
                <i class="fas fa-file-archive me-2"></i>Download Web (ZIP)
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Editor Column -->
        <div class="col-lg-5">
            <div class="glass-card-cv">
                
                <h5 class="fw-bold mb-3" style="color: var(--primary);">Pengaturan Portofolio</h5>
                
                <!-- Tabs -->
                <ul class="nav nav-tabs mb-4" id="portfolioTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="projects-tab" data-bs-toggle="tab" data-bs-target="#projects" type="button" role="tab" aria-selected="true">
                            <i class="fas fa-folder-open me-1"></i>Karya
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="web-tab" data-bs-toggle="tab" data-bs-target="#web" type="button" role="tab" aria-selected="false">
                            <i class="fas fa-globe me-1"></i>Web Portofolio
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="export-tab" data-bs-toggle="tab" data-bs-target="#export" type="button" role="tab" aria-selected="false">
                            <i class="fas fa-file-archive me-1"></i>Export ZIP
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="portfolioTabsContent">
                    <!-- Tab 1: Daftar Proyek -->
                    <div class="tab-pane fade show active" id="projects" role="tabpanel" aria-labelledby="projects-tab">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-bold m-0 text-muted">Daftar Proyek / Karya</h6>
                            <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addPortfolioModal" style="background: var(--primary); border: none;">
                                <i class="fas fa-plus me-1"></i> Tambah
                            </button>
                        </div>

                        <div class="portfolio-list" style="max-height: 500px; overflow-y: auto;">
                            @forelse($portfolios as $item)
                                <div class="card border border-light bg-light mb-3 rounded-3 position-relative shadow-sm">
                                    <div class="card-body p-3">
                                        <form action="{{ route('user.portfolio.destroy', $item->id) }}" method="POST" class="ajax-form d-inline position-absolute" style="top: 15px; right: 15px;" onsubmit="return confirm('Hapus karya ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-link text-danger p-0"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                        <h6 class="fw-bold mb-1" style="color: #2c3e50;">{{ $item->project_name }}</h6>
                                        <p class="text-muted small mb-2">{{ $item->project_role }}</p>
                                        <div class="mb-2">
                                            <span class="badge bg-white text-dark border"><i class="far fa-calendar-alt me-1 text-primary"></i>{{ $item->date_completed ? \Carbon\Carbon::parse($item->date_completed)->format('M Y') : 'Ongoing' }}</span>
                                        </div>
                                        @if($item->project_url)
                                            <a href="{{ $item->project_url }}" target="_blank" class="small text-decoration-none fw-semibold" style="color: var(--primary);"><i class="fas fa-external-link-alt me-1"></i>Kunjungi Tautan</a>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5 text-muted border rounded-3 border-dashed bg-white">
                                    <i class="fas fa-folder-open fs-1 mb-3" style="color: #cbd5e1;"></i>
                                    <p class="mb-0 small fw-medium">Belum ada karya ditambahkan</p>
                                    <p class="small text-muted mt-1">Tambahkan proyek untuk memperkaya portofoliomu</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Tab 2: Web Portfolio Settings -->
                    <div class="tab-pane fade" id="web" role="tabpanel" aria-labelledby="web-tab">
                        <div class="alert alert-info border-0 rounded-3 mb-4" style="background: rgba(0, 167, 157, 0.05); color: #00a79d;">
                            <i class="fas fa-info-circle me-2"></i> Portofolio berbasis web yang profesional, langsung terintegrasi dengan CV dan Proyekmu.
                        </div>

                        <form action="#" method="POST">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Tema Tampilan (Theme)</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="border rounded-3 p-3 text-center cursor-pointer" style="background: #0f172a; color: white; border-color: var(--primary) !important; border-width: 2px !important;">
                                            <i class="fas fa-moon mb-2 fs-4"></i>
                                            <div class="small fw-semibold">Dark Elite</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="border rounded-3 p-3 text-center cursor-pointer bg-white" style="color: #334155; opacity: 0.7;">
                                            <i class="fas fa-sun mb-2 fs-4"></i>
                                            <div class="small fw-semibold">Clean Light</div>
                                            <div class="badge bg-light text-dark mt-1" style="font-size: 0.6rem;">Coming Soon</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Aksen Warna (Accent Color)</label>
                                <div class="d-flex gap-2" id="accent-color-options">
                                    <div class="color-picker rounded-circle border border-2 active" data-color="#10b981" style="width: 35px; height: 35px; background: #10b981; border-color: #fff !important; outline: 2px solid #10b981; cursor: pointer; transition: 0.2s;"></div>
                                    <div class="color-picker rounded-circle border border-2 opacity-50" data-color="#3b82f6" style="width: 35px; height: 35px; background: #3b82f6; cursor: pointer; transition: 0.2s;"></div>
                                    <div class="color-picker rounded-circle border border-2 opacity-50" data-color="#f43f5e" style="width: 35px; height: 35px; background: #f43f5e; cursor: pointer; transition: 0.2s;"></div>
                                    <div class="color-picker rounded-circle border border-2 opacity-50" data-color="#8b5cf6" style="width: 35px; height: 35px; background: #8b5cf6; cursor: pointer; transition: 0.2s;"></div>
                                    <div class="color-picker rounded-circle border border-2 opacity-50" data-color="#f59e0b" style="width: 35px; height: 35px; background: #f59e0b; cursor: pointer; transition: 0.2s;"></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted">Tautan Khusus (Custom Link)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-0">ldksyah.id/p/</span>
                                    <input type="text" class="form-control bg-light border-0" value="{{ strtolower(str_replace(' ', '', $user->name)) }}" disabled>
                                </div>
                                <div class="form-text small">Tautan publik ini bisa dibagikan ke rekruter.</div>
                            </div>

                            <button type="button" class="btn btn-primary w-100 rounded-pill py-2" style="background: var(--primary); border: none;" onclick="alert('Pengaturan Web Portofolio berhasil disimpan!');"><i class="fas fa-save me-2"></i>Simpan Pengaturan Web</button>
                            <a href="#" class="btn btn-outline-primary w-100 rounded-pill py-2 mt-2" onclick="alert('Membuka tab baru ke Web Portofolio publik...');"><i class="fas fa-external-link-alt me-2"></i>Buka Halaman Publik</a>
                        </form>
                    </div>

                    <!-- Tab 3: Export ZIP Settings -->
                    <div class="tab-pane fade" id="export" role="tabpanel" aria-labelledby="export-tab">
                        <div class="text-center py-4">
                            <i class="fas fa-file-archive fa-4x mb-3 text-success opacity-75"></i>
                            <h6 class="fw-bold">Download Source Code (ZIP)</h6>
                            <p class="small text-muted mb-4">Unduh file HTML dan aset portofolio web Anda untuk di-hosting secara mandiri di server atau domain pribadi.</p>
                            <a href="{{ route('user.portfolio.downloadZip') }}" class="btn btn-success rounded-pill px-4 py-2 w-100 shadow-sm">
                                <i class="fas fa-download me-2"></i>Download ZIP Portofolio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Column -->
        <div class="col-lg-7">
            <div class="sticky-preview" id="previewColumnContainer">
                <!-- Preview Header Controls -->
                <div class="d-flex justify-content-between align-items-center mb-3" id="previewHeader">
                    <h5 class="fw-bold mb-0"><i class="fas fa-desktop me-2 text-primary"></i>Live Preview</h5>
                    <div class="d-flex gap-2 align-items-center">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-dark" id="btn-preview-web">Web Preview</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary ms-2" id="btn-fullscreen" title="Toggle Fullscreen">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>
                </div>

                <div class="cv-paper-container h-100 position-relative shadow-lg transition-all" id="previewCard" style="border: 1px solid rgba(0,0,0,0.1); border-radius: 15px; overflow: hidden; background: #0b0f19;">
                    <!-- Loading Overlay -->
                    <div id="loadingOverlay" class="position-absolute w-100 h-100 d-none justify-content-center align-items-center" style="background: rgba(11, 15, 25, 0.8); z-index: 10;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    
                    <!-- Web Portfolio HTML Preview (Default) -->
                    <div id="webPreviewContainer" class="w-100 h-100 overflow-auto scrollbar-dark" style="height: calc(100vh - 120px); display: block;">
                        
                        <div style="background-color: #05070a; color: #f8fafc; min-height: 100%; font-family: sans-serif; position: relative;">
                            
                            <!-- Top Navigation Bar -->
                            <div style="background: rgba(11, 15, 25, 0.9); padding: 1.5rem 2rem; border-bottom: 1px solid rgba(16, 185, 129, 0.2); display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 50; backdrop-filter: blur(10px);">
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width: 40px; height: 40px; border-radius: 8px; border: 2px solid #10b981; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #10b981; font-size: 1.2rem; background: rgba(16, 185, 129, 0.1);">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <h6 style="margin: 0; font-weight: 800; letter-spacing: 1px; color: #f8fafc;">ATSYAHID <span style="font-weight: 400; color: #10b981;">web portfolio</span></h6>
                                        <span style="font-size: 0.65rem; color: #64748b; letter-spacing: 2px;">LDKSYAH.ID DIGITAL SHOWCASE</span>
                                    </div>
                                </div>
                                <div>
                                    <button id="btn-exit-fullscreen-nav" class="d-none" style="background: #10b981; color: #000; border: none; padding: 0.5rem 1.2rem; border-radius: 8px; font-weight: 600; font-size: 0.85rem; transition: 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">&larr; Kembali ke Desain CV</button>
                                </div>
                            </div>
                            
                            <!-- Dynamic Header Vibe -->
                            <div style="background: linear-gradient(135deg, #0c1b18 0%, #040a08 100%); border-bottom: 2px solid #10b981; padding: 3.5rem 1.5rem; position: relative; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);">
                                <div style="position: absolute; left: -3rem; bottom: -3rem; width: 12rem; height: 12rem; border-radius: 50%; background: rgba(16, 185, 129, 0.2); filter: blur(40px);"></div>
                                <div style="position: absolute; right: -3rem; top: -3rem; width: 14rem; height: 14rem; border-radius: 50%; background: rgba(245, 158, 11, 0.1); filter: blur(40px);"></div>

                                <div style="max-width: 64rem; margin: 0 auto; display: flex; flex-direction: column; align-items: center; gap: 2rem; position: relative; z-index: 10;">
                                    @if(true)
                                    <div class="d-flex flex-column flex-md-row align-items-center gap-4 w-100">
                                        <!-- Avatar frame -->
                                        <div style="width: 8rem; height: 8rem; border-radius: 50%; border: 4px solid #10b981; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); overflow: hidden; display: flex; align-items: center; justify-content: center; background: #13161c; color: #10b981; font-family: serif; font-weight: bold; font-size: 2.25rem; flex-shrink: 0; position: relative;">
                                            <div style="position: absolute; inset: 4px; border-radius: 50%; border: 2px dotted rgba(16, 185, 129, 0.2);"></div>
                                            {{ substr($user->name, 0, 2) }}
                                        </div>

                                        <!-- Description & name -->
                                        <div class="text-center text-md-start flex-grow-1">
                                            <div style="display: inline-flex; items-center; gap: 0.375rem; padding: 0.25rem 0.75rem; background: rgba(245, 158, 11, 0.1); color: #fcd34d; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.6875rem; border-radius: 9999px; border: 1px solid rgba(245, 158, 11, 0.3); margin-bottom: 0.5rem;">
                                                <i class="fas fa-star" style="font-size: 0.6875rem;"></i> Digital Portfolio Aktif
                                            </div>
                                            <h1 style="font-size: 2.25rem; font-family: serif; font-weight: bold; letter-spacing: -0.025em; color: white; margin-bottom: 0.25rem;">
                                                {{ $user->name }}
                                            </h1>
                                            <p style="color: #10b981; font-weight: bold; font-size: 1rem; letter-spacing: 0.025em; font-family: monospace; margin-bottom: 0.75rem;">
                                                Full-stack Developer & Creator
                                            </p>
                                            
                                            <!-- Quick contact tags -->
                                            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-start gap-2 pt-2" style="font-size: 0.75rem; color: #cbd5e1; font-weight: 500;">
                                                <span style="display: flex; align-items: center; gap: 0.25rem; background: rgba(19, 22, 28, 0.6); padding: 0.375rem 0.75rem; border-radius: 0.5rem; border: 1px solid rgba(255, 255, 255, 0.05);">
                                                    <i class="fas fa-map-marker-alt" style="color: #10b981;"></i> Jakarta, Indonesia
                                                </span>
                                                <span style="display: flex; align-items: center; gap: 0.25rem; background: rgba(19, 22, 28, 0.6); padding: 0.375rem 0.75rem; border-radius: 0.5rem; border: 1px solid rgba(255, 255, 255, 0.05);">
                                                    <i class="fas fa-envelope" style="color: #10b981;"></i> {{ $user->email }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Main Content Layout -->
                            <div style="max-width: 64rem; margin: 2rem auto 0; padding: 0 1rem; padding-bottom: 4rem;">
                                <div class="row g-4">
                                    
                                    <!-- Left Column (Bio & Skills) -->
                                    <div class="col-lg-4">
                                        <div class="d-flex flex-column gap-4">
                                            
                                            <!-- About Card -->
                                            <div style="background: #0b0c10; padding: 1.5rem; border-radius: 1rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.05); position: relative; overflow: hidden;">
                                                <div style="position: absolute; top: 0; right: 0; width: 4rem; height: 4rem; background: rgba(16, 185, 129, 0.05); border-bottom-left-radius: 9999px;"></div>
                                                <h3 style="color: white; font-weight: bold; font-size: 1rem; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                                                    <i class="far fa-user" style="color: #10b981;"></i> Profil Profesional
                                                </h3>
                                                <p style="font-size: 0.875rem; color: #cbd5e1; line-height: 1.625; text-align: justify; font-family: sans-serif; margin-bottom: 0;">
                                                    {{ $profile && $profile->tentangdiri ? $profile->tentangdiri : "Tidak ada rincian ringkasan profil ditambahkan." }}
                                                </p>
                                            </div>

                                            <!-- Skills Map -->
                                            <div style="background: #0b0c10; padding: 1.5rem; border-radius: 1rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.05);">
                                                <h3 style="color: white; font-weight: bold; font-size: 1rem; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                                                    <i class="fas fa-code" style="color: #10b981;"></i> Peta Keahlian
                                                </h3>
                                                
                                                <div class="d-flex flex-wrap gap-1 mb-4">
                                                    <button style="padding: 0.25rem 0.75rem; font-size: 0.625rem; font-weight: bold; border-radius: 0.5rem; text-transform: uppercase; letter-spacing: 0.025em; background: #10b981; color: white; border: none;">Semua</button>
                                                    <button style="padding: 0.25rem 0.75rem; font-size: 0.625rem; font-weight: bold; border-radius: 0.5rem; text-transform: uppercase; letter-spacing: 0.025em; background: #13161c; color: #94a3b8; border: none;">Teknis</button>
                                                </div>

                                                @if($skills && $skills->count() > 0)
                                                <div class="d-flex flex-column gap-3">
                                                    @foreach($skills as $skill)
                                                    <div>
                                                        <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.75rem; margin-bottom: 0.25rem;">
                                                            <span style="font-weight: bold; color: #e2e8f0;">{{ $skill->name }}</span>
                                                            <span style="font-family: monospace; color: #fcd34d; font-weight: bold; font-size: 0.625rem; background: rgba(245, 158, 11, 0.1); padding: 0.125rem 0.375rem; border-radius: 0.25rem; border: 1px solid rgba(245, 158, 11, 0.2);">
                                                                @php
                                                                    $percentage = 50;
                                                                    if($skill->level == 'Pemula') $percentage = 30;
                                                                    elseif($skill->level == 'Menengah') $percentage = 60;
                                                                    elseif($skill->level == 'Mahir') $percentage = 85;
                                                                    elseif($skill->level == 'Pakar') $percentage = 100;
                                                                @endphp
                                                                {{ $percentage }}%
                                                            </span>
                                                        </div>
                                                        <div style="width: 100%; height: 0.5rem; background: #13161c; border-radius: 9999px; overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.05);">
                                                            <div style="height: 100%; width: {{ $percentage }}%; background: linear-gradient(90deg, #10b981, #f59e0b);"></div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @else
                                                <p style="font-size: 0.75rem; color: #64748b; margin: 0;">Belum ada skill.</p>
                                                @endif
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <!-- Right Column (Experience & Projects) -->
                                    <div class="col-lg-8">
                                        <div class="d-flex flex-column gap-4">
                                            
                                            <!-- Experience Timeline -->
                                            <div style="background: #0b0c10; padding: 1.5rem; border-radius: 1rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.05);">
                                                <h3 style="color: white; font-weight: bold; font-size: 1rem; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 0.75rem;">
                                                    <i class="fas fa-briefcase" style="color: #10b981;"></i> Pengalaman & Kontribusi Karir
                                                </h3>

                                                @if($experiences && $experiences->count() > 0)
                                                <div style="position: relative; padding-left: 1.5rem; border-left: 2px solid rgba(16, 185, 129, 0.2);">
                                                    @foreach($experiences as $index => $exp)
                                                    <div style="position: relative; margin-bottom: 2rem;">
                                                        <span style="position: absolute; left: -1.9rem; top: 0.375rem; width: 1rem; height: 1rem; border-radius: 50%; background: #0b0c10; border: 2px solid #10b981; display: flex; align-items: center; justify-content: center; font-size: 0.625rem; color: #10b981; font-weight: bold;">
                                                            {{ $index + 1 }}
                                                        </span>
                                                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-1 mb-1">
                                                            <h4 style="font-size: 0.875rem; font-weight: 800; color: white; margin: 0;">{{ $exp->position }}</h4>
                                                            <span style="font-size: 0.625rem; font-weight: bold; color: #fcd34d; background: rgba(245, 158, 11, 0.1); padding: 0.125rem 0.625rem; border-radius: 0.25rem; border: 1px solid rgba(245, 158, 11, 0.2); font-family: monospace;">
                                                                <i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} - {{ $exp->is_current ? 'Sekarang' : \Carbon\Carbon::parse($exp->end_date)->format('M Y') }}
                                                            </span>
                                                        </div>
                                                        <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 500; margin-bottom: 0.375rem;">
                                                            {{ $exp->company }}
                                                        </div>
                                                        <p style="font-size: 0.75rem; color: #cbd5e1; line-height: 1.625; text-align: justify; margin: 0; padding-left: 0.25rem; padding-top: 0.375rem;">
                                                            {{ $exp->description }}
                                                        </p>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @else
                                                <p style="font-size: 0.875rem; color: #64748b; margin: 0;">Belum ada pengalaman kerja diunggah.</p>
                                                @endif
                                            </div>

                                            <!-- Projects Gallery -->
                                            <div style="background: #0b0c10; padding: 1.5rem; border-radius: 1rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.05);">
                                                <h3 style="color: white; font-weight: bold; font-size: 1rem; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 0.75rem;">
                                                    <i class="fas fa-folder" style="color: #10b981;"></i> Galeri Projek & Inovasi
                                                </h3>

                                                @if($portfolios && $portfolios->count() > 0)
                                                <div class="row g-3">
                                                    @foreach($portfolios as $proj)
                                                    <div class="col-md-6">
                                                        <div style="padding: 1.25rem; border-radius: 0.75rem; border: 1px solid rgba(255, 255, 255, 0.05); background: rgba(19, 22, 28, 0.4); height: 100%; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.3s;" onmouseover="this.style.background='rgba(19, 22, 28, 0.8)'; this.style.borderColor='rgba(16, 185, 129, 0.2)';" onmouseout="this.style.background='rgba(19, 22, 28, 0.4)'; this.style.borderColor='rgba(255, 255, 255, 0.05)';">
                                                            <div style="margin-bottom: 0.5rem;">
                                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                                    <span style="padding: 0.375rem; background: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 0.5rem;">
                                                                        <i class="fas fa-code" style="font-size: 0.875rem;"></i>
                                                                    </span>
                                                                    @if($proj->project_url)
                                                                    <a href="{{ $proj->project_url }}" target="_blank" style="color: #10b981; font-size: 0.75rem; font-weight: bold; text-decoration: none;">
                                                                        Demo <i class="fas fa-external-link-alt" style="font-size: 0.625rem;"></i>
                                                                    </a>
                                                                    @endif
                                                                </div>
                                                                <h4 style="font-size: 0.875rem; font-weight: bold; color: white; margin-top: 0.25rem; margin-bottom: 0.125rem;">{{ $proj->project_name }}</h4>
                                                                <div style="font-size: 0.625rem; color: #fcd34d; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">{{ $proj->project_role }}</div>
                                                                <p style="font-size: 0.75rem; color: #cbd5e1; line-height: 1.625; text-align: justify; margin: 0; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                                                    {{ $proj->description }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @else
                                                <p style="font-size: 0.875rem; color: #64748b; margin: 0;">Belum ada rincian projek ditambahkan.</p>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Styled Footer -->
                            <footer style="margin-top: 3.5rem; border-top: 1px solid rgba(255, 255, 255, 0.05); padding-top: 2rem; padding-bottom: 2rem; text-align: center; font-size: 0.75rem; color: #64748b; max-width: 64rem; margin-left: auto; margin-right: auto;">
                                <p style="margin-bottom: 0.375rem;">
                                    Portofolio Web yang dihasilkan oleh platform <strong style="color: #10b981; font-weight: 600; font-family: serif;">"CV Syahid AI"</strong>. Didesain mirip <a href="https://ldksyah.id/" target="_blank" style="color: #10b981; font-weight: bold; text-decoration: none;">ldksyah.id</a>.
                                </p>
                                <p style="margin: 0;">
                                    Dibuat dengan <i class="fas fa-heart" style="color: #f43f5e; font-size: 0.625rem;"></i> untuk mahasiswa dan talenta muda Indonesia.
                                </p>
                            </footer>

                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Portfolio -->
<div class="modal fade font-outfit" id="addPortfolioModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" style="color: var(--primary);">Tambah Karya / Proyek</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.portfolio.store') }}" method="POST" class="ajax-form">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nama Karya / Proyek</label>
                        <input type="text" class="form-control form-control-lg bg-light border-0" name="project_name" required placeholder="Contoh: Website LDK Syahid">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Peran Anda</label>
                        <input type="text" class="form-control form-control-lg bg-light border-0" name="project_role" required placeholder="Contoh: UI/UX Designer">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Tautan (URL) Proyek (Opsional)</label>
                        <input type="url" class="form-control form-control-lg bg-light border-0" name="project_url" placeholder="https://...">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">Tanggal Selesai (Kosongkan jika masih berlangsung)</label>
                            <input type="date" class="form-control bg-light border-0" name="date_completed">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Deskripsi Proyek (Opsional)</label>
                        <textarea class="form-control bg-light border-0" name="description" rows="3" placeholder="Ceritakan singkat tentang proyek ini dan kontribusimu..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2" style="background: var(--primary); border: none;">Simpan Karya</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.getElementById('loadingOverlay');
        const ajaxForms = document.querySelectorAll('.ajax-form');

        // Fullscreen Toggle Logic
        const btnFullscreen = document.getElementById('btn-fullscreen');
        const btnExitFullscreenNav = document.getElementById('btn-exit-fullscreen-nav');
        const previewColumn = document.getElementById('previewColumnContainer');
        const webPreviewContainer = document.getElementById('webPreviewContainer');
        let isFullscreen = false;

        function toggleFullscreen() {
            if (!isFullscreen) {
                // Enter fullscreen mode visually within window
                previewColumn.classList.add('position-fixed', 'top-0', 'start-0', 'w-100', 'h-100');
                previewColumn.classList.remove('sticky-preview');
                previewColumn.style.zIndex = '9999';
                
                previewColumn.style.background = '#05070a'; // Solid dark for web preview
                webPreviewContainer.style.height = '100vh';
                
                // Set the card to take full space
                const card = document.getElementById('previewCard');
                card.style.borderRadius = '0';
                card.style.border = 'none';
                card.style.height = '100%';
                
                // Hide the header completely
                document.getElementById('previewHeader').classList.add('d-none');
                
                document.body.style.overflow = 'hidden';
                
                // Show corresponding nav exit button
                if (btnExitFullscreenNav) btnExitFullscreenNav.classList.remove('d-none');
                
                isFullscreen = true;
            } else {
                // Exit fullscreen
                previewColumn.classList.remove('position-fixed', 'top-0', 'start-0', 'w-100', 'h-100');
                previewColumn.classList.add('sticky-preview');
                previewColumn.style.zIndex = '';
                previewColumn.style.background = '';
                previewColumn.style.backdropFilter = '';
                
                webPreviewContainer.style.height = 'calc(100vh - 120px)';
                
                // Restore card
                const card = document.getElementById('previewCard');
                card.style.borderRadius = '15px';
                card.style.border = '1px solid rgba(0,0,0,0.1)';
                card.style.background = '#0b0f19';
                
                // Show the header
                document.getElementById('previewHeader').classList.remove('d-none');
                
                document.body.style.overflow = 'auto';
                
                // Hide nav exit buttons
                if(btnExitFullscreenNav) btnExitFullscreenNav.classList.add('d-none');
                
                isFullscreen = false;
            }
        }

        btnFullscreen.addEventListener('click', toggleFullscreen);
        if (btnExitFullscreenNav) btnExitFullscreenNav.addEventListener('click', toggleFullscreen);

        // Interactive Web Preview Settings Logic
        const colorPickers = document.querySelectorAll('.color-picker');
        const webPreview = document.getElementById('webPreviewContainer');
        
        // Setup CSS Variables for the preview
        webPreview.style.setProperty('--accent-color', '#10b981');
        
        // Add style to apply the variable
        const style = document.createElement('style');
        style.innerHTML = `
            #webPreviewContainer .text-emerald-400 { color: var(--accent-color) !important; }
            #webPreviewContainer .border-emerald-500 { border-color: var(--accent-color) !important; }
            #webPreviewContainer .bg-emerald-500 { background-color: var(--accent-color) !important; }
            #webPreviewContainer [style*="#10b981"] { 
                color: var(--accent-color) !important;
                border-color: var(--accent-color) !important;
            }
        `;
        document.head.appendChild(style);

        colorPickers.forEach(picker => {
            picker.addEventListener('click', function() {
                // Remove active class from all
                colorPickers.forEach(p => {
                    p.classList.remove('active');
                    p.classList.add('opacity-50');
                    p.style.outline = 'none';
                    p.style.borderColor = 'transparent';
                });
                
                // Add active to clicked
                this.classList.add('active');
                this.classList.remove('opacity-50');
                const color = this.getAttribute('data-color');
                this.style.outline = `2px solid ${color}`;
                this.style.borderColor = '#fff';
                this.style.setProperty('border-color', '#fff', 'important');
                
                // Update CSS Variable
                webPreview.style.setProperty('--accent-color', color);
            });
        });

        ajaxForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
                submitBtn.disabled = true;

                const formData = new FormData(this);
                const method = this.getAttribute('method').toUpperCase();
                
                if (method === 'GET') {
                    const params = new URLSearchParams(formData);
                    // Handle GET if needed
                }

                fetch(this.getAttribute('action'), {
                    method: method,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: method === 'GET' ? null : formData
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Close modal if it's inside one
                        const modal = this.closest('.modal');
                        if (modal) {
                            const bsModal = bootstrap.Modal.getInstance(modal);
                            if (bsModal) bsModal.hide();
                        }
                        
                        // Show overlay on iframe
                        overlay.classList.remove('d-none');
                        overlay.classList.add('d-flex');
                        
                        // Refresh
                        setTimeout(() => {
                            window.location.reload();
                        }, 800);
                    } else {
                        alert('Gagal menyimpan: ' + (data.message || 'Error'));
                        submitBtn.innerHTML = originalBtnText;
                        submitBtn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
            });
        });
    });
</script>
@endsection
