<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Referral;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index()
    {
        $pageTitle = 'Referral Commissions';
        $referrals = Referral::get();
        $commissionTypes = [
            'deposit_commission'=>'Deposit Commission',
            'plan_subscribe_commission'=>'Plan Subscription',
            'ptc_view_commission'=>'PTC View',
        ];
        return view('admin.referral_setting',compact('pageTitle','referrals','commissionTypes'));
    }

    public function status($type)
    {
        $general = GeneralSetting::first();
        if (@$general->$type == 1) {
            @$general->$type = 0;
        }else{
            @$general->$type = 1;
        }
        $general->save();
        $notify[] = ['success', 'Referral commission status updated successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request)
    {
        $request->validate([
            'percent*' => 'required|numeric',
            'commission_type' => 'required|in:deposit_commission,plan_subscribe_commission,ptc_view_commission',
        ]);
        $type = $request->commission_type;

        Referral::where('commission_type',$type)->delete();

        for ($i = 0; $i < count($request->percent); $i++){
            $referral = new Referral();
            $referral->level = $i + 1;
            $referral->percent = $request->percent[$i];
            $referral->commission_type = $request->commission_type;
            $referral->save();
        }

        $notify[] = ['success','Referral commission setting updated successfully'];
        return back()->withNotify($notify);
    }
}
