@extends('landing-page.template.body')

@section('styles')
    <!-- React App Assets -->
    <script type="module" crossorigin src="{{ asset('cv-editor/assets/index-BMMBsRKP.js') }}"></script>
    <link rel="stylesheet" crossorigin href="{{ asset('cv-editor/assets/index-C4oflBDj.css') }}">
    <script>
        window.CV_TEMPLATE_ID = "{{ $selectedTemplate }}";
        window.CV_PREVIEW_ONLY = true; // Tell React to only render the preview component full width
        
        // Inject Laravel Data for Preview
        window.CV_USER_DATA = {
            name: "{{ $user->name ?? '' }}",
            email: "{{ $user->email ?? '' }}",
            phone: "{{ $profile->nohp ?? '' }}",
            address: "{{ $profile->alamat ?? '' }}",
            summary: "{{ $profile->tentangdiri ?? '' }}"
        };
    </script>
@endsection

@section('content')
<div class="container-fluid py-4 font-outfit mt-5">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold mb-1" style="color: var(--primary);">
                <i class="fas fa-file-pdf me-2"></i>CV Builder (PDF)
            </h2>
            <p class="text-muted mb-0">Rancang dan unduh CV Anda dalam format dokumen statis profesional.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4 me-2">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <!-- React button will handle download inside the preview, but we can also have a native download link if wanted. -->
            <!-- For now, we will let React handle it, or we can use the old download endpoint. -->
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row g-4">
        <!-- Sidebar Column (Left) -->
        <div class="col-lg-4 col-xl-3" style="min-height: calc(100vh - 180px);">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 d-flex flex-column">
                    
                    <div class="text-center mb-4 pb-3 border-bottom">
                        <h6 class="fw-bold text-muted mb-3">Template Saat Ini</h6>
                        <div class="p-3 rounded-3 bg-light border mb-3">
                            <i class="fas fa-file-alt fa-2x mb-2 text-primary"></i>
                            <h5 class="fw-bold m-0" style="text-transform: capitalize;" id="currentTemplateName">{{ str_replace('_', ' ', $selectedTemplate) }}</h5>
                        </div>
                        <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm w-100 mb-3" style="background: var(--primary); border:none;" data-bs-toggle="modal" data-bs-target="#templateSelectionModal">
                            <i class="fas fa-th-large me-2"></i>Pilih Template
                        </button>
                        
                        <hr>
                        <h6 class="fw-bold text-muted mb-3 mt-3">Ingin Mengubah Isi Data CV?</h6>
                        <!-- Navigate to React Editor Page -->
                        <a href="{{ route('user.cv-builder.editor', ['template_id' => $selectedTemplate]) }}" class="btn btn-outline-primary rounded-pill px-4 shadow-sm w-100">
                            <i class="fas fa-pen me-2"></i>Buka Editor Interaktif
                        </a>
                    </div>

                    <div class="alert alert-info border-0 rounded-3 mb-4" style="background: rgba(0, 167, 157, 0.05); color: #00a79d;">
                        <i class="fas fa-info-circle me-2"></i> Data CV diambil secara otomatis. Untuk mengedit konten teks secara real-time, silakan klik tombol Buka Editor Interaktif di atas.
                    </div>

                </div>
            </div>
        </div>

        <!-- Preview Column (Right) -->
        <div class="col-lg-8 col-xl-9">
            <div class="card border-0 shadow-sm rounded-4 bg-light" id="previewColumnContainer">
                <!-- Preview Header Controls -->
                <div class="d-flex justify-content-between align-items-center mb-3 p-4 pb-0" id="previewHeader">
                    <h5 class="fw-bold mb-0"><i class="fas fa-desktop me-2 text-primary"></i>Live Preview (PDF)</h5>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-fullscreen" title="Toggle Fullscreen">
                        <i class="fas fa-expand"></i>
                    </button>
                </div>

                <div class="cv-paper-container position-relative shadow-sm transition-all" id="previewCard" style="border: 1px solid rgba(0,0,0,0.1); border-radius: 15px; background: #e2e8f0;">
                    
                <!-- React App will mount here -->
                <div id="root" style="width:100%; height:100%;"></div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Template Selection -->
<div class="modal fade" id="templateSelectionModal" tabindex="-1" aria-labelledby="templateSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 20px; border: none; background: #f8f9fa;">
            <div class="modal-header border-0 pb-0" style="padding: 2rem;">
                <h4 class="modal-title fw-bold" id="templateSelectionModalLabel" style="color: #2b3452;">
                    <i class="fas fa-chevron-left me-3" data-bs-dismiss="modal" style="cursor: pointer; color: #8a94a6;"></i>
                    Pilih Template CV
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 0 2rem 2rem 2rem;">
                
                <!-- Custom Tabs SuratPlus Style -->
                <ul class="nav nav-pills mb-4" id="templateTabs" role="tablist" style="background: white; display: inline-flex; border-radius: 30px; padding: 5px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-ats" data-bs-toggle="pill" data-bs-target="#content-ats" type="button" role="tab" style="border-radius: 25px; padding: 8px 24px; font-weight: 500;">ATS-Friendly</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-kreatif" data-bs-toggle="pill" data-bs-target="#content-kreatif" type="button" role="tab" style="border-radius: 25px; padding: 8px 24px; font-weight: 500;">Kreatif</button>
                    </li>
                </ul>

                <div class="tab-content" id="templateTabsContent">
                    
                    <!-- Tab ATS Friendly -->
                    <div class="tab-pane fade show active" id="content-ats" role="tabpanel">
                        <div class="row g-4">
                            <!-- Template Harvard -->
                            <div class="col-md-4 col-lg-3">
                                <div class="card h-100 border-0 shadow-sm template-card rounded-4 overflow-hidden {{ $selectedTemplate == 'harvard' ? 'border-primary border-3' : '' }}" data-template-id="harvard" style="cursor: pointer; transition: transform 0.2s;">
                                    <div style="height: 300px; background: #fff; display: flex; align-items: center; justify-content: center; position: relative; border-bottom: 1px solid #eee;">
                                        <div class="position-absolute top-0 end-0 p-2 z-index-1">
                                            <span class="badge bg-danger rounded-pill px-3 shadow-sm">POPULAR</span>
                                        </div>
                                        <!-- Simple visual mock for Harvard -->
                                        <div style="width: 70%; height: 85%; background: #fff; border: 1px solid #ccc; padding: 15px; display:flex; flex-direction:column; align-items:center;">
                                            <div style="width: 80%; height: 12px; background: #333; margin-bottom: 5px;"></div>
                                            <div style="width: 60%; height: 6px; background: #777; margin-bottom: 15px;"></div>
                                            <div style="width: 100%; height: 2px; background: #333; margin-bottom: 10px;"></div>
                                            <div style="width: 100%; height: 6px; background: #ddd; margin-bottom: 4px;"></div>
                                            <div style="width: 100%; height: 6px; background: #ddd; margin-bottom: 4px;"></div>
                                            <div style="width: 90%; height: 6px; background: #ddd; margin-bottom: 15px;"></div>
                                            <div style="width: 100%; height: 2px; background: #333; margin-bottom: 10px;"></div>
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="fw-bold mb-1">Harvard</h6>
                                        <small class="text-success fw-medium">ATS-Friendly</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Template Adelaide -->
                            <div class="col-md-4 col-lg-3">
                                <div class="card h-100 border-0 shadow-sm template-card rounded-4 overflow-hidden {{ $selectedTemplate == 'adelaide' ? 'border-primary border-3' : '' }}" data-template-id="adelaide" style="cursor: pointer; transition: transform 0.2s;">
                                    <div style="height: 300px; background: #fff; display: flex; align-items: center; justify-content: center; position: relative; border-bottom: 1px solid #eee;">
                                        <!-- Simple visual mock for Adelaide -->
                                        <div style="width: 70%; height: 85%; background: #fff; border: 1px solid #ccc; padding: 15px; display:flex; flex-direction:column; align-items:flex-start;">
                                            <div style="width: 60%; height: 12px; background: #333; margin-bottom: 5px;"></div>
                                            <div style="width: 100%; height: 6px; background: #777; margin-bottom: 15px;"></div>
                                            <div style="width: 40%; height: 8px; background: #000; margin-bottom: 10px;"></div>
                                            <div style="width: 100%; height: 6px; background: #ddd; margin-bottom: 4px;"></div>
                                            <div style="width: 100%; height: 6px; background: #ddd; margin-bottom: 15px;"></div>
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="fw-bold mb-1">Adelaide</h6>
                                        <small class="text-success fw-medium">ATS-Friendly</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Kreatif -->
                    <div class="tab-pane fade" id="content-kreatif" role="tabpanel">
                        <div class="row g-4">
                            <!-- Template Dion Devalda (Kreatif) -->
                            <div class="col-md-4 col-lg-3">
                                <div class="card h-100 border-0 shadow-sm template-card rounded-4 overflow-hidden {{ $selectedTemplate == 'dion' ? 'border-primary border-3' : '' }}" data-template-id="dion" style="cursor: pointer; transition: transform 0.2s;">
                                    <div style="height: 300px; background: #fff; display: flex; align-items: center; justify-content: center; position: relative; border-bottom: 1px solid #eee;">
                                        <div class="position-absolute top-0 end-0 p-2 z-index-1">
                                            <span class="badge bg-danger rounded-pill px-3 shadow-sm">POPULAR</span>
                                        </div>
                                        <!-- Placeholder for Minimalist Preview -->
                                        <div style="width: 80%; height: 90%; background: #fdfdfd; border: 1px solid #eaeaea; display: flex; flex-direction: column;">
                                            <div style="height: 30%; background: #f4f5f7; display:flex; align-items:center; padding: 10px;">
                                                <div style="width: 40px; height: 40px; background: #ddd; border-radius: 50%;"></div>
                                                <div style="margin-left: 10px; width: 60px; height: 10px; background: #ddd;"></div>
                                            </div>
                                            <div style="padding: 10px; flex: 1;">
                                                <div style="width: 100%; height: 5px; background: #eee; margin-bottom: 5px;"></div>
                                                <div style="width: 90%; height: 5px; background: #eee; margin-bottom: 15px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="fw-bold mb-1">Dion Devalda</h6>
                                        <small class="text-primary fw-medium">Kreatif</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Template Creative Ruby -->
                            <div class="col-md-4 col-lg-3">
                                <div class="card h-100 border-0 shadow-sm template-card rounded-4 overflow-hidden {{ $selectedTemplate == 'ruby' ? 'border-primary border-3' : '' }}" data-template-id="ruby" style="cursor: pointer; transition: transform 0.2s;">
                                    <div style="height: 300px; background: #fff; display: flex; align-items: center; justify-content: center; position: relative; border-bottom: 1px solid #eee;">
                                        <!-- Placeholder for Modern Preview -->
                                        <div style="width: 80%; height: 90%; background: #fdfdfd; border: 1px solid #eaeaea; display: flex;">
                                            <div style="width: 35%; background: #2c3e50; padding: 10px;">
                                                <div style="width: 100%; padding-bottom: 100%; background: #fff; border-radius: 50%; margin-bottom: 10px;"></div>
                                                <div style="width: 80%; height: 5px; background: #4a6984; margin-bottom: 5px;"></div>
                                            </div>
                                            <div style="width: 65%; padding: 10px;">
                                                <div style="width: 80%; height: 8px; background: #333; margin-bottom: 5px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="fw-bold mb-1">Creative Ruby</h6>
                                        <small class="text-primary fw-medium">Kreatif</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Template Munich Engineer -->
                            <div class="col-md-4 col-lg-3">
                                <div class="card h-100 border-0 shadow-sm template-card rounded-4 overflow-hidden {{ $selectedTemplate == 'munich' ? 'border-primary border-3' : '' }}" data-template-id="munich" style="cursor: pointer; transition: transform 0.2s;">
                                    <div style="height: 300px; background: #fff; display: flex; align-items: center; justify-content: center; position: relative; border-bottom: 1px solid #eee;">
                                        <!-- Placeholder for Corporate Preview -->
                                        <div style="width: 80%; height: 90%; background: #fff; border: 1px solid #eaeaea; border-top: 15px solid #00a79d; padding: 15px;">
                                            <div style="width: 50%; height: 10px; background: #333; margin-bottom: 20px;"></div>
                                            <div style="width: 100%; height: 5px; background: #eee; margin-bottom: 5px;"></div>
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="fw-bold mb-1">Munich Engineer</h6>
                                        <small class="text-primary fw-medium">Kreatif</small>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-5 shadow-sm" id="btnSaveTemplate" style="background: var(--primary);">Terapkan Template</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<style>
    .template-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
    .template-card.selected { border: 3px solid var(--primary) !important; box-shadow: 0 10px 25px rgba(0, 167, 157, 0.3) !important; }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Fullscreen Logic
        const btnFullscreen = document.getElementById('btn-fullscreen');
        const previewColumn = document.getElementById('previewColumnContainer');
        const previewCard = document.getElementById('previewCard');
        let isFullscreen = false;

        function toggleFullscreen() {
            if (!isFullscreen) {
                previewColumn.classList.add('position-fixed', 'top-0', 'start-0', 'w-100', 'h-100', 'overflow-y-auto');
                previewColumn.style.zIndex = '9999';
                previewColumn.style.background = 'rgba(255, 255, 255, 0.95)';
                previewColumn.style.backdropFilter = 'blur(10px)';
                
                previewCard.style.borderRadius = '0';
                previewCard.style.border = 'none';
                
                document.body.style.overflow = 'hidden';
                
                // Change icon
                btnFullscreen.innerHTML = '<i class="fas fa-compress"></i> Tutup Fullscreen';
                btnFullscreen.classList.remove('btn-outline-secondary');
                btnFullscreen.classList.add('btn-primary');
                
                isFullscreen = true;
            } else {
                previewColumn.classList.remove('position-fixed', 'top-0', 'start-0', 'w-100', 'h-100', 'overflow-y-auto');
                previewColumn.style.zIndex = '';
                previewColumn.style.background = '';
                previewColumn.style.backdropFilter = '';
                
                previewCard.style.borderRadius = '15px';
                
                document.body.style.overflow = '';
                
                // Change icon
                btnFullscreen.innerHTML = '<i class="fas fa-expand"></i>';
                btnFullscreen.classList.remove('btn-primary');
                btnFullscreen.classList.add('btn-outline-secondary');

                isFullscreen = false;
            }
            
            // Trigger window resize event so React can adjust sizes
            window.dispatchEvent(new Event('resize'));
        }

        btnFullscreen.addEventListener('click', toggleFullscreen);

        // Template Selection Logic
        let activeSelectedTemplate = '{{ $selectedTemplate }}';
        const templateCards = document.querySelectorAll('.template-card');
        
        templateCards.forEach(card => {
            card.addEventListener('click', function() {
                templateCards.forEach(c => c.classList.remove('selected', 'border-primary', 'border-3'));
                this.classList.add('selected', 'border-primary', 'border-3');
                activeSelectedTemplate = this.getAttribute('data-template-id');
            });
        });

        // Save Template via AJAX
        document.getElementById('btnSaveTemplate').addEventListener('click', function() {
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';
            btn.disabled = true;

            fetch('{{ route("user.cv.updateTemplate") }}', {
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
