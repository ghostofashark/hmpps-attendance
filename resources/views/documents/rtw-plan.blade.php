<!DOCTYPE html><html><head><meta charset="UTF-8"><style>
body{font-family:Arial,sans-serif;font-size:11px;color:#1a1a2e;margin:30px}
.header{border-bottom:3px solid #1a1a2e;padding-bottom:12px;margin-bottom:20px}
.crest{font-weight:900;font-size:18px;color:#1a1a2e}
.subtitle-small{color:#666;font-size:10px}
h2{font-size:13px;color:#1a1a2e;border-bottom:2px solid #1a1a2e;padding-bottom:4px;margin:18px 0 8px}
h3{font-size:11px;color:#444;margin:12px 0 4px;font-weight:700}
.field{display:flex;margin-bottom:6px;align-items:flex-start}
.label{width:200px;color:#666;flex-shrink:0;padding-top:1px}
.value{font-weight:600}
.blank{display:inline-block;border-bottom:1px solid #999;min-width:150px}
.box{border:1px solid #ddd;border-radius:4px;padding:10px;margin:6px 0;background:#f8f9fa;min-height:30px}
.phase-table{width:100%;border-collapse:collapse;margin:8px 0}
.phase-table th{background:#1a1a2e;color:white;text-align:left;padding:5px 8px;font-size:10px}
.phase-table td{border:1px solid #ddd;padding:5px 8px;font-size:10px}
.phase-table tr:nth-child(even) td{background:#f8f9fa}
.sig-line{border-top:1px solid #999;width:220px;padding-top:4px;font-size:10px;color:#666}
.sig-block{display:flex;gap:50px;margin-top:30px;flex-wrap:wrap}
.footer{margin-top:30px;font-size:9px;color:#999;border-top:1px solid #eee;padding-top:8px}
.official{background:#8B0000;color:white;text-align:center;padding:5px;font-size:9px;letter-spacing:2px;margin-bottom:16px;font-weight:bold}
.highlight{background:#fffbcd;border:1px solid #f0d000;border-radius:4px;padding:6px 10px;margin:6px 0;font-size:10px}
.review-table{width:100%;border-collapse:collapse;margin:8px 0}
.review-table th{background:#333;color:white;text-align:left;padding:5px 8px;font-size:10px}
.review-table td{border:1px solid #ddd;padding:5px 8px;font-size:10px}
</style></head><body>
<div class="official">OFFICIAL SENSITIVE — PERSONAL DATA</div>
<div class="header">
  <div class="crest">HMPPS</div>
  <div class="subtitle-small">Return to Work Plan — Manager Toolkit</div>
  <div style="font-size:9px;color:#999;margin-top:4px">This document is OFFICIAL SENSITIVE. Store securely and share only with authorised persons.</div>
</div>

<h2>1. Staff Details</h2>
<div class="field"><span class="label">Full Name:</span><span class="value">{{ $absence->staff->full_name }}</span></div>
<div class="field"><span class="label">Payroll Number:</span><span class="value">{{ $absence->staff->payroll_number }}</span></div>
<div class="field"><span class="label">Job Title / Band:</span><span class="value">{{ $absence->staff->job_title }} (Band {{ $absence->staff->band }})</span></div>
<div class="field"><span class="label">Department:</span><span class="value">{{ $absence->staff->department }}</span></div>
<div class="field"><span class="label">Establishment:</span><span class="value">{{ $prison->name }}</span></div>
<div class="field"><span class="label">Line Manager:</span><span class="value">{{ $absence->staff->lineManager?->name ?? '—' }}</span></div>
<div class="field"><span class="label">HOBBA:</span><span class="value">{{ $absence->staff->hobba?->name ?? '—' }}</span></div>

<h2>2. Current Absence Details</h2>
<div class="field"><span class="label">Absence Start Date:</span><span class="value">{{ $absence->start_date->format('d F Y') }}</span></div>
<div class="field"><span class="label">Duration (to date):</span><span class="value">{{ $absence->duration_days }} calendar day(s)</span></div>
<div class="field"><span class="label">Reason for Absence:</span><span class="value">{{ $absence->illness_type_label }}</span></div>
@if($absence->illness_details)
<div class="field"><span class="label">Details:</span><span class="value">{{ $absence->illness_details }}</span></div>
@endif
@if($absence->isExcluded())
<div class="highlight">Exclusion Applied: {{ $absence->exclusion_reason_label }} — this absence is excluded from Bradford Factor and formal trigger calculations.</div>
@endif
<div class="field" style="margin-top:8px"><span class="label">OH Referral Made?</span>
  @if($absence->ohReferral)<span class="value">Yes — {{ $absence->ohReferral->created_at->format('d M Y') }}</span>@else<span class="blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>@endif
</div>

<h2>3. Agreed Return to Work</h2>
<div class="field"><span class="label">Agreed Return Date:</span><span class="blank" style="min-width:180px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
<div class="field"><span class="label">Phased Return?</span>
  <span style="display:flex;gap:20px"><span>&#9744; Yes (complete schedule below)</span><span>&#9744; No (full duties immediately)</span></span>
</div>

<h3>Phased Return Schedule</h3>
<table class="phase-table">
  <thead><tr><th>Period</th><th>Hours per Day</th><th>Days per Week</th><th>Duties / Restrictions</th></tr></thead>
  <tbody>
    <tr><td>Week 1</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr><td>Week 2</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr><td>Week 3</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr><td>Week 4</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr><td>Full Duties From</td><td colspan="3">&nbsp;</td></tr>
  </tbody>
</table>

<h2>4. Workplace Adjustments Agreed</h2>
@if($absence->workplaceAdjustments->count())
@foreach($absence->workplaceAdjustments as $adj)
<div class="field"><span class="label">&#10003;</span><span>{{ $adj->adjustment_type }} — {{ $adj->description }}</span></div>
@endforeach
@else
<div class="box" style="min-height:50px">
  <p style="color:#aaa;font-size:10px">No formal adjustments recorded. Note any agreed adjustments below:</p>
  <br><br>
</div>
@endif

<h2>5. Supportive Measures</h2>
<div class="field"><span>&#9744; PAM Assist (Employee Assistance Programme) discussed — <strong>Tel: 0800 243 458</strong> (free, 24/7, confidential)</span></div>
<div class="field"><span>&#9744; Occupational Health (OH) recommendation actioned</span></div>
<div class="field"><span>&#9744; Mental Health Ally referral made</span></div>
<div class="field"><span>&#9744; Disability-related adjustments assessed (EQIA completed if required)</span></div>
<div class="field"><span>&#9744; Buddy / Mentor support agreed</span></div>
<div class="field"><span>&#9744; Other: <span class="blank" style="min-width:300px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></div>
<div style="margin-top:6px;font-size:10px;color:#555">Notes on support measures:</div>
<div class="box" style="min-height:30px"><br></div>

<h2>6. Review Dates</h2>
<p style="font-size:10px;color:#555;margin-bottom:6px">Weekly reviews are required for the first month following return. Record agreed dates below.</p>
<table class="review-table">
  <thead><tr><th>Review Number</th><th>Date</th><th>Type</th><th>Completed By</th><th>Outcome / Notes</th></tr></thead>
  <tbody>
    <tr><td>Week 1 Review</td><td>&nbsp;</td><td>Informal</td><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr><td>Week 2 Review</td><td>&nbsp;</td><td>Informal</td><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr><td>Week 3 Review</td><td>&nbsp;</td><td>Informal</td><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr><td>Week 4 Review</td><td>&nbsp;</td><td>Formal</td><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr><td>Month 2 Review</td><td>&nbsp;</td><td>Formal</td><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr><td>Month 3 Review</td><td>&nbsp;</td><td>Formal</td><td>&nbsp;</td><td>&nbsp;</td></tr>
  </tbody>
</table>

<h2>7. Signatures</h2>
<p style="font-size:10px;color:#555">Both parties confirm the above plan has been agreed and understood.</p>
<div class="sig-block">
  <div>
    <div class="sig-line">Staff Member Signature</div>
    <div style="margin-top:10px;font-size:10px;color:#666">Name: <span class="blank" style="min-width:160px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
    <div style="margin-top:6px;font-size:10px;color:#666">Date: <span class="blank" style="min-width:100px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
  </div>
  <div>
    <div class="sig-line">Line Manager Signature</div>
    <div style="margin-top:10px;font-size:10px;color:#666">Name: <span class="blank" style="min-width:160px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
    <div style="margin-top:6px;font-size:10px;color:#666">Date: <span class="blank" style="min-width:100px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
  </div>
</div>
<div class="footer">HMPPS Attendance Management Hub &nbsp;|&nbsp; Return to Work Plan &nbsp;|&nbsp; Generated: {{ now()->format('d F Y H:i') }} &nbsp;|&nbsp; OFFICIAL SENSITIVE</div>
</body></html>
