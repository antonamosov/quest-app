<div id="offer_1">
<div  class="area">    
    @if($columnVariable !== 3)
    <div class="zone-center">
    @endif
    @if($landing->LogoImagePath())
    <div id="partners-logo" class="zone-col{{ $columnVariable }}">
        <div>
            <img src="{{ $landing->LogoImagePath() }}">
        </div>
    </div>
    @endif
    @if($landing->image_text)
    <div id="partners-txt" class="zone-col{{ $columnVariable }}">
        <div>
            <p>
                {{ $landing->image_text }}
            </p>
        </div>
    </div>
     @endif
     @if($landing->mainImagePath())
    <div id="partners-photo" class="zone-col{{ $columnVariable }}">
        <div>
            <img src="{{ $landing->mainImagePath() }}">
        </div>
    </div>
     @endif
     @if($columnVariable !== 3)
    </div>
    @endif  
</div>
</div>
