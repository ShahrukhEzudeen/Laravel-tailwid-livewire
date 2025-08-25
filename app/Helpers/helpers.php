<?php

use App\Models\AuditTrail;
use Illuminate\Support\Facades\Auth;

if (! function_exists('audit')) {
    function audit($id,$action, $oldValues = null, $newValues = null)
    {
        AuditTrail::create([
            'user_id' => $id,
            'action' => $action,
            'old_values' => $oldValues,
            'new_values' => $newValues,
        ]);
    }
}