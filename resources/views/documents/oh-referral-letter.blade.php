<!DOCTYPE html><html><head><meta charset="UTF-8"><style>
body{font-family:Arial,sans-serif;font-size:11px;color:#1a1a2e;margin:30px}
.header{border-bottom:3px solid #1a1a2e;padding-bottom:12px;margin-bottom:20px}
.crest{display:flex;align-items:center;gap:10px}.crest-text{font-weight:900;font-size:14px;color:#1a1a2e}
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
<div class="official">OFFICIAL &mdash; SENSITIVE</div>
<div class="header"><div class="crest">HMPPS &mdash; {{ DVArabsence->prison->name }}</div></div>
<p>{{ now()->format('d F Y') }}</p>
<p><strong>Occupational Health Service</strong></p>
<h2>Referral for Occupational Health Assessment</h2>
<p>I am writing to refer the above-named employee for an Occupational Health assessment.</p>
<h2>Employee Details</h2>
<div class="field"><span class="label">Name:</span><span class="value">{{ DVArabsence->staff->full_name }}</span></div>
<div class="field"><span class="label">Payroll Number:</span><span class="value">{{ DVArabsence->staff->payroll_number }}</span></div>
<div class="field"><span class="label">Job Title:</span><span class="value">{{ DVArabsence->staff->job_title }}</span></div>
<div class="field"><span class="label">Days Absent:</span><span class="value">{{ DVArabsence->duration_days }}</span></div>
<div class="field"><span class="label">Illness Type:</span><span class="value">{{ DVArabsence->illness_type_label }}</span></div>
<h2>Questions for Occupational Health</h2>
<div class="box">
<ol>
<li style="margin-bottom:8px">Is the employee fit to return to their current role? If not, when might they be fit to return?</li>
<li style="margin-bottom:8px">Are there any workplace adjustments that would support an early return to work?</li>
<li style="margin-bottom:8px">Is the employee's condition likely to be covered by the Equality Act 2010?</li>
<li style="margin-bottom:8px">Are there any treatments or interventions that may assist recovery?</li>
<li style="margin-bottom:8px">Please provide any other advice relevant to the management of this case.</li>
</ol>
</div>
<p>Yours sincerely,</p><br><br>
<div class="sig-line">Manager Signature &amp; Date</div>
<div class="footer">HMPPS Attendance Management Hub &nbsp;|&nbsp; Generated: {{ now()->format('d F Y H:i') }}</div>
</body></html>
