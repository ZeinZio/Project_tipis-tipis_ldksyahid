<!-- Landscape Paper Document -->
<div id="landscapePaper" style="background: white; width: 100%; max-width: 1122px; aspect-ratio: 1.414; margin: 0 auto; box-shadow: 0 20px 40px rgba(0,0,0,0.15); padding: 3rem 4rem; font-family: 'Times New Roman', Times, serif; color: #1e293b; border-radius: 4px; position: relative; overflow: hidden;">
    
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 8px; background: #0f172a;"></div>

    <!-- Header Section -->
    <div style="border-bottom: 2px solid #cbd5e1; padding-bottom: 1.5rem; margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1 style="font-size: 3.5rem; font-weight: bold; margin: 0; color: #0f172a; letter-spacing: 2px; text-transform: uppercase;">{{ $user->name }}</h1>
            <h2 style="font-size: 1.25rem; font-family: Arial, sans-serif; color: #334155; font-weight: 700; margin-top: 0.5rem; text-transform: uppercase; letter-spacing: 3px;">Executive Portfolio</h2>
        </div>
        <div style="text-align: right; font-family: Arial, sans-serif; font-size: 0.85rem; color: #64748b; font-weight: 500;">
            <div style="margin-bottom: 0.25rem;"><i class="fas fa-envelope me-2" style="color: #0f172a;"></i>{{ $user->email }}</div>
            @if($profile && $profile->website)
            <div><i class="fas fa-globe me-2" style="color: #0f172a;"></i>{{ $profile->website }}</div>
            @endif
            @if($profile && $profile->phone)
            <div style="margin-top: 0.25rem;"><i class="fas fa-phone me-2" style="color: #0f172a;"></i>{{ $profile->phone }}</div>
            @endif
        </div>
    </div>
    
    <!-- Grid Content -->
    <div class="row g-4">
        @forelse($portfolios as $item)
        <div class="col-6">
            <div style="padding: 1.5rem; border-left: 4px solid #0f172a; background: #f8fafc; border-radius: 0 8px 8px 0; height: 100%;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h3 style="font-size: 1.25rem; font-family: Arial, sans-serif; font-weight: bold; color: #0f172a; margin: 0;">{{ $item->project_name }}</h3>
                    <span style="font-family: Arial, sans-serif; font-size: 0.75rem; font-weight: 700; color: #475569;">{{ $item->date_completed ? \Carbon\Carbon::parse($item->date_completed)->format('M Y') : 'Present' }}</span>
                </div>
                <div style="font-family: Arial, sans-serif; font-size: 0.75rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem;">
                    {{ $item->project_role }}
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; color: #334155; text-align: justify; margin: 0;">
                    {{ $item->description }}
                </p>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p style="color: #94a3b8; font-style: italic; font-size: 1.1rem;">Belum ada karya ditambahkan.</p>
        </div>
        @endforelse
    </div>

</div>
