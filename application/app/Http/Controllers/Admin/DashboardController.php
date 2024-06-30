<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Order;
use App\Models\RequestType;
use App\Models\Tanker;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'verified']);
    }

    public function index()
    {/*counts*/
        $data['confirmed'] = 20;
        $data['pending'] = 12;
        $data['delivered'] = 9;
        $data['cancel'] = 5;
        $totalOrders = 30;

        /*avg values*/
        $data['avg_order_value'] = 1000;
        $data['avg_tanker_sales'] = 5000;

        /*total sales*/
        $data['total_sales'] = 52360;

        /*avg daily sales in week*/
        $data['avg_daily_sales'] = 50030; //chart js data
        $data['weekly_sales_in_percentage'] = 0; //chart js data

        /*monthly sales*/
        $monthly_sales = 0;
        $data['monthly_sales_kilo'] = 0; //chart js data
        $data['total_monthly_sales'] = 0;

        /*earning from one month*/
        $data['current_month_earnings'] = 0; //chart js data
        $data['total_earnings'] = 256540;

        /*sale statistics*/
        $data['sales_statistics'] = 0; //chart js data

        // Calculate percentages data
        $data['confirmedPercentage'] = 12550;
        $data['pendingPercentage'] = 88880;
        $data['deliveredPercentage'] = 112550;
        $data['cancelPercentage'] = 66650;
        /*earning progress*/
        $data['earning_progress'] = 0;

        $data['orders'] =  null;
        $data['tankers'] = null;
        $data['request_types'] = null;
        $data['user'] = User::where('id', Auth::user()->id)->with('fileManager')->first();
        return view('admin.dashboard.home', $data);
    }

    protected function get_sales_statistics(): array
    {
        $data = [];

        $orders = Bill::where('payment_status', 1)->get();

        $groupedOrders = $orders->groupBy(function ($order) {
            $createdAt = Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at);
            return $createdAt->format('M-y');
        });

        foreach ($groupedOrders as $month => $orders) {
            $monthlyData['year'] = $month;

            $monthlyData['petrol'] = 0;
            $monthlyData['diesel'] = 0;
            $monthlyData['lpg gas'] = 0;

            foreach ($orders as $order) {
                $requestTypeName = $order->request_type->name;

                $monthlyData[strtolower($requestTypeName)]++;
            }

            $data[] = $monthlyData;
        }

        return $data;
    }
}
