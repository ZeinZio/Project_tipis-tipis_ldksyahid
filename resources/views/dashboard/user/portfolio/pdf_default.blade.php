<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Portfolio {{ $user->name }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #00A79D;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            color: #00A79D;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 14px;
        }
        .portfolio-item {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .project-title {
            font-size: 18px;
            color: #00A79D;
            font-weight: bold;
            margin: 0 0 5px 0;
        }
        .project-meta {
            font-size: 14px;
            color: #555;
            margin: 0 0 10px 0;
            font-weight: bold;
        }
        .project-date {
            color: #888;
            font-weight: normal;
            font-style: italic;
        }
        .project-desc {
            font-size: 14px;
            line-height: 1.6;
            margin: 0 0 10px 0;
            text-align: justify;
        }
        .project-link {
            font-size: 13px;
            color: #00A79D;
            text-decoration: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            vertical-align: top;
        }
        .bullet {
            width: 20px;
            color: #00A79D;
            font-size: 18px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>PORTFOLIO</h1>
        <p>{{ $user->name }}</p>
        <p>{{ $user->email }}</p>
    </div>

    @forelse($portfolios as $item)
        <div class="portfolio-item">
            <table>
                <tr>
                    <td class="bullet">&bull;</td>
                    <td>
                        <div class="project-title">{{ $item->project_name }}</div>
                        <div class="project-meta">
                            Role: {{ $item->project_role }} | 
                            <span class="project-date">
                                {{ $item->date_completed ? \Carbon\Carbon::parse($item->date_completed)->format('F Y') : 'Ongoing' }}
                            </span>
                        </div>
                        @if($item->description)
                            <div class="project-desc">{{ $item->description }}</div>
                        @endif
                        @if($item->project_url)
                            <div class="project-link">
                                Link: <a href="{{ $item->project_url }}" style="color: #00A79D;">{{ $item->project_url }}</a>
                            </div>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    @empty
        <p style="text-align: center; color: #888; font-style: italic; margin-top: 50px;">Belum ada proyek/karya yang ditambahkan.</p>
    @endforelse

</body>
</html>
