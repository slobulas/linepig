@extends('layout-for-individual-pages')
@section('title', 'LinEpig - A resource for ID of female erigonines')
@section('description', 'A visual aid for identifying the difficult spiders in family Linyphiidae.')
@section('species_name', 'Search')

@section('content')
  <div class="flex-container">  
    <div class="flex-item">
      <div class="search-container">
        <div id="search-form">
          {!! Form::open(['action' => 'SearchController@handleSearch']) !!}
            <fieldset class="search-fieldset">
              {!! Form::label('genus', 'Genus') !!}
              {!! Form::text('genus') !!}
            </fieldset>

            <fieldset class="search-fieldset">
              {!! Form::label('species', 'Species') !!}
              {!! Form::text('species') !!}
            </fieldset>

            <fieldset class="search-fieldset keywords">
              {!! Form::label('keywords', 'Keywords') !!}

              <ul class="keywords-option-list">
                @foreach ($keywords as $keyword)
                  <li class="keyword-option-item">
                    {!! Form::label('keywords', $keyword) !!}
                    {!! Form::checkbox('keywords[]', $keyword) !!}
                  </li>
                @endforeach
              </ul>
            </fieldset>

            {!! Form::submit('Search', array('class' => 'search')) !!}
          {!! Form::close() !!}
        </div>
      </div>
    </div><!--.flex-item blue-->

  </div><!--.flex-container blue-->

</div><!--item-picbox-->
@endsection