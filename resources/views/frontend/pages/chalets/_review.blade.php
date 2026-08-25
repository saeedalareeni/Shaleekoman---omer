@auth
    @php
        $hasReservation = $chalet
            ->bookings()
            ->where('customer_id', auth('customer')->id())
            ->exists();
    @endphp
    @if ($hasReservation)
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#ratingModal">
            {{ trans('back.review_chalet') }}
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
            </svg>
        </button>

         <!-- Modal -->
        <div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header pt-3">
                         <h1 class="modal-title fs-15 mt-0" id="ratingModalLabel">   {{ trans('back.review_chalet') }}                </h1>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body pt-2 pb-0">
                         <form action="{{ route('review.store') }}" method="POST">
                             @csrf
                             <input type="hidden" name="chalet_id" value="{{ $chalet->id }}">

                             @php
                             $criteria = [
                             'rating' => trans('back.rating'),
                             ];
                             @endphp

                             <div class="row">
                                 @foreach($criteria as $field => $label)
                                 <div class="col-md-12 mb-3 text-center">
                                     {{-- <label class="form-label d-block">{{ $label }}</label> --}}
                                     <fieldset class="starability-basic w-100 d-inline-flex" style="">
                                         @for($i = 1; $i<= 10; $i++)
                                             <input type="radio" id="{{ $field }}-{{ $i }}" name="{{ $field }}" value="{{ $i }}"{{ $i == 1 ? 'checked' : '' }} required />
                                             <label for="{{ $field }}-{{ $i }}" title="{{ $i }} نجوم">{{ $i }} نجوم</label>
                                         @endfor
                                     </fieldset>
                                 </div>
                                 @endforeach
                             </div>

                             <div class="form-group mt-3">
                                 <label for="comment">تعليقك</label>
                                 <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
                             </div>

                             <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('back.close') }}</button>
                                 <button type="submit" class="btn btn-primary">  {{ __('back.rating') }} </button>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
        </div>
    @endif
@endauth




<div class="row mt-4">
    <div class="col-12 mb-3">
        <h4 class="mb-0">  {{ __('back.guest_reviews') }} </h4>
    </div>
    <div class="col-6 d-flex align-items-center mb-3">
        <span class="badge badge-lg bg-white fs-15 p-4 shadow text-dark d-flex align-items-center">{{ number_format(round($chalet->reviews->avg('rating'), 1),1) }} </span>
        <div class=" ms-2">
            <p class="mb-0"> {{ __('back.general_rating') }} ({{  $chalet->reviews->count() }} {{ __('back.review') }})   </p>
            <strong>{{ getRatingText(round($chalet->reviews->avg('rating'), 1)) }}</strong>
        </div>
    </div>
</div>

<div class="row mb-20">
    @foreach($chalet->reviews()->latest()->get() as $review)
        <div class="col-6 d-flex align-items-center mb-3">
            <div class="p-4 border rounded mb-4 shadow-sm bg-white w-100">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ $review->customer->image ?? asset('avatar.png') }}" class="rounded-circle me-3" width="50" height="50" alt="User">
                    <div>
                        <strong class="d-block">{{ $review->customer->name ?? 'مستخدم' }}</strong>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($review->created_at)->translatedFormat('l، j F') }}</small>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#f39c12"
                        class="bi bi-star-fill me-2" viewBox="0 0 16 16">
                        <path
                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73-3.522-3.356c-.33-.314-.16-.888.282-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.244 4.319 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <span class="fw-bold me-2">{{ getRatingText(round($review->rating, 1)) }}</span>
                    <span class="text-muted">• {{ number_format(round($review->rating, 1),1) }}</span>
                </div>

                <div class="bg-light rounded p-3 mt-2">
                    <p class="mb-0">{{ $review->comment }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>


