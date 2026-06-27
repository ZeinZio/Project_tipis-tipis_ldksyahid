<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>CV {{ $user->name }}</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            font-size: 13px;
            line-height: 1.4;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
        }
        .sidebar {
            width: 35%;
            background-color: #fdd835; /* Yellow */
            vertical-align: top;
            padding: 0;
        }
        .sidebar-top {
            background-color: #111; /* Black top part */
            color: #fff;
            padding: 20px;
            text-align: center;
            height: 150px;
        }
        .sidebar-bottom {
            padding: 20px;
            background-color: #fdd835;
            color: #111;
        }
        .content {
            width: 65%;
            vertical-align: top;
            padding: 30px;
            background-color: #fff;
        }
        .name {
            font-size: 32px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 5px;
            color: #111;
        }
        .title {
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #666;
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 2px solid #111;
            margin-top: 15px;
            margin-bottom: 15px;
            padding-bottom: 5px;
            letter-spacing: 1px;
        }
        .sidebar-title {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
            margin-top: 20px;
            border-bottom: 2px solid #111;
            padding-bottom: 5px;
        }
        .item {
            margin-bottom: 15px;
        }
        .item-title {
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
        }
        .item-date {
            font-size: 12px;
            color: #666;
            margin-bottom: 3px;
        }
        .item-subtitle {
            font-style: italic;
            font-size: 13px;
            margin-bottom: 5px;
        }
        .item-desc {
            font-size: 12px;
            color: #444;
            text-align: justify;
        }
        .skill-item {
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: bold;
        }
        .contact-item {
            margin-bottom: 10px;
            font-size: 12px;
        }
        .photo-container {
            width: 100%;
            text-align: center;
        }
        .photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-top: 20px;
            background-color: #ccc;
        }
    </style>
</head>
<body>
    <table class="main-table">
        <tr>
            <td class="sidebar">
                <div class="sidebar-top">
                    <!-- Photo placeholder -->
                    <div style="margin-top:20px; font-size:14px; letter-spacing: 2px;">{{ $user->name }}</div>
                </div>
                <div class="sidebar-bottom">
                    <div class="sidebar-title">Contact</div>
                    <div class="contact-item">
                        <strong>Email:</strong><br>
                        {{ $user->email }}
                    </div>
                    <div class="contact-item">
                        <strong>LinkedIn:</strong><br>
                        {{ $profile->akunlinkedin ?? '-' }}
                    </div>
                    <div class="contact-item">
                        <strong>Location:</strong><br>
                        Jakarta, Indonesia
                    </div>

                    <div class="sidebar-title">Skills</div>
                    @forelse($skills as $skill)
                    <div class="skill-item">
                        {{ $skill->name }} ({{ $skill->level }})
                    </div>
                    @empty
                    <div style="font-size:12px;">No skills added.</div>
                    @endforelse

                    @if(isset($qrCode))
                    <div style="margin-top: 40px; text-align: center;">
                        <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code" style="width: 110px; height: 110px; margin-bottom: 5px;">
                        <div style="font-size: 10px; color: rgba(255,255,255,0.7);">Dokumen Valid & Terverifikasi</div>
                    </div>
                    @endif
                </div>
            </td>
            <td class="content">
                <div class="name">{{ $user->name }}</div>
                <div class="title">Professional</div>

                @if(isset($profile->tentangdiri) && $profile->tentangdiri != '')
                <div class="section-title">About Me</div>
                <div class="item-desc">
                    {{ $profile->tentangdiri }}
                </div>
                @endif

                <div class="section-title">Work Experience</div>
                @forelse($experiences as $exp)
                <div class="item">
                    <div class="item-date">{{ \Carbon\Carbon::parse($exp->start_date)->format('Y') }} - {{ $exp->is_current ? 'Present' : \Carbon\Carbon::parse($exp->end_date)->format('Y') }}</div>
                    <div class="item-title">{{ $exp->company }}</div>
                    <div class="item-subtitle">{{ $exp->position }}</div>
                    <div class="item-desc">{{ $exp->description }}</div>
                </div>
                @empty
                <div class="item-desc">No experience recorded.</div>
                @endforelse

                <div class="section-title">Education</div>
                @forelse($educations as $edu)
                <div class="item">
                    <div class="item-date">{{ \Carbon\Carbon::parse($edu->start_date)->format('Y') }} - {{ $edu->is_current ? 'Present' : \Carbon\Carbon::parse($edu->end_date)->format('Y') }}</div>
                    <div class="item-title">{{ $edu->institution }}</div>
                    <div class="item-subtitle">{{ $edu->degree }} in {{ $edu->field_of_study }}</div>
                    <div class="item-desc">{{ $edu->description }}</div>
                </div>
                @empty
                <div class="item-desc">No education recorded.</div>
                @endforelse
            </td>
        </tr>
    </table>
</body>
</html>
