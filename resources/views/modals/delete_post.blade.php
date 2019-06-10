<div class="modal fade" id="deletePostModal" tabindex="-1" role="dialog" aria-labelledby="deletePostModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id = "deleteForm" action="{{ route('posts.destroy', ['id' => $post->id]) }}">
                {{method_field('DELETE')}}
                @csrf
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Delete Post</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to delete this post?</div>
                <div class="modal-footer">
                    {!! Form::submit('Yes', ['class' => 'btn btn-danger col-sm-2']) !!}
                    <button type="button" class="btn col-sm-2" data-dismiss="modal" id="frm_cancel">No</button>
                </div>
                </div>
            </form>
        </div>
    </div>
</div>