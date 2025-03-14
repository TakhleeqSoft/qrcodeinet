  {{-- open modal --}}

  {{-- <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
      <div class="bg-white max-w-2xl w-full rounded-lg overflow-hidden relative">
          <form method="post" action="table-assign">
              @csrf
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title py-1 px-2 text-lg font-semibold border-b border-black/10"
                          id="exampleModalLabel">Call the Waiter</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body pb-4">
                      <div class="py-1 px-2">
                          <h6 class="modal-title mb-2" id="exampleModalLabel">Table Number</h6>
                          <select data-trigger id="table_restaurant" name="table_restaurant"
                              class="form-select @if ($errors->has('table_restaurant')) border border-danger @endif "
                              required>
                              <?php
                              $table_restaurant = old('table_restaurant') ? old('table_restaurant') : 0;
                              ?>
                              <option value="">Choose Table</option>

                              @foreach ($tables ?? [] as $table)
                                  <option value="{{ $table->id }}"
                                      @if ($table->id == $table_restaurant) selected @endif>
                                      {{ $table->name }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <div class="flex items-center justify-end gap-4">
                          <button type="submit" class="text-white px-6 bg-primary rounded-lg"
                              style="padding:5px 10px;">Save</button>
                      </div>
                  </div>
              </div>
          </form>
      </div>
  </div>
</div> --}}


  <div id="call_the_waiter_modal" class="modal {{ $errors->has('table_restaurant') ? '' : 'hidden' }} fade relative z-20" tabindex="-1" role="dialog"
      aria-labelledby="call_the_waiter_modal_label" aria-hidden="true">
      <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
      <div class="fixed inset-0 z-10 overflow-y-auto">
          <div class="flex h-1/2 items-end justify-center p-4 text-center sm:items-center sm:p-0">
              <div class="container">
                  <div
                      class="transform sm:w-1/2 mx-auto overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8">
                      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 relative">
                          <button class="absolute right-2  top-2 z-10 close-model" onclick="notificationToggleHandler()">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x"
                                  width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                  stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                  <line x1="18" y1="6" x2="6" y2="18"></line>
                                  <line x1="6" y1="6" x2="18" y2="18"></line>
                              </svg>
                          </button>
                          <form class="w-full flex-1 space-y-5" method="post" action="{{ url('table-assign') }}">
                              @csrf

                              <h3 class="font-bold text-xl">{{ __('system.call_waiters.menu') }}</h3>
                              <ul class="font-bold space-y-1 text-black/70">
                                  <h6 class="modal-title mb-2" id="exampleModalLabel">
                                      {{ __('system.call_waiters.table_number') }}</h6>
                                  <select data-trigger id="table_restaurant" name="table_restaurant"
                                      class=" text-sm font-semibold py-3.5 px-4 rounded-lg form-select outline-none w-full @if ($errors->has('table_restaurant')) border border-[red] @endif ""
                                      required>
                                      <?php
                                      $table_restaurant = old('table_restaurant') ? old('table_restaurant') : 0;
                                      ?>
                                      <option value="">{{ __('system.call_waiters.choose_table') }}</option>
                                      @foreach ($tables ?? [] as $table)
                                          <option value="{{ $table->id }}"
                                              @if ($table->id == $table_restaurant) selected @endif>
                                              {{ $table->name }}</option>
                                      @endforeach
                                  </select>
                              </ul>
                              <div class="float-right pb-5">
                                  <button type="submit"
                                      class="py-3.5 px-5 rounded-md text-white font-bold bg-primary">{{ __('system.call_waiters.menu') }}</button>
                              </div>
                      </div>
                  </div>
              </div>
              </form>
          </div>
      </div>
  </div>
