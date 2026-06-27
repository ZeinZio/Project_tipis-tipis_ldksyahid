@extends('landing-page.layouts.main')

@section('title', 'Verifikasi CV Anggota')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card border-0 shadow-lg" style="border-radius: 15px;">
                <div class="card-body p-5">
                    <i class="fas fa-check-circle text-success mb-4" style="font-size: 5rem;"></i>
                    <h2 class="mb-3 font-weight-bold" style="color: var(--primary);">CV Valid & Terverifikasi!</h2>
                    <p class="lead mb-4">Dokumen Curriculum Vitae (CV) ini adalah dokumen resmi yang diterbitkan oleh sistem <strong>LDK Syahid</strong>.</p>
                    
                    <div class="bg-light p-4 rounded text-left mx-auto mb-4" style="max-width: 500px; border-left: 5px solid var(--primary);">
                        <h5 class="font-weight-bold mb-3">Informasi Pemilik Dokumen:</h5>
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%" class="px-0 py-1">Nama Lengkap</th>
                                    <td class="px-0 py-1">: {{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th class="px-0 py-1">Status Keanggotaan</th>
                                    <td class="px-0 py-1">: <span class="badge badge-success px-3 py-2">Anggota Aktif</span></td>
                                </tr>
                                <tr>
                                    <th class="px-0 py-1">Tercatat Sejak</th>
                                    <td class="px-0 py-1">: {{ $user->created_at->format('d F Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <p class="text-muted small">
                        Verifikasi ini mengonfirmasi bahwa data yang tertera pada dokumen CV pelamar adalah sah dan tersinkronisasi secara otomatis dengan database organisasi kami.
                    </p>
                    
                    <div class="d-flex justify-content-center mt-3" style="gap: 15px;">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4 py-2" style="border-radius: 30px;">
                            <i class="fas fa-home mr-2"></i> Beranda
                        </a>
                        @if($user->portfolios()->count() > 0)
                        <a href="{{ route('verify.portfolio', ['hash' => bin2hex(encrypt($user->id))]) }}" target="_blank" class="btn btn-primary px-4 py-2" style="border-radius: 30px;">
                            <i class="fas fa-briefcase mr-2"></i> Lihat Portofolio
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
