<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Brand;
use App\Category;
use App\City;
use App\Country;
use App\Media;
use App\Payment;
use App\Report_ad;
use App\State;
use App\Sub_Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('app.all_ads');
        $ads = Ad::with('city', 'country', 'state')
            ->where('status', '1')
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('admin.all_ads', compact('title', 'ads'));
    }

    public function adminPendingAds()
    {
        $title = trans('app.pending_ads');
        $ads = Ad::with('city', 'country', 'state')
            ->where('status', '0')
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('admin.all_ads', compact('title', 'ads'));
    }
    public function adminBlockedAds()
    {
        $title = trans('app.blocked_ads');
        $ads = Ad::with('city', 'country', 'state')
            ->where('status', '2')
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('admin.all_ads', compact('title', 'ads'));
    }
    
    public function myAds()
    {
        $title = trans('app.my_ads');

        $user = Auth::user();
        $ads = $user->ads()->with('city', 'country', 'state')->orderBy('id', 'desc')->paginate(20);
        
        return view('admin.my_ads', compact('title', 'ads'));
    }

    public function pendingAds()
    {
        $title = trans('app.my_ads');

        $user = Auth::user();
        $ads = $user->ads()->where('status', '0')
            ->with('city', 'country', 'state')
            ->orderBy('id', 'desc')->paginate(20);

        return view('admin.pending_ads', compact('title', 'ads'));
    }

    public function favoriteAds(){
        $title = trans('app.favourite_ads');

        $user = Auth::user();
        $ads = $user->favourite_ads()->with('city', 'country', 'state')->orderBy('id', 'desc')->paginate(20);
        
        return view('admin.favourite_ads', compact('title', 'ads'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = Auth::user()->id;
        $title = trans('app.post_an_ad');
        $categories = Category::where('category_id', 0)->where('is_active', 1)->get();
        $countries = Country::whereIn('country_code', ['US', 'JP', 'KR', 'MY', 'SG', 'HK', 'PH', 'TL', 'ID', 'VN'])->get();
        $ads_images = Media::where('user_id' , $user_id)->where('ad_id' , 0)->where('ref' , 'ad')->get();
        
        $previous_brands = Brand::where('category_id', old('category'))->get();
        $previous_states = State::where('country_id', old('country'))->get();
        $previous_cities = City::where('state_id', old('state'))->get();


        return view('admin.create_ad', compact('title', 'categories', 'countries', 'ads_images', 'previous_brands', 'previous_states', 'previous_cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $rules = [
            'category'  => 'required',
            'ad_title'  => 'required',
            'ad_description'  => 'required',
            'type'  => 'required',
            'condition'  => 'required',
            'country'  => 'required',
            'seller_name'  => 'required',
            'seller_email'  => 'required',
            'seller_phone'  => 'required',
            'address'  => 'required',
            'price'  => 'required',
            'discount_price'  => 'required',
            'shipping_fee'  => 'required',
            'shipping_days'  => 'required|min:1',
            'ad_content'  => 'required',
            'ad_name'  => 'required',
        ];

        $this->validate($request, $rules);

        $adName = $request->ad_name;
        $slug = unique_slug($adName, 'Ad', 'slug');

        $sub_category = Category::find($request->category);

        $brand_id = $request->brand ? $request->brand : 0;
        $mark_ad_urgent = $request->mark_ad_urgent ? $request->mark_ad_urgent : 0;
        $video_url = $request->video_url ? $request->video_url : '';

        $data = [
            'title' => $request->ad_title,
            'slug' => $slug,
            'description' => $request->ad_description,
            'category_id' => $sub_category->category_id,
            'sub_category_id' => $request->category,
            'brand_id' => $brand_id,
            'type' => $request->type,
            'ad_condition' => $request->condition,
            'price' => $request->price,
            'discount_price'  => number_format($request->discount_price),
            'shipping_fee'  => $request->shipping_fee,
            'shipping_days'  => $request->shipping_days,
            'seller_name' => $request->seller_name,
            'seller_email' => $request->seller_email,
            'seller_phone' => $request->seller_phone,
            'country_id' => $request->country,
            'state_id' => $request->state,
            'city_id' => $request->city,
            'address' => $request->address,
            'video_url' => $video_url,
            'price_plan' => $request->price_plan,
            'mark_ad_urgent' => $mark_ad_urgent,
            'status' => '0',
            'user_id' => $user_id,
            'price_plan' => 'regular',
            'content' => $request->ad_content,
            'name' => $adName,
            'sku' => $request->sku ?? '',
        ];

        //Check ads moderation settings
        if (get_option('ads_moderation') == 'direct_publish'){
            $data['status'] = 1;
        }

        //if price_plan not in post data, then set a default value, although mysql will save it as enum first value
        if ( ! $request->price_plan){
            $data['price_plan'] = 'regular';
        }

        $created_ad = Ad::create($data);

        /**
         * iF add created
         */
        if ($created_ad){
            //Attach all unused media with this ad
            Media::where('user_id', $user_id)
                ->where('ad_id', 0)
                ->where('ref', 'ad')
                ->update(['ad_id' => $created_ad->id]);

            return redirect(route('pending_ads'))->with('success', trans('app.ad_created_msg'));
        }
        return redirect(route('create_ad'))->with('error', trans('app.ad_created_msg_failed'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $title = trans('app.edit_ad');
        $ad = Ad::find($id);

        if (!$ad)
            return view('admin.error.error_404');

        if (! $user->is_admin()){
            if ($ad->user_id != $user_id){
                return view('admin.error.error_404');
            }
        }
        
        $categories = Category::where('category_id', 0)->get();
        $countries = Country::whereIn('country_code', ['US', 'JP', 'KR', 'MY', 'SG', 'HK', 'PH', 'TL', 'ID', 'VN'])->get();
        $ads_images = Media::where('user_id' , $user_id)->where('ad_id' , 0)->where('ref' , 'ad')->get();

        $previous_brands = Brand::where('category_id', $ad->sub_category_id)->get();
        $previous_states = State::where('country_id', $ad->country_id)->get();
        $previous_cities = City::where('state_id', $ad->state_id)->get();
        
        return view('admin.edit_ad', compact('title', 'categories', 'countries', 'ads_images', 'ad', 'previous_brands', 'previous_states', 'previous_cities'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ad = Ad::find($id);
        $user = Auth::user();
        $user_id = $user->id;

        if (! $user->is_admin()){
            if ($ad->user_id != $user_id){
                return view('admin.error.error_404');
            }
        }
        $mark_ad_urgent = $request->mark_ad_urgent ? $request->mark_ad_urgent : 0;

        $rules = [
            'category'  => 'required',
            'ad_title'  => 'required',
            'ad_description'  => 'required',
            'type'  => 'required',
            'condition'  => 'required',
            'country'  => 'required',
            'seller_name'  => 'required',
            'seller_email'  => 'required',
            'seller_phone'  => 'required',
            'address'  => 'required',
            'price'  => 'required',
            'discount_price'  => 'required',
            'shipping_fee'  => 'required',
            'shipping_days'  => 'required|min:1',
            'ad_content'  => 'required',
        ];

        $this->validate($request, $rules);
        
        $sub_category = Category::find($request->category);
        $is_negotialble = $request->negotiable ? $request->negotiable : 0;
        $brand_id = $request->brand ? $request->brand : 0;
        $video_url = $request->video_url ? $request->video_url : '';

        $data = [
            'title' => $request->ad_title,
            'description' => $request->ad_description,
            'category_id' => $sub_category->category_id,
            'sub_category_id' => $request->category,
            'brand_id' => $brand_id,
            'type' => $request->type,
            'ad_condition' => $request->condition,
            'price' => $request->price,
            'discount_price'  => $request->discount_price,
            'shipping_fee'  => $request->shipping_fee,
            'shipping_days'  => $request->shipping_days,
            'is_negotiable' => $is_negotialble,

            'seller_name' => $request->seller_name,
            'seller_email' => $request->seller_email,
            'seller_phone' => $request->seller_phone,
            'country_id' => $request->country,
            'state_id' => $request->state,
            'city_id' => $request->city,
            'address' => $request->address,
            'video_url' => $video_url,
            'price_plan' => 'regular',
            'mark_ad_urgent' => $mark_ad_urgent,
            'content' => $request->ad_content,
            'sku' => $request->sku ?? '',
        ];
        $updated_ad = $ad->update($data);

        /**
         * iF add created
         */
        if ($updated_ad){
            //Attach all unused media with this ad
            Media::where('user_id' , $user_id)
                ->where('ad_id' , 0)
                ->where('ref' , 'ad')
                ->update(['ad_id'=>$ad->id]);
        }

        return redirect()->back()->with('success', trans('app.ad_updated'));
    }


    public function adStatusChange(Request $request){
        $slug = $request->slug;
        $ad = Ad::where('slug', $slug)->first();
        if ($ad){
            $value = $request->value;
            /*
            $ad->status = $value;
            $ad->save();*/
            ad_status_change($ad->id, $value);
            if ($value ==1){
                return ['success'=>1, 'msg' => trans('app.ad_approved_msg')];
            }elseif($value ==2){
                return ['success'=>1, 'msg' => trans('app.ad_blocked_msg')];
            }
            elseif($value ==3){
                return ['success'=>1, 'msg' => trans('app.ad_archived_msg')];
            }
        }
        return ['success'=>0, 'msg' => trans('app.error_msg')];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $slug = $request->slug;
        $ad = Ad::where('slug', $slug)->first();
        if ($ad){
            $media = Media::where('ad_id', $ad->id)->get();
            if ($media->count() > 0){
                foreach($media as $m){
                    $storage = Storage::disk($m->storage);
                    if ($storage->has('uploads/images/'.$m->media_name)){
                        $storage->delete('uploads/images/'.$m->media_name);
                    }
                    if ($m->type == 'image'){
                        if ($storage->has('uploads/images/thumbs/'.$m->media_name)){
                            $storage->delete('uploads/images/thumbs/'.$m->media_name);
                        }
                    }
                    $m->delete();
                }
            }
            $ad->delete();
            return ['success'=>1, 'msg' => trans('app.media_deleted_msg')];
        }
        return ['success'=>0, 'msg' => trans('app.error_msg')];
    }

    public function getSubCategoryByCategory(Request $request){
        $category_id = $request->category_id;
        $brands = Sub_Category::where('category_id', $category_id)
            ->select('id', 'category_name', 'category_slug')->get();
        return $brands;
    }

    public function getBrandByCategory(Request $request){
        $category_id = $request->category_id;
        $brands = Brand::where('category_id', $category_id)
            ->select('id', 'brand_name')->get();
        return $brands;
    }

    public function getStateByCountry(Request $request){
        $country_id = $request->country_id;
        $states = State::where('country_id', $country_id)->select('id', 'state_name')->get();
        return $states;
    }

    public function getCityByState(Request $request){
        $state_id = $request->state_id;
        $cities = City::where('state_id', $state_id)->select('id', 'city_name')->get();
        return $cities;
    }

    public function getParentCategoryInfo(Request $request){
        $category_id = $request->category_id;
        $sub_category = Category::find($category_id);
        $category = Category::find($sub_category->category_id);
        return $category;
    }

    public function uploadAdsImage(Request $request){
        $user_id = Auth::user()->id;

        if ($request->hasFile('images')){
            $image = $request->file('images');
            $valid_extensions = ['jpg','jpeg','png'];

            if ( ! in_array(strtolower($image->getClientOriginalExtension()), $valid_extensions) ){
                return ['success' => 0, 'msg' => implode(',', $valid_extensions).' '.trans('app.valid_extension_msg')];
            }

            $file_base_name = str_replace('.'.$image->getClientOriginalExtension(), '', $image->getClientOriginalName());

            $resized = Image::make($image)->resize(640, null, function ($constraint) {
                $constraint->aspectRatio();
            })->stream();
            $resized_thumb = Image::make($image)->resize(320, 213)->stream();

            $image_name = strtolower(time().str_random(5).'-'.str_slug($file_base_name)).'.' . $image->getClientOriginalExtension();
//            $imageFileName = 'uploads/images/'.$image_name;
//            $imageThumbName = 'uploads/images/thumbs/'.$image_name;

            try{
                $filePath = 'product_images/' . $image_name;
                //Upload original image
//                $is_uploaded = current_disk()->put($imageFileName, $resized->__toString(), 'public');
                $is_uploaded = Storage::disk('s3')->put($filePath, $resized->__toString(), 'public');

                if ($is_uploaded) {
                    //Save image name into db
                    $created_img_db = Media::create(
                        [
                            'user_id' => $user_id,
                            'media_name'=>$image_name,
                            'type'=>'image',
                            'storage' => get_option('default_storage'),
                            'ref'=>'ad'
                        ]
                    );

                    //upload thumb image
                    $filePath = 'product_images/thumb/' . $image_name;
//                    current_disk()->put($filePath, $resized_thumb->__toString(), 'public');
                    Storage::disk('s3')->put($filePath, $resized_thumb->__toString(), 'public');
                    $img_url = media_url($created_img_db, false);
                    return ['success' => 1, 'img_url' => $img_url];
                } else {
                    return ['success' => 0];
                }
            } catch (\Exception $e){
                return $e->getMessage();
            }

        }
    }
    /**
     * @param Request $request
     * @return array
     */

    public function deleteMedia(Request $request){
        $media_id = $request->media_id;
        $media = Media::find($media_id);

        $storage = Storage::disk($media->storage);
        if ($storage->has('product_images/' . $media->media_name)){
            $storage->delete('product_images/' . $media->media_name);
        }

        if ($media->type == 'image'){
            if ($storage->has('product_images/thumb/' . $media->media_name)){
                $storage->delete('product_images/thumb/' . $media->media_name);
            }
        }

        $media->delete();
        return ['success'=>1, 'msg'=>trans('app.media_deleted_msg')];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function featureMediaCreatingAds(Request $request){
        $user_id = Auth::user()->id;
        $media_id = $request->media_id;

        Media::where('user_id' , $user_id)->where('ad_id' , 0)->where('ref' , 'ad')->update(['is_feature'=>0]);
        Media::whereId($media_id)->update(['is_feature'=>1]);

        return ['success'=>1, 'msg'=>trans('app.media_featured_msg')];
    }

    /**
     * @return mixed
     */
    
    public function appendMediaImage(){
        $user_id = Auth::user()->id;
        $ads_images = Media::where('user_id' , $user_id)
            ->where('ad_id' , 0)
            ->where('ref' , 'ad')->get();

        return view('admin.append_media', compact('ads_images'));
    }

    /**
     * Listing
     */

    public function listing(Request $request){
        $ads = Ad::active();
        $business_ads_count = Ad::active()->business();
        $personal_ads_count = Ad::active()->personal();

        $premium_ads = Ad::activePremium();

        if ($request->q){
            $ads = $ads->where(function($ads) use($request){
                $ads->where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%");
            });
            
            $business_ads_count = $business_ads_count->where(function($business_ads_count) use($request){
                $business_ads_count->where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%");
            });

            $personal_ads_count = $personal_ads_count->where(function($personal_ads_count) use($request){
                $personal_ads_count->where('title','like', "%{$request->q}%")->orWhere('description','like', "%{$request->q}%");
            });
        }
        if ($request->category){
            $ads = $ads->where('category_id', $request->category);
            $business_ads_count = $business_ads_count->where('category_id', $request->category);
            $personal_ads_count = $personal_ads_count->where('category_id', $request->category);

            $premium_ads = $premium_ads->where('category_id', $request->category);
        }
        if ($request->sub_category){
            $ads = $ads->where('sub_category_id', $request->sub_category);
            $business_ads_count = $business_ads_count->where('sub_category_id', $request->sub_category);
            $personal_ads_count = $personal_ads_count->where('sub_category_id', $request->sub_category);

            $premium_ads = $premium_ads->where('sub_category_id', $request->sub_category);
        }
        if ($request->brand){
            $ads = $ads->where('brand_id', $request->brand);
            $business_ads_count = $business_ads_count->where('brand_id', $request->brand);
            $personal_ads_count = $personal_ads_count->where('brand_id', $request->brand);
        }
        if ($request->condition){
            $ads = $ads->where('ad_condition', $request->condition);
            $business_ads_count = $business_ads_count->where('ad_condition', $request->condition);
            $personal_ads_count = $personal_ads_count->where('ad_condition', $request->condition);
        }
        if ($request->type){
            $ads = $ads->where('type', $request->type);
            $business_ads_count = $business_ads_count->where('type', $request->type);
            $personal_ads_count = $personal_ads_count->where('type', $request->type);
        }
        if ($request->country){
            $ads = $ads->where('country_id', $request->country);
            $business_ads_count = $business_ads_count->where('country_id', $request->country);
            $personal_ads_count = $personal_ads_count->where('country_id', $request->country);
        }
        if ($request->state){
            $ads = $ads->where('state_id', $request->state);
            $business_ads_count = $business_ads_count->where('state_id', $request->state);
            $personal_ads_count = $personal_ads_count->where('state_id', $request->state);
        }
        if ($request->city){
            $ads = $ads->whereCityId($request->city);
            $business_ads_count = $business_ads_count->whereCityId($request->city);
            $personal_ads_count = $personal_ads_count->whereCityId($request->city);
        }
        if ($request->min_price){
            $ads = $ads->where('price', '>=', $request->min_price);
            $business_ads_count = $business_ads_count->where('price', '>=', $request->min_price);
            $personal_ads_count = $personal_ads_count->where('price', '>=', $request->min_price);
        }
        if ($request->max_price){
            $ads = $ads->where('price', '<=', $request->max_price);
            $business_ads_count = $business_ads_count->where('price', '<=', $request->max_price);
            $personal_ads_count = $personal_ads_count->where('price', '<=', $request->max_price);
        }
        if ($request->adType){
            if ($request->adType == 'business') {
                $ads = $ads->business();
            }elseif ($request->adType == 'personal'){
                $ads = $ads->personal();
            }
        }
        if ($request->user_id){
            $ads = $ads->where('user_id', $request->user_id);
            $business_ads_count = $business_ads_count->where('user_id', $request->user_id);
            $personal_ads_count = $personal_ads_count->where('user_id', $request->user_id);
        }
        if ($request->shortBy){
            switch ($request->shortBy){
                case 'price_high_to_low':
                    $ads = $ads->orderBy('price', 'desc');
                    break;
                case 'price_low_to_height':
                    $ads = $ads->orderBy('price', 'asc');
                    break;
                case 'latest':
                    $ads = $ads->orderBy('id', 'desc');
                    break;
            }
        }else{
            $ads = $ads->orderBy('id', 'desc');
        }


        $ads_per_page = get_option('ads_per_page');
        $ads = $ads->with('feature_img', 'country', 'state', 'city', 'category');
        $ads = $ads->paginate($ads_per_page);


        //Check max impressions
        $max_impressions = get_option('premium_ads_max_impressions');
        $premium_ads = $premium_ads->where('max_impression', '<', $max_impressions);
        $take_premium_ads = get_option('number_of_premium_ads_in_listing');
        if ($take_premium_ads > 0){
            $premium_order_by = get_option('order_by_premium_ads_in_listing');
            $premium_ads = $premium_ads->take($take_premium_ads);
            $last_days_premium_ads = get_option('number_of_last_days_premium_ads');

            $premium_ads = $premium_ads->where('created_at', '>=', Carbon::now()->timezone(get_option('default_timezone'))->subDays($last_days_premium_ads));

            if ($premium_order_by == 'latest'){
                $premium_ads = $premium_ads->orderBy('id', 'desc');
            }elseif ($premium_order_by == 'random'){
                $premium_ads = $premium_ads->orderByRaw('RAND()');
            }

            $premium_ads = $premium_ads->get();

        }else{
            $premium_ads = false;
        }

        $business_ads_count = $business_ads_count->count();
        $personal_ads_count = $personal_ads_count->count();

        $title = trans('app.post_an_ad');
        $categories = Category::where('category_id', 0)->where('is_active', 1)->get();
        $countries = Country::whereIn('country_code', ['US', 'JP', 'KOR', 'MY', 'SG', 'HK', 'PH', 'TL', 'ID', 'VN'])->get();

        $selected_categories = Category::find($request->category);
        $selected_sub_categories = Category::find($request->sub_category);

        $selected_countries = Country::find($request->country);
        $selected_states = State::find($request->state);
        //dd($selected_countries->states);

        return view($this->theme.'listing', compact('top_categories', 'ads', 'title', 'categories', 'countries', 'selected_categories', 'selected_sub_categories', 'selected_countries', 'selected_states', 'personal_ads_count', 'business_ads_count', 'premium_ads'));
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function singleAd($slug){
        $limit_regular_ads = get_option('number_of_free_ads_in_home');
        $ad = Ad::where('slug', $slug)->first();

        if (!$ad){
            return view('theme.error_404');
        }
        
        if (!$ad->is_published()){
            if (Auth::check()){
                $user_id = Auth::user()->id;
                if ($user_id != $ad->user_id){
                    return view('theme.error_404');
                }
            }else{
                return view('theme.error_404');
            }
        }else{
            $ad->view = $ad->view+1;
            $ad->save();
        }

        $title = $ad->title;

        //Get Related Ads, add [->where('country_id', $ad->country_id)] for more specific results
        $related_ads = Ad::active()
            ->where('category_id', $ad->category_id)
            ->where('id', '!=',$ad->id)
            ->with('category', 'city')
            ->limit($limit_regular_ads)
            ->orderByRaw('RAND()')
            ->get();
        
        return view($this->theme.'single_ad', compact('ad', 'title', 'related_ads'));
    }
    
    public function switchGridListView(Request $request){
        session(['grid_list_view' => $request->grid_list_view]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function reportAds(Request $request){
        $ad = Ad::where('slug', $request->slug)->first();
        if ($ad) {
            $data = [
                'ad_id' => $ad->id,
                'reason' => $request->reason,
                'email' => $request->email,
                'message' => $request->message,
            ];
            Report_ad::create($data);
            return ['status'=>1, 'msg'=>trans('app.ad_reported_msg')];
        }
        return ['status'=>0, 'msg'=>trans('app.error_msg')];
    }
    
    
    public function reports(){
        $reports = Report_ad::orderBy('id', 'desc')->with('ad')->paginate(20);
        $title = trans('app.ad_reports');

        return view('admin.ad_reports', compact('title', 'reports'));
    }

    public function deleteReports(Request $request){
        Report_ad::find($request->id)->delete();
        return ['success'=>1, 'msg' => trans('app.report_deleted_success')];
    }
    
    public function reportsByAds($slug){
        $user = Auth::user();

        if ($user->is_admin()){
            $ad = Ad::where('slug', $slug)->first();
        }else{
            $ad = Ad::where('slug', $slug)->where('user_id', $user->id)->first();
        }

        if (! $ad){
            return view('admin.error.error_404');
        }

        $reports = $ad->reports()->paginate(20);

        $title = trans('app.ad_reports');
        return view('admin.reports_by_ads', compact('title', 'ad', 'reports'));

    }


}
