<?php

namespace App\Http\Controllers\Restaurant;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\TestimonialRequest;
use App\Repositories\Restaurant\TestimonialRepository;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        $user = auth()->user();
        $params = $request->only('par_page', 'sort', 'direction', 'filter', 'testimonial_id');
        $params['testimonial_id'] = $params['testimonial_id'] ?? $user->testimonial_id;
        $testimonials = (new TestimonialRepository())->allTestimonial($params);
        return view('restaurant.testimonial.index', ['testimonials' => $testimonials]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurant.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TestimonialRequest $request)
    {
        $data = $request->all();
        $newUser = Testimonial::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'testimonial_image' => $data['testimonial_image'] ?? null,
        ]);

        $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.testimonial.name')]));

        return redirect(route('restaurant.testimonials.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $testimonial = Testimonial::where('testimonial_id', $id)->first();
        if (empty($testimonial)) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => 'testimonial']));
            return redirect()->back();
        }

        return view('restaurant.testimonial.edit', ['testimonial' => $testimonial]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TestimonialRequest $request, $id)
    {
        $testimonial = Testimonial::where('testimonial_id', $id)->first();
        if (empty($testimonial)) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => 'Testimonial']));
            return redirect()->back();
        }

        try {
            DB::beginTransaction();

            $testimonial->update($request->all());

            DB::commit();
            $request->session()->flash('Success', __('system.messages.saved', ['model' => __('system.testimonial.name')]));
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            $request->session()->flash('Error', __('system.messages.operation_rejected'));
            return redirect()->back();
        }
        return redirect(route('restaurant.testimonials.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::where('testimonial_id', $id)->first();
        if (empty($testimonial)) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => 'Testimonial']));
            return redirect()->back();
        }
        $testimonial->delete();
        request()->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.testimonial.title')]));
        return redirect(route('restaurant.testimonials.index'));
    }
}
