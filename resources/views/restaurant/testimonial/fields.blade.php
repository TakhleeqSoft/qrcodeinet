@csrf
<div>
    <section>

        <div class="row mb-3">
            <div class="col-md-12  form-group">
                <div class="d-flex align-items-center">
                    <div class='mx-3 '>
                        @if (isset($testimonial) && $testimonial->testimonial_image != null)
                            <img data-src="{{ $testimonial->testimonial_image }}" alt="" class="avatar-xl rounded-circle img-thumbnail preview-image lazyload">
                        @else
                            <div class="preview-image-default">
                                <h1 class="rounded-circle font-size text-white d-inline-block text-bold bg-primary px-4 py-3 ">{{ 'T' }}</h1>
                            </div>
                            <img class="avatar-xl rounded-circle img-thumbnail preview-image" style="display: none;" />
                        @endif

                    </div>
                    @php($lbl_testimonial_image = __('system.fields.testimonial_image'))
                    <input @if(isset($testimonial->testimonial_image) && $testimonial->testimonial_image!=null) @else required @endif  type="file" name="testimonial_image" id="testimonial_image" class="d-none my-preview" accept="image/*" data-pristine-accept-message="{{ __('validation.enum', ['attribute' => strtolower($lbl_testimonial_image)]) }}" data-preview='.preview-image'>
                    <label for="testimonial_image" class="mb-0">
                        <div for="profile-image" class="btn btn-outline-primary waves-effect waves-light my-2 mdi mdi-upload ">
                            {{ $lbl_testimonial_image }}
                        </div>
                    </label>
                </div>
                @error('testimonial_image')
                    <div class="pristine-error text-help">{{ $message }}</div>
                @enderror
            </div>
        </div>


        <div class="row mb-3">
            <div class="col-lg-4 mb-2">
                <div class="form-group">
                    <label class="text-label">{{ trans('system.testimonial.name') }}*</label>
                    <input data-pristine-required-message="{{ __('validation.required', ['attribute' => strtolower(trans('system.testimonial.name'))]) }}" value="{{ old('name') ? old('name') : (isset($testimonial) ? $testimonial->name : '') }}" type="text" name="name" class="form-control" required>
                </div>
            </div>
            <div class="col-lg-4 mb-2">
                <div class="form-group">
                    <label class="text-label">{{ trans('system.testimonial.description') }}*</label>
                    <textarea  data-pristine-required-message="{{ __('validation.required', ['attribute' => strtolower(trans('system.testimonial.description'))]) }}"  name="description" class="form-control" required>{{ old('description') ? old('description') : (isset($testimonial) ? $testimonial->description : '') }}</textarea>
                </div>
            </div>
        </div>
    </section>
</div>
@once
    @push('page_css')
        <style>
            .ml-3 {
                margin-left: 10px;
            }
        </style>
    @endpush

    @push('page_scripts')
        <script>
            $(document).ready(function() {
                $('.isUnlimited').click(function() {
                    console.log('hello');
                    let setter = false;
                    if ($(this).is(':checked')) {
                        setter = true;
                    }
                    $($(this).data('target')).attr('readonly', setter);
                });

                $('.isUnlimited:checked').each(function(key, element) {
                    $($(element).data('target')).attr('readonly', true);
                });
            });
        </script>
    @endpush
@endonce
