<!-- Landscape Paper Document -->
<div id="landscapePaper" style="background: #0f172a; width: 100%; max-width: 1122px; aspect-ratio: 1.414; margin: 0 auto; box-shadow: 0 20px 40px rgba(0,0,0,0.15); padding: 3rem 4rem; font-family: 'Outfit', sans-serif; color: #f8fafc; border-radius: 12px; position: relative; overflow: hidden;">
    
    <!-- Header Section -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem; border-bottom: 1px solid #1e293b; padding-bottom: 2rem;">
        <div>
            <h1 style="font-size: 3.5rem; font-weight: 700; margin: 0; color: #f8fafc; letter-spacing: -1px;">
                {{ explode(' ', trim($user->name))[0] }}<span style="color: #10b981;">.</span>
            </h1>
            <h2 style="font-size: 1.1rem; color: #94a3b8; font-weight: 400; margin-top: 0.25rem; letter-spacing: 2px; text-transform: uppercase;">UI/UX Designer Portfolio</h2>
        </div>
        <div style="text-align: right; font-size: 0.85rem; color: #cbd5e1;">
            <div style="display: flex; gap: 1.5rem;">
                <div>
                    <span style="display: block; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.2rem;">Email</span>
                    {{ $user->email }}
                </div>
                @if($profile && $profile->website)
                <div>
                    <span style="display: block; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.2rem;">Website</span>
                    {{ $profile->website }}
                </div>
                @endif
                @if($profile && $profile->phone)
                <div>
                    <span style="display: block; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.2rem;">Phone</span>
                    {{ $profile->phone }}
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Grid Content -->
    <div class="row g-4">
        @forelse($portfolios as $item)
        <div class="col-6">
            <div style="background: #1e293b; padding: 1.5rem; border-radius: 16px; height: 100%; border: 1px solid #334155; transition: 0.3s;">
                <div style="margin-bottom: 1rem;">
                    <span style="font-size: 0.65rem; font-weight: 600; color: #10b981; background: rgba(16, 185, 129, 0.1); padding: 0.25rem 0.75rem; border-radius: 50px; text-transform: uppercase; letter-spacing: 1px;">
                        {{ $item->project_role }}
                    </span>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 600; color: #f8fafc; margin-bottom: 0.5rem;">{{ $item->project_name }}</h3>
                <div style="font-size: 0.75rem; color: #64748b; margin-bottom: 1rem;">
                    {{ $item->date_completed ? \Carbon\Carbon::parse($item->date_completed)->format('F Y') : 'Ongoing Project' }}
                </div>
                <p style="font-size: 0.9rem; line-height: 1.6; color: #cbd5e1; margin: 0;">
                    {{ $item->description }}
                </p>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p style="color: #64748b; font-style: italic; font-size: 1.1rem;">No projects added yet.</p>
        </div>
        @endforelse
    </div>

</div>
