<?php

namespace BrachiosX\AuditLogger\Jobs;

use BrachiosX\AuditLogger\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;

class OnDeletedLoggerJob
{
    use Dispatchable;

    private Model $model;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $payload = $this->getPayload();

        $auditLog = new AuditLog();
        $auditLog->create($payload);
    }

    private function getPayload(): array
    {
        $payload = [];
        $payload['ref_id'] = $this->model->getKey();
        $payload['ref_type'] = get_class($this->model);

        $payload['from'] = null;
        $payload['to'] = null;

        $payload['state'] = json_encode($this->model->getAttributes());

        $payload['action'] = 'delete';

        $payload['ip_address'] = request()->ip();

        $payload['created_by'] = auth()->id();
        $payload['created_at'] = now();

        return $payload;
    }
}
