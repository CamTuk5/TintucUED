<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PayPalService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    protected $payPalService;

    public function __construct(PayPalService $payPalService)
    {
        $this->payPalService = $payPalService;
    }

   
    public function index()
    {
        return view('subscription.index');
    }

    public function createPayment()
    {
        // Cấu hình giá tiền Việt và Tỷ giá
        $priceVND = 260000;
        $exchangeRate = 26000;

        // Quy đổi sang USD
        // Công thức: Tiền Việt / Tỷ giá
        $priceUSD = round($priceVND / $exchangeRate, 2); 
        $approveLink = $this->payPalService->createOrder($priceUSD);

        if ($approveLink) {
            return redirect($approveLink);
        }

        return back()->with('error', 'Lỗi kết nối đến PayPal. Vui lòng thử lại.');
    }

    
    public function success(Request $request)
    {
        // PayPal trả về token trên URL
        $token = $request->query('token');

        if (!$token) {
            return redirect()->route('subscription.index')->with('error', 'Thanh toán bị hủy.');
        }
        // Gọi Service xác nhận trừ tiền
        $isSuccess = $this->payPalService->captureOrder($token);

        if ($isSuccess) {
            // NÂNG CẤP USER LÊN VIP
            $user = User::find(Auth::id());
            $user->is_vip = true;
            $user->vip_expires_at = now()->addMonth(); // VIP 1 tháng
            $user->save();

            return redirect()->route('home')->with('success', 'Chúc mừng! Bạn đã trở thành thành viên VIP.');
        }

        return redirect()->route('subscription.index')->with('error', 'Giao dịch thất bại.');
    }
}