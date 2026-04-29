<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Device;
use App\Models\Attendance;
use App\Enum\AttendanceMethod;
use App\Enum\AttendanceStatus;
use App\Enum\DeviceStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ZKTecoController extends Controller
{
    /**
     * Handshake / Initialization (GET /iclock/cdata)
     */
    public function handshake(Request $request)
    {
        Log::info('ZKTeco Handshake Request:', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'query' => $request->query(),
            'headers' => $request->headers->all(),
        ]);
        
        $sn = $request->query('SN', 'UNKNOWN');
        if ($sn !== 'UNKNOWN') {
            $this->ensureDeviceExists($sn);
        }
        
        $response = "GET OPTION FROM: {$sn}\n" .
                    "ATTLOGStamp=None\n" .
                    "OPERLOGStamp=None\n" .
                    "ATTPHOTOStamp=None\n" .
                    "BIODATAStamp=None\n" .
                    "IDCARDStamp=None\n" .
                    "ERRORLOGStamp=None\n" .
                    "ErrorDelay=30\n" .
                    "Delay=10\n" .
                    "TransTimes=00:00;14:05\n" .
                    "TransInterval=1\n" .
                    "TransFlag=TransData\tAttLog\tOpLog\tAttPhoto\tEnrollUser\tChgUser\tEnrollFP\tChgFP\tFACE\tUserPic\tWORKCODE\tBioPhoto\n" .
                    "TimeZone=2\n" .
                    "Realtime=1\n" .
                    "Encrypt=0\n" .
                    "ServerVer=2.4.0\n" .
                    "PushProtVer=2.4.0\n" .
                    "PushOptionsFlag=1\n" .
                    "PushOptions=FingerFunOn,FaceFunOn,PhotoFunOn,BioPhotoFun,BioDataFun,VisilightFun\n" .
                    "ATTPHOTOBase64=1\n" .
                    "MultiBioDataSupport=0:1:1:0:0:0:0:0:0:0\n" .
                    "MultiBioPhotoSupport=0:1:1:0:0:0:0:0:0:0\n";
                    
        return response($response, 200)->header('Content-Type', 'text/plain');
    }

    /**
     * Keep-Alive / Get Request (GET /iclock/getrequest)
     */
    public function getRequest(Request $request)
    {
        return response("OK\n", 200)->header('Content-Type', 'text/plain');
    }

    /**
     * Receive Data (POST /iclock/cdata)
     */
    public function receiveData(Request $request)
    {
        Log::info('ZKTeco Data Request:', [
            'url' => $request->fullUrl(),
            'query' => $request->query(),
            'content' => $request->getContent(),
        ]);
        
        $sn = $request->query('SN');
        $table = $request->query('table');

        if (!$sn || $table !== 'ATTLOG') {
            return response("OK\n", 200)->header('Content-Type', 'text/plain');
        }

        $device = $this->ensureDeviceExists($sn);
        
        $content = $request->getContent();
        $lines = explode("\n", trim($content));
        
        $processedCount = 0;

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            
            // Split by any whitespace (tabs or spaces)
            $parts = preg_split('/\s+/', $line);
            if (count($parts) < 3) continue;

            $pin = $parts[0];
            // Usually PIN, DATE, TIME, STATUS...
            // So DATE is parts[1], TIME is parts[2]
            $timeString = $parts[1] . ' ' . $parts[2];

            if ($pin && $timeString) {
                $this->processAttendanceLog($pin, $timeString, $device);
                $processedCount++;
            }
        }

        // Return OK: count to tell the device we received the data
        return response("OK: {$processedCount}\n", 200)->header('Content-Type', 'text/plain');
    }

    private function ensureDeviceExists($sn)
    {
        $defaultProject = \App\Models\Project::first();
        return Device::firstOrCreate(
            ['serial_number' => $sn],
            [
                'name' => "ZKTeco $sn", 
                'code' => "DEV-$sn", 
                'status' => DeviceStatus::Online ?? null,
                'project_id' => $defaultProject ? $defaultProject->id : null
            ]
        );
    }

    private function processAttendanceLog($pin, $timeString, $device)
    {
        $employee = Employee::where('employee_number', $pin)->first();

        if (!$employee) {
            Log::warning("ZKTeco ADMS: Unknown employee PIN {$pin}");
            return;
        }

        try {
            $timestamp = Carbon::parse($timeString, 'Africa/Kigali');
        } catch (\Exception $e) {
            Log::error("ZKTeco ADMS: Invalid time format {$timeString}");
            return;
        }

        $date = $timestamp->format('Y-m-d');
        $time = $timestamp->format('H:i:s');

        $attendance = Attendance::firstOrNew(
            [
                'employee_id' => $employee->id,
                'date' => $date,
            ],
            [
                'code' => 'ATT-ZK-' . $employee->code . '-' . $timestamp->format('Ymd'),
                'status' => AttendanceStatus::Entered,
                'daily_status' => 'Present',
                'device_id' => $device->id,
            ]
        );

        $updated = false;

        if (empty($attendance->check_in)) {
            $attendance->check_in = $time;
            $attendance->check_in_method = AttendanceMethod::Finger_Prints;
            $updated = true;
        } else {
            // $attendance->check_in is already cast to a Carbon object by the model
            $existingCheckIn = Carbon::parse($date . ' ' . $attendance->check_in->format('H:i:s'), 'Africa/Kigali');
            
            // Only process if this punch is distinct (not a duplicate tap within 15s)
            $diff = $timestamp->diffInSeconds($existingCheckIn, false); // false = signed diff
            Log::info("ZKTeco ADMS: Punch for {$pin} at {$time}. Signed Diff from CI: {$diff}s");

            if (abs($diff) >= 15) {
                $existingCheckOut = $attendance->check_out ? Carbon::parse($date . ' ' . $attendance->check_out->format('H:i:s'), 'Africa/Kigali') : null;
                
                // Collect all punch times for this record
                $punches = [$existingCheckIn, $timestamp];
                if ($existingCheckOut) $punches[] = $existingCheckOut;
                
                // Sort them: earliest is check_in, latest is check_out
                sort($punches);
                
                $earliest = $punches[0];
                $latest = end($punches);
                
                Log::info("ZKTeco ADMS: Updating record. CI: {$earliest->format('H:i:s')}, CO: {$latest->format('H:i:s')}");

                $attendance->check_in = $earliest->format('H:i:s');
                $attendance->check_out = $latest->format('H:i:s');
                $attendance->check_in_method = AttendanceMethod::Finger_Prints;
                $attendance->check_out_method = AttendanceMethod::Finger_Prints;
                $updated = true;
            } else {
                Log::info("ZKTeco ADMS: Punch ignored (cooldown, diff: {$diff}s).");
            }
        }

        if ($attendance->check_in && $attendance->check_out) {
            $ci = Carbon::parse($date . ' ' . $attendance->check_in->format('H:i:s'), 'Africa/Kigali');
            $co = Carbon::parse($date . ' ' . $attendance->check_out->format('H:i:s'), 'Africa/Kigali');
            
            if ($co->lt($ci)) {
                $co->addDay();
            }
            
            $totalMinutes = $ci->diffInMinutes($co);
            $attendance->total_worked_minutes = $totalMinutes;
            
            // Calculate Overtime (anything over 8 hours = 480 minutes)
            if ($totalMinutes > 480) {
                $attendance->overtime_minutes = $totalMinutes - 480;
            } else {
                $attendance->overtime_minutes = 0;
            }

            // Calculate Lateness if shift is available
            if ($employee->shift) {
                $shiftStart = Carbon::parse($date . ' ' . $employee->shift->start_time->format('H:i:s'), 'Africa/Kigali');
                if ($ci->gt($shiftStart)) {
                    $attendance->late_minutes = $ci->diffInMinutes($shiftStart);
                } else {
                    $attendance->late_minutes = 0;
                }
            }
            
            $updated = true;
        }

        if ($updated) {
            $attendance->save();
        }
    }
}
