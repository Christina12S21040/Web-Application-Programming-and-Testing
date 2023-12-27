<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index(): JsonResponse
    {
        $services = Service::all();
        $formattedServices = $services->map(function ($service) {
            return [
                'service' => $service,
                'links' => $service->getLinks(),
            ];
        });

        return response()->json([
            'services' => $formattedServices,
        ]);
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);
        return response()->json([
            'service' => $service,
            'links' => $service->getLinks(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_name' => 'required',
            'service_description' => '',
            'service_price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Tidak menyertakan service_image saat membuat Service baru
        $data = $request->only(['service_name', 'service_description', 'service_price']);
        $service = Service::create($data);
        return new ServiceResource($service);
    }

    public function update(Request $request, $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'service_name' => 'required',
            'service_description' => '',
            'service_price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Tidak menyertakan service_image saat melakukan update Service
        $data = $request->only(['service_name', 'service_description', 'service_price']);
        $service->update($data);

        return new ServiceResource($service);
    }

    public function destroy($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['error' => 'Service not found'], 404);
        } else {
            $service->delete();
            return response()->json(['message' => 'Service deleted successfully']);
        }
    }
}
