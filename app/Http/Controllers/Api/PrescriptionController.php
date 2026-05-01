<?php
// app/Http/Controllers/Api/PrescriptionController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PrescriptionController extends Controller
{
    /**
     * Recevoir une prescription depuis l'interface web
     */
    public function sendPrescription(Request $request): JsonResponse
    {
        try {
            // LOG: Afficher toutes les données reçues
            Log::info('sendPrescription appelé', [
                'all_data' => $request->all(),
                'headers' => $request->headers->all(),
                'method' => $request->method(),
                'path' => $request->path()
            ]);
            
            // Valider les données
            $validated = $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'medication' => 'required|string',
                'dosage' => 'required|string',
                'instructions' => 'required|string',
            ]);
            
            // LOG: Données validées
            Log::info('Données validées', $validated);
            
            // Créer la prescription
            $prescription = Prescription::create([
                'patient_id' => $validated['patient_id'],
                'medication' => $validated['medication'],
                'dosage' => $validated['dosage'],
                'instructions' => $validated['instructions'],
                'content' => $validated['instructions'], // Ajouter content
                'prescribed_at' => now(),
            ]);
            
            Log::info('Prescription créée avec succès', ['id' => $prescription->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Prescription envoyée avec succès',
                'data' => $prescription
            ], 200);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erreur de validation', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Erreur générale', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'envoi: ' . $e->getMessage()
            ], 500);
        }
    }
}