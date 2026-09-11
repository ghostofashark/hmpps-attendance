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
<p>Dear {{ DVArabsence->staff->first_name }},</p>
<h2>28-Day Review / Home Visit &mdash; Attendance Management</h2>
<p>Your absence commenced on <strong>{{ DVArabsence->start_date->format('d F Y') }}</strong> ({{ DVArabsence->duration_days }} days). In accordance with the HMPPS Attendance Management Policy, a 28-day review and/or home visit is now due.</p>
<p>This letter serves as notification that your manager will be in contact to arrange a welfare visit or meeting. The purpose is to provide support and discuss your expected return to work.</p>
<div class="box"><p><strong>At this review we will discuss:</strong></p>
<ul><li>Your current health and wellbeing</li><li>Occupational Health referral (if not already made)</li><li>Workplace adjustments that may assist your return</li><li>An expected return to work date</li><li>Any support services available to you</li></ul></div>
<p>Yours sincerely,</p><br><br>
<div class="sig-line">Line Manager Signature &amp; Date</div>
<div class="footer">HMPPS Attendance Management Hub &nbsp;|&nbsp; Generated: {{ now()->format('d F Y H:i') }}</div>
</body></html>
