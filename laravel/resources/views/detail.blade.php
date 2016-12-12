@extends('layout-for-individual-pages')
@section('title', 'LinEpig - A resource for ID of female erigonines')
@section('description', 'A visual aid for identifying the difficult spiders in family Linyphiidae.')
@section('species_name', $record['species_name'])

@section('content')
  <div class="flex-container blue">  
    <div class="flex-item">
          <h4 style="margin:30px 0 0 0;">Female epigynum, ventral view.</h4>
          <img src="{{ $record['image_url'] }}" class="detail-pic">
          <p><i>{{ $record['genus_species'] }}</i> {{ $record['author'] }}</p>
    </div><!--.flex-item blue-->
 
    <div class="flex-item species-links">
          <h4 class="species-title">Show all <i>{{ $record['genus_species'] }}</i>:</h4>
            <ul class="subset-list-links">
              @foreach ($record['subsets'] as $key => $value)
                @if ($value == true)
                  <li class="subset-list-item">
                    <a href="/subset/{{ $key }}/{{ $record['taxonomy_irn'] }}" class="subset-link">
                      {{ $key }}
                    </a>
                  </li>
                @endif
              @endforeach
              <li class="subset-list-item">
                <a href="/subset/all/{{ $record['taxonomy_irn'] }}" class="subset-link">
                  all images
                </a>
              </li>
            </ul>
     </div><!--.flex-item species-links-->
  </div><!--.flex-container blue-->


  <div class="additional-info">
    <h2>Taxonomy</h2>

    @if (!empty($record['bold_url']))
      <p class="bold-systems">
        <a href="{{ $record['bold_url'] }}" target="_blank">BOLD systems taxon page</a>
      </p>
    @endif

    <p class="wsc">
      <a href="{{ $record['world_spider_catalog_url'] }}" target="_blank">World Spider Catalog lookup</a>
    </p>

    <p>
      <h2>Material</h2>
      <p>{{ $record['DetSource'] }}&nbsp;
      @if (!empty($record['collection_record_url']))
        <a href="{{ $record['collection_record_url'] }}">View collection record</a>
      @endif
    </p>
    <p>Image {!! $record['rights'] !!}</p>

      <!-- Link to old/bad previous classification -->
      @if (!empty($record['wrong_multimedia']))
        <div class="wrong-multimedia"><hr>
          <p>{!! $record['wrong_multimedia']['enarratives:TaxTaxaRef_tab'][0]['NarNarrative'] or "" !!}</p>
          <p>
            @if (!empty($record['wrong_multimedia']['thumbnail_url']))
              <img src="{{ $record['wrong_multimedia']['thumbnail_url'] }}"
                   alt="{{ $record['wrong_multimedia']['taxon_to_display'] }}"
                   title="{{ $record['wrong_multimedia']['taxon_to_display'] }}" >
            @endif
          </p>
        </div>
      @endif

    {{-- Notes section --}}
    @if (!empty($record['notes']))
      <div class="notes">
        <h2>Notes</h2>
        {{ $record['notes'] }}
      </div>
    @endif

  </div>
</div><!--item-picbox-->
@endsection
