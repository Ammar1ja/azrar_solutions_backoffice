<div class="w-100 row">

    @if (isset($feature) && !isset($is_new))
    <div class="col-lg-5">

    @include('admin.components.forms.input', [
        'name' => "features[{$feature->id}][en_feature]",
        'label' => 'English Feature',
        'required' => true,
        'id' => "features_{$feature->id}_en_feature",
        'value' => old("features.{$feature->id}.en_feature", $feature['en_name'] ?? '')
    ])
    </div>

     <div class="col-lg-5">

            @include('admin.components.forms.input', [
        'name' => "features[{$feature->id}][ar_feature]",
        'label' => 'Arabic Feature',
        'required' => true,
        'id' => "features_{$feature->id}_ar_feature",
        'value' => old("features.{$feature->id}.ar_feature", $feature['ar_name'] ?? '')
    ])
    </div>
    


    @else
     <div class="col-lg-5">
  @include('admin.components.forms.input', [
        'name' => "features[new_row][en_feature]",
        'label' => 'English Feature',
        'required' => true,
        'id' => "features_new_row_en_feature",
    ])
        </div>


          <div class="col-lg-5">
@include('admin.components.forms.input', [
        'name' => "features[new_row][ar_feature]",
        'label' => 'Arabic Feature',
        'required' => true,
        'id' => "features_new_row_ar_feature",
    ])
        </div>
      
        


    @endif

    <div class="col-lg-2">
            <div class="form-group">
            <label class="d-block">&nbsp;</label>

              {{-- delete row --}}
    <button type="button" 
    onclick="this.closest('.row').remove()"
    class="btn btn-danger btn-sm  remove-feature-row">Delete Feature</button>

            </div>
 

    </div>

 

</div>