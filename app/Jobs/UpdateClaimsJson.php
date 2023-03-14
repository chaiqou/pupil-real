<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\PeriodicLunch;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateClaimsJson implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $validated;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($validated)
    {
        $this->validated = $validated;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        if ($this->validated['menu_type'] === 'Fixed') {
            $formattedDay = Carbon::parse($this->validated['day'])->addDay()->format('Y-m-d');
            $models = PeriodicLunch::where('claims', 'like', '%"'.$formattedDay.'"%')->get();

            foreach ($models as $model) {
                $claims = json_decode($model->claims, true);

                if (isset($claims[$formattedDay])) {
                    $claims[$formattedDay][0]['menu'] = 'New Menu';
                    $claims[$formattedDay][0]['menu_code'] = 'New Menu Code';

                    // Encode the updated array back into a string and save it to the model
                    $model->claims = json_encode($claims);
                    $model->save();
                }
            }
        }
    }
}
