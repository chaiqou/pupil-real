<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MerchantResource;
use App\Models\Merchant;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Request;

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
}
