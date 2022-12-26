<?php

namespace App\Http\Controllers\Admin\Api\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateMerchantRequest;
use App\Http\Resources\MerchantResource;
use App\Models\Merchant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MerchantController extends Controller
{
    public function index(Request $request): ResourceCollection
    {
        $merchants = Merchant::where('school_id', $request->school_id)->latest('created_at')->paginate(5);

        return MerchantResource::collection($merchants);
    }

    public function show(Request $request): MerchantResource
    {
        $merchant = Merchant::where('id', $request->merchant_id)->first();

        return new MerchantResource($merchant);
    }

    public function update(UpdateMerchantRequest $request): ResourceCollection
    {
        $merchant = Merchant::where('id', $request->merchant_id)->first();
        $merchant->update([
            'merchant_nick' => $request->merchant_nick,
            'company_legal_name' => $request->company_legal_name,
            'company_details' => [
                'company_name' => $request->company_name,
                'street_address' => $request->street_address,
                'country' => $request->country,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'VAT' => $request->VAT,
            ],
        ]);
        $merchants = Merchant::where('school_id', $request->school_id)->paginate(5);

        return MerchantResource::collection($merchants);
    }

    public function updateStatus(Request $request): JsonResponse
    {
        $merchant = Merchant::where('id', $request->merchant_id)->first();
        $merchant->update([
            'activated' => $request->activated,
        ]);

        return response()->json($merchant);
    }
}
