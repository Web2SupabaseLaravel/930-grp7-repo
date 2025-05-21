<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Practitioner;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('can:view-reports');
    }

    public function appointmentVolume(Request $request)
    {
        
        $period = $request->get('period', 'daily');
        $now    = Carbon::now();

        $query = Appointment::select(
            DB::raw($this->groupByDateSql($period) . ' as period'),
            DB::raw('count(*) as total')
        )->groupBy('period');

        
        if ($period === 'daily') {
            $query->whereDate('appointment_date', $now->toDateString());
        } elseif ($period === 'weekly') {
            $query->whereBetween('appointment_date', [
                $now->startOfWeek()->toDateString(),
                $now->endOfWeek()->toDateString(),
            ]);
        } else { 
            $query->whereMonth('appointment_date', $now->month)
                  ->whereYear('appointment_date', $now->year);
        }

        return response()->json($query->get());
    }

    public function practitionerUtilization()
    {
        $data = Practitioner::withCount(['services', 'appointments as total_appointments'])
            ->with(['appointments' => function($q){
                $q->select(DB::raw('practitioner_id, AVG(TIMESTAMPDIFF(MINUTE, 
                         CONCAT(appointment_date, " ", appointment_time), 
                         CONCAT(appointment_date, " ", appointment_time)) 
                       ) as avg_duration'))
                  ->groupBy('practitioner_id');
            }])
            ->get()
            ->map(function($pr){
                $revenue = $pr->appointments->sum(function($appt){
                    return $appt->service->price;
                });
                return [
                    'practitioner_id'   => $pr->id,
                    'name'              => $pr->name,
                    'total_appointments'=> $pr->total_appointments,
                    'average_duration'  => optional($pr->appointments->first())->avg_duration ?? 0,
                    'revenue'           => $revenue,
                ];
            });

        return response()->json($data);
    }

    public function cancellationNoShow(Request $request)
    {
        $cancellations = Appointment::select(
            'practitioner_id',
            DB::raw('COUNT(*) as cancelled_count')
        )->where('status','cancelled')
         ->groupBy('practitioner_id');

        $total = Appointment::select(
            'practitioner_id',
            DB::raw('COUNT(*) as total_count')
        )->groupBy('practitioner_id');

        $stats = Practitioner::select('id','name')
            ->leftJoinSub($cancellations,'cxl', function($join){
                $join->on('practitioners.id','=','cxl.practitioner_id');
            })
            ->leftJoinSub($total,'tot', function($join){
                $join->on('practitioners.id','=','tot.practitioner_id');
            })
            ->get()
            ->map(function($row){
                $cancelled = $row->cancelled_count ?? 0;
                $total     = $row->total_count     ?? 0;
                $rate      = $total ? round($cancelled / $total * 100, 2) : 0;
                return [
                    'practitioner_id' => $row->id,
                    'name'            => $row->name,
                    'cancellation_rate_percent' => $rate,
                ];
            });

        $noShows = Appointment::select(
            'practitioner_id',
            DB::raw('COUNT(*) as no_show_count')
        )->where('status','scheduled')
         ->whereDate('appointment_date','<', Carbon::today()->toDateString())
         ->groupBy('practitioner_id');

        $statsNoShow = Practitioner::select('id','name')
            ->leftJoinSub($noShows,'ns', function($join){
                $join->on('practitioners.id','=','ns.practitioner_id');
            })
            ->get()
            ->map(function($row){
                return [
                    'practitioner_id' => $row->id,
                    'name'            => $row->name,
                    'no_show_count'   => $row->no_show_count ?? 0,
                ];
            });

        return response()->json([
            'cancellation_rates' => $stats,
            'no_show_rates'      => $statsNoShow,
        ]);
    }

    
    private function groupByDateSql($period)
    {
        switch($period){
            case 'weekly':
                return "WEEK(appointment_date)";
            case 'monthly':
                return "MONTH(appointment_date)";
            default:
                return "DATE(appointment_date)";
        }
    }
}

