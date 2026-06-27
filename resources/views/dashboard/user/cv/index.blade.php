@extends('landing-page.template.body')

@section('styles')
<style>
    .nav-tabs .nav-link {
        color: #6c757d;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 1rem 1.5rem;
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
</style>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid py-5 mt-5 font-outfit px-lg-5" style="min-height: 80vh;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--primary);">CV Builder LDK</h2>
            <p class="text-muted">Bangun CV kamu secara interaktif. Perubahan akan langsung terlihat di sebelah kanan.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <div class="dropdown">
                <button class="btn btn-primary rounded-pill dropdown-toggle px-4" type="button" data-bs-toggle="dropdown" style="background: var(--primary); border: none;">
                    <i class="fas fa-download me-2"></i>Unduh PDF
                </button>
                <ul class="dropdown-menu shadow">
                    <li><a class="dropdown-item" href="{{ route('user.cv.download', ['template' => 'profesional']) }}"><i class="fas fa-file-pdf me-2 text-danger"></i>Template Profesional</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.cv.download', ['template' => 'kreatif']) }}"><i class="fas fa-file-pdf me-2 text-warning"></i>Template Kreatif</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Editor Column -->
        <div class="col-lg-5">
            <div class="glass-card-cv">
                <!-- Tabs -->
                <ul class="nav nav-tabs mb-4" id="cvTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab == 'personal' ? 'active' : '' }}" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab" aria-controls="personal" aria-selected="{{ $activeTab == 'personal' ? 'true' : 'false' }}">
                            <i class="fas fa-user-circle me-1"></i>Data Diri
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab == 'education' ? 'active' : '' }}" id="education-tab" data-bs-toggle="tab" data-bs-target="#education" type="button" role="tab" aria-controls="education" aria-selected="{{ $activeTab == 'education' ? 'true' : 'false' }}">
                            <i class="fas fa-graduation-cap me-1"></i>Pendidikan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab == 'experience' ? 'active' : '' }}" id="experience-tab" data-bs-toggle="tab" data-bs-target="#experience" type="button" role="tab" aria-controls="experience" aria-selected="{{ $activeTab == 'experience' ? 'true' : 'false' }}">
                            <i class="fas fa-briefcase me-1"></i>Pengalaman
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab == 'skills' ? 'active' : '' }}" id="skills-tab" data-bs-toggle="tab" data-bs-target="#skills" type="button" role="tab" aria-controls="skills" aria-selected="{{ $activeTab == 'skills' ? 'true' : 'false' }}">
                            <i class="fas fa-star me-1"></i>Keahlian
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab == 'projects' ? 'active' : '' }}" id="projects-tab" data-bs-toggle="tab" data-bs-target="#projects" type="button" role="tab" aria-controls="projects" aria-selected="{{ $activeTab == 'projects' ? 'true' : 'false' }}">
                            <i class="fas fa-folder-open me-1"></i>Proyek
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="cvTabsContent">
                    <!-- Personal -->
                    <div class="tab-pane fade {{ $activeTab == 'personal' ? 'show active' : '' }}" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                        <h5 class="fw-bold mb-4">Informasi Dasar & Kontak</h5>
                        <form action="{{ route('user.cv.updatePersonal') }}" method="POST" class="ajax-form">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">LinkedIn</label>
                                    <input type="text" class="form-control" name="akunlinkedin" value="{{ $profile->akunlinkedin ?? '' }}" placeholder="https://linkedin.com/in/username">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Ringkasan Profil (Professional Summary)</label>
                                    <textarea class="form-control" name="tentangdiri" rows="5" placeholder="Ceritakan secara singkat tentang profil profesionalmu...">{{ $profile->tentangdiri ?? '' }}</textarea>
                                </div>
                                <div class="col-12 text-end mt-4">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="background: var(--primary); border: none;">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Education -->
                    <div class="tab-pane fade {{ $activeTab == 'education' ? 'show active' : '' }}" id="education" role="tabpanel" aria-labelledby="education-tab">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">Riwayat Pendidikan</h5>
                            <button class="btn btn-sm btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalEducation"><i class="fas fa-plus me-1"></i> Tambah</button>
                        </div>
                        
                        <div id="education-list">
                            @forelse($educations as $edu)
                                <div class="border rounded p-3 mb-3 position-relative">
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <form action="{{ route('user.cv.destroyEducation', $edu->id) }}" method="POST" class="ajax-form d-inline" onsubmit="return confirm('Hapus data ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-link text-danger p-0"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                    <h6 class="fw-bold mb-1">{{ $edu->institution }}</h6>
                                    <p class="text-muted small mb-2">{{ $edu->degree }} - {{ $edu->field_of_study }}</p>
                                    <span class="badge bg-light text-dark">{{ $edu->start_date }} s.d. {{ $edu->is_current ? 'Sekarang' : $edu->end_date }}</span>
                                </div>
                            @empty
                                <div class="text-center text-muted py-5 empty-state">
                                    <i class="fas fa-graduation-cap fa-3x mb-3" style="opacity: 0.2;"></i>
                                    <p>Belum ada data pendidikan.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Experience -->
                    <div class="tab-pane fade {{ $activeTab == 'experience' ? 'show active' : '' }}" id="experience" role="tabpanel" aria-labelledby="experience-tab">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">Riwayat Pengalaman</h5>
                            <button class="btn btn-sm btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalExperience"><i class="fas fa-plus me-1"></i> Tambah</button>
                        </div>
                        
                        <div id="experience-list">
                            @forelse($experiences as $exp)
                                <div class="border rounded p-3 mb-3 position-relative">
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <form action="{{ route('user.cv.destroyExperience', $exp->id) }}" method="POST" class="ajax-form d-inline" onsubmit="return confirm('Hapus data ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-link text-danger p-0"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                    <h6 class="fw-bold mb-1">{{ $exp->position }}</h6>
                                    <p class="text-muted small mb-2">{{ $exp->company }}</p>
                                    <span class="badge bg-light text-dark">{{ $exp->start_date }} s.d. {{ $exp->is_current ? 'Sekarang' : $exp->end_date }}</span>
                                </div>
                            @empty
                                <div class="text-center text-muted py-5 empty-state">
                                    <i class="fas fa-briefcase fa-3x mb-3" style="opacity: 0.2;"></i>
                                    <p>Belum ada data pengalaman.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="tab-pane fade {{ $activeTab == 'skills' ? 'show active' : '' }}" id="skills" role="tabpanel" aria-labelledby="skills-tab">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">Keahlian (Skills)</h5>
                            <button class="btn btn-sm btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalSkill"><i class="fas fa-plus me-1"></i> Tambah</button>
                        </div>
                        
                        <div id="skills-list">
                            @forelse($skills as $skill)
                                <span class="badge bg-light text-dark border p-2 me-2 mb-2 position-relative" style="font-size: 0.9rem; padding-right: 30px !important;">
                                    {{ $skill->name }} <span class="text-muted ms-1">({{ $skill->level }})</span>
                                    <form action="{{ route('user.cv.destroySkill', $skill->id) }}" method="POST" class="ajax-form d-inline position-absolute" style="top: 8px; right: 8px;" onsubmit="return confirm('Hapus keahlian ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0" style="line-height:1;"><i class="fas fa-times"></i></button>
                                    </form>
                                </span>
                            @empty
                                <div class="text-center text-muted py-5 empty-state">
                                    <i class="fas fa-star fa-3x mb-3" style="opacity: 0.2;"></i>
                                    <p>Belum ada data keahlian.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Projects -->
                    <div class="tab-pane fade {{ $activeTab == 'projects' ? 'show active' : '' }}" id="projects" role="tabpanel" aria-labelledby="projects-tab">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">Riwayat Proyek</h5>
                            <a href="{{ route('user.portfolio.index') }}" class="btn btn-sm btn-outline-primary rounded-pill"><i class="fas fa-external-link-alt me-1"></i> Kelola di Portofolio</a>
                        </div>
                        
                        <div id="projects-list">
                            @forelse($projects as $proj)
                                <div class="border rounded p-3 mb-3 position-relative">
                                    <h6 class="fw-bold mb-1">{{ $proj->project_name }}</h6>
                                    <p class="text-muted small mb-2">{{ $proj->project_role }}</p>
                                    <p class="small mb-2">{{ \Illuminate\Support\Str::limit($proj->description, 100) }}</p>
                                    <span class="badge bg-light text-dark">{{ $proj->date_completed ? \Carbon\Carbon::parse($proj->date_completed)->format('M Y') : 'Ongoing' }}</span>
                                </div>
                            @empty
                                <div class="text-center text-muted py-5 empty-state">
                                    <i class="fas fa-folder-open fa-3x mb-3" style="opacity: 0.2;"></i>
                                    <p>Belum ada data proyek. Silakan tambahkan melalui Galeri Portofolio.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Preview Column -->
        <div class="col-lg-7">
            <div class="sticky-preview">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-eye me-2 text-primary"></i>Live Preview</h5>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-dark template-btn" data-template="profesional">Profesional</button>
                        <button type="button" class="btn btn-sm btn-outline-dark template-btn" data-template="kreatif">Kreatif</button>
                    </div>
                </div>
                
                <!-- Modern HTML Preview Area -->
                <div class="cv-paper-container position-relative bg-light" style="height: calc(100vh - 120px); overflow-y: auto;">
                    <div class="p-4 p-md-5 mx-auto bg-white shadow-sm" style="max-width: 800px; min-height: 1131px; border: 1px solid #eee; margin-top: 20px; margin-bottom: 20px;" id="cv-html-preview">
                        
                        <!-- Header Section -->
                        <div class="border-bottom pb-4 mb-4 text-center">
                            <h1 class="text-uppercase fw-bold mb-1" style="color: #2c3e50; font-size: 2.2rem; letter-spacing: 1px;" id="prev-name">{{ $user->name ?: 'NAMA LENGKAP' }}</h1>
                            
                            <div class="d-flex flex-wrap justify-content-center gap-3 mt-3 text-muted" style="font-size: 0.9rem;">
                                @if($user->email)
                                <span><i class="fas fa-envelope me-1"></i> {{ $user->email }}</span>
                                @endif
                                @if($profile && $profile->akunlinkedin)
                                <span><i class="fab fa-linkedin me-1"></i> {{ str_replace('https://linkedin.com/in/', '', $profile->akunlinkedin) }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Professional Summary -->
                        @if($profile && $profile->tentangdiri)
                        <div class="mb-4">
                            <h5 class="text-uppercase fw-bold mb-3" style="color: #2c3e50; font-size: 1.1rem; border-bottom: 2px solid #00a79d; display: inline-block; padding-bottom: 3px;">Ringkasan Profil</h5>
                            <p style="font-size: 0.95rem; line-height: 1.6; text-align: justify;" id="prev-summary">{{ $profile->tentangdiri }}</p>
                        </div>
                        @endif

                        <!-- Experience -->
                        @if($experiences->count() > 0)
                        <div class="mb-4">
                            <h5 class="text-uppercase fw-bold mb-3" style="color: #2c3e50; font-size: 1.1rem; border-bottom: 2px solid #00a79d; display: inline-block; padding-bottom: 3px;">Pengalaman Kerja</h5>
                            <div id="prev-experience">
                                @foreach($experiences as $exp)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-baseline mb-1">
                                        <h6 class="fw-bold mb-0" style="color: #34495e;">{{ $exp->position }}</h6>
                                        <span class="text-muted small fw-bold" style="font-size: 0.85rem;">{{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} - {{ $exp->is_current ? 'Sekarang' : \Carbon\Carbon::parse($exp->end_date)->format('M Y') }}</span>
                                    </div>
                                    <div class="fw-semibold text-primary mb-1" style="font-size: 0.95rem;">{{ $exp->company }}</div>
                                    <p style="font-size: 0.9rem; line-height: 1.5; color: #555;">{{ $exp->description }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Education -->
                        @if($educations->count() > 0)
                        <div class="mb-4">
                            <h5 class="text-uppercase fw-bold mb-3" style="color: #2c3e50; font-size: 1.1rem; border-bottom: 2px solid #00a79d; display: inline-block; padding-bottom: 3px;">Pendidikan</h5>
                            <div id="prev-education">
                                @foreach($educations as $edu)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-baseline mb-1">
                                        <h6 class="fw-bold mb-0" style="color: #34495e;">{{ $edu->institution }}</h6>
                                        <span class="text-muted small fw-bold" style="font-size: 0.85rem;">{{ \Carbon\Carbon::parse($edu->start_date)->format('Y') }} - {{ $edu->is_current ? 'Sekarang' : \Carbon\Carbon::parse($edu->end_date)->format('Y') }}</span>
                                    </div>
                                    <div class="mb-1" style="font-size: 0.95rem;">{{ $edu->degree }}, {{ $edu->field_of_study }}</div>
                                    @if($edu->description)
                                    <p style="font-size: 0.9rem; color: #555;">{{ $edu->description }}</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Projects -->
                        @if($projects->count() > 0)
                        <div class="mb-4">
                            <h5 class="text-uppercase fw-bold mb-3" style="color: #2c3e50; font-size: 1.1rem; border-bottom: 2px solid #00a79d; display: inline-block; padding-bottom: 3px;">Proyek</h5>
                            <div id="prev-projects">
                                @foreach($projects as $proj)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-baseline mb-1">
                                        <h6 class="fw-bold mb-0" style="color: #34495e;">{{ $proj->project_name }}</h6>
                                        <span class="text-muted small fw-bold" style="font-size: 0.85rem;">{{ $proj->date_completed ? \Carbon\Carbon::parse($proj->date_completed)->format('Y') : 'Ongoing' }}</span>
                                    </div>
                                    <div class="mb-1 fw-semibold text-muted" style="font-size: 0.9rem;">{{ $proj->project_role }}</div>
                                    @if($proj->description)
                                    <p style="font-size: 0.9rem; color: #555; line-height: 1.5;">{{ $proj->description }}</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Skills -->
                        @if($skills->count() > 0)
                        <div class="mb-4">
                            <h5 class="text-uppercase fw-bold mb-3" style="color: #2c3e50; font-size: 1.1rem; border-bottom: 2px solid #00a79d; display: inline-block; padding-bottom: 3px;">Keahlian</h5>
                            <div class="d-flex flex-wrap gap-2" id="prev-skills">
                                @foreach($skills as $skill)
                                <span class="badge" style="background: #eef2f5; color: #2c3e50; font-size: 0.85rem; font-weight: 500; padding: 0.5rem 0.8rem; border-radius: 6px;">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if(isset($qrCode))
                        <div class="text-end mt-5 pe-3">
                            <div class="d-inline-block text-center">
                                <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code" style="width: 110px; height: 110px; margin-bottom: 5px;">
                                <div style="font-size: 10px; color: #555;">Dokumen Valid & Terverifikasi</div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>

                <!-- Kreatif HTML Preview Area (hidden by default) -->
                <div class="cv-paper-container position-relative bg-light" style="height: calc(100vh - 120px); overflow-y: auto; display: none;" id="cv-html-preview-kreatif">
                    <div class="p-0 mx-auto bg-white shadow-sm d-flex" style="max-width: 800px; min-height: 1131px; border: 1px solid #eee; margin-top: 20px; margin-bottom: 20px;">
                        <!-- Sidebar -->
                        <div style="width: 35%; background-color: #2c3e50; color: white; padding: 2.5rem 1.5rem;">
                            <h2 class="text-white fw-bold mb-4" id="prev-name-kreatif" style="font-size: 1.8rem; line-height: 1.2;">{{ $user->name ?: 'NAMA LENGKAP' }}</h2>
                            
                            <h6 class="text-uppercase fw-bold mt-4 mb-3" style="border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom: 5px; font-size: 0.9rem; letter-spacing: 1px;">Contact</h6>
                            <div class="mb-2" style="font-size: 0.85rem;"><i class="fas fa-envelope me-2 opacity-75"></i>{{ $user->email }}</div>
                            @if($profile && $profile->akunlinkedin)
                            <div class="mb-2" style="font-size: 0.85rem;"><i class="fab fa-linkedin me-2 opacity-75"></i>{{ str_replace('https://linkedin.com/in/', '', $profile->akunlinkedin) }}</div>
                            @endif

                            <h6 class="text-uppercase fw-bold mt-5 mb-3" style="border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom: 5px; font-size: 0.9rem; letter-spacing: 1px;">Skills</h6>
                            <div id="prev-skills-kreatif">
                                @foreach($skills as $skill)
                                <div class="mb-2" style="font-size: 0.85rem;">{{ $skill->name }} <span class="opacity-50 ms-1">({{ $skill->level }})</span></div>
                                @endforeach
                            </div>

                            @if(isset($qrCode))
                            <div style="margin-top: 60px; text-align: center;">
                                <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code" style="width: 110px; height: 110px; margin-bottom: 5px;">
                                <div style="font-size: 10px; color: rgba(255,255,255,0.7);">Dokumen Valid & Terverifikasi</div>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div style="width: 65%; padding: 3rem 2.5rem;">
                            @if($profile && $profile->tentangdiri)
                            <h5 class="text-uppercase fw-bold mb-3" style="color: #2c3e50; border-bottom: 2px solid #3498db; display: inline-block; padding-bottom: 3px; font-size: 1.1rem; letter-spacing: 1px;">About Me</h5>
                            <p style="font-size: 0.9rem; text-align: justify; color: #555; line-height: 1.6;" id="prev-summary-kreatif">{{ $profile->tentangdiri }}</p>
                            @endif

                            <h5 class="text-uppercase fw-bold mt-4 mb-3" style="color: #2c3e50; border-bottom: 2px solid #3498db; display: inline-block; padding-bottom: 3px; font-size: 1.1rem; letter-spacing: 1px;">Work Experience</h5>
                            <div id="prev-experience-kreatif">
                                @foreach($experiences as $exp)
                                <div class="mb-4">
                                    <div class="fw-bold" style="color: #2c3e50; font-size: 1.05rem;">{{ $exp->company }}</div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-muted fw-semibold" style="font-size: 0.9rem;">{{ $exp->position }}</span>
                                        <span class="text-primary fw-bold" style="font-size: 0.85rem;">{{ \Carbon\Carbon::parse($exp->start_date)->format('Y') }} - {{ $exp->is_current ? 'Present' : \Carbon\Carbon::parse($exp->end_date)->format('Y') }}</span>
                                    </div>
                                    <p style="font-size: 0.9rem; color: #555; line-height: 1.5; margin-top: 5px;">{{ $exp->description }}</p>
                                </div>
                                @endforeach
                            </div>

                            <h5 class="text-uppercase fw-bold mt-4 mb-3" style="color: #2c3e50; border-bottom: 2px solid #3498db; display: inline-block; padding-bottom: 3px; font-size: 1.1rem; letter-spacing: 1px;">Education</h5>
                            <div id="prev-education-kreatif">
                                @foreach($educations as $edu)
                                <div class="mb-4">
                                    <div class="fw-bold" style="color: #2c3e50; font-size: 1.05rem;">{{ $edu->institution }}</div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-muted fw-semibold" style="font-size: 0.9rem;">{{ $edu->degree }}, {{ $edu->field_of_study }}</span>
                                        <span class="text-primary fw-bold" style="font-size: 0.85rem;">{{ \Carbon\Carbon::parse($edu->start_date)->format('Y') }} - {{ $edu->is_current ? 'Present' : \Carbon\Carbon::parse($edu->end_date)->format('Y') }}</span>
                                    </div>
                                    @if($edu->description)
                                    <p style="font-size: 0.9rem; color: #555; line-height: 1.5; margin-top: 5px;">{{ $edu->description }}</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<!-- Modal Education -->
<div class="modal fade" id="modalEducation" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('user.cv.storeEducation') }}" method="POST" class="modal-content ajax-form-modal">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pendidikan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Institusi Pendidikan</label>
                    <input type="text" name="institution" class="form-control" required placeholder="Contoh: UIN Syarif Hidayatullah">
                </div>
                <div class="mb-3">
                    <label>Tingkat (Degree)</label>
                    <input type="text" name="degree" class="form-control" required placeholder="Contoh: S1">
                </div>
                <div class="mb-3">
                    <label>Jurusan (Field of Study)</label>
                    <input type="text" name="field_of_study" class="form-control" required placeholder="Contoh: Teknik Informatika">
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="end_date" class="form-control">
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_current" class="form-check-input" id="is_current_edu" value="1">
                    <label class="form-check-label" for="is_current_edu">Masih menempuh pendidikan ini</label>
                </div>
                <div class="mb-3">
                    <label>Deskripsi Singkat (Opsional)</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" style="background: var(--primary);">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Experience -->
<div class="modal fade" id="modalExperience" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('user.cv.storeExperience') }}" method="POST" class="modal-content ajax-form-modal">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengalaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Posisi / Jabatan</label>
                    <input type="text" name="position" class="form-control" required placeholder="Contoh: Ketua Pelaksana / Web Developer">
                </div>
                <div class="mb-3">
                    <label>Nama Organisasi / Perusahaan</label>
                    <input type="text" name="company" class="form-control" required placeholder="Contoh: LDK Syahid / PT Mencari Cinta Sejati">
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="end_date" class="form-control">
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_current" class="form-check-input" id="is_current_exp" value="1">
                    <label class="form-check-label" for="is_current_exp">Masih menjabat / bekerja di sini</label>
                </div>
                <div class="mb-3">
                    <label>Deskripsi Tugas & Pencapaian</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" style="background: var(--primary);">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Skill -->
<div class="modal fade" id="modalSkill" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('user.cv.storeSkill') }}" method="POST" class="modal-content ajax-form-modal">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Keahlian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Nama Keahlian</label>
                    <input type="text" name="name" class="form-control" required placeholder="Contoh: Public Speaking / Laravel">
                </div>
                <div class="mb-3">
                    <label>Tingkat Kemahiran</label>
                    <select name="level" class="form-select" required>
                        <option value="Pemula">Pemula (Beginner)</option>
                        <option value="Menengah">Menengah (Intermediate)</option>
                        <option value="Mahir">Mahir (Advanced)</option>
                        <option value="Pakar">Pakar (Expert)</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" style="background: var(--primary);">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const iframe = document.getElementById('cvPreviewIframe');
        let currentTemplate = 'profesional';


        // Template Switcher
        document.querySelectorAll('.template-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.template-btn').forEach(b => {
                    b.classList.remove('btn-dark');
                    b.classList.add('btn-outline-dark');
                });
                this.classList.remove('btn-outline-dark');
                this.classList.add('btn-dark');
                currentTemplate = this.getAttribute('data-template');
                
                // Switch preview container visibility
                if (currentTemplate === 'kreatif') {
                    document.getElementById('cv-html-preview').parentElement.style.display = 'none';
                    document.getElementById('cv-html-preview-kreatif').style.display = 'block';
                } else {
                    document.getElementById('cv-html-preview').parentElement.style.display = 'block';
                    document.getElementById('cv-html-preview-kreatif').style.display = 'none';
                }
            });
        });

        // Real-time Keystroke bindings for Data Diri
        const nameInput = document.querySelector('input[name="name"]');
        if (nameInput) nameInput.addEventListener('input', e => {
            document.getElementById('prev-name').innerText = e.target.value || 'NAMA LENGKAP';
            if(document.getElementById('prev-name-kreatif')) document.getElementById('prev-name-kreatif').innerText = e.target.value || 'NAMA LENGKAP';
        });
        
        const summaryInput = document.querySelector('textarea[name="tentangdiri"]');
        if (summaryInput) summaryInput.addEventListener('input', e => {
            const preview = document.getElementById('prev-summary');
            if (preview) preview.innerText = e.target.value;
            const previewKreatif = document.getElementById('prev-summary-kreatif');
            if (previewKreatif) previewKreatif.innerText = e.target.value;
        });

        function handleAjaxForm(e) {
            e.preventDefault();
            const form = this;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.disabled = true;

            const formData = new FormData(form);
            const method = form.querySelector('input[name="_method"]')?.value || form.getAttribute('method');

            fetch(form.getAttribute('action'), {
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
                if (data.success) {
                    
                    // Fetch the current page again to update the left panel silently
                    fetch(window.location.href)
                        .then(res => res.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            
                            // Update the lists
                            const listsToUpdate = ['education-list', 'experience-list', 'skills-list', 'projects-list'];
                            listsToUpdate.forEach(listId => {
                                const el = document.getElementById(listId);
                                const newEl = doc.getElementById(listId);
                                if (el && newEl) el.innerHTML = newEl.innerHTML;
                            });

                            // Update Preview Profesional
                            const previewHTML = doc.getElementById('cv-html-preview');
                            if (previewHTML) document.getElementById('cv-html-preview').innerHTML = previewHTML.innerHTML;
                            
                            // Update Preview Kreatif
                            const previewHTMLKreatif = doc.getElementById('cv-html-preview-kreatif');
                            if (previewHTMLKreatif) {
                                document.getElementById('cv-html-preview-kreatif').innerHTML = previewHTMLKreatif.innerHTML;
                            }
                            
                            // Close any open modals
                            document.querySelectorAll('.modal.show').forEach(modalEl => {
                                const modal = bootstrap.Modal.getInstance(modalEl);
                                if (modal) modal.hide();
                            });
                            
                            // Re-attach listeners to new delete buttons
                            attachAjaxListeners();
                            
                            submitBtn.innerHTML = originalBtnText;
                            submitBtn.disabled = false;
                            
                            // Reset form
                            if (method !== 'DELETE') form.reset();
                        });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }

        function attachAjaxListeners() {
            // Remove old listeners to prevent duplicates (not strictly necessary with innerHTML replace, but good practice)
            document.querySelectorAll('.ajax-form, .ajax-form-modal').forEach(form => {
                form.removeEventListener('submit', handleAjaxForm);
                form.addEventListener('submit', handleAjaxForm);
            });
        }
        
        attachAjaxListeners();
    });
</script>
@endsection
