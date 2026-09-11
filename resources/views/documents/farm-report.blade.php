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
<div class="header"><span style="font-weight:900;font-size:14px;color:#1a1a2e;letter-spacing:1px">HM Prison &amp; Probation Service</span></div>
<h1 style="font-size:16px;margin-bottom:4px">Formal Attendance Review Meeting (FARM) Record</h1>
<h2>Employee &amp; Case Details</h2>
<div class="field"><span class="label">Name:</span><span class="value">{{ $absence->staff->full_name }}</span></div>
<div class="field"><span class="label">Payroll Number:</span><span class="value">{{ $absence->staff->payroll_number }}</span></div>
<div class="field"><span class="label">Establishment:</span><span class="value">{{ $absence->prison->name }}</span></div>
<div class="field"><span class="label">Absence Started:</span><span class="value">{{ $absence->start_date->format('d F Y') }}</span></div>
<div class="field"><span class="label">Days Absent:</span><span class="value">{{ $absence->duration_days }}</span></div>
<div class="field"><span class="label">Bradford Score:</span><span class="value">{{ $absence->staff->bradford_score }}</span></div>
<div class="field"><span class="label">Risk Rating:</span><span class="value">{{ strtoupper($absence->risk_rating) }}</span></div>
<h2>Reason for FARM</h2>
<div class="box"><br><br><br></div>
<h2>Issues Discussed</h2>
<div class="box"><br><br><br><br></div>
<h2>Actions Agreed / Targets Set</h2>
<div class="box"><br><br><br><br></div>
<h2>Occupational Health / Support Considered</h2>
<div class="box"><br><br><br></div>
<h2>Outcome</h2>
<div style="display:flex;gap:20px;margin:8px 0">
<label><input type="checkbox"> No Further Action</label>
<label><input type="checkbox"> Improvement Period Commenced</label>
<label><input type="checkbox"> OH Referral Made</label>
<label><input type="checkbox"> Formal Warning Issued</label>
</div>
<div style="display:flex;gap:60px;margin-top:20px">
<div class="sig-line">Manager Signature &amp; Date</div>
<div class="sig-line">Employee Signature &amp; Date</div>
<div class="sig-line">Governor / HOB Signature &amp; Date</div>
</div>
<div class="footer">HMPPS Attendance Management Hub &nbsp;|&nbsp; Generated: {{ now()->format('d F Y H:i') }}</div>
</body></html>
