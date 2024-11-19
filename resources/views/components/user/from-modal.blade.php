
<div id="{{ $id }}" {{ $attributes->merge(["class" => 'modal fade editUserDataModal', 'tabindex'=> "-1", 'aria-labelledby'=> "exampleModalLabel", "aria-hidden" => "true"]) }}>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <x-user.form  id="{{ $fromId }}" submitButtonText="{{ $submitButtonText }}" submitButtonId="{{ $submitButtonId }}"/>
            </div>
        </div>
    </div>
</div>