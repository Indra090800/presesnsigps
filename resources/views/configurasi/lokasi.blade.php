@extends('layout.admin.tabler')

@section('content')

<div class="page-header d-print-none">
    <div class="container-xl">
    <div class="row g-2 align-items-center">
        <div class="col">
        <!-- Page pre-title -->
        <h2 class="page-title">
            Konfigurasi Lokasi
        </h2>
        </div>
        <!-- Page title actions -->
    </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <form action="/configurasi/updatelokasi" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                
                                @if (Session::get('success'))
                                    <div class="alert alert-success">
                                        {{ Session::get('success') }}
                                    </div>
                                @endif

                                @if (Session::get('error'))
                                    <div class="alert alert-error">
                                        {{ Session::get('error') }}
                                    </div>  
                                @endif
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-icon mb-3">
                                        <span class="input-icon-addon">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M18.364 4.636a9 9 0 0 1 .203 12.519l-.203 .21l-4.243 4.242a3 3 0 0 1 -4.097 .135l-.144 -.135l-4.244 -4.243a9 9 0 0 1 12.728 -12.728zm-6.364 3.364a3 3 0 1 0 0 6a3 3 0 0 0 0 -6z" stroke-width="0" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        <input type="text" value="{{ $lok_kantor->lokasi }}" name="lokasi" class="form-control" placeholder="Lokasi Kantor" id="lokasi">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-icon mb-3">
                                        <span class="input-icon-addon">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-access-point" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 12l0 .01"></path>
                                            <path d="M14.828 9.172a4 4 0 0 1 0 5.656"></path>
                                            <path d="M17.657 6.343a8 8 0 0 1 0 11.314"></path>
                                            <path d="M9.168 14.828a4 4 0 0 1 0 -5.656"></path>
                                            <path d="M6.337 17.657a8 8 0 0 1 0 -11.314"></path>
                                            </svg>
                                        </span>
                                        <input type="number" value="{{ $lok_kantor->radius }}" name="radius" class="form-control" placeholder="Radius Kantor" id="radius">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-">
                                    <button class="btn btn-primary w-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-reload" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747"></path>
                                    <path d="M20 4v5h-5"></path>
                                    </svg>    
                                    Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection