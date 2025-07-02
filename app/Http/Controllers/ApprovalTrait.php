<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NumesaHelper;

trait ApprovalTrait
{
    /**
     * Approve submission
     */
    public function approve(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!$request->ajax()) {
            return response('Request Tidak Benar', 400);
        }

        // Check if user has permission
        if (!auth()->user()->hasRole(['administrator', 'OPD'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses untuk melakukan approval'
            ], 403);
        }

        $id = decrypt($request->id);
        
        // Get the model class from the controller
        $modelClass = $this->getModelClass();
        $submission = $modelClass::find($id);

        if (!$submission) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Update approval status
        $submission->update([
            'status_approval' => 'approved',
            'approved_by' => auth()->user()->id,
            'approved_at' => now(),
            'approval_notes' => $request->notes
        ]);

        NumesaHelper::log('INFO', 'Approve submission: ' . $this->getSubmissionName($submission), auth()->user()->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Pengajuan berhasil disetujui'
        ]);
    }

    /**
     * Reject submission
     */
    public function reject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'notes' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!$request->ajax()) {
            return response('Request Tidak Benar', 400);
        }

        // Check if user has permission
        if (!auth()->user()->hasRole(['administrator', 'OPD'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses untuk melakukan approval'
            ], 403);
        }

        $id = decrypt($request->id);
        
        // Get the model class from the controller
        $modelClass = $this->getModelClass();
        $submission = $modelClass::find($id);

        if (!$submission) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Update approval status
        $submission->update([
            'status_approval' => 'rejected',
            'approved_by' => auth()->user()->id,
            'approved_at' => now(),
            'approval_notes' => $request->notes
        ]);

        NumesaHelper::log('INFO', 'Reject submission: ' . $this->getSubmissionName($submission), auth()->user()->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Pengajuan berhasil ditolak'
        ]);
    }

    /**
     * Get submission details for modal
     */
    public function detail(Request $request, $id)
    {
        if (!$request->ajax()) {
            return response('Request Tidak Benar', 400);
        }

        $id = decrypt($id);
        
        // Get the model class from the controller
        $modelClass = $this->getModelClass();
        $submission = $modelClass::with(['approver', 'creator'])->find($id);

        if (!$submission) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $submission,
            'canApprove' => auth()->user()->hasRole(['administrator', 'OPD'])
        ]);
    }

    /**
     * Get the model class name for the current controller
     * This method should be implemented in each controller that uses this trait
     */
    abstract protected function getModelClass();

    /**
     * Get submission name for logging
     * This method should be implemented in each controller that uses this trait
     */
    abstract protected function getSubmissionName($submission);
} 