<?php

declare(strict_types=1);

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelFattureInCloudV2\Api\Api;
use OfflineAgency\LaravelFattureInCloudV2\Api\Client;
use OfflineAgency\LaravelFattureInCloudV2\Api\Info;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedDocument;
use OfflineAgency\LaravelFattureInCloudV2\Api\IssuedEInvoice;

/*
 * The Laravel Boost guideline and skill teach AI assistants how to use this package.
 * These tests run their code examples against a faked API, so the AI instructions
 * cannot drift from the real method names and payloads.
 */

const BOOST_GUIDELINE = __DIR__.'/../../resources/boost/guidelines/core.blade.php';
const BOOST_SKILL = __DIR__.'/../../resources/boost/skills/fatture-in-cloud-e-invoicing/SKILL.md';

/**
 * @return list<string>
 */
function guidelineSnippets(): array
{
    preg_match_all('/<code-snippet[^>]*lang="php">(.*?)<\/code-snippet>/s', Blade::render(file_get_contents(BOOST_GUIDELINE)), $m);

    return $m[1];
}

/**
 * @return list<string>
 */
function skillSnippets(): array
{
    preg_match_all('/```php\n(.*?)```/s', file_get_contents(BOOST_SKILL), $m);

    return $m[1];
}

/**
 * Runs code examples from this repository's own docs files (never external input),
 * so the examples shown to AI assistants are proven to work.
 */
function runSnippets(string $code): void
{
    // `use` statements must come first in eval'd code; hoist them.
    preg_match_all('/^use [^;]+;$/m', $code, $uses);
    $body = preg_replace('/^use [^;]+;$/m', '', $code);
    $imports = array_unique(array_merge(
        ['use OfflineAgency\LaravelFattureInCloudV2\LaravelFattureInCloudV2Facade as FIC;'],
        $uses[0],
    ));

    eval(implode("\n", $imports)."\n".$body);
}

describe('Laravel Boost guideline', function () {
    it('renders as Blade and keeps code snippets verbatim', function () {
        $rendered = Blade::render(file_get_contents(BOOST_GUIDELINE));

        expect($rendered)->toContain('## Fatture in Cloud')
            ->and($rendered)->not->toContain('@verbatim')
            ->and(guidelineSnippets())->toHaveCount(3);
    });

    it('has code snippets that are valid PHP', function () {
        foreach (guidelineSnippets() as $snippet) {
            expect(fn () => token_get_all('<?php '.$snippet, TOKEN_PARSE))->not->toThrow(ParseError::class);
        }
    });

    it('has examples that work against the API', function () {
        [$listAndCreate, $handle, $fake] = guidelineSnippets();

        // The testing snippet sets credentials and fakes clients. Run it first:
        // each Http::fake() call resets the requests recorded so far.
        Config::set('fatture-in-cloud-v2.companies.default', ['id' => '', 'bearer' => '']);
        runSnippets($fake);
        Http::fake([
            '*/issued_documents?*' => Http::response(['data' => [['id' => 1, 'type' => 'invoice']]]),
            '*/issued_documents' => Http::response(['data' => ['id' => 2, 'type' => 'invoice']]),
        ]);

        runSnippets($listAndCreate."\n".$handle);

        Http::assertSent(fn (Request $r) => $r->method() === 'POST'
            && str_ends_with($r->url(), '/issued_documents')
            && preg_match('/^\d{4}-\d{2}-\d{2}$/', $r['data']['date']) === 1);
        Http::assertSent(fn (Request $r) => str_ends_with($r->url(), '/entities/clients')
            && ($r['data']['name'] ?? null) === 'ACME S.p.A.');
    });
})->covers(Api::class, IssuedDocument::class, Client::class);

describe('Laravel Boost e-invoicing skill', function () {
    it('has the frontmatter Boost requires, matching its folder name', function () {
        $content = file_get_contents(BOOST_SKILL);

        expect($content)->toStartWith("---\nname: fatture-in-cloud-e-invoicing\ndescription: ")
            ->and(basename(dirname(BOOST_SKILL)))->toBe('fatture-in-cloud-e-invoicing');
    });

    it('walks the documented e-invoice flow against the API', function () {
        Http::fake([
            '*/info/vat_types*' => Http::response(['data' => [
                ['id' => 0, 'value' => 10.0, 'description' => '10%'],
                ['id' => 7, 'value' => 22.0, 'description' => '22%'],
            ]]),
            '*/issued_documents/totals' => Http::response(['data' => ['amount_due' => 610.0, 'amount_gross' => 610.0]]),
            '*/issued_documents' => Http::response(['data' => ['id' => 99, 'type' => 'invoice']]),
            '*/issued_documents/99/e_invoice/xml_verify' => Http::response(['data' => ['success' => true]]),
            '*/issued_documents/99/e_invoice/send' => Http::response(['data' => ['name' => 'IT0123_00001.xml', 'date' => '2026-11-27']]),
            '*/issued_documents/99/e_invoice/error_reason' => Http::response(['data' => ['reason' => 'Codice destinatario errato', 'code' => '0036']]),
            '*/issued_documents/99*' => Http::response(['data' => ['id' => 99, 'ei_status' => 'rejected']]),
        ]);

        runSnippets(implode("\n", skillSnippets()));

        // VAT id is looked up, not hard-coded; payments match the previewed total; nested date formatted.
        Http::assertSent(function (Request $r) {
            if ($r->method() !== 'POST' || ! str_ends_with($r->url(), '/issued_documents')) {
                return false;
            }
            $data = $r['data'];

            return $data['e_invoice'] === true
                && $data['items_list'][0]['vat']['id'] === 7
                && $data['payments_list'][0]['amount'] === 610.0
                && preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['payments_list'][0]['due_date']) === 1;
        });
        Http::assertSent(fn (Request $r) => str_ends_with($r->url(), '/e_invoice/send') && $r['options']['dry_run'] === true);
        Http::assertSent(fn (Request $r) => str_contains($r->url(), '/issued_documents/99?') && $r['fieldset'] === 'detailed');
        Http::assertSent(fn (Request $r) => str_ends_with($r->url(), '/e_invoice/error_reason'));
    });
})->covers(Api::class, Info::class, IssuedDocument::class, IssuedEInvoice::class);
