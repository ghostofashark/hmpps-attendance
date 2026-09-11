<?php
namespace App\Http\Controllers;
use App\Models\AbsenceRecord;
use App\Models\ContactLog;
use Illuminate\Http\Request;
class ContactLogController extends Controller {
    public function store(Request $request, AbsenceRecord $absence) {
        $contactLog = $absence->contactLogs()->create(array_merge(
            $request->validate([
                'contact_type'      => 'required|string',
                'contact_direction' => 'required|in:outbound,inbound',
                'contacted_at'      => 'required|date',
                'contact_outcome'   => 'required|string',
                'pre_call_checklist'=> 'nullable|array',
                'post_contact_notes'=> 'nullable|string',
                'next_contact_due'  => 'nullable|date',
                'kit_call'          => 'boolean',
            ]),
            ['logged_by' => auth()->id()]
        ));
        return back()->with('success', 'Contact logged.');
    }
    public function destroy(ContactLog $log) { $log->delete(); return back(); }
}
