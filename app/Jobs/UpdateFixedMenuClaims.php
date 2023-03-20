<?php

namespace App\Jobs;

use App\Models\PeriodicLunch;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateFixedMenuClaims implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $validated;

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
        $day = Carbon::parse($this->validated['day'])->addDay()->format('Y-m-d');
        $periodic_lunch = PeriodicLunch::where('claims', 'like', "%$day%")->first();

        if ($periodic_lunch) {
            $claims_array = json_decode($periodic_lunch->claims, true);

            // Loop through each date in the $claims_array and check if it matches the "day" value in $this->validated
            foreach ($claims_array as $date => $claims) {
                if ($date === $day) {
                    // Loop through each claim for that date and check if the "name" value matches the "menu_type" value in $this->validated.
                    foreach ($claims as $index => $claim) {
                        foreach ($this->validated['menus'] as $menu_key => $menu) {
                            if ($claim['name'] === $menu_key) {
                                $claims_array[$date][$index]['menu'] = $menu;
                                $claims_array[$date][$index]['menu_code'] = 0;
                            }
                        }
                    }
                }
            }

            $periodic_lunch->claims = json_encode($claims_array);
            $periodic_lunch->save();
        }
    }
}
