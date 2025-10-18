<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Plant;
use App\Models\Project;
use App\Traits\SyncsPivotRelations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PlantController extends Controller
{
    use SyncsPivotRelations;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $currentUser = Auth::user();

        $plantsQuery = Plant::query();

        if ($currentUser && $currentUser->hasRole('Admin')) {
            $plantsQuery->where('uuid', $currentUser->department->plant->uuid);
        }

        if ($search) {
            $plantsQuery->where(function ($query) use ($search) {
                $query->where('plant', 'like', '%' . $search . '%')
                      ->orWhere('abbrivation', 'like', '%' . $search . '%');
            });
        }

        $plants = $plantsQuery->with('realDepartments')->latest()->paginate(5)->withQueryString();

        return view('plant.index', compact('plants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('plant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'plant' => 'required|string|max:255',
            'abbrivation' => 'required|string|max:255'
        ]);

        Plant::create([
            'plant' => $request->plant,
            'abbrivation' => $request->abbrivation
        ]);

        return redirect()->route('plants.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        $plant = Plant::where('uuid', $uuid)->firstOrFail();
        return view('plant.edit', compact('plant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid)
    {
        $request->validate([
            'plant' => 'required|string|max:255',
            'abbrivation' => 'required|string|max:255'
        ]);

        $plant = Plant::where('uuid', $uuid)->firstOrFail();
        $plant->update([
            'plant' => $request->plant,
            'abbrivation' => $request->abbrivation
        ]);

        return redirect()->route('plants.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $plant = Plant::where('uuid', $uuid)->firstOrFail();
        $plant->delete();

        return redirect()->route('plants.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    public function manageDepartment($uuid)
    {
        $plant = Plant::with('realDepartments')->firstWhere('uuid', $uuid);
        $departments = Department::all(); // show all, checkbox will be checked if visible is true

        return view('plant.manage_department', [
            'plant' => $plant,
            'departments' => $departments
        ]);
    }

    public function updateManageDepartment(Request $request, $uuid)
    {
        $plant = Plant::firstWhere('uuid', $uuid);
        $this->syncPivotRelations(
            modelUuid: $plant->uuid,
            pivotTable: 'department_plants',
            modelForeignKey: 'plant_uuid',
            relatedForeignKey: 'department_uuid',
            relatedUuids: $request->department ?? [],
            includeUuid: true // Set to false if your pivot table doesn't require uuid
        );

        return redirect()->route('plants.index')->with('success', 'Departments updated successfully.');
    }

    public function synchronizePlant($uuid)
    {
        $plant = Plant::firstWhere('uuid', $uuid);

        return view('plant.synchronize', [
            'plant' => $plant,
        ]);
    }

    public function synchronize(Request $request, $uuid)
    {

        $syncMessages = [];

        foreach ($request->project_uuid as $project_uuid) {
            $plant = Plant::with('realDepartments')->firstWhere('uuid', $uuid);
            $data = [
                'plant' => [
                    'uuid' => $plant->uuid,
                    'plant' => $plant->plant,
                    'abbrivation' => $plant->abbrivation,
                    'departments' => $plant->realDepartments->map(function ($dept) {
                        return [
                            'uuid' => $dept->uuid,
                            'department' => $dept->department,
                            'abbrivation' => $dept->abbrivation
                        ];
                    })->values()->toArray()
                ]
            ];

            $result = $this->NodeRedSyncPlant($data);

            if (($result['status'] ?? 'error') === 'success') {
                $syncMessages[] = [
                    'status' => $result['status'] ?? 'error',
                    'message' => $result['message'] ?? 'Unknown Error'
                ];
            }

            $messageStrings = array_map(function ($msg) {
                return "{$msg['project']} ({$msg['status']} - {$msg['message']})";
            }, $syncMessages);

            // If any failed → return with error
            $hasError = collect($syncMessages)->contains(fn($msg) => $msg['status'] !== 'success');

            if ($hasError) {
                return redirect()
                    ->route('plants.index', $uuid)
                    ->with('error', 'Beberapa plant gagal disinkronkan: ' . implode(', ', $messageStrings));
            }

            return redirect()
                ->route('plants.index', $uuid)
                ->with('success', 'Plant berhasil didisinkronsisasi: ' . implode(', ', $messageStrings));
        }
    }

    private function NodeRedSyncPlant($data)
    {
        $url = 'http://10.68.1.141:1881/sync-plant';
        $username = 'admin';
        $password = 'admin';

        try {
            $response = Http::withBasicAuth($username, $password)
                ->timeout(5)
                ->post($url, $data);

            if ($response->successful()) {
                $resData = $response->json();

                return [
                    'status' => $resData['status'] ?? 'unknown',
                    'message' => $resData['message'] ?? 'No message from Node-RED'
                ];
            } else {
                return [
                    'status' => 'error',
                    'messsage' => 'Failed to send to Node-RED (HTTP ' . $response->status() . '/'
                ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 'error',
                'message' => 'Exception: ' . $e->getMessage()
            ];
        }
    }
}