<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AddressService;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{

    public function findAddress(Request $request, AddressService $addressService)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'Error',
                'msg' => $validator->errors()->first(),
            ], 404);
        }
        try {
            $data = $addressService->findAddresses($request->all());
            if ($data->count()>0) {
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Address Result.',
                    'data' => $data
                ], 200);
            } else {
                return response()->json([
                    'status' => 'Error',
                    'msg' => "Address not found",
                ], 404);
            }

        } catch (\Exception $exception) {
            $data = $exception->getMessage();
            return response()->json([
                'status' => 'Error',
                'msg' => $data,
            ], 404);
        }
    }

    public function findAddressesGroups(Request $request,AddressService $addressService)
    {
        try {
            $data = $addressService->findAddressesGroups($request->all());
            if (count($data)>0) {
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Address Result.',
                    'data' => $data
                ], 200);
            } else {
                return response()->json([
                    'status' => 'Error',
                    'msg' => "Address not found",
                ], 404);
            }

        } catch (\Exception $exception) {
            $data = $exception->getMessage();
            return response()->json([
                'status' => 'Error',
                'msg' => $data,
            ], 404);
        }
    }
}