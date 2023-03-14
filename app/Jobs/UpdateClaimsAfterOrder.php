<?php

namespace App\Jobs;

use App\Models\LunchMenu;
use App\Models\PeriodicLunch;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateClaimsAfterOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $validated;

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
        foreach ($this->validated['claim_days'] as &$date) {
            $formattedDay = Carbon::parse($date)->addDay()->format('Y-m-d');
            $models = PeriodicLunch::where('claims', 'like', '%"'.$formattedDay.'"%')->get();

            foreach ($models as $model) {
                $claims = json_decode($model->claims, true);
                $menus = LunchMenu::where('lunch_id', $model->lunch_id)->get();

                foreach ($menus as $menu) {
                    $menu_array = json_decode($menu['menus'], true);
                    $menu_keys = array_keys($menu_array);
                    $first_key = array_shift($menu_keys);
                    $menu_name = $menu_array[$first_key][0]['menus'];

                    if (isset($claims[$formattedDay]) && $menu['date'] === $formattedDay) {
                        $claims[$formattedDay][0]['menu'] = $menu_name;
                        $claims[$formattedDay][0]['menu_code'] = 0;

                        // Encode the updated array back into a string and save it to the model
                        $model->claims = json_encode($claims);
                        $model->save();
                    }
                }
            }
        }
    }
}
