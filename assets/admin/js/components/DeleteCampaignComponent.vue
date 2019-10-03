
<div class="modal fade" id="deleteModal{{$campaign->id}}" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form method="POST" action="{{ route('admin.delete_campaign', $campaign->id) }}">
                @method('DELETE')
                @csrf
                <div class="modal-body">
                    <p>You are about to delete.</p> 
                    
                    <p class="text-muted">This action cannot be undone.</p>
                    
                    <h5>Do you want to proceed ?</h5>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div> 