<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Asset Detail - {{ $asset->asset_tag }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        .logo { height: 50px; margin-bottom: 5px; }
        .title { font-size: 16px; font-weight: bold; text-transform: uppercase; }
        
        .section { margin-bottom: 15px; }
        .section-title { font-size: 14px; font-weight: bold; background-color: #f0f0f0; padding: 5px; margin-bottom: 5px; border-left: 4px solid #4f46e5; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        td { padding: 6px; border-bottom: 1px solid #eee; vertical-align: top; }
        .label { font-weight: bold; width: 30%; color: #555; }
        .value { width: 70%; }
        
        .photo-container { text-align: center; margin-bottom: 20px; border: 1px solid #ccc; padding: 5px; display: inline-block; }
        .photo { max-height: 200px; max-width: 100%; }

        .footer { margin-top: 30px; font-size: 10px; color: #888; text-align: center; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        @php
            $logo = \App\Models\Setting::get('company_logo');
            $companyName = \App\Models\Setting::get('company_name', 'NSDO Procurement');
        @endphp
        
        @if($logo && file_exists(storage_path('app/public/' . $logo)))
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $logo))) }}" class="logo">
        @endif
        <div class="title">{{ $companyName }}</div>
        <div>Asset Specification Sheet</div>
    </div>

    @if($asset->photo_path && file_exists(storage_path('app/public/' . $asset->photo_path)))
        <div style="text-align: center;">
            <div class="photo-container">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $asset->photo_path))) }}" class="photo">
            </div>
        </div>
    @endif

    <div class="section">
        <div class="section-title">General Information</div>
        <table>
            <tr>
                <td class="label">Asset Tag:</td>
                <td class="value"><strong>{{ $asset->asset_tag }}</strong></td>
            </tr>
            <tr>
                <td class="label">Asset Name:</td>
                <td class="value">{{ $asset->name }}</td>
            </tr>
            <tr>
                <td class="label">Type:</td>
                <td class="value">{{ $asset->assetType->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Project:</td>
                <td class="value">{{ $asset->project->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Condition:</td>
                <td class="value">{{ $asset->condition }}</td>
            </tr>
            <tr>
                <td class="label">Quantity:</td>
                <td class="value">{{ $asset->quantity }}</td>
            </tr>
            <tr>
                <td class="label">Description:</td>
                <td class="value">{{ $asset->description ?? 'No description provided.' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Location & Assignment</div>
        <table>
            <tr>
                <td class="label">Province:</td>
                <td class="value">{{ $asset->province->name ?? $asset->location_province ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Department:</td>
                <td class="value">{{ $asset->department->name ?? $asset->location_department ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Room / Office:</td>
                <td class="value">{{ $asset->room_number ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Assigned Staff:</td>
                <td class="value">{{ $asset->staff->name ?? $asset->handed_over_to ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Handover Details</div>
        <table style="border: none;">
            <tr>
                <td class="label" style="border: none;">Handed Over By:</td>
                <td class="value" style="border: none;">{{ $asset->handed_over_by ?? 'Logistics Officer' }}</td>
            </tr>
            <tr>
                <td class="label" style="border: none;">Handover Date:</td>
                <td class="value" style="border: none;">{{ $asset->handover_date ? $asset->handover_date->format('Y-m-d') : 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label" style="border: none;">Handedover to:</td>
                <td class="value" style="border: none;">{{ $asset->staff->name ?? $asset->handed_over_to ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <div style="margin-top: 50px;">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width: 45%; border: none; text-align: center; padding-top: 20px;">
                    <div style="border-top: 1px solid #000; padding-top: 5px;">
                        <strong>Handed Over By</strong><br>
                        <span style="font-size: 10px;">(Signature & Date)</span>
                    </div>
                </td>
                <td style="width: 10%; border: none;"></td>
                <td style="width: 45%; border: none; text-align: center; padding-top: 20px;">
                    <div style="border-top: 1px solid #000; padding-top: 5px;">
                        <strong>Received By</strong><br>
                        <span style="font-size: 10px;">(Signature & Date)</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Generated by PMIS on {{ now()->format('Y-m-d H:i:s') }}
    </div>
</body>
</html>
