<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Library\ClassFactory as CF;

class DashboardController extends Controller
{
    
    public function index(){
        return view('pages/dashboard/index');
    }

    public function getExpense(){
        $data = [];
        $monthToday = date('Y-m');
        $expenseSum = CF::model('Tbl_expense')
                        ->where('date_from','like','%'.$monthToday.'%')
                        ->sum('amount');
        $data['expenseSum'] = number_format($expenseSum,2);


        echo json_encode($data);
    }
    
    public function getMonthlyIncome() {
        $data = [];
        $monthToday = date('Y-m');
        $incomeSum = CF::model('Tbl_transaction')
                        ->where('date_trans','like','%'.$monthToday.'%')
                        ->sum('amount');
        $data['monthlyIncomeSum'] = number_format($incomeSum,2);

        echo json_encode($data);
    }

    public function getWeeklyIncome() {
        $data = [];
        $startOfWeek = date("Y-m-d", strtotime("Monday this week"));
        $endOfWeek = date("Y-m-d", strtotime($startOfWeek." + 6 day"));
        $weeklySum = CF::model('Tbl_transaction')
                        ->whereBetween('date_trans', [$startOfWeek, $endOfWeek])
                        ->sum('amount');
        $data['weeklyIncomeSum'] = number_format($weeklySum,2);
        
        echo json_encode($data);
    }

    public function getTransactions() {
        $data = [];
        $transactionCount = CF::model('Tbl_transaction')->count();
        $data['transactionCount'] = $transactionCount;
        echo json_encode($data);
    }

    public function getIncomeYearly() {
        $data = [];

        for($i = 1; $i <= 12; $i++){
            $month = date('Y-m', mktime(0,0,0, $i,1,date('Y')));
            $monthName = date('M', mktime(0,0,0, $i,1,date('Y')));
            
            $itemData = CF::model('Tbl_transaction')
                            ->where('date_trans','like','%'.$month.'%')
                            ->sum('amount');
            $data['months'][] = $monthName;
            $data['datas'][] = $itemData;
        }

        echo json_encode($data);
    }

}
