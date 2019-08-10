<?php

namespace App\Services;

use App\Core\Services\BaseService;
use App\Address;
use Illuminate\Support\Facades\DB;

class AddressService extends BaseService
{
    /**
     * @param $data
     */
    public function createAddress($data)
    {
        Address::firstOrCreate($data);
    }

    /**
     * @param $data
     * @return \Illuminate\Support\Collection
     */
    public function findAddresses($data)
    {
        $address = $data["address"];
        $address_number = filter_var($address, FILTER_SANITIZE_NUMBER_INT);
        $address_name = preg_replace('/\PL/u', '', $address);
        $search_result = Address::where('addresses_address', 'like', $address_number . '%')
            ->where(function ($query) use ($address_name) {
                $query->where('addresses_street', 'like', '%' . $address_name . '%')
                    ->orWhere('addresses_street_name', 'like', '%' . $address_name . '%');
            })->get();
        return $search_result;
    }

    /**
     * @param $data
     * @param int $distance_radius
     * @return mixed
     */
    public function findAddressesGroups($data, $distance_radius = 6371)
    {
        $lat = $data['lat'];
        $lng = $data['lng'];
        $distance = 0;
        $search_result = DB::table('addresses');
        $search_result->having('distance', '>', $distance);
        $search_result->select('*',
            DB::raw('(' . $distance_radius . '* acos(cos(radians(addresses_cord_x)) *
                         cos(radians(' . $lat . ')) * cos(radians(' . $lng . ') -
                         radians(addresses_cord_y)) + sin(radians(' . $lat . '))
                        * sin(radians(addresses_cord_x)))) as distance'));
        $search_result->orderBy('distance', 'asc');
        $search_result = $search_result->get();
        return $search_result;

    }
}