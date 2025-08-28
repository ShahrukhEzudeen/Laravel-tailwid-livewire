<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiResponse;
use App\Models\Process;
use App\Models\Process_config;
use App\Models\Application;
use App\Models\Application_Flow;
use Illuminate\Support\Facades\DB;

class WorkflowController extends Controller
{
    //
    use ApiResponse;
    public function getworkflowdetail(Request $request)
    {


        try {

            $flowid = $request->header('flowid');
            $secretKey = $request->header('secret_key');

            if (!$flowid || !$secretKey) {
                return response()->json([
                    'message' => 'Missing flowid or secret_key in headers'
                ], 400);
            }

            $process = Process::with('configs.flows')
                ->where('flowid', $flowid)
                ->where('secret_key', $secretKey)
                ->first();



            if (!$process) {
                return $this->error('Flow id or Key Mismatch', 401);
            }



            $processes = Process::with('configs.flows')->get();
            return  $this->success($processes);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function startflow(Request $request)
    {

        try {
            $flowid = $request->header('flowid');
            $secretKey = $request->header('secret_key');

            if (!$flowid || !$secretKey) {
                return response()->json([
                    'message' => 'Missing flowid or secret_key in headers'
                ], 400);
            }
            $config = Process_config::whereHas('process', function ($q) use ($flowid, $secretKey) {
                $q->where('flowid', $flowid)
                    ->where('secret_key', $secretKey);
            })
                ->where('sequence', 1)
                ->first();


            $flow = Application::create([
                'process_config_id' => $config->id,
            ]);


            $app = Application_Flow::create([
                'process_config_id' => $config->id,
                'application_id'    => $flow->id,
            ]);

            $application = Application::with([
                'appflow',
                'config',
                'config.flows'
            ])->find($flow->id);

            $result = [
                'application_id'   => $application->id,
                'current_stage' => $application->config->name ?? null,
                'action_process' => $application->config->flows->action_button ?? null,
                'history'          => $application->appflow, // all history records
            ];

            return  $result;
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function processflow(Request $request)
    {
        try {
            $flowid = $request->header('flowid');
            $secretKey = $request->header('secret_key');
            $application_id = $request->header('application_id');
            $nextstepid = $request->header('nextstepid');

            if (!$flowid || !$secretKey) {
                return response()->json([
                    'message' => 'Missing flowid or secret_key in headers'
                ], 400);
            }

            $process = Process::with('configs.flows')
                ->where('flowid', $flowid)
                ->where('secret_key', $secretKey)
                ->first();



            if (!$process) {
                return $this->error('Flow id or Key Mismatch', 404);
            }
            $app = Application::where('id',  $application_id)
                ->first();

            if (!$app) {
                return $this->error('Application Not Found', 404);
            }


            $currentstep = Process_config::with('flows')->where('id', $app->process_config_id)->get();
            $nextstep = Process_config::with('flows')->where('id', $nextstepid)->get();

            if (!$nextstep) {
                return $this->error('Next Step Not Found', 404);
            }

            return $currentstep;


            if ($currentstep->is_multiple) {

                $total = count($currentstep->$flows);
                $countFinish = count(array_filter($currentstep->$flows, fn($f) => $f['is_finish'] === 1));

                // if ($countFinish <= $total) {
                //     $config->is_complete = 1;
                //     $config->save();
                // }
            } else {
                if (count(array_filter($currentstep->$flows, fn($f) => $f['is_finish'] == 1)) === 1) {

                    return $this->error('Stage Already Completed', 400);
                } else {
                    foreach ($currentstep->$flows as $flow) {
                        $flow['is_finish'] = 1;
                    }
                    $config->save();

                    $flow = Application_Flow::create([
                        'process_config_id' => $nextstepid,
                        'application_id'    => $app->id,
                    ]);

                    $app->process_config_id = $nextstepid;
                    $app->save();
                }
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
