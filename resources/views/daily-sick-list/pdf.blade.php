<!DOCTYPE html>
<html><head><meta charset="UTF-8">
<style>
body { font-family: Arial, sans-serif; font-size: 11px; color: #1a1a2e; margin: 20px; }
h1 { font-size: 16px; color: #1a1a2e; margin-bottom: 4px; }
.sub { color: #666; font-size: 10px; margin-bottom: 16px; }
table { width: 100%; border-collapse: collapse; }
th { background: #1a1a2e; color: white; padding: 6px 8px; text-align: left; font-size: 10px; text-transform: uppercase; }
td { padding: 5px 8px; border-bottom: 1px solid #eee; }
tr:nth-child(even) td { background: #f8f9fa; }
.risk-red { background: #fee2e2; color: #b91c1c; padding: 1px 6px; border-radius: 8px; font-weight: bold; font-size: 9px; }
.risk-amber { background: #fef3c7; color: #b45309; padding: 1px 6px; border-radius: 8px; font-weight: bold; font-size: 9px; }
.risk-green { background: #dcfce7; color: #15803d; padding: 1px 6px; border-radius: 8px; font-weight: bold; font-size: 9px; }
.footer { margin-top: 20px; font-size: 9px; color: #999; border-top: 1px solid #eee; padding-top: 8px; }
</style></head><body>
<h1>HMPPS Daily Sick List</h1>
<div class="sub">Generated: {{ now()->format('d F Y H:i') }} &nbsp;|&nbsp; OFFICIAL SENSITIVE &mdash; NOT FOR GENERAL CIRCULATION</div>
<table>
<thead><tr><th>Name</th><th>Payroll</th><th>Department</th><th>Band</th><th>Illness</th><th>Days Absent</th><th>Date Started</th><th>Risk</th></tr></thead>
<tbody>
@foreach($absences->sortBy('staff.last_name') as $absence)
<tr>
  <td>{{ $absence->staff->full_name }}</td>
  <td>{{ $absence->staff->payroll_number }}</td>
  <td>{{ $absence->staff->department }}</td>
  <td>{{ $absence->staff->band }}</td>
  <td>{{ $absence->illness_type_label }}</td>
  <td><strong>{{ $absence->duration_days }}</strong></td>
  <td>{{ $absence->start_date->format('d M Y') }}</td>
  <td><span class="risk-{{ $absence->risk_rating }}">{{ strtoupper($absence->risk_rating) }}</span></td>
</tr>
@endforeach
</tbody></table>
<div class="footer">HMPPS Attendance Management Hub &nbsp;|&nbsp; Prison Service &nbsp;|&nbsp; Total absent: {{ $absences->count() }}</div>
</body></html>
