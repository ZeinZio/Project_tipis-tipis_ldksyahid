<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>CV {{ $user->name }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            margin: 0;
            padding: 0;
            font-size: 14px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .name {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .contact {
            font-size: 13px;
            color: #333;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #000;
            margin-top: 15px;
            margin-bottom: 10px;
            padding-bottom: 2px;
        }
        .item {
            margin-bottom: 12px;
        }
        .item-header {
            width: 100%;
            margin-bottom: 2px;
        }
        .item-title {
            font-weight: bold;
            font-size: 15px;
            float: left;
        }
        .item-date {
            float: right;
            font-style: italic;
            font-size: 13px;
        }
        .clearfix {
            clear: both;
        }
        .item-subtitle {
            font-style: italic;
            font-size: 14px;
        }
        .item-desc {
            font-size: 13px;
            margin-top: 4px;
            text-align: justify;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="name">{{ $user->name }}</div>
        <div class="contact">
            {{ $user->email }} | {{ $profile->akunlinkedin ?? 'linkedin.com/in/username' }} | Jakarta, Indonesia
        </div>
    </div>

    @if(isset($profile->tentangdiri) && $profile->tentangdiri != '')
    <div class="section-title">Professional Summary</div>
    <div class="item-desc">
        {{ $profile->tentangdiri }}
    </div>
    @endif

    <div class="section-title">Education</div>
    @forelse($educations as $edu)
    <div class="item">
        <div class="item-header">
            <div class="item-title">{{ $edu->institution }}</div>
            <div class="item-date">{{ \Carbon\Carbon::parse($edu->start_date)->format('M Y') }} - {{ $edu->is_current ? 'Present' : \Carbon\Carbon::parse($edu->end_date)->format('M Y') }}</div>
            <div class="clearfix"></div>
        </div>
        <div class="item-subtitle">{{ $edu->degree }} in {{ $edu->field_of_study }}</div>
        <div class="item-desc">{{ $edu->description }}</div>
    </div>
    @empty
    <div class="item-desc">No education history recorded.</div>
    @endforelse

    <div class="section-title">Experience</div>
    @forelse($experiences as $exp)
    <div class="item">
        <div class="item-header">
            <div class="item-title">{{ $exp->position }}</div>
            <div class="item-date">{{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} - {{ $exp->is_current ? 'Present' : \Carbon\Carbon::parse($exp->end_date)->format('M Y') }}</div>
            <div class="clearfix"></div>
        </div>
        <div class="item-subtitle">{{ $exp->company }}</div>
        <div class="item-desc">{{ $exp->description }}</div>
    </div>
    @empty
    <div class="item-desc">No work experience recorded.</div>
    @endforelse

    <div class="section-title">Skills</div>
    <div class="item-desc">
        @forelse($skills as $skill)
            {{ $skill->name }}{{ !$loop->last ? ', ' : '' }}
        @empty
            No skills recorded.
        @endforelse
    </div>
    <div style="margin-top: 40px; width: 100%;">
        @if(isset($qrCode))
        <table style="width: 100%;">
            <tr>
                <td style="text-align: right;">
                    <div style="display: inline-block; text-align: center;">
                        <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code" style="width: 110px; height: 110px; margin-bottom: 5px;">
                        <div style="font-size: 10px; color: #555;">Dokumen Valid & Terverifikasi</div>
                    </div>
                </td>
            </tr>
        </table>
        @endif
    </div>
</body>
</html>
