<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Portfolio - {{ $user->name }}</title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Bootstrap CSS (for grid system) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body { margin: 0; font-family: sans-serif; background-color: #05070a; color: #f8fafc; }
        .scrollbar-dark::-webkit-scrollbar { width: 8px; }
        .scrollbar-dark::-webkit-scrollbar-track { background: rgba(0,0,0,0.1); }
        .scrollbar-dark::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }
    </style>
</head>
<body>

    <div style="background-color: #05070a; color: #f8fafc; min-height: 100vh; position: relative;">
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
        </div>
        
        <!-- Dynamic Header Vibe -->
        <div style="background: linear-gradient(135deg, #0c1b18 0%, #040a08 100%); border-bottom: 2px solid #10b981; padding: 3.5rem 1.5rem; position: relative; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);">
            <div style="position: absolute; left: -3rem; bottom: -3rem; width: 12rem; height: 12rem; border-radius: 50%; background: rgba(16, 185, 129, 0.2); filter: blur(40px);"></div>
            <div style="position: absolute; right: -3rem; top: -3rem; width: 14rem; height: 14rem; border-radius: 50%; background: rgba(245, 158, 11, 0.1); filter: blur(40px);"></div>

            <div style="max-width: 64rem; margin: 0 auto; display: flex; flex-direction: column; align-items: center; gap: 2rem; position: relative; z-index: 10;">
                <div class="d-flex flex-column flex-md-row align-items-center gap-4 w-100">
                    <!-- Avatar frame -->
                    <div style="width: 8rem; height: 8rem; border-radius: 50%; border: 4px solid #10b981; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); overflow: hidden; display: flex; align-items: center; justify-content: center; background: #13161c; color: #10b981; font-family: serif; font-weight: bold; font-size: 2.25rem; flex-shrink: 0; position: relative;">
                        <div style="position: absolute; inset: 4px; border-radius: 50%; border: 2px dotted rgba(16, 185, 129, 0.2);"></div>
                        {{ substr($user->name, 0, 2) }}
                    </div>

                    <!-- Description & name -->
                    <div class="text-center text-md-start flex-grow-1">
                        <div style="display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.25rem 0.75rem; background: rgba(245, 158, 11, 0.1); color: #fcd34d; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.6875rem; border-radius: 9999px; border: 1px solid rgba(245, 158, 11, 0.3); margin-bottom: 0.5rem;">
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

</body>
</html>
