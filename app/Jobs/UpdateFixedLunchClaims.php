<?php

namespace App\Jobs;

use App\Models\PeriodicLunch;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateFixedLunchClaims implements ShouldQueue
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
