<?php

namespace App\Helpers;

use App\Enum\RecordChangeType;
use App\Models\RecordHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Exception;

class RecordHistoryHelper
{
    /**
     * Record a history entry for a model action.
     *
     * @param Model $model The model instance (e.g., User) being recorded.
     * @param RecordChangeType $changeType The type of change (Create, Update, Delete).
     * @param array|null $changeDetails Details of the change (e.g., field, old_value, new_value).
     * @return bool Whether the history record was created successfully.
     */
    public static function record(Model $model, RecordChangeType $changeType, ?array $changeDetails = null): bool
    {
        try {
            $historyData = [
                'user_id' => Auth::id(),
                'recordable_type' => get_class($model),
                'recordable_id' => $model->id,
                'change_type' => $changeType,
                'change_details' => $changeDetails ? json_encode($changeDetails, JSON_THROW_ON_ERROR) : null,
            ];

            // Generate formatted ID using FormattedIdHelper
            $historyData['code'] = FormattedCodeHelper::getNextFormattedCode( RecordHistory::class,'SGA', 5);

            RecordHistory::create($historyData);

            Log::info('RecordHistory created successfully', [
                'user_id' => $historyData['user_id'],
                'recordable_type' => $historyData['recordable_type'],
                'recordable_id' => $historyData['recordable_id'],
                'change_type' => $changeType,
                'code' => $historyData['code'],
            ]);

            return true;
        } catch (Exception $e) {
            Log::error('Failed to create RecordHistory', [
                'user_id' => Auth::id(),
                'recordable_type' => get_class($model),
                'recordable_id' => $model->id,
                'change_type' => $changeType,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return false;
        }
    }
}
