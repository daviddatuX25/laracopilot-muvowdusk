<?php

namespace App\Livewire\Report;

use PDF;

class ReportExporter
{
    public static function exportPdf($viewName, $data, $filename)
    {
        $pdf = PDF::loadView($viewName, $data);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename);
    }

    public static function exportCsv($headers, $rows, $filename)
    {
        $csv = implode(',', array_map(fn($h) => '"' . addslashes($h) . '"', $headers)) . "\n";
        
        foreach ($rows as $row) {
            $values = [];
            foreach ($headers as $header) {
                $value = $row[$header] ?? '';
                $values[] = '"' . addslashes((string) $value) . '"';
            }
            $csv .= implode(',', $values) . "\n";
        }

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, $filename, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public static function exportMultiSectionCsv($sections, $filename)
    {
        $csv = '';
        
        foreach ($sections as $section) {
            if ($csv !== '') {
                $csv .= "\n\n";
            }
            
            $csv .= $section['title'] . "\n";
            
            if (!empty($section['headers'])) {
                $csv .= implode(',', array_map(fn($h) => '"' . addslashes($h) . '"', $section['headers'])) . "\n";
                
                foreach ($section['rows'] as $row) {
                    $values = [];
                    foreach ($section['headers'] as $header) {
                        $value = $row[$header] ?? '';
                        $values[] = '"' . addslashes((string) $value) . '"';
                    }
                    $csv .= implode(',', $values) . "\n";
                }
            }
        }

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, $filename, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
