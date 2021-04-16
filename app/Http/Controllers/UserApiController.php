<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckOTPRequest;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;
use Illuminate\Support\Collection;
use Log;
use Auth;
use Hash;
use Route;
use Storage;
use App\Banners;
use Setting;
use Exception;
use Validator;
use Notification;
use QrCode;
use Carbon\Carbon;
use App\Notifications\WebPush;
use App\Http\Controllers\SendPushNotification;
use App\Notifications\ResetPasswordOTP;
use App\Helpers\Helper;
use App\Card;
use App\User;
use App\Work;
use App\Admin;
use App\Reason;
use App\Provider;
use App\Settings;
use App\Promocode;
use App\UserWallet;
use App\ServiceType;
use App\UserRequests;
use App\RequestFilter;
use App\PromocodeUsage;
use App\WalletPassbook;
use App\ProviderService;
use Location\Coordinate;
use App\AgentCities;
use App\UserRequestRating;
use App\PromocodePassbook;
use App\UserRequestDispute;
use App\UserRequestLostItem;
use Location\Distance\Vincenty;
use App\Http\Controllers\ProviderResources\TripController;
use App\Http\Controllers\Resource\ReferralResource;
use App\Services\ServiceTypes;
use GuzzleHttp\Client;
use App\Services\PaymentGateway;
use App\PaymentLog;

class UserApiController extends Controller
{

    /**
     * Checks the availability of Email and Telephone to the user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        // $this->validate($request, [
        // 		'email' => 'required|email|unique:users',
        // 	]);
        if ($request->email == '') {
            return response()->json(['message' => 'Please enter an email'], 422);
        }
        $email_case = User::where('email', $request->email)->first();
        //User Already Exists
        if ($email_case) {
            return response()->json(['message' => 'Email already registered, please type another email'], 422);
        }
        try {
            return response()->json(['message' => trans('api.email_available')]);
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function checkUserEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);
        try {
            $email = $request->email;
            $results = User::where('email', $email)->first();
            if (empty($results))
                return response()->json(['message' => trans('api.email_available'), 'is_available' => true]);
            else
                return response()->json(['message' => trans('api.email_not_available'), 'is_available' => false]);
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }


    /**
     * Performs user authentication
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $tokenRequest = $request->create('/oauth/token', 'POST', $request->all());
        $request->request->add([
            "client_id" => $request->client_id,
            "client_secret" => $request->client_secret,
            "grant_type" => 'password',
            "code" => '*',
        ]);
        $response = Route::dispatch($tokenRequest);
        $json = (array)json_decode($response->getContent());
        if (!empty($json['error'])) {
            $json['error'] = $json['message'];
        }
        if (empty($json['error'])) {
            if (Auth::guard("web")->attempt(['email' => $request->username, 'password' => $request->password])) {
                $user = Auth::guard("web")->user();
                if ($user) {
                    $accessTokens = DB::table('oauth_access_tokens')->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
                    $t = 1;
                    foreach ($accessTokens as $accessToken) {
                        if ($t != 1) {
                            DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id)->delete();
                            DB::table('oauth_access_tokens')->where('id', $accessToken->id)->delete();
                        }
                        $t++;
                    }
                }
            }
        }
        // $json['status'] = true;
        $response->setContent(json_encode($json));
        $update = User::where('email', $request->username)->update(['device_token' => $request->device_token, 'device_id' => $request->device_id, 'device_type' => $request->device_type]);
        return $response;
    }

    /**
     *
     *
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function signup(Request $request)
    {
        if ($request->referral_code != null) {
            $validate['referral_unique_id'] = $request->referral_code;
            $validator = (new ReferralResource)->checkReferralCode($validate);
            if (!$validator->fails()) {
                $validator->errors()->add('referral_code', 'Invalid Referral Code');
                throw new \Illuminate\Validation\ValidationException($validator);
            }
        }
        $referral_unique_id = (new ReferralResource)->generateCode();
        $this->validate($request, [
            'social_unique_id' => ['required_if:login_by,facebook,google', 'unique:users'],
            'device_type' => 'required|in:android,ios',
            'device_token' => 'required',
            'device_id' => 'required',
            'login_by' => 'required|in:manual,facebook,google',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'country_code' => 'required',
            'mobile' => 'required',
            'password' => 'required|min:6',
        ]);

        $currentUser = null;

        $email_case = User::where('email', $request->email)->where([['country_code', $request->country_code], ['mobile', $request->mobile]])->first();
        $registeredEmail = User::where('email', $request->email)->where('user_type', 'INSTANT')->first();
        $registeredMobile = User::where([['country_code', $request->country_code], ['mobile', $request->mobile]])->where('user_type', 'INSTANT')->first();
        $registeredEmailNormal = User::where('email', $request->email)->where('user_type', 'NORMAL')->first();
        $registeredMobileNormal = User::where([['country_code', $request->country_code], ['mobile', $request->mobile]])->where('user_type', 'NORMAL')->first();

        //User Already Exists
        if ($email_case != null) {
            return response()->json(['error' => 'Email is already registered!'], 422);
        }
        if ($registeredEmail != null && $registeredMobile != null) {
            //User Already Registerd with same credentials
            if ($registeredEmail != null)
                return response()->json(['error' => 'User already registered with this email!'], 422);
            else if ($registeredMobile != null)
                return response()->json(['error' => 'User already registered by this phone number!'], 422);
        } else {
            if ($registeredEmail != null)
                $currentUser = $registeredEmail;
            else if ($registeredMobile != null)
                $currentUser = $registeredMobile;
        }

        if ($registeredEmailNormal != null)
            return response()->json(['error' => 'User already registered with a given email!'], 422);
        else if ($registeredMobileNormal != null)
            return response()->json(['error' => 'User already registered with a given mobile number!'], 422);

        $file = QrCode::format('png')->size(500)->margin(10)->generate('{
                "country_code":' . '"' . $request->country_code . '"' . ',
                "mobile":' . '"' . $request->mobile . '"' . '
                }');
        // $file=QrCode::format('png')->size(200)->margin(20)->phoneNumber($request->country_code.$request->mobile);
        $fileName = Helper::upload_qrCode($request->mobile, $file);


        $otp = mt_rand(100000, 999999);



        if ($currentUser == null) {
            $user = $request->all();
            if ($request->has('gender')) {
                if ($request->gender == 'MALE') {
                    $user['gender'] = 'MALE';
                } else {
                    $user['gender'] = 'FEMALE';
                }
            }
            $user['payment_mode'] = 'CASH';
            $user['password'] = bcrypt($request->password);
            $user['referral_unique_id'] = $referral_unique_id;
            $user['qrcode_url'] = $fileName;
            $user = User::create($user);

            $user = Auth::loginUsingId($user->id);
            $userToken = $user->createToken('AutoLogin');
            $user['access_token'] = $userToken->accessToken;
            $user['currency'] = config('constants.currency');
            $user['sos'] = config('constants.sos_number', '911');
            $user['app_contact'] = config('constants.app_contact', '5777');
            $user['measurement'] = config('constants.distance', 'Kms');
            $user['opt'] = $otp;
        } else {
            $user = $currentUser;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->country_code = $request->country_code;
            $user->mobile = $request->mobile;
            $user->password = bcrypt($request->password);
            $user->login_by = 'manual';
            $user->payment_mode = 'CASH';
            $user->user_type = 'NORMAL';
            $user->referral_unique_id = $referral_unique_id;
            $user->qrcode_url = $fileName;
            $user->otp = $otp;
            $user->save();
        }
        // Sends welcome email to the user
        // if (config('constants.send_email', 0) == 1) {
        // Helper::site_registermail($user);
        //        }
        //check user referrals
        if (config('constants.referral', 0) == 1) {
            if ($request->referral_code != null) {
                //call referral function
                (new ReferralResource)->create_referral($request->referral_code, $user);
            }
        }
        return $user;
    }

    /**
     * Logout the application
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        try {
            $token = $request->user()->token();
            $token->revoke();

            User::where('id', $request->id)->update(['device_id' => '', 'device_token' => '']);
            return response()->json(['message' => trans('api.logout_success')]);
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Change user password
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function change_password(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
            'old_password' => 'required',
        ]);
        $user = Auth::user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = bcrypt($request->password);
            $user->save();
            if ($request->ajax()) {
                return response()->json(['message' => trans('api.user.password_updated')]);
            } else {
                return back()->with('flash_success', trans('api.user.password_updated'));
            }
        } else {
            if ($request->ajax()) {
                return response()->json(['error' => trans('api.user.incorrect_old_password')], 422);
            } else {
                return back()->with('flash_error', trans('api.user.incorrect_old_password'));
            }
        }
    }

    /**
     * Updates location information
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update_location(Request $request)
    {
        $this->validate($request, [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        if ($user = User::find(Auth::user()->id)) {
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
            $user->save();
            return response()->json(['message' => trans('api.user.location_updated')]);
        } else {
            return response()->json(['error' => trans('api.user.user_not_found')], 422);
        }
    }

    /**
     * Updates language information
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update_language(Request $request)
    {
        $this->validate($request, [
            'language' => 'required',
        ]);
        if ($user = User::find(Auth::user()->id)) {
            $user->language = $request->language;
            $user->save();
            return response()->json(['message' => trans('api.user.language_updated'), 'language' => $request->language]);
        } else {
            return response()->json(['error' => trans('api.user.user_not_found')], 422);
        }
    }

    /**
     * Provides user details information
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function details(Request $request)
    {
        $this->validate($request, [
            'device_type' => 'in:android,ios',
        ]);
        try {
            if ($user = User::find(Auth::user()->id)) {
                if ($request->has('device_token')) {
                    $user->device_token = $request->device_token;
                }
                if ($request->has('device_type')) {
                    $user->device_type = $request->device_type;
                }
                if ($request->has('device_id')) {
                    $user->device_id = $request->device_id;
                }
                $user->save();
                if ($user->language != null) {
                    app()->setLocale($user->language);
                }
                $align = ($user->language == 'ar') ? 'text-align: right' : '';
                $user->currency = config('constants.currency');
                $user->sos = config('constants.sos_number', '911');
                $user->app_contact = config('constants.app_contact', '5777');
                $user->measurement = config('constants.distance', 'Kms');
                $user->cash = (int)config('constants.cash');
                //TODO ALL - Debit changes on the machine and voucher
                $user->debit_machine = (int)config('constants.debit_machine');
                $user->voucher = (int)config('constants.voucher');

                $user->card = (int)config('constants.card');
                $user->payumoney = (int)config('constants.payumoney');
                $user->paypal = (int)config('constants.paypal');
                $user->paypal_adaptive = (int)config('constants.paypal_adaptive');
                $user->braintree = (int)config('constants.braintree');
                $user->paytm = (int)config('constants.paytm');

                $user->stripe_secret_key = config('constants.stripe_secret_key');
                $user->stripe_publishable_key = config('constants.stripe_publishable_key');
                $user->stripe_currency = config('constants.stripe_currency');

                $user->payumoney_environment = config('constants.payumoney_environment');
                $user->payumoney_key = config('constants.payumoney_key');
                $user->payumoney_salt = config('constants.payumoney_salt');
                $user->payumoney_auth = config('constants.payumoney_auth');

                $user->paypal_environment = config('constants.paypal_environment');
                $user->paypal_currency = config('constants.paypal_currency');
                $user->paypal_client_id = config('constants.paypal_client_id');
                $user->paypal_client_secret = config('constants.paypal_client_secret');

                $user->braintree_environment = config('constants.braintree_environment');
                $user->braintree_merchant_id = config('constants.braintree_merchant_id');
                $user->braintree_public_key = config('constants.braintree_public_key');
                $user->braintree_private_key = config('constants.braintree_private_key');

                $user->referral_count = config('constants.referral_count', '0');
                $user->referral_amount = config('constants.referral_amount', '0');
                $user->referral_text = trans('api.user.invite_friends');
                $user->referral_total_count = (new ReferralResource)->get_referral('user', Auth::user()->id)[0]->total_count;
                $user->referral_total_amount = (new ReferralResource)->get_referral('user', Auth::user()->id)[0]->total_amount;
                $user->referral_total_text = "<p style='font-size:16px; color: #000; $align'>" . trans('api.user.referral_amount') . ": " . (new ReferralResource)->get_referral('user', Auth::user()->id)[0]->total_amount . "<br>" . trans('api.user.referral_count') . ": " . (new ReferralResource)->get_referral('user', Auth::user()->id)[0]->total_count . "</p>";
                $user->ride_otp = (int)config('constants.ride_otp');
                $user->ride_toll = (int)config('constants.ride_toll');
                return $user;
            } else {
                return response()->json(['error' => trans('api.user.user_not_found')], 422);
            }
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Updates connection information
     *
     * @param Request $request
     */
    public function update_details(Request $request)
    {
        if ($request->has('callid')) {
            if (is_null(Auth::user()->callid) || empty(Auth::user()->callid)) {
                $user = User::find(Auth::user()->id);
                $user->callid = $request->get('callid');
                $user->save();
            } else if (Auth::user()->callid != $request->get('callid')) {
                $user = User::find(Auth::user()->id);
                $user->callid = $request->get('callid');
                $user->save();
            }
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_profile(Request $request)
    {

        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'max:255',
            'email' => 'email|unique:users,email,' . Auth::user()->id,
            'picture' => 'mimes:jpeg,bmp,png',
        ]);
        try {
            $user = User::findOrFail(Auth::user()->id);
            if ($request->has('first_name')) {
                $user->first_name = $request->first_name;
            }
            if ($request->has('last_name')) {
                $user->last_name = $request->last_name;
            }
            if ($request->has('country_code')) {
                $user->country_code = $request->country_code;
            }
            if ($request->has('gender')) {
                $user->gender = $request->gender;
            }
            if ($request->has('mobile') && $request->mobile != null) {
                $user->mobile = $request->mobile;
                // QrCode generator
                $file = QrCode::format('png')->size(500)->margin(10)->generate('{
					"country_code":' . '"' . $request->country_code . '"' . ',
					"mobile":' . '"' . $request->mobile . '"' . '
					}');
                // $file=QrCode::format('png')->size(200)->margin(20)->phoneNumber($request->country_code.$request->mobile);
                $fileName = Helper::upload_qrCode($request->mobile, $file);
                $user->qrcode_url = $fileName;
            }
            if ($request->has('gender')) {
                $user->gender = $request->gender;
            }
            if ($request->has('language')) {
                $user->language = $request->language;
            }
            if ($request->picture != "") {
                Storage::delete($user->picture);
                $user->picture = $request->picture->store('user/profile');
            }
            $user->save();
            $user->currency = config('constants.currency');
            $user->sos = config('constants.sos_number', '911');
            $user->app_contact = config('constants.app_contact', '5777');
            $user->measurement = config('constants.distance', 'Kms');
            if ($user->language != null) {
                app()->setLocale($user->language);
            }
            $align = ($user->language == 'ar') ? 'text-align: right' : '';
            $user->referral_count = config('constants.referral_count', '0');
            $user->referral_amount = config('constants.referral_amount', '0');
            $user->referral_text = trans('api.user.invite_friends');
            $user->referral_total_count = (new ReferralResource)->get_referral('user', Auth::user()->id)[0]->total_count;
            $user->referral_total_amount = (new ReferralResource)->get_referral('user', Auth::user()->id)[0]->total_amount;
            $user->referral_total_text = "<p style='font-size:16px; color: #000; $align'>" . trans('api.user.referral_amount') . ": " . (new ReferralResource)->get_referral('user', Auth::user()->id)[0]->total_amount . "<br>" . trans('api.user.referral_count') . ": " . (new ReferralResource)->get_referral('user', Auth::user()->id)[0]->total_count . "</p>";
            if ($request->ajax()) {
                return response()->json($user);
            } else {
                return back()->with('flash_success', trans('api.user.profile_updated'));
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => trans('api.user.user_not_found')], 422);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return Collection
     */
    public function services(Request $request)
    {
        // TODO ALL - Consult existing franchise services in the passenger search city
        $serviceList = ServiceType::where('status', '=', '1')->where('parent_id', '=', '0')->with('childrenRecursive')->get();
        $ActiveProviders = ProviderService::where('status', 'active')
            ->get()->pluck('provider_id');
        $providers = Provider::with('service')->whereIn('id', $ActiveProviders)
            ->where('status', 'approved')
            ->get();
        if ($serviceList->count() != null && $providers->count() != null) {
            return $serviceList;
        } else {

            if (Auth()->user()->latitude) {
                //TODO ALL - Consult services of no franchise in the city of the passenger and a driver from another city on site
                $distance = config('constants.provider_search_radius', '10');
                $ActiveProviders = ProviderService::where('status', 'active')
                    ->get()->pluck('provider_id');
                $providers = Provider::with('service')->whereIn('id', $ActiveProviders)
                    ->where('status', 'approved')
                    ->whereRaw("round((6371 * acos( cos( radians(" . Auth()->user()->latitude . ") ) * cos( radians(latitude) ) * cos( radians(longitude) - radians(" . Auth()->user()->longitude . ") ) + sin( radians(" . Auth()->user()->latitude . ") ) * sin( radians(latitude) ) ) ),3) <= $distance")
                    ->get();
                if ($providers->count() != null) {
                    foreach ($providers as $provider) {
                        $serviceList = ServiceType::where('status', '=', '1')->where('parent_id', '=', '0')->with('childrenRecursive')->get();
                    }
                    return $serviceList;
                } else {
                    return response()->json(['error' => trans('api.services_not_found')], 422);
                }
            }


        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function send_request(Request $request)
    {
        \Log::alert('message', $request->all());
        if ($request->ajax()) {
            $this->validate($request, [
                's_latitude' => 'required|numeric',
                's_longitude' => 'required|numeric',
                'd_latitude' => 'numeric',
                'd_longitude' => 'numeric',
                'service_type' => 'required|numeric|exists:service_types,id',
                //'promo_code' => 'exists:promocodes,promo_code',
                //'distance' => 'required|numeric',
                'use_wallet' => 'numeric',

                //TODO ALL -Debit changes on the machine and voucher
                'payment_mode' => 'required|in:BRAINTREE,CASH,DEBIT_MACHINE,CARD,PAYPAL,PAYPAL-ADAPTIVE,PAYUMONEY,PAYTM',
                'card_id' => ['required_if:payment_mode,CARD', 'exists:cards,card_id,user_id,' . Auth::user()->id],
            ]);
        } else {
            $this->validate($request, [
                's_latitude' => 'required|numeric',
                's_longitude' => 'required|numeric',
                'd_latitude' => 'numeric',
                'd_longitude' => 'numeric',
                'service_type' => 'required|numeric|exists:service_types,id',
                //'promo_code' => 'exists:promocodes,promo_code',
                //'distance' => 'required|numeric',
                'use_wallet' => 'numeric',
                'payment_mode' => 'required|in:BRAINTREE,CASH,CARD,DEBIT_MACHINE,PAYPAL,PAYPAL-ADAPTIVE,PAYUMONEY,PAYTM',
                'card_id' => ['required_if:payment_mode,CARD', 'exists:cards,card_id,user_id,' . Auth::user()->id],
            ]);
        }
        $ActiveRequests = UserRequests::PendingRequest(Auth::user()->id)->count();
        if ($ActiveRequests > 0) {
            if ($request->ajax()) {
                return response()->json(['error' => trans('api.ride.request_inprogress')], 422);
            } else {
                return redirect('dashboard')->with('flash_error', trans('api.ride.request_inprogress'));
            }
        }
        if ($request->has('schedule_date') && $request->has('schedule_time')) {
            $beforeschedule_time = (new Carbon("$request->schedule_date $request->schedule_time"))->subHour(1);
            $afterschedule_time = (new Carbon("$request->schedule_date $request->schedule_time"))->addHour(1);
            $CheckScheduling = UserRequests::where('status', 'SCHEDULED')
                ->where('user_id', Auth::user()->id)
                ->whereBetween('schedule_at', [$beforeschedule_time, $afterschedule_time])
                ->count();
            if ($CheckScheduling > 0) {
                if ($request->ajax()) {
                    return response()->json(['error' => trans('api.ride.request_scheduled')], 422);
                } else {
                    return redirect('dashboard')->with('flash_error', trans('api.ride.request_scheduled'));
                }
            }
        }
        $distance = config('constants.provider_search_radius', '10');
        $latitude = $request->s_latitude;
        $longitude = $request->s_longitude;
        $service_type = $request->service_type;
        $providers = Provider::with('service')
            ->select(DB::Raw("round((6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),3) AS distance"), 'id')
            ->where('status', 'approved')
            ->whereRaw("round((6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),3) <= $distance")
            ->whereHas('service', function ($query) use ($service_type) {
                $query->where('status', 'active');
                $query->where('service_type_id', $service_type);
            })
            ->orderBy('distance', 'asc')
            ->get();
        // dd($providers);
        //Log::info($providers);
        // List Providers who are currently busy and add them to the filter list.
        if (count($providers) == 0) {
            if ($request->ajax()) {
                // Push Notification to User
                return response()->json(['error' => trans('api.ride.no_providers_found')], 422);
            } else {
                return back()->with('flash_success', trans('api.ride.no_providers_found'));
            }
        }
        try {
            $details = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $request->s_latitude . "," . $request->s_longitude . "&destination=" . $request->d_latitude . "," . $request->d_longitude . "&mode=driving&key=" . config('constants.map_key');
            $json = curl($details);
            $details = json_decode($json, TRUE);
            $route_key = (count($details['routes']) > 0) ? $details['routes'][0]['overview_polyline']['points'] : '';
            $userRequest = new UserRequests;
            $userRequest->booking_id = Helper::generate_booking_id();
            if ($request->has('braintree_nonce') && $request->braintree_nonce != null) {
                $userRequest->braintree_nonce = $request->braintree_nonce;
            }
            $userRequest->user_id = Auth::user()->id;
            if ((config('constants.manual_request', 0) == 0) && (config('constants.broadcast_request', 0) == 0)) {
                $userRequest->current_provider_id = $providers[0]->id;
            } else {
                $userRequest->current_provider_id = 0;
            }
            //Calculates estimated fare value
            try {
                $response = new ServiceTypes();
                $responsedata = $response->calculateFare($request->all(), 1);
                $userRequest->estimated_fare = $responsedata['data']['estimated_fare'];
                $userRequest->estimated_fare = 0;//$responsedata['data']['estimated_fare'];
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            $userRequest->service_type_id = $request->service_type;
            //$userRequest->rental_hours = $request->rental_hours;
            $userRequest->payment_mode = $request->payment_mode;
            $userRequest->promocode_id = $request->promocode_id ?: 0;
            $userRequest->status = 'SEARCHING';
            $userRequest->s_address = $request->s_address ?: "";
            $userRequest->d_address = $request->d_address ?: "";
            $userRequest->s_latitude = $request->s_latitude;
            $userRequest->s_longitude = $request->s_longitude;
            $userRequest->d_latitude = $request->d_latitude ? $request->d_latitude : $request->s_latitude;
            $userRequest->d_longitude = $request->d_longitude ? $request->d_longitude : $request->s_longitude;
            if ($request->d_latitude == null && $request->d_longitude == null) {
                $userRequest->is_drop_location = 0;
            }
            $userRequest->destination_log = json_encode([['latitude' => $userRequest->d_latitude, 'longitude' => $request->d_longitude, 'address' => $request->d_address]]);
            $userRequest->distance = 0;//$request->distance;
            $userRequest->unit = config('constants.distance', 'Kms');
            if (Auth::user()->wallet_balance > 0) {
                $userRequest->use_wallet = $request->use_wallet ?: 0;
            }
            if (config('constants.track_distance', 0) == 1) {
                $userRequest->is_track = "YES";
            }
            $userRequest->otp = mt_rand(1000, 9999);
            $userRequest->assigned_at = Carbon::now();
            $userRequest->route_key = $route_key;
            if ($providers->count() <= config('constants.surge_trigger') && $providers->count() > 0) {
                $userRequest->surge = 1;
            }
            if ($request->has('schedule_date') && $request->has('schedule_time')) {
                $userRequest->status = 'SCHEDULED';
                $userRequest->schedule_at = date("Y-m-d H:i:s", strtotime("$request->schedule_date $request->schedule_time"));
                $userRequest->is_scheduled = 'YES';
            }
            if ($userRequest->status != 'SCHEDULED') {
                if ((config('constants.manual_request', 0) == 0) && (config('constants.broadcast_request', 0) == 0)) {
                    Log::info('New Request id : ' . $userRequest->id . ' Assigned to provider : ' . $userRequest->current_provider_id);
                    (new SendPushNotification)->IncomingRequest($providers[0]->id);
                }
            }
            $userRequest->save();
            if ((config('constants.manual_request', 0) == 1)) {
                $admins = Admin::select('id')->get();
                foreach ($admins as $admin_id) {
                    $admin = Admin::find($admin_id->id);
                    $admin->notify(new WebPush("Notifications", trans('api.push.incoming_request'), route('admin.dispatcher.index')));
                }
            }
            // update payment mode
            User::where('id', Auth::user()->id)->update(['payment_mode' => $request->payment_mode]);
            if ($request->has('card_id')) {
                Card::where('user_id', Auth::user()->id)->update(['is_default' => 0]);
                Card::where('card_id', $request->card_id)->update(['is_default' => 1]);
            }
            if ($userRequest->status != 'SCHEDULED') {
                if (config('constants.manual_request', 0) == 0) {
                    foreach ($providers as $key => $provider) {
                        if (config('constants.broadcast_request', 0) == 1) {
                            (new SendPushNotification)->IncomingRequest($provider->id);
                        }
                        $Filter = new RequestFilter;
                        // Send push notifications to the first provider
                        // incoming request push to provider
                        $Filter->request_id = $userRequest->id;
                        $Filter->provider_id = $provider->id;
                        $Filter->save();
                    }
                }
            }
            if ($request->ajax()) {
                return response()->json([
                    'message' => ($userRequest->status == 'SCHEDULED') ? 'Request schedule created!' : 'New Request created!',
                    'request_id' => $userRequest->id,
                    'current_provider' => $userRequest->current_provider_id,
                ]);
            } else {
                if ($userRequest->status == 'SCHEDULED') {
                    $request->session()->flash('flash_success', 'Your Request is scheduled!');
                }
                return redirect('dashboard');
            }
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong') . $e->getMessage()], 500);
            } else {
                return back()->with('flash_error', trans('api.something_went_wrong') . $e->getMessage());
            }
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel_request(Request $request)
    {
        $this->validate($request, [
            'request_id' => 'required|numeric|exists:user_requests,id,user_id,' . Auth::user()->id,
        ]);
        try {
            $userRequest = UserRequests::findOrFail($request->request_id);
            if ($userRequest->status == 'CANCELLED') {
                if ($request->ajax()) {
                    return response()->json(['error' => trans('api.ride.already_cancelled')], 422);
                } else {
                    return back()->with('flash_error', trans('api.ride.already_cancelled'));
                }
            }
            if (in_array($userRequest->status, ['SEARCHING', 'STARTED', 'ARRIVED', 'SCHEDULED'])) {
                if ($userRequest->status != 'SEARCHING') {
                    $this->validate($request, [
                        'cancel_reason' => 'max:255',
                    ]);
                }
                $userRequest->status = 'CANCELLED';
                if ($request->cancel_reason == 'ot')
                    $userRequest->cancel_reason = $request->cancel_reason_opt;
                else
                    $userRequest->cancel_reason = $request->cancel_reason;

                $userRequest->cancelled_by = 'USER';
                $userRequest->save();
                RequestFilter::where('request_id', $userRequest->id)->delete();
                if ($userRequest->status != 'SCHEDULED') {
                    if ($userRequest->provider_id != 0) {
                        ProviderService::where('provider_id', $userRequest->provider_id)->update(['status' => 'active']);
                    }
                }
                // Send Push Notification to User
                (new SendPushNotification)->UserCancellRide($userRequest);
                if ($request->ajax()) {
                    return response()->json(['message' => trans('api.ride.ride_cancelled')]);
                } else {
                    return redirect('dashboard')->with('flash_success', trans('api.ride.ride_cancelled'));
                }
            } else {
                if ($request->ajax()) {
                    return response()->json(['error' => trans('api.ride.already_onride')], 422);
                } else {
                    return back()->with('flash_error', trans('api.ride.already_onride'));
                }
            }
        } catch (ModelNotFoundException $e) {
            if ($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            } else {
                return back()->with('flash_error', trans('api.something_went_wrong'));
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function extend_trip(Request $request)
    {
        $this->validate($request, [
            'request_id' => 'required|numeric|exists:user_requests,id,user_id,' . Auth::user()->id,
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required',
        ]);

        try {
            $userRequest = UserRequests::findOrFail($request->request_id);
            $details = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $userRequest->s_latitude . "," . $userRequest->s_longitude . "&destination=" . $request->latitude . "," . $request->longitude . "&mode=driving&key=" . config('constants.map_key');
            $json = curl($details);
            $details = json_decode($json, TRUE);
            $route_key = (count($details['routes']) > 0) ? $details['routes'][0]['overview_polyline']['points'] : '';
            $destination_log = json_decode($userRequest->destination_log);
            $destination_log[] = ['latitude' => $request->latitude, 'longitude' => $request->longitude, 'address' => $request->address];
            //New distance arrow
            $locationarr = ["s_latitude" => $userRequest->s_latitude, "s_longitude" => $userRequest->s_longitude, "d_latitude" => $request->latitude, "d_longitude" => $request->longitude];
            $userRequest->distance = $this->getLocationDistance($locationarr);
            $userRequest->d_latitude = $request->latitude;
            $userRequest->d_longitude = $request->longitude;
            $userRequest->d_address = $request->address;
            $userRequest->route_key = $route_key;
            $userRequest->destination_log = json_encode($destination_log);
            $userRequest->save();
            $message = trans('api.destination_changed');
            (new SendPushNotification)->sendPushToProvider($userRequest->provider_id, $message);
            (new SendPushNotification)->sendPushToUser($userRequest->user_id, $message);
            return $userRequest;
        } catch (ModelNotFoundException $e) {
            if ($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            } else {
                return back()->with('flash_error', trans('api.something_went_wrong'));
            }
        }
    }

    /**
     * Check distance between 2 points
     *
     * @return \Illuminate\Http\Response
     */
    public function getLocationDistance($locationarr)
    {
        $fn_response = array('data' => null, 'errors' => null);
        try {
            $s_latitude = $locationarr['s_latitude'];
            $s_longitude = $locationarr['s_longitude'];
            $d_latitude = empty($locationarr['d_latitude']) ? $locationarr['s_latitude'] : $locationarr['d_latitude'];
            $d_longitude = empty($locationarr['d_longitude']) ? $locationarr['s_longitude'] : $locationarr['d_longitude'];
            $apiurl = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $s_latitude . "," . $s_longitude . "&destinations=" . $d_latitude . "," . $d_longitude . "&mode=driving&sensor=false&units=imperial&key=" . config('constants.map_key');
            $client = new Client;
            $location = $client->get($apiurl);
            $location = json_decode($location->getBody(), true);
            if (!empty($location['rows'][0]['elements'][0]['status']) && $location['rows'][0]['elements'][0]['status'] == 'ZERO_RESULTS') {
                throw new Exception("Out of service area", 1);
            }
            $fn_response["meter"] = $location['rows'][0]['elements'][0]['distance']['value'];
            $fn_response["time"] = $location['rows'][0]['elements'][0]['duration']['text'];
            $fn_response["seconds"] = $location['rows'][0]['elements'][0]['duration']['value'];
        } catch (Exception $e) {
            $fn_response["errors"] = trans('user.maperror');
        }
        return round($fn_response['meter'] / 1000, 1);//RETORNA QUILÔMETROS
    }

    /**
     * Show the request status check.
     *
     * @return \Illuminate\Http\Response
     */
    public function request_status_check()
    {
        try {
            $check_status = ['CANCELLED', 'SCHEDULED'];
            $userRequests = UserRequests::UserRequestStatusCheck(Auth::user()->id, $check_status)
                ->get()
                ->toArray();
            $search_status = ['SEARCHING', 'SCHEDULED'];
            $userRequestsFilter = UserRequests::UserRequestAssignProvider(Auth::user()->id, $search_status)->get();
            //Log::info($userRequestsFilter);
            if (!empty($userRequests)) {
                $userRequests[0]['ride_otp'] = (int)config('constants.ride_otp', 0);
                $userRequests[0]['ride_toll'] = (int)config('constants.ride_toll', 0);
                $userRequests[0]['reasons'] = Reason::where('type', 'USER')->get();
            }
            $Timeout = config('constants.provider_select_timeout', 180);
            $type = config('constants.broadcast_request', 0);
            if (!empty($userRequestsFilter)) {
                for ($i = 0; $i < count($userRequestsFilter); $i++) {
                    if ($type == 1) {
                        $ExpiredTime = $Timeout - (time() - strtotime($userRequestsFilter[$i]->created_at));
                        if ($userRequestsFilter[$i]->status == 'SEARCHING' && $ExpiredTime < 0) {
                            UserRequests::where('id', $userRequestsFilter[$i]->id)->update(['status' => 'CANCELLED']);
                            // No longer need request specific rows from RequestMeta
                            RequestFilter::where('request_id', $userRequestsFilter[$i]->id)->delete();
                        } else if ($userRequestsFilter[$i]->status == 'SEARCHING' && $ExpiredTime > 0) {
                            break;
                        }
                    } else {
                        $ExpiredTime = $Timeout - (time() - strtotime($userRequestsFilter[$i]->assigned_at));
                        if ($userRequestsFilter[$i]->status == 'SEARCHING' && $ExpiredTime < 0) {
                            $providertrip = new TripController();
                            $providertrip->assign_next_provider($userRequestsFilter[$i]->id);
                        } else if ($userRequestsFilter[$i]->status == 'SEARCHING' && $ExpiredTime > 0) {
                            break;
                        }
                    }
                }
            }
            if (empty($userRequests)) {
                $cancelled_request = UserRequests::where('user_requests.user_id', Auth::user()->id)
                    ->where('user_requests.user_rated', 0)
                    ->where('user_requests.status', ['CANCELLED'])->orderby('updated_at', 'desc')
                    ->where('updated_at', '>=', \Carbon\Carbon::now()->subSeconds(5))
                    ->first();
                if ($cancelled_request != null) {
                    \Session::flash('flash_error', $cancelled_request->cancel_reason);
                }
            }
            return response()->json(['data' => $userRequests,
                'sos' => config('constants.sos_number', '190'),
                'cash' => (int)config('constants.cash'),

                //TODO ALL - Debit changes at the machine and voucher
                'debit_machine' => (int)config('constants.debit_machine'),
                'voucher' => (int)config('constants.voucher'),

                'card' => (int)config('constants.card'),
                'currency' => config('constants.currency', '$'),
                'payumoney' => (int)config('constants.payumoney'),
                'paypal' => (int)config('constants.paypal'),
                'paypal_adaptive' => (int)config('constants.paypal_adaptive'),
                'braintree' => (int)config('constants.braintree'),
                'paytm' => (int)config('constants.paytm'),
                'stripe_secret_key' => config('constants.stripe_secret_key'),
                'stripe_publishable_key' => config('constants.stripe_publishable_key'),
                'stripe_currency' => config('constants.stripe_currency'),
                'payumoney_environment' => config('constants.payumoney_environment'),
                'payumoney_key' => config('constants.payumoney_key'),
                'payumoney_salt' => config('constants.payumoney_salt'),
                'payumoney_auth' => config('constants.payumoney_auth'),
                'paypal_environment' => config('constants.paypal_environment'),
                'paypal_currency' => config('constants.paypal_currency'),
                'paypal_client_id' => config('constants.paypal_client_id'),
                'paypal_client_secret' => config('constants.paypal_client_secret'),
                'braintree_environment' => config('constants.braintree_environment'),
                'braintree_merchant_id' => config('constants.braintree_merchant_id'),
                'braintree_public_key' => config('constants.braintree_public_key'),
                'braintree_private_key' => config('constants.braintree_private_key')]);
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function rate_provider(Request $request)
    {
        $this->validate($request, [
            'request_id' => 'required|integer|exists:user_requests,id,user_id,' . Auth::user()->id,
            'rating' => 'required|integer|in:1,2,3,4,5',
            'comment' => 'max:255',
        ]);
        $userRequests = UserRequests::where('id', $request->request_id)
            ->where('status', 'COMPLETED')
            ->where('paid', 0)
            ->first();
        if ($userRequests) {
            if ($request->ajax()) {
                return response()->json(['error' => trans('api.user.not_paid')], 422);
            } else {
                return back()->with('flash_error', trans('api.user.not_paid'));
            }
        }
        try {
            $userRequest = UserRequests::findOrFail($request->request_id);
            if ($userRequest->rating == null) {
                UserRequestRating::create([
                    'provider_id' => $userRequest->provider_id,
                    'user_id' => $userRequest->user_id,
                    'request_id' => $userRequest->id,
                    'user_rating' => $request->rating,
                    'user_comment' => $request->comment,
                ]);
            } else {
                $userRequest->rating->update([
                    'user_rating' => $request->rating,
                    'user_comment' => $request->comment,
                ]);
            }
            $userRequest->user_rated = 1;
            $userRequest->save();
            $average = UserRequestRating::where('provider_id', $userRequest->provider_id)->avg('user_rating');
            Provider::where('id', $userRequest->provider_id)->update(['rating' => $average]);
            // Send Push Notification to Provider
            if ($request->ajax()) {
                return response()->json(['message' => trans('api.ride.provider_rated')]);
            } else {
                return redirect('dashboard')->with('flash_success', trans('api.ride.provider_rated'));
            }
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            } else {
                return back()->with('flash_error', trans('api.something_went_wrong'));
            }
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function modifiy_request(Request $request)
    {
        $this->validate($request, [
            'request_id' => 'required|integer|exists:user_requests,id,user_id,' . Auth::user()->id,
            'latitude' => 'sometimes|nullable|numeric',
            'longitude' => 'sometimes|nullable|numeric',
            'address' => 'sometimes|nullable',
            // TODO ALL - Debit changes at the machine and voucher
            'payment_mode' => 'sometimes|nullable|in:BRAINTREE,CASH,CARD,DEBIT_MACHINE,PAYPAL,PAYPAL-ADAPTIVE,PAYUMONEY,PAYTM',
            'card_id' => ['required_if:payment_mode,CARD', 'exists:cards,card_id,user_id,' . Auth::user()->id],
        ]);
        try {
            $userRequest = UserRequests::findOrFail($request->request_id);
            if (!empty($request->latitude) && !empty($request->longitude)) {
                $userRequest->d_latitude = $request->latitude ?: $userRequest->d_latitude;
                $userRequest->d_longitude = $request->longitude ?: $userRequest->d_longitude;
                $userRequest->d_address = $request->address ?: $userRequest->d_address;
            }
            if ($request->has('braintree_nonce') && $request->braintree_nonce != null) {
                $userRequest->braintree_nonce = $request->braintree_nonce;
            }
            if (!empty($request->payment_mode)) {
                $userRequest->payment_mode = $request->payment_mode;
//                if ($request->payment_mode == 'CARD' && $userRequest->status == 'DROPPED') {
//                    $userRequest->status = 'COMPLETED';
//                }
            }
            $userRequest->save();
            if ($request->has('card_id')) {
                Card::where('user_id', Auth::user()->id)->update(['is_default' => 0]);
                Card::where('card_id', $request->card_id)->update(['is_default' => 1]);
            }
            // Send Push Notification to Provider
            if ($request->ajax()) {
                return response()->json(['message' => trans('api.ride.request_modify_location')]);
            } else {
                return redirect('dashboard')->with('flash_success', trans('api.ride.request_modify_location'));
            }
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            } else {
                return back()->with('flash_error', trans('api.something_went_wrong'));
            }
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function trips()
    {
        try {
            $userRequests = UserRequests::UserTrips(Auth::user()->id)->get();
            if (!empty($userRequests)) {
                $map_icon = asset('asset/img/marker-start.png');
                foreach ($userRequests as $key => $value) {
                    $userRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?" .
                        "autoscale=1" .
                        "&size=320x130" .
                        "&maptype=terrian" .
                        "&format=png" .
                        "&visual_refresh=true" .
                        "&markers=icon:" . $map_icon . "%7C" . $value->s_latitude . "," . $value->s_longitude .
                        "&markers=icon:" . $map_icon . "%7C" . $value->d_latitude . "," . $value->d_longitude .
                        "&path=color:0x191919|weight:3|enc:" . $value->route_key .
                        "&key=" . config('constants.map_key');
                }
            }
            return $userRequests;
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function estimatedFare(Request $request)
    {
        $this->validate($request, [
            's_latitude' => 'required|numeric',
            's_longitude' => 'numeric',
            'd_latitude' => 'required|numeric',
            'd_longitude' => 'numeric',
            'service_type' => 'required|numeric|exists:service_types,id',
        ]);
        try {
            $response = new ServiceTypes();
            $responsedata = $response->calculateFare($request->all(), 1);
            if (!empty($responsedata['errors'])) {
                throw new Exception($responsedata['errors']);
            } else {
                return response()->json($responsedata['data']);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function trip_details(Request $request)
    {
        $this->validate($request, ['request_id' => 'required|integer|exists:user_requests,id']);
        try {
            $userRequests = UserRequests::UserTripDetails(Auth::user()->id, $request->request_id)->get();
            if (!empty($userRequests)) {
                $map_icon = asset('asset/img/marker-start.png');
                foreach ($userRequests as $key => $value) {
                    $userRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?" .
                        "autoscale=1" .
                        "&size=320x130" .
                        "&maptype=terrian" .
                        "&format=png" .
                        "&visual_refresh=true" .
                        "&markers=icon:" . $map_icon . "%7C" . $value->s_latitude . "," . $value->s_longitude .
                        "&markers=icon:" . $map_icon . "%7C" . $value->d_latitude . "," . $value->d_longitude .
                        "&path=color:0x191919|weight:3|enc:" . $value->route_key .
                        "&key=" . config('constants.map_key');
                }
                $userRequests[0]->dispute = UserRequestDispute::where('dispute_type', 'user')->where('request_id', $request->request_id)->where('user_id', Auth::user()->id)->first();
                $userRequests[0]->lostitem = UserRequestLostItem::where('request_id', $request->request_id)->where('user_id', Auth::user()->id)->first();
                $userRequests[0]->contact_number = config('constants.contact_number', '');
                $userRequests[0]->contact_email = config('constants.contact_email', '');
            }
            return $userRequests;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
    }

    /**
     * get all promo code.
     *
     * @return \Illuminate\Http\Response
     */
    public function promocodes()
    {
        try {
            $this->check_expiry();
            return PromocodeUsage::Active()
                ->where('user_id', Auth::user()->id)
                ->with('promocode')
                ->get();
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    public function check_expiry()
    {
        try {
            $Promocode = Promocode::all();
            foreach ($Promocode as $index => $promo) {
                if (date("Y-m-d") > $promo->expiration) {
                    $promo->status = 'EXPIRED';
                    $promo->save();
                    PromocodeUsage::where('promocode_id', $promo->id)->update(['status' => 'EXPIRED']);
                } else {
                    PromocodeUsage::where('promocode_id', $promo->id)
                        ->where('status', '<>', 'USED')
                        ->update(['status' => 'ADDED']);

                    PromocodePassbook::create([
                        'user_id' => Auth::user()->id,
                        'status' => 'ADDED',
                        'promocode_id' => $promo->id
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * add promo code.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_promocode(Request $request)
    {
        try {

            $promo_list = Promocode::where('expiration', '>=', date("Y-m-d H:i"))
                ->where('status', '=', 'ADDED')
                ->whereDoesntHave('promousage', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                })
                ->get();
            \Log::alert("testtest" . $promo_list);
            if ($request->ajax()) {
                return response()->json([
                    'promo_list' => $promo_list
                ]);
            } else {
                return $promo_list;
            }
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            } else {
                return back()->with('flash_error', trans('api.something_went_wrong'));
            }
        }
    }

    public function add_promocode(Request $request)
    {
        $this->validate($request, [
            'promocode' => 'required|exists:promocodes,promo_code',
        ]);
        try {

            $find_promo = Promocode::where('promo_code', $request->promocode)->first();

            if ($find_promo->status == 'EXPIRED' || (date("Y-m-d") > $find_promo->expiration)) {

                if ($request->ajax()) {

                    return response()->json([
                        'message' => trans('api.promocode_expired'),
                        'code' => 'promocode_expired'
                    ]);
                } else {
                    return back()->with('flash_error', trans('api.promocode_expired'));
                }
            } elseif (PromocodeUsage::where('promocode_id', $find_promo->id)->where('user_id', Auth::user()->id)->whereIN('status', ['ADDED', 'USED'])->count() > 0) {

                if ($request->ajax()) {

                    return response()->json([
                        'message' => trans('api.promocode_already_in_use'),
                        'code' => 'promocode_already_in_use'
                    ]);
                } else {
                    return back()->with('flash_error', trans('api.promocode_already_in_use'));
                }
            } else {

                $promo = new PromocodeUsage;
                $promo->promocode_id = $find_promo->id;
                $promo->user_id = Auth::user()->id;
                $promo->status = 'ADDED';
                $promo->save();

                $count_id = PromocodePassbook::where('promocode_id', $find_promo->id)->count();
                //dd($count_id);
                if ($count_id == 0) {

                    PromocodePassbook::create([
                        'user_id' => Auth::user()->id,
                        'status' => 'ADDED',
                        'promocode_id' => $find_promo->id
                    ]);
                }
                if ($request->ajax()) {

                    return response()->json([
                        'message' => trans('api.promocode_applied'),
                        'code' => 'promocode_applied'
                    ]);
                } else {
                    return back()->with('flash_success', trans('api.promocode_applied'));
                }
            }
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            } else {
                return back()->with('flash_error', trans('api.something_went_wrong'));
            }
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function upcoming_trips()
    {
        try {

            $userRequests = UserRequests::UserUpcomingTrips(Auth::user()->id)->get();
            if (!empty($userRequests)) {
                $map_icon = asset('asset/img/marker-start.png');
                foreach ($userRequests as $key => $value) {
                    $userRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?" .
                        "autoscale=1" .
                        "&size=320x130" .
                        "&maptype=terrian" .
                        "&format=png" .
                        "&visual_refresh=true" .
                        "&markers=icon:" . $map_icon . "%7C" . $value->s_latitude . "," . $value->s_longitude .
                        "&markers=icon:" . $map_icon . "%7C" . $value->d_latitude . "," . $value->d_longitude .
                        "&path=color:0x000000|weight:3|enc:" . $value->route_key .
                        "&key=" . config('constants.map_key');
                }
            }
            return $userRequests;
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function upcoming_trip_details(Request $request)
    {
        $this->validate($request, [
            'request_id' => 'required|integer|exists:user_requests,id',
        ]);
        try {
            $userRequests = UserRequests::UserUpcomingTripDetails(Auth::user()->id, $request->request_id)->get();
            if (!empty($userRequests)) {
                $map_icon = asset('asset/img/marker-start.png');
                foreach ($userRequests as $key => $value) {
                    $userRequests[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?" .
                        "autoscale=1" .
                        "&size=320x130" .
                        "&maptype=terrian" .
                        "&format=png" .
                        "&visual_refresh=true" .
                        "&markers=icon:" . $map_icon . "%7C" . $value->s_latitude . "," . $value->s_longitude .
                        "&markers=icon:" . $map_icon . "%7C" . $value->d_latitude . "," . $value->d_longitude .
                        "&path=color:0x000000|weight:3|enc:" . $value->route_key .
                        "&key=" . config('constants.map_key');
                }
            }
            return $userRequests;
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Show the nearby providers.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_providers(Request $request)
    {
        $this->validate($request, [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'service' => 'numeric|exists:service_types,id',
        ]);
        // TODO - Update user city by latitude and longitude
        User::where('id', Auth::user()->id)->update(['latitude' => $request->latitude, 'longitude' => $request->longitude]);

        try {
            //Altered by All
            $distance = config('constants.provider_search_radius', '10');
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            if ($request->has('service')) {
                $ActiveProviders = ProviderService::AvailableServiceProvider($request->service)
                    ->get()->pluck('provider_id');
                $providers = Provider::with('service')->whereIn('id', $ActiveProviders)
                    ->where('status', 'approved')
                    ->whereRaw("round((6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),3) <= $distance")
                    ->get();
            } else {
                $ActiveProviders = ProviderService::where('status', 'active')
                    ->get()->pluck('provider_id');
                $providers = Provider::with('service')->whereIn('id', $ActiveProviders)
                    ->where('status', 'approved')
                    ->whereRaw("round((6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ),3) <= $distance")
                    ->get();
            }
            return $providers;

        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            } else {
                return back()->with('flash_error', trans('api.something_went_wrong'));
            }
        }
    }

    /**
     * Forgot Password.
     *
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
        ]);
        try {
            $user = User::where('email', $request->email)->first();
            $otp = mt_rand(100000, 999999);
            $user->otp = $otp;
            $user->save();
            Notification::send($user, new ResetPasswordOTP($otp));
            return response()->json([
                'message' => 'Password has been sent to your E-mail! ',
                'user' => $user
            ]);
        } catch (Exception $e) {
            // Log::info($e->getMessage());
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Reset Password.
     *
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
            'id' => 'required|numeric|exists:users,id'
        ]);
        try {
            $user = User::findOrFail($request->id);
            // $UpdatedAt = date_create($user->updated_at);
            // $CurrentAt = date_create(date('Y-m-d H:i:s'));
            // $ExpiredAt = date_diff($UpdatedAt,$CurrentAt);
            // $ExpiredMin = $ExpiredAt->i;
            $user->password = bcrypt($request->password);
            $user->save();
            if ($request->ajax()) {
                return response()->json(['message' => trans('api.user.password_updated')]);
            }
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }
        }
    }

    /**
     * help Details.
     *
     * @return \Illuminate\Http\Response
     */
    public function help_details(Request $request)
    {
        try {
            if ($request->ajax()) {
                return response()->json([
                    'contact_npromocodesumber' => config('constants.contact_number', ''),
                    'contact_email' => config('constants.contact_email', '')
                ]);
            }
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }
        }
    }

    /**
     * Show the wallet usage.
     *
     * @return \Illuminate\Http\Response
     */
    public function wallet_passbook(Request $request)
    {
        try {
            $start_node = $request->start_node;
            $limit = $request->limit;

            $wallet_transation = UserWallet::where('user_id', Auth::user()->id);
            if (!empty($limit)) {
                $wallet_transation = $wallet_transation->offset($start_node);
                $wallet_transation = $wallet_transation->limit($limit);
            }
            $wallet_transation = $wallet_transation->orderBy('id', 'desc')->get();
            return response()->json(['wallet_transation' => $wallet_transation, 'wallet_balance' => Auth::user()->wallet_balance]);
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Show the promo usage.
     *
     * @return \Illuminate\Http\Response
     */
    public function promo_passbook(Request $request)
    {
        try {
            return PromocodePassbook::where('user_id', Auth::user()->id)->with('promocode')->get();
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function test(Request $request)
    {
        //$push =  (new SendPushNotification)->IncomingRequest($request->id);
        $push = (new SendPushNotification)->Arrived($request->id);
        dd($push);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function pricing_logic($id)
    {
        //return $id;
        $logic = ServiceType::select('calculator')->where('id', $id)->first();
        return $logic;
    }

    public function fare(Request $request)
    {
        $this->validate($request, [
            's_latitude' => 'required|numeric',
            's_longitude' => 'numeric',
            'd_latitude' => 'required|numeric',
            'd_longitude' => 'numeric',
            'service_type' => 'required|numeric|exists:service_types,id',
        ]);
        try {
            $response = new ServiceTypes();
            $responsedata = $response->calculateFare($request->all());
            //$responsedata = 0;
            if (!empty($responsedata['errors'])) {
                throw new Exception($responsedata['errors']);
            } else {
                return response()->json($responsedata['data']);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the wallet usage.
     *
     * @return \Illuminate\Http\Response
     */
    /* public function check(Request $request)
      {
      $this->validate($request, [
      'name' => 'required',
      'age' => 'required',
      'work' => 'required',
      ]);
      return Work::create(request(['name', 'age' ,'work']));
      } */

    public function chatPush(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|numeric',
            'message' => 'required',
        ]);
        try {
            $user_id = $request->user_id;
            $message = $request->message;
            $sender = $request->sender;
            $message = \PushNotification::Message($message, array(
                'badge' => 1,
                'sound' => 'default',
                'custom' => array('type' => 'chat')
            ));
            (new SendPushNotification)->sendPushToProvider($user_id, $message);
            //(new SendPushNotification)->sendPushToUser($user_id, $message);
            return response()->json(['success' => 'true']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function checkVersion(Request $request)
    {
        $this->validate($request, [
            'sender' => 'in:user,provider',
            'device_type' => 'in:android,ios',
            'version' => 'required',
        ]);
        try {
            $sender = $request->sender;
            $device_type = $request->device_type;
            $version = $request->version;
            if ($sender == 'user') {
                if ($device_type == 'ios') {
                    $current_version = config('constants.version_ios_user');
                    if ($current_version == $version) {
                        return response()->json(['force_update' => false]);
                    } elseif ($current_version > $version) {
                        return response()->json(['force_update' => true, 'url' => config('constants.store_link_ios_user')]);
                    } else {
                        return response()->json(['force_update' => false]);
                    }
                } else {
                    $current_version = config('constants.version_android_user');
                    if ($current_version == $version) {
                        return response()->json(['force_update' => false]);
                    } elseif ($current_version > $version) {
                        return response()->json(['force_update' => true, 'url' => config('constants.store_link_android_user')]);
                    } else {
                        return response()->json(['force_update' => false]);
                    }
                }
            } else if ($sender == 'provider') {
                if ($device_type == 'ios') {
                    $current_version = config('constants.version_ios_provider');
                    if ($current_version == $version) {
                        return response()->json(['force_update' => false]);
                    } elseif ($current_version > $version) {
                        return response()->json(['force_update' => true, 'url' => config('constants.store_link_ios_provider')]);
                    } else {
                        return response()->json(['force_update' => false]);
                    }
                } else {
                    $current_version = config('constants.version_android_provider');
                    if ($current_version == $version) {
                        return response()->json(['force_update' => false]);
                    } elseif ($current_version > $version) {
                        return response()->json(['force_update' => true, 'url' => config('constants.store_link_android_provider')]);
                    } else {
                        return response()->json(['force_update' => false]);
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function checkapi(Request $request)
    {
        //Log::info('Request Details:', $request->all());
        return response()->json(['sucess' => true]);
    }

    public function reasons(Request $request)
    {
        return Reason::where('type', 'USER')->where('status', 1)->get();
    }

    public function payment_log(Request $request)
    {
        $log = PaymentLog::where('transaction_code', $request->order)->first();
        $log->response = $request->all();
        $log->save();
        return response()->json(['message' => trans('api.payment_success')]);
    }

    public function verifyCredentials(Request $request)
    {
        if ($request->has("mobile")) {
            $provider = User::where([['country_code', $request->country_code], ['mobile', $request->mobile]])->where('user_type', 'NORMAL')->first();
            if ($provider != null) {
                return response()->json(['message' => trans('api.mobile_exist')], 422);
            }
        }
        if ($request->has("email")) {
            $provider = User::where('email', $request->input("email"))->first();
            if ($provider != null) {
                return response()->json(['message' => trans('api.email_exist')], 422);
            }
        }
        return response()->json(['message' => trans('api.available')]);
    }

    public function settings(Request $request)
    {
        $serviceType = ServiceType::where('parent_id', '=', '0')->with('childrenRecursive')->where('status', 1)->get();
        $settings = [
            'serviceTypes' => $serviceType,
            'referral' => [
                'referral' => config('constants.referral', 0),
                'count' => config('constants.referral_count', 0),
                'amount' => config('constants.referral_amount', 0),
                'ride_otp' => (int)config('constants.ride_otp'),
                'ride_toll' => (int)config('constants.ride_toll'),
            ]
        ];
        return response()->json($settings);
    }

    public function client_token()
    {
        $this->set_Braintree();
        $clientToken = \Braintree_ClientToken::generate();
        return response()->json(['token' => $clientToken]);
    }

    public function set_Braintree()
    {
        \Braintree_Configuration::environment(config('constants.braintree_environment'));
        \Braintree_Configuration::merchantId(config('constants.braintree_merchant_id'));
        \Braintree_Configuration::publicKey(config('constants.braintree_public_key'));
        \Braintree_Configuration::privateKey(config('constants.braintree_private_key'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function banners()
    {
        if ($serviceList = Banners::all()) {
            return $serviceList;
        } else {
            return response()->json(['error' => trans('api.services_not_found')], 500);
        }

    }


    public function checkOTP(CheckOTPRequest $request)
    {

        try {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                if ($user->otp == $request->otp_code) {
                    return response()->json(['success' => 'Verified'], 200);
                } else {
                    return response()->json(['message' => 'Invalid OTP'], 422);
                }
            } else {
                return response()->json(['error' => 'User Not Found'], 404);
            }
        } catch (Exception $e) {
            // Log::info($e->getMessage());
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }
}
