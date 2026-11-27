<?php

use Illuminate\Http\Client\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Sleep;
use OfflineAgency\LaravelFattureInCloudV2\Api\Api;
use OfflineAgency\LaravelFattureInCloudV2\Api\Archive;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Api\ReceivedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Api\Taxes;

/**
 * @return array<int, array<string, mixed>>
 */
function attachmentParts(Request $request): array
{
    return array_values(array_filter(
        $request->data(),
        fn (array $part) => $part['name'] === 'attachment',
    ));
}

describe('Api attachment upload', function () {
    it('sends the file exactly once, as a file part', function (string $apiClass) {
        Http::fake(['*' => Http::response(['data' => ['attachment_token' => 'tok']])]);

        $api = new $apiClass();
        $body = ['filename' => 'invoice.pdf', 'attachment' => 'PDF-BYTES'];
        $api instanceof Archive ? $api->upload($body) : $api->attachment($body);

        Http::assertSent(function (Request $request) {
            $parts = attachmentParts($request);

            return count($parts) === 1
                && $parts[0]['contents'] === 'PDF-BYTES'
                && $parts[0]['filename'] === 'invoice.pdf';
        });
    })->with([IssuedDocument::class, ReceivedDocument::class, Taxes::class, Archive::class]);

    it('keeps the filename form field', function () {
        Http::fake(['*' => Http::response(['data' => ['attachment_token' => 'tok']])]);

        (new IssuedDocument())->attachment(['filename' => 'invoice.pdf', 'attachment' => 'PDF-BYTES']);

        Http::assertSent(fn (Request $request) => in_array(
            ['name' => 'filename', 'contents' => 'invoice.pdf'],
            $request->data(),
            true,
        ));
    });

    it('accepts a stream resource as attachment', function () {
        Http::fake(['*' => Http::response(['data' => ['attachment_token' => 'tok']])]);

        $stream = fopen('php://memory', 'r+');
        fwrite($stream, 'STREAMED-BYTES');
        rewind($stream);

        (new IssuedDocument())->attachment(['filename' => 'invoice.pdf', 'attachment' => $stream]);

        Http::assertSent(function (Request $request) {
            $parts = attachmentParts($request);

            return count($parts) === 1
                && str_contains($request->body(), 'STREAMED-BYTES');
        });
    });

    it('re-sends the full stream contents when a 429 is retried', function () {
        Sleep::fake();

        $stream = fopen('php://memory', 'r+');
        fwrite($stream, 'STREAMED-BYTES');
        rewind($stream);

        $calls = 0;
        Http::fake(function () use (&$calls, $stream) {
            // In production Guzzle closes the caller's resource once the first
            // request is released; Http::fake() would otherwise hide that.
            if (++$calls === 1) {
                fclose($stream);

                return Http::response([], 429, ['Retry-After' => '1']);
            }

            return Http::response(['data' => ['attachment_token' => 'tok']]);
        });

        (new IssuedDocument())->attachment(['filename' => 'invoice.pdf', 'attachment' => $stream]);

        $bodies = Http::recorded()->map(fn (array $pair) => $pair[0]->body());
        expect($bodies)->toHaveCount(2)
            ->and($bodies[0])->toContain('STREAMED-BYTES')
            ->and($bodies[1])->toContain('STREAMED-BYTES');
    });

    it('accepts an uploaded file', function () {
        Http::fake(['*' => Http::response(['data' => ['attachment_token' => 'tok']])]);

        $file = UploadedFile::fake()->createWithContent('invoice.pdf', 'UPLOADED-BYTES');

        (new IssuedDocument())->attachment(['filename' => 'invoice.pdf', 'attachment' => $file]);

        Http::assertSent(fn (Request $request) => count(attachmentParts($request)) === 1
            && str_contains($request->body(), 'UPLOADED-BYTES'));
    });

    it('rejects unsupported attachment types instead of uploading an empty file', function (mixed $attachment) {
        Http::fake();

        try {
            (new IssuedDocument())->attachment(['filename' => 'invoice.pdf', 'attachment' => $attachment]);
        } finally {
            Http::assertNothingSent();
        }
    })->with([
        'integer' => [123],
        'array' => [['PDF-BYTES']],
        'missing file' => [new SplFileInfo('/nonexistent/invoice.pdf')],
    ])->throws(InvalidArgumentException::class);
})->covers(Api::class);
