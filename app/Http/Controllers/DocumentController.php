<?php
namespace App\Http\Controllers;
use App\Models\AbsenceRecord;
use App\Services\DocumentService;
class DocumentController extends Controller {
    public function __construct(private DocumentService $docs) {}
    public function generate(AbsenceRecord $absence, string $type) {
        match($type) {
            'rtw_form'          => $this->docs->generateRtwForm($absence),
            'farm_report'       => $this->docs->generateFarmReport($absence),
            '14_day_letter'     => $this->docs->generate14DayLetter($absence),
            '28_day_letter'     => $this->docs->generate28DayLetter($absence),
            'self_cert'         => $this->docs->generateSelfCert($absence),
            'oh_referral_letter'=> $this->docs->generateOhReferralLetter($absence),
            'rtw_plan'          => $this->docs->generateRtwPlan($absence),
            default => abort(400)
        };
        return back()->with('success', 'Document generated.');
    }
}
