<?php

namespace App\Console\Commands;

use App\Models\BillingoData;
use App\Models\Merchant;
use App\Models\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class RequestProformasByQuery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'request:paid-proformas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $yesterday_date = date('Y-m-d',strtotime("-1 days"));
        $merchants = Merchant::all();
        foreach ($merchants as $merchant) {
            $billingoData = BillingoData::where('merchant_id', $merchant->id)->first();
            $request = Http::withHeaders([
                'X-API-KEY' => $billingoData->billingo_api_key,//
                //                ?type=proforma&per_page=100&payment_status=paid&paid_start_date=$yesterday_date
            ])->get("https://api.billingo.hu/v3/documents?type=proforma&per_page=2&payment_status=paid&paid_start_date=$yesterday_date")->json();
            $firstRequest = [];
            array_push($firstRequest, $request['data']);

            $foreachChecker = $request;
            if($request['next_page_url'] !== null)
            {
                $dataArray = array();
                array_push($dataArray, $request['data']);
                do {
                    $requestLoop =  Http::withHeaders([
                        'X-API-KEY' => $billingoData->billingo_api_key,
                    ])->get($request['next_page_url'])->json();

                    $request = $requestLoop;

                    array_push($dataArray, $requestLoop['data']);
                }while ($request['next_page_url'] !== null);
            }
        }
        if($foreachChecker["next_page_url"] !== null)
        {
            foreach($dataArray as $datas) {
                foreach($datas as $data) {
                    $transaction = Transaction::where('billingo_proforma_id', $data["id"])->first();
                    $merchantOfTransaction = Merchant::where('id', $transaction->merchant_id)->first();
                    $merchantBillingoData = BillingoData::where('merchant_id', $merchantOfTransaction->id)->first();
                    $request = Http::withHeaders([
                        'X-API-KEY' => $merchantBillingoData->billingo_api_key,
                    ])->post("https://api.billingo.hu/v3/documents/" . $data["id"] . "/create-from-proforma", [
                        "document_type" => "invoice",
                        "fulfillment_date" => $data["fulfillment_date"],
                        "due_date" => $data["due_date"],
                        "document_format" => "",
                        "comment" => $transaction->billing_comment,
                        "settings" => [
                            "should_send_email" => true,
                        ]
                    ])->json();
                    $transaction->update([
                        'billing_type' => 'invoice',
                        'billingo_transaction_id' => $request['id']
                    ]);
                    return;
                }
            }
        }

        if($foreachChecker["next_page_url"] === null) {
            foreach($firstRequest as $datas) {
                foreach($datas as $data) {
                    $transaction = Transaction::where('billingo_proforma_id', $data["id"])->first();
                    $merchantOfTransaction = Merchant::where('id', $transaction->merchant_id)->first();
                    $merchantBillingoData = BillingoData::where('merchant_id', $merchantOfTransaction->id)->first();
                    $request = Http::withHeaders([
                        'X-API-KEY' => $merchantBillingoData->billingo_api_key,
                    ])->post("https://api.billingo.hu/v3/documents/" . $data["id"] . "/create-from-proforma", [
                        "document_type" => "invoice",
                        "fulfillment_date" => $data["fulfillment_date"],
                        "due_date" => $data["due_date"],
                        "document_format" => "",
                        "comment" => $transaction->billing_comment,
                        "settings" => [
                            "should_send_email" => true,
                            ]
                    ])->json();
                    $transaction->update([
                        'billing_type' => 'invoice',
                        'billingo_transaction_id' => $request['id']
                    ]);
                   return;
                }
            }
        }
    }
}
