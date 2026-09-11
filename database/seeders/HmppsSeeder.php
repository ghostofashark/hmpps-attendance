<?php
namespace Database\Seeders;
use App\Models\Prison;
use App\Models\User;
use App\Models\Staff;
use App\Models\AbsenceRecord;
use App\Models\ContactLog;
use App\Models\TriggerPoint;
use App\Services\ActionDateService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HmppsSeeder extends Seeder
{
    public function run(): void
    {
        $actionSvc = new ActionDateService();

        // ===== PRISONS =====
        $prisons = [
            Prison::create(['name'=>'HMP Wandsworth','code'=>'WAN','region'=>'London','category'=>'B','type'=>'public','governor_name'=>'Mark Richardson']),
            Prison::create(['name'=>'HMP Manchester','code'=>'MAN','region'=>'North West','category'=>'B','type'=>'public','governor_name'=>'Sarah Holden']),
            Prison::create(['name'=>'HMP Belmarsh','code'=>'BEL','region'=>'London','category'=>'A','type'=>'public','governor_name'=>'James Whitfield']),
            Prison::create(['name'=>'HMP Oakwood','code'=>'OAK','region'=>'West Midlands','category'=>'C','type'=>'private','governor_name'=>'Linda Frost']),
            Prison::create(['name'=>'HMP Exeter','code'=>'EXE','region'=>'South West','category'=>'B','type'=>'public','governor_name'=>'Gary Preston']),
        ];
        [$wan, $man, $bel, $oak, $exe] = $prisons;

        // ===== USERS (managers) =====
        $hobba = User::create(['name'=>'Janet Hobba','email'=>'j.hobba@hmpps.gov.uk','password'=>Hash::make('password'),'prison_id'=>$wan->id,'default_prison_id'=>$wan->id,'job_title'=>'Head of Business','payroll_number'=>'HOB001']);
        $mgr1 = User::create(['name'=>'Paul Griffiths','email'=>'p.griffiths@hmpps.gov.uk','password'=>Hash::make('password'),'prison_id'=>$wan->id,'default_prison_id'=>$wan->id,'job_title'=>'Band 7 Manager','payroll_number'=>'MGR001']);
        $mgr2 = User::create(['name'=>'Diane Clarke','email'=>'d.clarke@hmpps.gov.uk','password'=>Hash::make('password'),'prison_id'=>$man->id,'default_prison_id'=>$man->id,'job_title'=>'Band 7 Manager','payroll_number'=>'MGR002']);
        $gov = User::create(['name'=>'George Blackwell','email'=>'g.blackwell@hmpps.gov.uk','password'=>Hash::make('password'),'prison_id'=>$wan->id,'default_prison_id'=>$wan->id,'job_title'=>'Governor','payroll_number'=>'GOV001']);

        $hobba->assignRole('hobba');
        $mgr1->assignRole('line_manager');
        $mgr2->assignRole('line_manager');
        $gov->assignRole('governor');

        // ===== 20 STAFF =====
        $staffData = [
            // [first, last, payroll, prison_id, dept, band, job, email, phone, manager]
            ['James','Morrison','P001001',$wan->id,'Residential','Band 4','Prison Officer','j.morrison@wan.hmpps.gov.uk','07700900001',$mgr1->id],
            ['Sarah','Mitchell','P001002',$wan->id,'Healthcare','Band 5','Healthcare Officer','s.mitchell@wan.hmpps.gov.uk','07700900002',$mgr1->id],
            ['David','Patel','P001003',$wan->id,'Administration','Band 3','Admin Officer','d.patel@wan.hmpps.gov.uk','07700900003',$mgr1->id],
            ['Emma','Thompson','P002001',$man->id,'Security','Band 4','Prison Officer','e.thompson@man.hmpps.gov.uk','07700900004',$mgr2->id],
            ['Robert','Clarke','P002002',$man->id,'Offender Management','Band 5','Case Manager','r.clarke@man.hmpps.gov.uk','07700900005',$mgr2->id],
            ['Lisa','Hughes','P002003',$man->id,'Residential','Band 3','Prison Officer','l.hughes@man.hmpps.gov.uk','07700900006',$mgr2->id],
            ['Michael','Brennan','P003001',$bel->id,'Programmes','Band 7','Programmes Manager','m.brennan@bel.hmpps.gov.uk','07700900007',$mgr1->id],
            ['Claire','Watson','P003002',$bel->id,'Healthcare','Band 4','Healthcare Assistant','c.watson@bel.hmpps.gov.uk','07700900008',$mgr1->id],
            ['Thomas','Griffiths','P003003',$bel->id,'Security','Band 3','Prison Officer','t.griffiths@bel.hmpps.gov.uk','07700900009',$mgr1->id],
            ['Natalie','Price','P004001',$oak->id,'Administration','Band 5','Senior Admin','n.price@oak.hmpps.gov.uk','07700900010',$mgr1->id],
            ['Kevin','Sharma','P004002',$oak->id,'Residential','Band 4','Prison Officer','k.sharma@oak.hmpps.gov.uk','07700900011',$mgr1->id],
            ['Rachel','Foster','P004003',$oak->id,'Offender Management','Band 3','Probation Officer','r.foster@oak.hmpps.gov.uk','07700900012',$mgr1->id],
            ['Daniel','Cooper','P004004',$oak->id,'Programmes','Band 5','Programmes Officer','d.cooper@oak.hmpps.gov.uk','07700900013',$mgr1->id],
            ['Joanne','Hill','P001004',$wan->id,'Healthcare','Band 4','Healthcare Officer','j.hill@wan.hmpps.gov.uk','07700900014',$mgr1->id],
            ['Andrew','Barnes','P001005',$wan->id,'Security','Band 3','Prison Officer','a.barnes@wan.hmpps.gov.uk','07700900015',$mgr1->id],
            ['Stephanie','Young','P002004',$man->id,'Residential','Band 5','Senior Officer','s.young@man.hmpps.gov.uk','07700900016',$mgr2->id],
            ['Paul','Hutchinson','P005001',$exe->id,'Offender Management','Band 4','Case Manager','p.hutchinson@exe.hmpps.gov.uk','07700900017',$mgr1->id],
            ['Helen','Walsh','P005002',$exe->id,'Administration','Band 3','Admin Officer','h.walsh@exe.hmpps.gov.uk','07700900018',$mgr1->id],
            ['Christopher','Evans','P005003',$exe->id,'Programmes','Band 5','Programmes Officer','c.evans@exe.hmpps.gov.uk','07700900019',$mgr1->id],
            ['Patricia','Ogden','P003004',$bel->id,'Healthcare','Band 7','Head of Healthcare','p.ogden@bel.hmpps.gov.uk','07700900020',$mgr1->id],
        ];

        $createdStaff = [];
        foreach ($staffData as $row) {
            $createdStaff[] = Staff::create([
                'prison_id'     => $row[3],
                'first_name'    => $row[0],
                'last_name'     => $row[1],
                'payroll_number'=> $row[2],
                'job_title'     => $row[6],
                'department'    => $row[4],
                'band'          => $row[5],
                'email'         => $row[7],
                'phone'         => $row[8],
                'mobile'        => $row[8],
                'home_address'  => rand(1,200).' Example Street, London',
                'next_of_kin_name'  => 'Emergency Contact',
                'next_of_kin_phone'=> '07700'.str_pad(rand(100000,999999), 6, '0', STR_PAD_LEFT),
                'line_manager_id'=> $row[9],
                'hobba_id'      => $hobba->id,
                'date_joined'   => Carbon::now()->subYears(rand(1,15))->subMonths(rand(0,11)),
                'is_active'     => true,
            ]);
        }

        // ===== ABSENCES =====
        // 20 staff, varied illnesses, dates, statuses
        $absenceData = [
            // [staff_idx, illness, days_ago, duration_or_null, status, risk, include]
            [0,  'cold_flu',       5,   5,    'returned',   'green', true],
            [1,  'stress',        35,   null, 'long_term',  'red',   true],
            [2,  'back_pain',     18,   null, 'active',     'amber', true],
            [3,  'anxiety',       10,   10,   'returned',   'green', true],
            [4,  'depression',    45,   null, 'long_term',  'red',   true],
            [5,  'cold_flu',       3,    3,   'returned',   'green', true],
            [6,  'stress',        22,   null, 'active',     'amber', true],
            [7,  'injury',        14,   14,   'returned',   'amber', true],
            [8,  'cold_flu',       5,    5,   'returned',   'green', true],
            [9,  'anxiety',       31,   null, 'referred_oh','red',   true],
            [10, 'other',          7,    7,   'returned',   'green', true],
            [11, 'back_pain',     12,   null, 'active',     'amber', true],
            [12, 'ptsd',          60,   null, 'referred_oh','red',   false],
            [13, 'depression',    21,   21,   'returned',   'amber', true],
            [14, 'cold_flu',       2,    2,   'returned',   'green', true],
            [15, 'stress',        16,   null, 'active',     'amber', true],
            [16, 'injury',         8,   null, 'active',     'green', true],
            [17, 'cold_flu',       4,    4,   'returned',   'green', true],
            [18, 'anxiety',       28,   null, 'active',     'amber', true],
            [19, 'surgery',       42,   null, 'long_term',  'red',   true],
        ];

        $reporter = $mgr1;

        foreach ($absenceData as $ad) {
            $staff = $createdStaff[$ad[0]];
            $start = Carbon::today()->subDays($ad[2]);
            $end = $ad[3] ? $start->copy()->addDays($ad[3])->subDay() : null;

            $absence = AbsenceRecord::create([
                'staff_id'     => $staff->id,
                'prison_id'    => $staff->prison_id,
                'reported_by'  => $reporter->id,
                'start_date'   => $start->toDateString(),
                'end_date'     => $end?->toDateString(),
                'illness_type' => $ad[1],
                'illness_details'=> 'Self-reported. Further details as per contact log.',
                'status'       => $ad[4],
                'risk_rating'  => $ad[5],
                'include_in_daily_list'=> $ad[6],
                'self_cert_required'=> $ad[3] && $ad[3] <= 7,
                'self_cert_received'=> $ad[3] && $ad[3] <= 7,
                'fit_note_required' => $ad[3] === null || $ad[3] > 7,
                'fit_note_received' => $ad[4] === 'returned' && ($ad[3] ?? 99) > 7,
                'notes'        => $ad[4] === 'active' ? 'Ongoing absence. Regular contact maintained.' : null,
            ]);

            // Triggers
            $actionSvc->calculateAndCreateTriggers($absence);

            // Contact logs for active/long-term absences
            if (in_array($ad[4], ['active','long_term','referred_oh']) && $ad[2] > 7) {
                $contacts = [
                    [$start->copy()->addDays(2), 'phone_call', 'outbound', 'spoke_to_staff', 'Spoke with '.$staff->first_name.'. They report still feeling unwell. Discussed expected return date. Fit note requested if absence continues beyond 7 days. Next contact in 7 days.'],
                    [$start->copy()->addDays(7), 'phone_call', 'outbound', 'spoke_to_staff', '7-day welfare call completed. Staff member reports no significant change. Fit note received. Discussed OH referral pathway. Reminder about 14-day review sent. Next contact in 7 days.'],
                ];
                if ($ad[2] > 14) {
                    $contacts[] = [$start->copy()->addDays(14), 'phone_call', 'outbound', in_array($ad[5],['red','amber']) ? 'spoke_to_staff' : 'left_voicemail', '14-day review completed. Absence discussed in detail. Occupational Health referral under consideration. Workplace adjustments discussed. Staff member advised of FARM process if absence continues.'];
                }
                if ($ad[2] > 21) {
                    $contacts[] = [$start->copy()->addDays(21), 'teams_call', 'outbound', 'spoke_to_staff', '21-day welfare check via Teams. Staff member visible on screen, appears well. OH referral agreed and initiated. Phased return discussed as a potential option. Expected return date discussed.'];
                }
                if ($ad[2] > 28) {
                    $contacts[] = [$start->copy()->addDays(28), 'home_visit', 'outbound', 'spoke_to_staff', '28-day home visit conducted. Staff member engaged positively. Workplace adjustment passport reviewed. FARM meeting scheduled. Governor notified as per policy.'];
                }

                foreach ($contacts as $contact) {
                    ContactLog::create([
                        'absence_id'       => $absence->id,
                        'logged_by'        => $reporter->id,
                        'contact_type'     => $contact[1],
                        'contact_direction'=> $contact[2],
                        'contacted_at'     => $contact[0],
                        'contact_outcome'  => $contact[3],
                        'post_contact_notes'=> $contact[4],
                        'pre_call_checklist'=> ['Reviewed last contact notes','Checked fit note status','Noted outstanding actions','Prepared welfare questions'],
                        'next_contact_due' => $contact[0]->copy()->addDays(7)->toDateString(),
                        'kit_call'         => $ad[4] === 'long_term' && $contact[0] > $start->copy()->addDays(14),
                    ]);
                }
            }
        }

        // Update Bradford scores
        foreach ($createdStaff as $staff) {
            $absences = AbsenceRecord::where('staff_id', $staff->id)->whereYear('start_date', now()->year)->get();
            $spells = $absences->count();
            $days = $absences->sum(fn($a) => $a->duration_days);
            $score = ($spells * $spells) * $days;
            AbsenceRecord::where('staff_id', $staff->id)->update(['bradford_score' => $score]);
        }

        // Mark overdue triggers
        TriggerPoint::whereNull('completed_at')
            ->where('action_due_date', '<', now()->toDateString())
            ->update(['is_overdue' => true]);

        $this->command->info('HMPPS seed complete: 5 prisons, 4 users, 20 staff, 20 absences, contact logs.');
    }
}
