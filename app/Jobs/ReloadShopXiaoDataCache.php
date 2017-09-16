<?php

namespace App\Jobs;

use App\Services\DataViewsService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ReloadShopXiaoDataCache implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $param;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($param)
    {
        //
        $this->param = $param;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DataViewsService $dataViewsService)
    {
        $time   = strtotime($this->param['add_time']);
        $year   = date("Y", $time);
        $mouth  = date("m", $time);
        $day    = date("d", $time);
        $dataViewsService->reloadShopXiaohaoCache($year, $mouth, $day, $this->param['shop_id']);
    }
}
