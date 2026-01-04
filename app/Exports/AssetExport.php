<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class AssetExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $projectId;
    protected $condition;

    public function __construct($projectId = null, $condition = null)
    {
        $this->projectId = $projectId;
        $this->condition = $condition;
    }

    public function query()
    {
        $query = Asset::query()->with('project');

        if ($this->projectId) {
            $query->where('project_id', $this->projectId);
        }

        if ($this->condition) {
            $query->where('condition', $this->condition);
        }

        return $query;
    }

    public function map($asset): array
    {
        return [
            $asset->asset_tag,
            $asset->name,
            $asset->project->name ?? 'N/A',
            $asset->condition,
            $asset->quantity,
            $asset->location_province,
            $asset->location_department,
            $asset->handed_over_to,
            $asset->handed_over_by,
            $asset->created_at->format('Y-m-d'),
        ];
    }

    public function headings(): array
    {
        return [
            'Asset Tag',
            'Asset Name',
            'Project',
            'Condition',
            'Quantity',
            'Province',
            'Department',
            'Handed Over To',
            'Handed Over By',
            'Created Date',
        ];
    }
}