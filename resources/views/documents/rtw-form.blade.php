<!DOCTYPE html><html><head><meta charset="UTF-8"><style>
body{font-family:Arial,sans-serif;font-size:11px;color:#1a1a2e;margin:30px}
.header{border-bottom:3px solid #1a1a2e;padding-bottom:12px;margin-bottom:20px}
.logo{height:48px;width:auto}
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
<div class="header"><img src="{{ asset('images/hmpps-logo.png') }}" alt="HM Prison &amp; Probation Service" class="logo"></div>
<h1 style="font-size:16px;margin-bottom:4px">Return to Work Interview Record</h1>
<p class="subtitle">Attendance Management Policy &mdash; Mandatory RTW Discussion</p>
<h2>Employee Details</h2>
<div class="field"><span class="label">Name:</span><span class="value">{{ DVArabsence->staff->first_name }} {{ $absence->staff->last_name }}</span></div>
<div class="field"><span class="label">Payroll Number:</span><span class="value">{{ DVArabsence->staff->payroll_number }}</span></div>
<div class="field"><span class="label">Department:</span><span class="value">{{ DVArabsence->staff->department }}</span></div>
<div class="field"><span class="label">Band:</span><span class="value">{{ DVArabsence->staff->band }}</span></div>
<div class="field"><span class="label">Establishment:</span><span class="value">{{ $absence->prison->name }}</span></div>
<h2>Absence Details</h2>
<div class="field"><span class="label">First day of absence:</span><span class="value">{{ DVArabsence->start_date->format('d F Y') }}</span></div>
<div class="field"><span class="label">Date returned:</span><span class="value">{{ DVArabsence->end_date?->format('d F Y') ?? 'To be confirmed' }}</span></div>
<div class="field"><span class="label">Total days absent:</span><span class="value">{{ DVArabsence->duration_days }}</span></div>
<div class="field"><span class="label">Reason for absence:</span><span class="value">{{ DVArabsence->illness_type_label }}</span></div>
<h2>RTW Discussion Questions</h2>
<div class="box"><p><strong>1.</strong> Is the employee now fully fit to carry out their normal duties?<br><br><br></p></div>
<div class="box"><p><strong>2.</strong> Does the employee require any workplace adjustments or support?<br><br><br></p></div>
<div class="box"><p><strong>3.</strong> Was the employee aware of the absence reporting procedure?<br><br><br></p></div>
<div class="box"><p><strong>4.</strong> Have you considered any support available (PAM Assist, OH, MH Ally)?<br><br><br></p></div>
<div class="box"><p><strong>5.</strong> Does this absence trigger any attendance action? Bradford score: {{ DVArabsence->staff->bradford_score }}<br><br><br></p></div>
<div style="display:flex;gap:60px;margin-top:20px">
<div class="sig-line">Manager Signature &amp; Date</div>
<div class="sig-line">Employee Signature &amp; Date</div>
</div>
<div class="footer">HMPPS Attendance Management Hub &nbsp;|&nbsp; Generated: {{ now()->format('d F Y H:i') }} &nbsp;|&nbsp; OFFICIAL SENSITIVE</div>
</body></html>
