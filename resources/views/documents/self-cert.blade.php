<!DOCTYPE html><html><head><meta charset="UTF-8"><style>
body{font-family:Arial,sans-serif;font-size:11px;color:#1a1a2e;margin:30px}
.header{border-bottom:3px solid #1a1a2e;padding-bottom:12px;margin-bottom:20px}
.crest{font-weight:900;font-size:18px;color:#1a1a2e}
.subtitle{color:#666;font-size:10px}
h2{font-size:13px;color:#1a1a2e;border-bottom:1px solid #ddd;padding-bottom:4px;margin:16px 0 8px}
.field{display:flex;margin-bottom:6px}
.label{width:180px;color:#666;flex-shrink:0}
.value{font-weight:600}
.box{border:1px solid #ddd;border-radius:6px;padding:12px;margin:8px 0;background:#f8f9fa}
.sig-line{border-top:1px solid #999;width:200px;margin-top:30px;padding-top:4px;font-size:10px;color:#666}
.footer{margin-top:30px;font-size:9px;color:#999;border-top:1px solid #eee;padding-top:8px}
.official{background:#1a1a2e;color:white;text-align:center;padding:4px;font-size:9px;letter-spacing:2px;margin-bottom:16px}
</style></head><body>
<div class="official">OFFICIAL</div>
<div class="header"><div class="crest">HMPPS</div><div class="subtitle">Self-Certification of Sickness Absence</div></div>
<p class="subtitle">For absences of 7 calendar days or less. Submit to your line manager on return to work.</p>
<h2>Employee Details</h2>
<div class="field"><span class="label">Full Name:</span><span class="value">{{ DVArabsence->staff->full_name }}</span></div>
<div class="field"><span class="label">Payroll Number:</span><span class="value">{{ DVArabsence->staff->payroll_number }}</span></div>
<div class="field"><span class="label">Department:</span><span class="value">{{ DVArabsence->staff->department }}</span></div>
<div class="field"><span class="label">Establishment:</span><span class="value">{{ DVArabsence->prison->name }}</span></div>
<h2>Absence Details</h2>
<div class="field"><span class="label">First day of absence:</span><span class="value">{{ DVArabsence->start_date->format('d F Y') }}</span></div>
<div class="field"><span class="label">First day back:</span><span class="value">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
<div class="field"><span class="label">Total days absent:</span><span class="value">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
<h2>Nature of Illness / Reason for Absence</h2>
<div class="box"><br><br><br><br></div>
<p>I declare that the information given above is correct to the best of my knowledge and belief.</p>
<div style="display:flex;gap:60px;margin-top:20px">
<div class="sig-line">Employee Signature &amp; Date</div>
<div class="sig-line">Manager Signature &amp; Date</div>
</div>
<div class="footer">HMPPS Attendance Management Hub &nbsp;|&nbsp; Generated: {{ now()->format('d F Y H:i') }}</div>
</body></html>
