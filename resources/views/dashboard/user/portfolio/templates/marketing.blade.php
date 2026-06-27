<!-- Landscape Paper Document -->
<div id="landscapePaper" style="background: white; width: 100%; max-width: 1122px; aspect-ratio: 1.414; margin: 0 auto; box-shadow: 0 20px 40px rgba(0,0,0,0.15); padding: 0; font-family: 'Segoe UI', Arial, sans-serif; color: #1e293b; border-radius: 0; position: relative; overflow: hidden; display: flex;">
    
    <!-- Left Sidebar -->
    <div style="width: 300px; background: #2e1065; color: white; padding: 3rem 2rem; display: flex; flex-direction: column;">
        <h1 style="font-size: 3rem; font-weight: 800; margin: 0; line-height: 1.1; letter-spacing: -1px; word-break: break-word;">{{ $user->name }}</h1>
        <div style="width: 40px; height: 4px; background: #8b5cf6; margin: 1.5rem 0;"></div>
        <h2 style="font-size: 1.1rem; color: #c4b5fd; font-weight: 600; margin-bottom: 3rem; text-transform: uppercase; letter-spacing: 2px;">Marketing Specialist</h2>
        
        <div style="margin-top: auto;">
            <h3 style="font-size: 0.85rem; color: #8b5cf6; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; margin-bottom: 1rem;">Contact Info</h3>
            <div style="font-size: 0.85rem; color: #e2e8f0; margin-bottom: 0.5rem;"><i class="fas fa-envelope me-2" style="width: 15px;"></i>{{ $user->email }}</div>
            @if($profile && $profile->website)
            <div style="font-size: 0.85rem; color: #e2e8f0; margin-bottom: 0.5rem;"><i class="fas fa-globe me-2" style="width: 15px;"></i>{{ $profile->website }}</div>
            @endif
            @if($profile && $profile->phone)
            <div style="font-size: 0.85rem; color: #e2e8f0;"><i class="fas fa-phone me-2" style="width: 15px;"></i>{{ $profile->phone }}</div>
            @endif
        </div>
    </div>

    <!-- Right Content -->
    <div style="flex-grow: 1; padding: 3rem 3rem; background: #f8fafc; overflow-y: auto;">
        
        <h3 style="font-size: 1.5rem; font-weight: 800; color: #1e293b; margin-bottom: 2rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; display: flex; justify-content: space-between; align-items: center;">
            <span>Selected Campaigns & Projects</span>
            <i class="fas fa-bullhorn text-muted opacity-50"></i>
        </h3>

        <!-- Grid Content -->
        <div class="row g-4">
            @forelse($portfolios as $item)
            <div class="col-6">
                <div style="background: white; padding: 1.5rem; border-radius: 8px; height: 100%; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h4 style="font-size: 1.1rem; font-weight: 700; color: #2e1065; margin: 0;">{{ $item->project_name }}</h4>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                        <span style="font-size: 0.7rem; font-weight: 700; color: #8b5cf6; background: #ede9fe; padding: 0.2rem 0.6rem; border-radius: 4px;">{{ $item->project_role }}</span>
                        <span style="font-size: 0.7rem; color: #64748b; font-weight: 600;"><i class="far fa-calendar-alt me-1"></i>{{ $item->date_completed ? \Carbon\Carbon::parse($item->date_completed)->format('Y') : 'Present' }}</span>
                    </div>
                    <p style="font-size: 0.85rem; line-height: 1.6; color: #475569; margin: 0;">
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
</div>
