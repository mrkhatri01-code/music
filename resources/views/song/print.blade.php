<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $song->title_nepali }} Lyrics - Print</title>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a202c;
            --secondary-color: #4a5568;
            --accent-color: #cbd5e0;
            --border-color: #e2e8f0;
            --font-main: 'Inter', system-ui, -apple-system, sans-serif;
            --font-lyrics: 'Crimson Pro', serif;
        }

        body {
            font-family: var(--font-main);
            color: var(--primary-color);
            line-height: 1.5;
            margin: 0;
            padding: 50px;
            background: white;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            width: 80%;
            max-width: 700px;
            opacity: 0.05;
            z-index: -1;
            pointer-events: none;
        }

        .print-wrapper {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 1px solid var(--border-color);
            position: relative;
        }

        header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--primary-color);
        }

        .song-titles {
            margin-bottom: 12px;
        }

        h1 {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
            color: var(--primary-color);
            letter-spacing: -0.02em;
        }

        .title-english {
            font-size: 20px;
            color: var(--secondary-color);
            font-weight: 400;
            margin-top: 4px;
        }

        .metadata {
            font-size: 16px;
            color: var(--secondary-color);
            margin-top: 15px;
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
        }

        .meta-label {
            font-weight: 600;
            margin-right: 6px;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.05em;
            color: #a0aec0;
        }

        .lyrics-container {
            font-family: var(--font-lyrics);
            font-size: 20px;
            line-height: 1.8;
            color: #2d3748;
            margin: 0 auto;
            column-count: 1;
            column-gap: 40px;
            text-align: left;
        }

        .lyrics-line {
            margin-bottom: 4px;
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .lyrics-section-break {
            margin-top: 1.5em;
        }

        footer {
            margin-top: 60px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
            font-size: 11px;
            color: #a0aec0;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .qr-placeholder {
            font-size: 10px;
            text-align: right;
        }

        .source-url {
            max-width: 70%;
            word-break: break-all;
        }

        @media print {
            body { 
                padding: 0;
                margin: 0;
            }
            header {
                padding-bottom: 20px;
                margin-bottom: 30px;
            }
            .lyrics-container {
                font-size: 18px; /* Slightly smaller for print to save space if needed */
            }
            @page { 
                margin: 2cm;
                size: portrait;
            }
        }
    </style>
</head>
<body>
    @php
        $siteLogo = \App\Models\SiteSetting::get('site_logo') ?? 'images/logo.png';
        $findLogo = function($filename) {
            $paths = [public_path($filename), base_path('public/' . $filename), base_path($filename)];
            foreach ($paths as $path) {
                if ($path && file_exists($path)) return ['path' => $path, 'version' => @filemtime($path)];
            }
            return ['path' => null, 'version' => time()];
        };
        $logoInfo = $findLogo($siteLogo);
        $logoUrl = asset($siteLogo) . '?v=' . ($logoInfo['version'] ?? time());
        
        $lyrics = $type === 'romanized' ? $song->lyric->content_romanized : $song->lyric->content_unicode;
        $lines = preg_split('/\R/u', $lyrics);
    @endphp

    <img src="{{ $logoUrl }}" class="watermark" alt="Watermark">

    <div class="print-wrapper">
        <header>
            <div class="song-titles">
                <h1>{{ $song->title_nepali }}</h1>
                <div class="title-english">{{ $song->title_english }}</div>
            </div>
        </header>

        <div class="lyrics-container">
            @foreach($lines as $line)
                @php $trimmed = trim($line); @endphp
                @if(empty($trimmed))
                    <div class="lyrics-section-break"></div>
                @else
                    <div class="lyrics-line">{{ $trimmed }}</div>
                @endif
            @endforeach
        </div>

        <footer>
            <div class="source-url">
                Downloaded from: {{ config('app.url') }}/lyrics/{{ ($song->artist ?? $song->writer)->slug }}/{{ $song->slug }}
            </div>
            <div class="print-date">
                Printed on: {{ now()->format('Y-m-d') }}
            </div>
        </footer>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>

