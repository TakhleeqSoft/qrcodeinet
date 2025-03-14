<?php

namespace App\Http\Controllers;

use App\Models\Subscriptions;
use App\Models\User;
use App\Models\Plans;
use App\Models\Table;
use App\Models\VendorSetting;
use App\Models\Waiter;
use App\Models\CmsPage;
use App\Models\ContactUs;
use App\Models\Restaurant;
use App\Mail\ContactUsMail;
use App\Models\FaqQuestion;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Restaurant\ContactUsRequest;
use App\Models\Settings;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        $compact = [];
        $compact['testimonials'] = Testimonial::get();
        $compact['faqQuestions'] = FaqQuestion::get();
        $compact['plans'] = Plans::take(2)->get();
        return view("frontend.landing_page.index", $compact);
    }

    public function contact_us(Request $request)
    {
        return view('frontend.landing_page.contact_us');
    }
    public function contactUs(ContactUsRequest $request)
    {
        ContactUs::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ]);

        $data = [];
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['message'] = $request->message;

        $adminEmails = User::where('user_type', User::USER_TYPE_ADMIN)->pluck('email')->toArray();

        foreach ($adminEmails as $adminEmail) {

            Mail::send(new ContactUsMail($data, $adminEmail));
        }
        return redirect('/contact-us')->with('Success', trans('system.contact_us.success'));
    }

    public function restaurant($restaurant_slug)
    {

        $hide_restaurant_after_days = config('app.hide_restaurant_after_days');
        $restaurant = Restaurant::where('slug', $restaurant_slug)->with('vendor_setting')->first();
        if (empty($restaurant)) {
            return redirect('/');
        }

        $current_plans = ($restaurant->created_user->active_plan);

        if (isset($current_plans) && $current_plans!=null) {
            if (isset($current_plans->expiry_date) && $current_plans->expiry_date!=null) {
                $current_date = Carbon::now()->format('Y-m-d H:i:s');

                $expire_date = $current_plans->expiry_date;

                if ($expire_date < $current_date) {

                    $current_date = Carbon::parse($current_date);
                    $shift_difference = $current_date->diffInDays($expire_date);

                    if ($shift_difference > $hide_restaurant_after_days) {
                        return redirect('/');
                    }
                }
            }
        }

        return (new \App\Http\Controllers\Restaurant\MenuController)->show($restaurant);
    }

    public function tableAssign(Request $request)
    {
        try {
            request()->validate([
                'table_restaurant' => 'required',
            ]);

            $table = Table::findorfail($request->table_restaurant);

            Waiter::create([
                'user_id' => $table->user_id,
                'restaurant_id' => $table->restaurant_id,
                'table_id' => $table->id,
            ]);

            $pusher_data = VendorSetting::select('pusher_appid', 'pusher_key', 'pusher_secret', 'pusher_cluster')->where('user_id', $table->user_id)->first();

            if (isset($pusher_data) && $pusher_data != null) {

                if ($pusher_data->pusher_appid != null && $pusher_data->pusher_key != null && $pusher_data->pusher_secret != null && $pusher_data->pusher_cluster != null) {
                    $options = array(
                        'cluster' => $pusher_data->pusher_cluster,
                        'useTLS' => true
                    );
                    $pusher = new \Pusher\Pusher(
                        $pusher_data->pusher_key,
                        $pusher_data->pusher_secret,
                        $pusher_data->pusher_appid,
                        $options
                    );

                    $data['message'] = trans('system.call_waiters.call_waiter');
                    $data['restaurant'] = $table->restaurant->name;
                    $data['table'] = $table->name;

                    $pusher->trigger('myrestro_' . $table->restaurant_id, 'myrestro_' . $table->restaurant_id, $data);
                }
            }
            return redirect()->back()->with('Success', trans('system.call_waiters.success'));
        } catch (\Exception $ex) {
            $request->session()->flash('Error', __('system.messages.operation_rejected'));
            return redirect()->back();
        }
    }

    public function termsAndCondition()
    {
        $termsAndCondition = CmsPage::where('slug', 'terms-and-conditions')->value('description');
        return view('frontend.landing_page.terms_and_condition')->with('termsAndCondition', $termsAndCondition);
    }
    public function privacyPolicy()
    {
        $privacyPolicy = CmsPage::where('slug', 'privacy-policy')->value('description');
        return view('frontend.landing_page.privacy_policy')->with('privacyPolicy', $privacyPolicy);
    }
}
