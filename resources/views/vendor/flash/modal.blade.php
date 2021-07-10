<div id="flash-overlay-modal" class="modal fade {{ isset($modalClass) ? $modalClass : '' }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body">
                <h4 class="my-2 text-center">{{$body}}</h4>
                
                <div class="mb-2 d-flex justify-content-center"> 
                    <a href="{{route('dashboard')}}" class="btn btn-success mr-1">Buy Plan</a>
                    <button type="button" class="btn btn-light" data-dismiss="modal" aria-hidden="true">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
