<!DOCTYPE html><html><head><meta charset="UTF-8"><style>
body{font-family:Arial,sans-serif;font-size:11px;color:#1a1a2e;margin:30px}
.header{border-bottom:3px solid #1a1a2e;padding-bottom:12px;margin-bottom:20px}
.crest{font-weight:900;font-size:18px;color:#1a1a2e}
.subtitle{color:#666;font-size:10px}
h2{font-size:13px;color:#1a1a2e;border-bottom:1px solid #ddd;padding-bottom:4px;margin:16px 0 8px}
.field{display:flex;margin-bottom:6px}
.label{width:220px;color:#666;flex-shrink:0}
.value{font-weight:600}
.box{border:1px solid #ddd;border-radius:6px;padding:12px;margin:8px 0;background:#f8f9fa}
.radio-line{margin:4px 0;display:flex;align-items:center;gap:20px}
.radio-opt{display:flex;align-items:center;gap:5px}
.blank{display:inline-block;border-bottom:1px solid #999;min-width:120px;margin:0 6px}
.sig-line{border-top:1px solid #999;width:220px;margin-top:30px;padding-top:4px;font-size:10px;color:#666}
.footer{margin-top:30px;font-size:9px;color:#999;border-top:1px solid #eee;padding-top:8px}
.official{background:#1a1a2e;color:white;text-align:center;padding:4px;font-size:9px;letter-spacing:2px;margin-bottom:16px}
.declaration-box{border:2px solid #1a1a2e;border-radius:6px;padding:12px;margin:12px 0;background:#f0f4ff}
</style></head><body>
<div class="official">OFFICIAL</div>
<div class="header"><div class="crest">HMPPS</div><div class="subtitle">Self-Certification of Sickness Absence</div></div>
<p class="subtitle">For absences of 7 calendar days or less. Submit to your line manager on return to work.</p>
<h2>Employee Details</h2>
<div class="field"><span class="label">Full Name:</span><span class="value">{{ $absence->staff->full_name }}</span></div>
<div class="field"><span class="label">Payroll Number:</span><span class="value">{{ $absence->staff->payroll_number }}</span></div>
<div class="field"><span class="label">Department:</span><span class="value">{{ $absence->staff->department }}</span></div>
<div class="field"><span class="label">Establishment:</span><span class="value">{{ $absence->prison->name }}</span></div>
<h2>Absence Details</h2>
<div class="field"><span class="label">First day of absence:</span><span class="value">{{ $absence->start_date->format('d F Y') }}</span></div>
<div class="field"><span class="label">First day back:</span><span class="blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
<div class="field"><span class="label">Total days absent:</span><span class="blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
<h2>Nature of Illness / Reason for Absence</h2>
<div class="box"><br><br><br><br></div>
<h2>Injury at Work</h2>
<div class="radio-line">
  <span>Was this absence related to an injury at work?</span>
  <span class="radio-opt"><input type="checkbox"> Yes</span>
  <span class="radio-opt"><input type="checkbox"> No</span>
</div>
<div class="field" style="margin-top:8px"><span class="label">If yes, date of accident:</span><span class="blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
<div class="field"><span class="label">Location of accident:</span><span class="blank" style="min-width:200px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
<div class="radio-line">
  <span>Was the accident reported via RIDDOR?</span>
  <span class="radio-opt"><input type="checkbox"> Yes</span>
  <span class="radio-opt"><input type="checkbox"> No</span>
</div>
<h2>Third-Party Claim</h2>
<div class="radio-line">
  <span>Is a third-party claim being pursued in relation to this absence?</span>
  <span class="radio-opt"><input type="checkbox"> Yes</span>
  <span class="radio-opt"><input type="checkbox"> No</span>
</div>
<div class="field" style="margin-top:8px"><span class="label">If yes, please give details:</span></div>
<div class="box" style="min-height:40px"><br></div>
<h2>Employee Declaration</h2>
<div class="declaration-box">
  <p>I declare that the above information is true and correct to the best of my knowledge. I understand that providing false information may result in disciplinary action being taken against me in accordance with HMPPS disciplinary procedures.</p>
</div>
<div style="display:flex;gap:60px;margin-top:20px">
  <div class="sig-line">Employee Signature &amp; Date</div>
  <div class="sig-line">Print Name</div>
</div>
<h2>Manager Countersignature</h2>
<p style="font-size:10px;color:#555">To be completed by the line manager at the return-to-work interview. Confirm the above information has been discussed and is accurate to the best of your knowledge.</p>
<div class="field" style="margin-top:10px"><span class="label">Manager Name:</span><span class="blank" style="min-width:200px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
<div class="field"><span class="label">Job Title:</span><span class="blank" style="min-width:200px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
<div class="radio-line" style="margin-top:8px">
  <span>Return-to-work interview conducted?</span>
  <span class="radio-opt"><input type="checkbox"> Yes — Date: <span class="blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>
  <span class="radio-opt"><input type="checkbox"> No (reason: <span class="blank" style="min-width:120px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>)</span>
</div>
<div style="display:flex;gap:60px;margin-top:20px">
  <div class="sig-line">Manager Signature &amp; Date</div>
  <div class="sig-line">Print Name</div>
</div>
<div class="footer">HMPPS Attendance Management Hub &nbsp;|&nbsp; Generated: {{ now()->format('d F Y H:i') }} &nbsp;|&nbsp; OFFICIAL</div>
</body></html>
