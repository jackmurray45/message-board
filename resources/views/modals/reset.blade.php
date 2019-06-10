<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('profiles.password') }}">
                @csrf
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Change Password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="current" class="col-form-label mx-auto">Current Password</label>
                        <div class="col-sm-10 mx-auto">
                            <input id="current" type="password" class="form-control" name="current" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-form-label mx-auto">New Password</label>
                        <div class="col-sm-10 mx-auto">
                            <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password-confirmation" class="col-form-label mx-auto">Confirm New Password</label>
                        <br>
                        <div class="col-sm-10 mx-auto">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>     
                </div>

                <div class="modal-footer d-flex justify-content-center">
                    {!! Form::submit('Change Password', ['class' => 'form-control btn btn-default']) !!}
                </div>
            </form>
        </div>
    </div>
</div>