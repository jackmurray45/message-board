<div class="modal fade" id="deleteCommentModal" tabindex="-1" role="dialog" aria-labelledby="deleteCommentModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id = "deleteCommentForm" action="{{ route('comments.destroy', ['id' => $comment->id]) }}">
                {{method_field('DELETE')}}
                @csrf
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Delete Comment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to delete this Comment?</div>
                <div class="modal-footer">
                    {!! Form::submit('Yes', ['class' => 'btn btn-danger col-sm-2']) !!}
                    <button type="button" class="btn col-sm-2" data-dismiss="modal" id="frm_cancel">No</button>
                </div>
                </div>
            </form>
        </div>
    </div>
</div>