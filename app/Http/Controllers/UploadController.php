<?php

namespace App\Http\Controllers;

use App\Address;
use App\Services\AddressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UploadController extends Controller
{
    /**
     * @param Request $request
     * @param AddressService $addressService
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadXml(Request $request, AddressService $addressService)
    {
        $data = $request->xml;
        foreach ($data as $k => $item) {
            foreach ($data[$k] as $key => $value) {
                $data[$k][$key] = $value['_text'];
            }
            $validator = Validator::make($data[$k], [
                'addresses_id' => 'required',
                'addresses_address' => 'required',
                'addresses_street' => 'required',
                'addresses_street_name' => 'required',
                'addresses_street_type' => 'required',
                'addresses_adm1' => 'required',
                'addresses_adm2' => 'required',
                'addresses_cord_x' => 'required',
                'addresses_cord_y' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'Error',
                    'msg' => $validator->errors()->first(),
                ], 404);
            }
            try {
                $addressService->createAddress($data[$k]);
            } catch (\Exception $exception) {
                $data = $exception->getMessage();
                return response()->json([
                    'status' => 'Error',
                    'msg' => $data,
                ], 404);
            }
        }
        return response()->json([
            'status' => 'success',
            'msg' => 'Xml file uploaded successfully.',
            'data' => $data
        ], 200);
    }


}