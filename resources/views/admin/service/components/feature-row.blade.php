<div class="w-100 row">

    @if (isset($feature))
    <div class="col-lg-5">

    @include('admin.components.forms.input', [
        'name' => "features[{$feature->id}][en_feature]",
        'label' => 'English Feature',
        'required' => true,
        'id' => "features_{$index}_en_feature",
        'value' => old("features.{$feature->id}.en_feature", $feature['en_feature'] ?? '')
    ])
    </div>

     <div class="col-lg-5">

            @include('admin.components.forms.input', [
        'name' => "features[{$feature->id}][ar_feature]",
        'label' => 'Arabic Feature',
        'required' => true,
        'id' => "features_{$index}_ar_feature",
        'value' => old("features.{$feature->id}.ar_feature", $feature['ar_feature'] ?? '')
    ])
    </div>
    


    @else
     <div class="col-lg-5">
  @include('admin.components.forms.input', [
        'name' => "features[new_row][en_feature]",
        'label' => 'English Feature',
        'required' => true,
        'id' => "features_new_row_en_feature",
        'value' => old("features.new_row.en_feature", '')
    ])
        </div>


          <div class="col-lg-5">
@include('admin.components.forms.input', [
        'name' => "features[new_row][ar_feature]",
        'label' => 'Arabic Feature',
        'required' => true,
        'id' => "features_new_row_ar_feature",
        'value' => old("features.new_row.ar_feature", '')
    ])
        </div>
      
        


    @endif

    <div class="col-lg-2">
   {{-- delete row --}}
    <button type="button" 
    onclick="this.closest('.row').remove()"
    class="btn btn-danger btn-sm mt-2 remove-feature-row">Delete Feature</button>


    </div>

 

</div>