<!-- Landscape Paper Document -->
<div id="landscapePaper" style="background: #fafafa; width: 100%; max-width: 1122px; aspect-ratio: 1.414; margin: 0 auto; box-shadow: 0 20px 40px rgba(0,0,0,0.15); padding: 3rem 4rem; font-family: 'Helvetica Neue', Arial, sans-serif; color: #1e293b; border-radius: 20px; position: relative; overflow: hidden;">
    
    <!-- Abstract shapes -->
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: #f43f5e; border-radius: 50%; opacity: 0.1;"></div>
    <div style="position: absolute; bottom: -50px; left: -50px; width: 300px; height: 300px; background: #e11d48; border-radius: 50%; opacity: 0.05;"></div>

    <!-- Header Section -->
    <div style="display: flex; align-items: center; gap: 3rem; margin-bottom: 3rem; position: relative; z-index: 2;">
        <div style="flex-shrink: 0;">
            <div style="width: 120px; height: 120px; border-radius: 50%; background: #f43f5e; color: white; display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: 900; letter-spacing: -2px;">
                {{ substr($user->name, 0, 2) }}
            </div>
        </div>
        <div style="flex-grow: 1;">
            <h1 style="font-size: 4rem; font-weight: 900; margin: 0; color: #0f172a; letter-spacing: -1px; line-height: 1;">{{ $user->name }}</h1>
            <h2 style="font-size: 1.5rem; color: #f43f5e; font-weight: 700; margin-top: 0.5rem; letter-spacing: 1px;">CREATIVE DESIGNER</h2>
        </div>
        <div style="text-align: right; font-size: 0.9rem; color: #475569; font-weight: 600;">
            <div style="margin-bottom: 0.5rem; background: white; padding: 0.5rem 1rem; border-radius: 50px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">{{ $user->email }}</div>
            @if($profile && $profile->website)
            <div style="background: white; padding: 0.5rem 1rem; border-radius: 50px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">{{ $profile->website }}</div>
            @endif
        </div>
    </div>
    
    <!-- Grid Content -->
    <div class="row g-4 position-relative" style="z-index: 2;">
        @forelse($portfolios as $item)
        <div class="col-4">
            <div style="background: white; padding: 1.5rem; border-radius: 16px; height: 100%; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border-top: 4px solid #f43f5e; transition: transform 0.2s;">
                <span style="font-size: 0.7rem; font-weight: 800; color: #f43f5e; background: #ffe4e6; padding: 0.3rem 0.8rem; border-radius: 20px; display: inline-block; margin-bottom: 1rem;">
                    {{ $item->date_completed ? \Carbon\Carbon::parse($item->date_completed)->format('Y') : 'ONGOING' }}
                </span>
                <h3 style="font-size: 1.1rem; font-weight: 900; color: #0f172a; margin-bottom: 0.25rem;">{{ $item->project_name }}</h3>
                <div style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 1rem;">
                    {{ $item->project_role }}
                </div>
                <p style="font-size: 0.85rem; line-height: 1.6; color: #64748b; margin: 0;">
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
