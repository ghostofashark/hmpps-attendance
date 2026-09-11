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
<div class="official">OFFICIAL</div>
<div class="header"><div class="crest"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 132 97" style="height:40px;width:auto;fill:#1a1a2e;vertical-align:middle" aria-hidden="true"><path d="M25 30.2c3.5 1.5 7.7-.2 9.1-3.7 1.5-3.6-.2-7.8-3.9-9.2-3.6-1.4-7.6.3-9.1 3.9-1.4 3.5.3 7.5 3.9 9zM9 39.5c3.6 1.5 7.8-.2 9.2-3.7 1.5-3.6-.3-7.8-3.9-9.1-3.6-1.5-7.6.2-9.1 3.8-1.4 3.5.3 7.5 3.8 9zM4.4 57.2c3.5 1.5 7.7-.2 9.1-3.8 1.5-3.6-.2-7.7-3.9-9.1-3.5-1.5-7.6.3-9.1 3.8-1.4 3.5.3 7.6 3.9 9.1zm38.3-21.4c3.5 1.5 7.7-.2 9.1-3.8 1.5-3.6-.2-7.7-3.9-9.1-3.6-1.5-7.6.3-9.1 3.8-1.3 3.6.4 7.7 3.9 9.1zm64.4-5.6c-3.6 1.5-7.8-.2-9.1-3.7-1.5-3.6.2-7.8 3.8-9.2 3.6-1.4 7.7.3 9.2 3.9 1.3 3.5-.4 7.5-3.9 9zm15.9 9.3c-3.6 1.5-7.7-.2-9.1-3.7-1.5-3.6.2-7.8 3.7-9.1 3.6-1.5 7.7.2 9.2 3.8 1.5 3.5-.3 7.5-3.8 9zm4.7 17.7c-3.6 1.5-7.8-.2-9.2-3.8-1.5-3.6.2-7.7 3.9-9.1 3.6-1.5 7.7.3 9.2 3.8 1.3 3.5-.4 7.6-3.9 9.1zM89.3 35.8c-3.6 1.5-7.8-.2-9.2-3.8-1.4-3.6.2-7.7 3.9-9.1 3.6-1.5 7.7.3 9.2 3.8 1.4 3.6-.3 7.7-3.9 9.1zM69.7 17.7l8.9 4.7V9.3l-8.9 2.8c-.2-.3-.5-.6-.9-.9L72.4 0H59.6l3.5 11.2c-.3.3-.6.5-.9.9l-8.8-2.8v13.1l8.8-4.7c.3.3.6.7.9.9l-5 15.4v.1h-4.1v-.2l-9.5-3.2c-.3.2-.7.2-1 .2H38l-3.2-9.8h-4.9l3.2 9.8h-1.6c-.4 0-.7 0-1-.1l-9.6 3.3v.1H16v-.1l5-15.4c.4-.3.7-.6.9-.9l8.8 4.7V9.3L22 12.1c-.3-.3-.6-.6-.9-.9L24.7 0H11.9l3.6 11.2c-.3.3-.6.5-.9.9l-8.9-2.8v13.1l8.9-4.7c.3.3.6.7.9.9L10 33h-.1v34.4h.1l1.3 1.5H6.7l.5 1.7.2.8h117.9l.2-.8.5-1.7h-4.6l1.3-1.5V33h-.1L116.5 18.7c.3-.3.6-.7.9-.9z"/></svg></div><div class="subtitle">Self-Certification of Sickness Absence</div></div>
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
