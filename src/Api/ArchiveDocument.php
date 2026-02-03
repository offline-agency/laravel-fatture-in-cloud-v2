<?php
namespace OfflineAgency\LaravelFattureInCloudV2\Api;

use OfflineAgency\LaravelFattureInCloudV2\Entities\ArchiveDocuments\ArchiveDocuments;
use OfflineAgency\LaravelFattureInCloudV2\Entities\Pagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class ArchiveDocument extends Api
{
    public function listArchiveDocument(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_page' => 'nullable|int',
            'first_page_url' => 'nullable|url',
            'from' => 'nullable|int',
            'last_page' => 'nullable|int',
            'last_page_url' => 'nullable|url',
            'next_page_url' => 'nullable|url',
            'path' => 'nullable|url',
            'per_page' => 'nullable|int|min:1|max:100',
            'prev_page_url' => 'nullable|url',
            'to' => 'nullable|int',
            'total' => 'nullable|int',
            'data' => 'nullable|array',
            'data.id' => 'nullable|int',
            'data.date' => 'nullable|date',
            'data.description' => 'nullable|string',
            'data.attachment_url' => 'nullable|url',
            'data.category' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $currentPage = $request->input('current_page', 1);
        $perPage = $request->input('per_page', 5);

        $archiveDocuments = ArchiveDocuments->paginate($perPage, ['*'], 'page', $currentPage);

        return response()->json(['data' => $archiveDocuments], 200);
    }

    public function createArchiveDocument(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'data.id' => 'int',
                'data.date' => 'required|date',
                'data.description' => 'required|string',
                'data.category' => 'required|string',
                'data.attachment_token' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $archiveDocument = new ArchiveDocuments($request->all());

            return response()->json(['data' => $archiveDocument], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Errore durante la creazione del documento di archivio: ' . $e->getMessage()], 500);
        }
    }
    public function getArchiveDocument($id)
    {
        try {
            $archiveDocumentData = [
                'id' => $id,
                'date' => '2024-06-06',
                'description' => 'Document description',
                'attachment_url' => 'https://example.com/document.pdf',
                'category' => 'General',
            ];

            $archiveDocument = new ArchiveDocuments($archiveDocumentData);

            return response()->json(['data' => $archiveDocument], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Errore durante il recupero del documento di archivio: ' . $e->getMessage()], 500);
        }
    }

    public function updateArchiveDocument(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'data.id' => 'int',
                'data.date' => 'required|date',
                'data.description' => 'required|string',
                'data.category' => 'required|string',
                'data.attachment_token' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $existingArchiveDocument = ArchiveDocuments->find($id);

            if (!$existingArchiveDocument) {
                return response()->json(['error' => 'Documento di archivio non trovato'], 404);
            }

            $existingArchiveDocument->id = $request->input('data.id');
            $existingArchiveDocument->date = $request->input('data.date');
            $existingArchiveDocument->description = $request->input('data.description');
            $existingArchiveDocument->category = $request->input('data.category');
            $existingArchiveDocument->attachment_token = $request->input('data.attachment_token');

            $existingArchiveDocument->save();

            return response()->json(['data' => $existingArchiveDocument], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Errore durante l\'aggiornamento del documento di archivio: ' . $e->getMessage()], 500);
        }
    }

    public function deleteArchiveDocument($id)
    {
        try {
            $archiveDocumentData = ArchiveDocuments->find($id);

            if (!$archiveDocumentData) {
                return response()->json(['error', 'Documento di archivio non trovato'], 404);
            }

            $archiveDocumentData->delete();

            return response()->json(['message' => 'Documento di archivio eliminato'], 200);
        }catch (\Exception $e){
            return response()->json(['error' => 'Errore durante l\'eliminazione del documento di archivio: ' . $e->getMessage()], 500);
        }
    }
    public function uploadDocument(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'data.attachment_token' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $attachmentToken = $request->input('data.attachment_token');
            $attachmentToken->save();

            return response()->json(['message' => 'Token di allegato caricato con successo'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Errore durante il caricamento del token di allegato: ' . $e->getMessage()], 500);
        }
    }
}
