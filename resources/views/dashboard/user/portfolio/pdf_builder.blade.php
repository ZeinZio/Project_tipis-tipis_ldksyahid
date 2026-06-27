@extends('landing-page.template.body')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold mb-1" style="color: var(--primary);">
                <i class="fas fa-file-pdf me-2"></i>Portofolio PDF Kreatif
            </h2>
            <p class="text-muted mb-0">Rancang dan unduh portofolio Anda dalam format dokumen statis profesional.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4 me-2">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <a href="{{ route('user.portfolio.download') }}" class="btn btn-danger rounded-pill px-4 shadow-sm">
                <i class="fas fa-download me-2"></i>Unduh PDF
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row g-4 h-100">
        <!-- Editor Column (Left) -->
        <div class="col-lg-5 col-xl-4 h-100" style="min-height: calc(100vh - 180px);">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 d-flex flex-column h-100">
                    
                    <div class="text-center mb-4 pb-3 border-bottom">
                        <h6 class="fw-bold text-muted mb-3">Template Saat Ini</h6>
                        <div class="p-3 rounded-3 bg-light border mb-3">
                            <i class="fas fa-palette fa-2x mb-2 text-primary"></i>
                            <h5 class="fw-bold m-0" style="text-transform: capitalize;" id="currentTemplateName">{{ str_replace('_', ' ', $selectedTemplate) }}</h5>
                        </div>
                        <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm w-100" data-bs-toggle="modal" data-bs-target="#templateModal">
                            <i class="fas fa-th-large me-2"></i>Pilih Template
                        </button>
                    </div>

                    <div class="alert alert-info border-0 rounded-3 mb-4" style="background: rgba(0, 167, 157, 0.05); color: #00a79d;">
                        <i class="fas fa-info-circle me-2"></i> Data portofolio (Karya, Pengalaman, Skill) diambil secara otomatis dari profil Anda. Untuk mengedit konten, gunakan halaman Web Portofolio atau menu CV.
                    </div>

                    <div class="mt-auto">
                        <a href="{{ route('user.portfolio.index') }}" class="btn btn-outline-primary w-100 rounded-pill">
                            <i class="fas fa-globe me-2"></i>Kelola Data Portofolio Web
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Column (Right) -->
        <div class="col-lg-7 col-xl-8">
            <div class="sticky-preview position-relative" id="previewColumnContainer">
                <!-- Preview Header Controls -->
                <div class="d-flex justify-content-between align-items-center mb-3" id="previewHeader">
                    <h5 class="fw-bold mb-0"><i class="fas fa-desktop me-2 text-primary"></i>Live Preview (PDF)</h5>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-fullscreen" title="Toggle Fullscreen">
                        <i class="fas fa-expand"></i>
                    </button>
                </div>

                <div class="cv-paper-container h-100 position-relative shadow-lg transition-all" id="previewCard" style="border: 1px solid rgba(0,0,0,0.1); border-radius: 15px; overflow: hidden; background: #e2e8f0;">
                    
                    <div id="loadingOverlay" class="position-absolute w-100 h-100 d-none justify-content-center align-items-center" style="background: rgba(226, 232, 240, 0.8); z-index: 10;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <div id="pdfPreviewContainer" class="w-100 h-100 overflow-auto scrollbar-dark" style="padding: 2rem; position: relative; height: calc(100vh - 120px);">
                        
                        <!-- Top Navigation Bar for PDF Preview -->
                        <div style="background: rgba(255, 255, 255, 0.9); padding: 1rem 1.5rem; border-radius: 12px; border-bottom: 1px solid rgba(16, 185, 129, 0.2); display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 50; backdrop-filter: blur(10px); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin-bottom: 2rem;">
                            <div class="d-flex align-items-center gap-3">
                                <div>
                                    <h6 style="margin: 0; font-weight: 800; letter-spacing: 1px; color: #0f172a;">CREATIVE <span style="font-weight: 400; color: #10b981;">portfolio</span></h6>
                                    <span style="font-size: 0.65rem; color: #64748b; letter-spacing: 2px;">NON-WEB LANDSCAPE</span>
                                </div>
                            </div>
                            <div>
                                <button id="btn-exit-fullscreen-pdf" class="d-none" style="background: #10b981; color: #fff; border: none; padding: 0.4rem 1rem; border-radius: 8px; font-weight: 600; font-size: 0.85rem; transition: 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">&larr; Tutup Fullscreen</button>
                            </div>
                        </div>

                        <!-- Render Template Dynamically -->
                        <div id="templateRenderer">
                            @include('dashboard.user.portfolio.templates.' . $selectedTemplate)
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pilih Template -->
<div class="modal fade font-outfit" id="templateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <h4 class="modal-title fw-bold" style="color: var(--primary);">Pilih Template Portfolio Anda</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 py-3">
                <!-- Kategori Tabs -->
                <ul class="nav nav-pills mb-4 gap-2" id="templateCategoryTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill px-4" data-bs-toggle="pill" data-category="all" type="button">All</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill px-4" data-bs-toggle="pill" data-category="design" type="button">Design</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill px-4" data-bs-toggle="pill" data-category="tech" type="button">Tech</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill px-4" data-bs-toggle="pill" data-category="marketing" type="button">Marketing</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill px-4" data-bs-toggle="pill" data-category="business" type="button">Business</button>
                    </li>
                </ul>

                <!-- Templates Grid -->
                <div class="row g-4" id="templateGrid">
                    
                    <!-- Business Template -->
                    <div class="col-md-4 col-sm-6 template-item" data-category="business">
                        <div class="card h-100 border-0 shadow-sm template-card rounded-4 overflow-hidden {{ $selectedTemplate == 'business' ? 'border-primary border-3' : '' }}" data-template-id="business" style="cursor: pointer; transition: transform 0.2s;">
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 180px; background: linear-gradient(135deg, #1e293b, #0f172a);">
                                <h3 class="text-white fw-bold m-0" style="font-family: serif;">BUSINESS</h3>
                            </div>
                            <div class="card-body text-center">
                                <h6 class="fw-bold mb-1">Corporate Business</h6>
                                <span class="badge bg-light text-dark">Business</span>
                            </div>
                        </div>
                    </div>

                    <!-- Design Graphic Template -->
                    <div class="col-md-4 col-sm-6 template-item" data-category="design">
                        <div class="card h-100 border-0 shadow-sm template-card rounded-4 overflow-hidden {{ $selectedTemplate == 'design_graphic' ? 'border-primary border-3' : '' }}" data-template-id="design_graphic" style="cursor: pointer; transition: transform 0.2s;">
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 180px; background: linear-gradient(135deg, #f43f5e, #e11d48);">
                                <h3 class="text-white fw-bold m-0" style="font-family: sans-serif; letter-spacing: 2px;">CREATIVE</h3>
                            </div>
                            <div class="card-body text-center">
                                <h6 class="fw-bold mb-1">Design Graphic</h6>
                                <span class="badge bg-light text-dark">Design</span>
                            </div>
                        </div>
                    </div>

                    <!-- Marketing Template -->
                    <div class="col-md-4 col-sm-6 template-item" data-category="marketing">
                        <div class="card h-100 border-0 shadow-sm template-card rounded-4 overflow-hidden {{ $selectedTemplate == 'marketing' ? 'border-primary border-3' : '' }}" data-template-id="marketing" style="cursor: pointer; transition: transform 0.2s;">
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 180px; background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                                <h3 class="text-white fw-bold m-0" style="font-style: italic;">MARKETING</h3>
                            </div>
                            <div class="card-body text-center">
                                <h6 class="fw-bold mb-1">Marketing Strategy</h6>
                                <span class="badge bg-light text-dark">Marketing</span>
                            </div>
                        </div>
                    </div>

                    <!-- Product Manager Template -->
                    <div class="col-md-4 col-sm-6 template-item" data-category="business tech">
                        <div class="card h-100 border-0 shadow-sm template-card rounded-4 overflow-hidden {{ $selectedTemplate == 'product_manager' ? 'border-primary border-3' : '' }}" data-template-id="product_manager" style="cursor: pointer; transition: transform 0.2s;">
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 180px; background: linear-gradient(135deg, #3b82f6, #2563eb);">
                                <h3 class="text-white fw-bold m-0" style="font-family: monospace;">PRODUCT</h3>
                            </div>
                            <div class="card-body text-center">
                                <h6 class="fw-bold mb-1">Product Manager</h6>
                                <span class="badge bg-light text-dark">Business</span> <span class="badge bg-light text-dark">Tech</span>
                            </div>
                        </div>
                    </div>

                    <!-- UI/UX Design Template -->
                    <div class="col-md-4 col-sm-6 template-item" data-category="design tech">
                        <div class="card h-100 border-0 shadow-sm template-card rounded-4 overflow-hidden {{ $selectedTemplate == 'uiux_design' ? 'border-primary border-3' : '' }}" data-template-id="uiux_design" style="cursor: pointer; transition: transform 0.2s;">
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 180px; background: linear-gradient(135deg, #10b981, #059669);">
                                <h3 class="text-white fw-bold m-0" style="letter-spacing: -1px;">UI/UX DESIGN</h3>
                            </div>
                            <div class="card-body text-center">
                                <h6 class="fw-bold mb-1">UI/UX Designer</h6>
                                <span class="badge bg-light text-dark">Design</span> <span class="badge bg-light text-dark">Tech</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-5 shadow-sm" id="btnSaveTemplate">Terapkan Template</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .template-card:hover { transform: translateY(-5px); }
    .template-card.selected { border: 3px solid var(--primary) !important; box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3) !important; }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Fullscreen Logic
        const btnFullscreen = document.getElementById('btn-fullscreen');
        const btnExitFullscreenPdf = document.getElementById('btn-exit-fullscreen-pdf');
        const previewColumn = document.getElementById('previewColumnContainer');
        const pdfPreviewContainer = document.getElementById('pdfPreviewContainer');
        let isFullscreen = false;

        function toggleFullscreen() {
            if (!isFullscreen) {
                previewColumn.classList.add('position-fixed', 'top-0', 'start-0', 'w-100', 'h-100');
                previewColumn.classList.remove('sticky-preview');
                previewColumn.style.zIndex = '9999';
                
                previewColumn.style.background = 'rgba(0, 0, 0, 0.6)';
                previewColumn.style.backdropFilter = 'blur(15px)';
                pdfPreviewContainer.style.background = 'transparent';
                pdfPreviewContainer.style.height = '100vh';
                
                const card = document.getElementById('previewCard');
                card.style.borderRadius = '0';
                card.style.border = 'none';
                card.style.height = '100%';
                card.style.background = 'transparent';
                
                document.getElementById('previewHeader').classList.add('d-none');
                document.body.style.overflow = 'hidden';
                if (btnExitFullscreenPdf) btnExitFullscreenPdf.classList.remove('d-none');
                
                isFullscreen = true;
            } else {
                previewColumn.classList.remove('position-fixed', 'top-0', 'start-0', 'w-100', 'h-100');
                previewColumn.classList.add('sticky-preview');
                previewColumn.style.zIndex = '';
                previewColumn.style.background = '';
                previewColumn.style.backdropFilter = '';
                
                pdfPreviewContainer.style.height = 'calc(100vh - 120px)';
                pdfPreviewContainer.style.background = '#e2e8f0';
                
                const card = document.getElementById('previewCard');
                card.style.borderRadius = '15px';
                card.style.border = '1px solid rgba(0,0,0,0.1)';
                card.style.background = '#e2e8f0';
                
                document.getElementById('previewHeader').classList.remove('d-none');
                document.body.style.overflow = 'auto';
                if(btnExitFullscreenPdf) btnExitFullscreenPdf.classList.add('d-none');
                
                isFullscreen = false;
            }
        }

        btnFullscreen.addEventListener('click', toggleFullscreen);
        if (btnExitFullscreenPdf) btnExitFullscreenPdf.addEventListener('click', toggleFullscreen);


        // Template Selection Logic
        let activeSelectedTemplate = '{{ $selectedTemplate }}';
        const templateCards = document.querySelectorAll('.template-card');
        
        // Handle Template Clicking
        templateCards.forEach(card => {
            card.addEventListener('click', function() {
                // Remove selected from all
                templateCards.forEach(c => c.classList.remove('selected', 'border-primary', 'border-3'));
                // Add to clicked
                this.classList.add('selected', 'border-primary', 'border-3');
                activeSelectedTemplate = this.getAttribute('data-template-id');
            });
        });

        // Filter Logic
        const filterBtns = document.querySelectorAll('#templateCategoryTabs .nav-link');
        const templateItems = document.querySelectorAll('.template-item');
        
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                
                templateItems.forEach(item => {
                    if(category === 'all' || item.getAttribute('data-category').includes(category)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // Save Template
        document.getElementById('btnSaveTemplate').addEventListener('click', function() {
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';
            btn.disabled = true;

            fetch('{{ route("user.portfolio.updateTemplate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ template: activeSelectedTemplate })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    window.location.reload();
                } else {
                    alert('Gagal menyimpan template');
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan koneksi');
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        });

    });
</script>
@endsection
