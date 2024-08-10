@extends('frontend.layouts.app')
@section('title', 'Services')
@section('content')
    <!-- Cards Section Start -->
    <section>
        <div class="container">
            <div class="row py-5">
                @foreach ($services as $service)
                    <div class="col-lg-4">
                        <div class="card__box">
                            <div>
                                <div class="card__icon">


                                    <i class="{{ $service->icon }}" style="font-size: 100px"></i>
                                </div>
                                <div class="mt-4">
                                    <h4>{{ $service->name }}</h4>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p>
                                    {{ $service->description }}
                                </p>
                            </div>
                            <div class="w-100 d-flex align-items-center justify-content-center mt-3">
                                <a href="{{ route('packages.index', ['service' => $service->id]) }}"
                                    class="btn__purple">Packages</a>
                                <!-- <a href="javascript::void()" class="btn__packages">Read More</a> -->
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
        </div>
    </section>
@endsection
