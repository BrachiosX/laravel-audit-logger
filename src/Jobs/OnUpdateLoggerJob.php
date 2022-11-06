<?php

namespace BrachiosX\AuditLogger\Jobs;

use BrachiosX\AuditLogger\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;

class OnUpdateLoggerJob
{
    use Dispatchable;

    private Model $model;
    private array $ignoreFields;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Model $model, array $ignoreFields)
    {
        $this->model = $model;
        $this->ignoreFields = $ignoreFields;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ignoreFields = array_merge(
          config('audit_logger.ignore_fields', []),
          $this->ignoreFields
        );

        $editedFieldCollection = collect($this->model->getChanges());
        $editedFieldCollection->each(function ($editedValue, $fieldName) use ($ignoreFields) {
            if (in_array($fieldName, $ignoreFields)) return;

            $originalValue = $this->model->getOriginal($fieldName);

            $payload = $this->getPayload($fieldName, $originalValue, $editedValue);
            $auditLogger = new AuditLog();
            $auditLogger->create($payload);
        });
    }

    private function getPayload(string $fieldName, string $from, string $to): array
    {
        $payload = [];
        $payload['ref_id'] = $this->model->getKey();
        $payload['ref_type'] = get_class($this->model);

        // need to migrate field_name & ref_field to override
        $payload['ref_field'] = $fieldName;
        $payload['ref_field_title'] = $fieldName;

        $payload['from'] = $from;
        $payload['to'] = $to;

        $payload['state'] = json_encode($this->model->getAttributes());

        $payload['action'] = 'update';

        $payload['ip_address'] = request()->ip();

        $payload['created_by'] = auth()->id();
        $payload['created_at'] = now();

        return $payload;
    }
}
