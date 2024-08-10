@extends('frontend.layouts.app')

@section('title', 'Reviews')

@section('content')
       <style>
        /* Enhanced CSS for review cards */
        .review-box {
            background-color: #f9f9f9;
            border: 1px solid #dedede;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .review-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .review-box p {
            font-size: 14px;
            color: #555;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .review-box h5 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            color: #333;
        }

        .review-box .title {
            font-size: 14px;
            color: #888;
        }

        .review-box .rating {
            font-size: 16px;
            color: #ffcc00;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }

        .rate input {
            display: none;
            /* Hide the radio inputs */
        }

        .rate label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rate label:before {
            content: '★ ';
        }

        .rate input:checked~label {
            color: #ffc700;
        }

        .rate label:hover,
        .rate label:hover~label {
            color: #deb217;
        }

        .rate input:checked+label:hover,
        .rate input:checked~label:hover,
        .rate label:hover~input:checked~label {
            color: #c59b08;
        }
    </style>
    <div class="container main-container">
        <div class="cards">
            <h2 class="text-center mb-4 mt-3">Reviews</h2>
            <div id="reviews-container" class="row">
                @foreach ($reviews as $review)
                    <div class="col-md-3 col-sm-6 review-item">
                        <div class="review-box">
                            <p>{{ $review->review }}</p> <!-- Review on top -->
                            <div class="rating my-2"> <!-- Rating in the middle -->
                                @for ($i = 0; $i < $review->rating; $i++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-3"> <!-- User info at the bottom -->
                                <div>
                                    <h4>{{ $review->service->name }}</h4>
                                    <h6>{{ $review->user_name }}</h6>
                                    <span class="title">{{ $review->user_email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
        <div class="text-center mt-4">
            <button id="show-less" class="btn btn-secondary" style="display: none;">Show Less</button>
            @if ($reviews->hasMorePages())
                <button id="load-more" class="btn btn-primary">Load More</button>
            @endif
        </div>
    </div>
    <section>
        <div class="container">
            <div class="row py-5">
                <div class="col-12">
                    <h2 class="text-center mb-4">Add a Review</h2>
                    <form action="{{ route('reviews.store') }}" method="POST" id="review-form">
                        @csrf

                        <div class="mb-3">
                            <select class="form-select form-control" id="service_id" name="service_id" required>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="text" name="user_name" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="user_email" class="form-control" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">

                            <div class="rate">
                                <input type="radio" id="star5" name="rating" value="5" />
                                <label for="star5" title="5 stars">5 stars</label>
                                <input type="radio" id="star4" name="rating" value="4" />
                                <label for="star4" title="4 stars">4 stars</label>
                                <input type="radio" id="star3" name="rating" value="3" />
                                <label for="star3" title="3 stars">3 stars</label>
                                <input type="radio" id="star2" name="rating" value="2" />
                                <label for="star2" title="2 stars">2 stars</label>
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label for="star1" title="1 star">1 star</label>
                            </div>
                        </div>
                        <input type="hidden" name="rating" id="rating-input">
                        <div class="form-group">
                            <textarea name="review" class="form-control" placeholder="Your Review" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        let currentPage = {{ $reviews->currentPage() }};
        let totalPages = {{ $reviews->lastPage() }};
        let reviewsContainer = $('#reviews-container');

        function loadReviews() {
            $.ajax({
                url: '{{ route('reviews.index') }}',
                type: 'GET',
                data: {
                    page: currentPage + 1
                },
                success: function(response) {
                    let reviews = response.data;
                    reviews.forEach(review => {
                        let reviewHtml = `
                            <div class="col-md-3 col-sm-6 review-item">
                                <div class="review-box">

                                    <div><h5>${review.service.name}</h5></div>
                                    <div class="rating">
                                        ${'★'.repeat(review.rating)}
                                    </div>
                                    <p>${review.review}</p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h5>${review.user_name}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        reviewsContainer.append(reviewHtml);
                    });

                    currentPage++;
                    if (currentPage >= totalPages) {
                        $('#load-more').hide();
                    }
                    $('#show-less').show();
                }
            });
        }

        function showLessReviews() {
            $('.review-item').slice(-8).remove();
            currentPage--;
            if (currentPage === 1) {
                $('#show-less').hide();
            }
            $('#load-more').show();
        }

        $(document).ready(function() {
            $('#load-more').click(function() {
                loadReviews();
            });

            $('#show-less').click(function() {
                showLessReviews();
            });

            $('.rate input').on('change', function() {
                var rating = $(this).val();
                $('#rating-input').val(rating);
            });
        });
    </script>
@endpush
