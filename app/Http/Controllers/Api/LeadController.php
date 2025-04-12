<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\ApiRequestLog;
use App\Models\ApiResponseLog;
use Illuminate\Support\Facades\Validator;
use Exception;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        //Requisition Log
        $requestLog = ApiRequestLog::create([
            'endpoint' => $request->path(),
            'payload' => json_encode($data),
            'ip_address' => $request->ip(),
        ]);

        try {
            // Validate
            $validator = Validator::make($data, [
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => 'required|email|unique:leads,email',
                'phone' => 'required|string|max:20',
                'date_of_birth' => 'date|nullable',
            ]);

            if ($validator->fails()) {
                ApiResponseLog::create([
                    'request_id' => $requestLog->id,
                    'status_code' => 422,
                    'response_body' => json_encode(['errors' => $validator->errors()]),
                ]);

                return response()->json(['errors' => $validator->errors()], 422);
            }

            //Build the Lead
            $lead = Lead::create($validator->validated());

            ApiResponseLog::create([
                'request_id' => $requestLog->id,
                'status_code' => 201,
                'response_body' => json_encode(['message' => 'Lead Created Successfully']),
            ]);

            return response()->json(['message' => 'Lead criado com sucesso', 'lead' => $lead], 201);
        } catch (Exception $e) {
            ApiResponseLog::create([
                'request_id' => $requestLog->id,
                'status_code' => 500,
                'response_body' => json_encode(['error' => 'Error in Server']),
            ]);

            return response()->json(['error' => 'Erro no servidor'], 500);
        }
    }
}
