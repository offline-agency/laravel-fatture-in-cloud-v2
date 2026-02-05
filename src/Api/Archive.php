<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Archive\Archive as ArchiveEntity;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Archive\ArchiveList;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Error;
use OfflineAgency\LaravelFattureInCloudV2\Traits\ListTrait;

class Archive extends Api
{
    use ListTrait;

    public function list(array $additionalData = []): ArchiveList|Error
    {
        $additionalData = $this->data($additionalData, [
            'fields',
            'fieldset',
            'sort',
            'page',
            'per_page',
            'q',
        ]);

        /** @var object $response */
        $response = $this->get(
            'c/'.$this->companyId.'/archive',
            $additionalData
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $archive = $response->data;

        return new ArchiveList($archive);
    }

    /**
     * @return array<ArchiveEntity>|Error
     */
    public function all(array $additionalData = []): array|Error
    {
        $allArchive = $this->getAll([
            'fields',
            'fieldset',
            'sort',
            'page',
            'per_page',
            'q',
        ], 'c/'.$this->companyId.'/archive', $additionalData);

        if ($allArchive instanceof Error) {
            return $allArchive;
        }

        return array_map(function ($archive) {
            return new ArchiveEntity($archive);
        }, $allArchive);
    }

    public function detail(int $archiveId, array $additionalData = []): ArchiveEntity|Error
    {
        $additionalData = $this->data($additionalData, [
            'fields',
            'fieldset',
        ]);

        /** @var object $response */
        $response = $this->get(
            'c/'.$this->companyId.'/archive/'.$archiveId,
            $additionalData
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $archive = $response->data->data;

        return new ArchiveEntity($archive);
    }

    public function delete(int $archiveId): string|Error
    {
        /** @var object $response */
        $response = $this->destroy(
            'c/'.$this->companyId.'/archive/'.$archiveId
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return 'Archive document deleted';
    }

    public function create(array $body = []): ArchiveEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.date' => 'required',
            'data.description' => 'required',
            'data.category' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /** @var object $response */
        $response = $this->post(
            'c/'.$this->companyId.'/archive',
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $archive = $response->data->data;

        return new ArchiveEntity($archive);
    }

    public function edit(int $archiveId, array $body = []): ArchiveEntity|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'data' => 'required',
            'data.date' => 'required',
            'data.description' => 'required',
            'data.category' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /** @var object $response */
        $response = $this->put(
            'c/'.$this->companyId.'/archive/'.$archiveId,
            $body
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        $archiveResponse = $response->data->data;

        return new ArchiveEntity($archiveResponse);
    }

    public function upload(array $body = []): \stdClass|Error|MessageBag
    {
        $validator = Validator::make($body, [
            'filename' => 'required',
            'attachment' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /** @var object $response */
        $response = $this->post(
            'c/'.$this->companyId.'/archive/attachment',
            $body,
            true
        );

        if (! $response->success) {
            return new Error($response->data);
        }

        return $response->data;
    }
}
