@extends('layouts.master')

@section('styles')

@endsection

@section('main-content')

<!-- Chapter Lists-->
<div class="container">
    <div class="chapter-section">
        <div class="text-center">
            <h2 class="section-title">Learn By Chapters</h2>
        </div>

        <!-- start card-columns -->
        <div class="card-columns">

            @foreach ($chapters as $chapter)
            <!-- Single Chapter -->
            <div class="card">
                {{-- <img src="{{ asset('public/images/chapters/groups.jpg') }}" class="card-img-top"> --}}
                <div class="card-body">
                    <h5 class="card-title">{{ $chapter->name }}</h5> <!-- Parent Category -->
                    <div class="card-text">


                        <!-- Sub Categories -->
                        <ul class="list-group list-group-flush">
                            <a href="{{ route('chapters.show', ['fi', 'professions']) }}" class="subcategory-item-link">
                                <li class="list-group-item subcategory-item">
                                    Ammatit - Professions
                                    <span class="badge badge-warning rounded">52</span>
                                </li>
                            </a>
                            <a href="{{ route('chapters.show', ['fi', 'professions']) }}" class="subcategory-item-link">
                                <li class="list-group-item subcategory-item">
                                    Test 2 - Testo
                                    <span class="badge badge-warning rounded">100</span>
                                </li>
                            </a>
                            <a href="{{ route('chapters.show', ['fi', 'professions']) }}" class="subcategory-item-link">
                                <li class="list-group-item subcategory-item">
                                    Another - Another
                                    <span class="badge badge-warning rounded">20</span>
                                </li>
                            </a>
                        </ul>

                    </div>
                </div>
                <div class="card-footer">
                    <span class="badge badge-primary badge-words">
                        40 Words
                    </span>
                    <span class="badge badge-info badge-sentence">
                        30 Sentence
                    </span>
                </div>
            </div>

            @endforeach


        </div> <!-- end card-columns -->


    </div>

</div>
@endsection

@section('scripts')

@endsection