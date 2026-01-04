<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Asset Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .meta {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 50px;
            width: 100%;
        }
        .signature-box {
            float: right;
            width: 200px;
            text-align: center;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            margin-bottom: 5px;
            height: 40px;
        }
    </style>
</head>
<body>
    <div class="header">
        @php
            $logo = \App\Models\Setting::get('company_logo');
            $companyName = \App\Models\Setting::get('company_name', 'Procurement MIS');
            
            // DomPDF requires absolute paths for images to render correctly
            $logoPath = $logo ? storage_path('app/public/' . $logo) : null;
        @endphp

        @if($logoPath && file_exists($logoPath))
            <img src="{{ $logoPath }}" style="max-height: 60px; margin-bottom: 10px;">
        @endif
        
        <h1>{{ $companyName }} - Asset Report</h1>
        <p>Generated on: {{ date('Y-m-d H:i') }}</p>
    </div>

    <div class="meta">
        <strong>Filter Project:</strong> {{ $filters['project'] }} <br>
        <strong>Filter Condition:</strong> {{ $filters['condition'] }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Tag</th>
                <th>Asset Name</th>
                <th>Project</th>
                <th>Condition</th>
                <th>Qty</th>
                <th>Location</th>
                <th>Handover To</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assets as $asset)
                <tr>
                    <td>{{ $asset->asset_tag }}</td>
                    <td>{{ $asset->name }}</td>
                    <td>{{ $asset->project->name ?? 'N/A' }}</td>
                    <td>{{ $asset->condition }}</td>
                    <td>{{ $asset->quantity }}</td>
                    <td>{{ $asset->location_province }}</td>
                    <td>{{ $asset->handed_over_to }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">No assets found matching the criteria.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            <div class="signature-line"></div>
            <p>Authorized Signature</p>
        </div>
    </div>
</body>
</html>
