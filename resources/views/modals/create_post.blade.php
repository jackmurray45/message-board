<div class="modal fade" id="createPostModal" tabindex="-1" role="dialog" aria-labelledby="createPostModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('posts.store') }}">
                @csrf
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Write your post</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class = "input-group">      
                        {!! Form::textarea('content', '', ['class' => 'form-control', 'placeholder' => 'Today I went to...']) !!}
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    {!! Form::submit('Submit Post', ['class' => 'form-control btn btn-default']) !!}
                </div>
            </form>
        </div>
    </div>
</div>