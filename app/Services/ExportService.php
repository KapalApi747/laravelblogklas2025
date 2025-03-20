<?php

namespace App\Services;

use App\Exports\ExportCollection;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;

class ExportService
{
    public function export(string $format, Collection $data, array $headers, string $filename)
    {
        switch ($format) {
            case 'csv':
                return $this->exportCsv($data, $headers, $filename);
            case 'xlsx':
                return $this->exportExcel($data, $headers, $filename);
            case 'pdf':
                return $this->exportPdf($data, $headers, $filename);
            case 'json':
                return $this->exportJson($data, $filename);
            case 'xml':
                return $this->exportXml($data, $filename);
            default:
                return response()->json(['error' => 'Invalid format'], 400);
        }
    }

    private function exportCsv(Collection $data, array $headers, string $filename)
    {

        $csvData = implode(',', $headers)."\n";

        foreach ($data as $row) {
            $csvData .= implode(',', array_values($row->toArray()))."\n";
        }

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename.csv\"",
        ]);
    }

    private function exportExcel(Collection $data, array $headers, string $filename)
    {
        return Excel::download(new ExportCollection($data, $headers), "$filename.xlsx");
    }

    private function exportPdf(Collection $data, array $headers, string $filename)
    {
        $pdf = Pdf::loadView('exports.pdf', ['data' => $data, 'headers' => $headers]);

        return $pdf->download("$filename.pdf");
    }

    private function exportJson(Collection $data, string $filename)
    {
        return Response::json($data, 200, [
            'Content-Disposition' => "attachment; filename=\"$filename.json\"",
        ]);
    }

    private function exportXml(Collection $data, string $filename)
    {
        $xml = new \SimpleXMLElement('<root/>');
        foreach ($data as $item) {
            $itemNode = $xml->addChild('item');
            foreach ($item->toArray() as $key => $value) {
                $itemNode->addChild($key, htmlspecialchars($value));
            }
        }

        return Response::make($xml->asXML(), 200, [
            'Content-Type' => 'application/xml',
            'Content-Disposition' => "attachment; filename=\"$filename.xml\"",
        ]);
    }
}
