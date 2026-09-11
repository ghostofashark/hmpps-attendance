<?php
namespace App\Services;
use App\Models\AbsenceRecord;
use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
class DocumentService {
    private function generate(AbsenceRecord $absence, string $view, string $type, string $prefix): string {
        $pdf = Pdf::loadView($view, ['absence' => $absence, 'staff' => $absence->staff, 'prison' => $absence->prison]);
        $filename = $prefix.'_'.$absence->id.'_'.now()->format('Ymd_His').'.pdf';
        $path = 'documents/'.$filename;
        Storage::put('public/'.$path, $pdf->output());
        Document::create([
            'absence_id'  => $absence->id,
            'staff_id'    => $absence->staff_id,
            'generated_by'=> auth()->id() ?? 1,
            'document_type'=> $type,
            'file_path'   => $path,
            'generated_at'=> now(),
        ]);
        return $path;
    }
    public function generateRtwForm(AbsenceRecord $absence): string { return $this->generate($absence, 'documents.rtw-form', 'rtw_form', 'rtw'); }
    public function generateFarmReport(AbsenceRecord $absence): string { return $this->generate($absence, 'documents.farm-report', 'farm_report', 'farm'); }
    public function generate14DayLetter(AbsenceRecord $absence): string { return $this->generate($absence, 'documents.14-day-letter', '14_day_letter', '14day'); }
    public function generate28DayLetter(AbsenceRecord $absence): string { return $this->generate($absence, 'documents.28-day-letter', '28_day_letter', '28day'); }
    public function generateSelfCert(AbsenceRecord $absence): string { return $this->generate($absence, 'documents.self-cert', 'self_cert', 'selfcert'); }
    public function generateOhReferralLetter(AbsenceRecord $absence): string { return $this->generate($absence, 'documents.oh-referral-letter', 'oh_referral_letter', 'oh'); }
}
