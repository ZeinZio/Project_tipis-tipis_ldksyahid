<!-- Landscape Paper Document -->
<div id="landscapePaper" style="background: white; width: 100%; max-width: 1122px; aspect-ratio: 1.414; margin: 0 auto; box-shadow: 0 20px 40px rgba(0,0,0,0.15); padding: 3rem 4rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; color: #1e293b; border-radius: 12px; position: relative; overflow: hidden;">
    
    <div style="position: absolute; top: 0; right: 0; width: 400px; height: 100%; background: linear-gradient(180deg, #eff6ff, #dbeafe); z-index: 1;"></div>

    <div style="position: relative; z-index: 2;">
        <!-- Header Section -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 3.5rem;">
            <div style="max-width: 60%;">
                <div style="display: inline-block; padding: 0.25rem 0.75rem; background: #2563eb; color: white; font-size: 0.75rem; font-weight: 700; border-radius: 50px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem;">
                    Product Portfolio
                </div>
                <h1 style="font-size: 3rem; font-weight: 800; margin: 0; color: #1e293b; letter-spacing: -1px; line-height: 1.2;">{{ $user->name }}</h1>
            </div>
            <div style="text-align: right; background: white; padding: 1rem 1.5rem; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                <div style="font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; font-weight: 500;">
                    <i class="fas fa-envelope text-primary me-2"></i>{{ $user->email }}
                </div>
                @if($profile && $profile->website)
                <div style="font-size: 0.85rem; color: #475569; margin-bottom: 0.5rem; font-weight: 500;">
                    <i class="fas fa-link text-primary me-2"></i>{{ $profile->website }}
                </div>
                @endif
                @if($profile && $profile->phone)
                <div style="font-size: 0.85rem; color: #475569; font-weight: 500;">
                    <i class="fas fa-phone text-primary me-2"></i>{{ $profile->phone }}
                </div>
                @endif
            </div>
        </div>
        
        <!-- Grid Content -->
        <div class="row g-4">
            @forelse($portfolios as $item)
            <div class="col-6">
                <div style="background: white; padding: 1.5rem; border-radius: 12px; height: 100%; border: 1px solid #e2e8f0; transition: 0.3s; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: #1e293b; margin: 0;">{{ $item->project_name }}</h3>
                        <span style="font-size: 0.75rem; font-weight: 600; color: #64748b;"><i class="far fa-calendar-alt me-1"></i>{{ $item->date_completed ? \Carbon\Carbon::parse($item->date_completed)->format('M Y') : 'Present' }}</span>
                    </div>
                    <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
                        <span style="font-size: 0.7rem; font-weight: 600; color: #2563eb; background: #eff6ff; padding: 0.2rem 0.6rem; border-radius: 4px; border: 1px solid #bfdbfe;">
                            Role: {{ $item->project_role }}
                        </span>
                    </div>
                    <p style="font-size: 0.9rem; line-height: 1.6; color: #475569; margin: 0;">
                        {{ $item->description }}
                    </p>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p style="color: #94a3b8; font-style: italic; font-size: 1.1rem;">Belum ada karya atau proyek ditambahkan.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
